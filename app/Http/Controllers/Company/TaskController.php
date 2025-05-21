<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\InternshipPosting;
use App\Models\ParticipantProfile;
use App\Models\InternshipApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TaskController extends Controller
{
    public function participantIndex()
    {
        $company = Auth::user()->companyProfile;

        $applications = InternshipApplication::with(['participant.user', 'internship'])
            ->where('status', 'accepted')
            ->where('result_received', true)
            ->whereHas('internship', fn($q) => $q->where('company_id', $company->id))
            ->latest()
            ->paginate(15);

        return view('company.participants.index', compact('applications'));
    }

    public function tasksByParticipant($participantId)
    {
        $company = Auth::user()->companyProfile;

        $participant = ParticipantProfile::with('user')->findOrFail($participantId);

        $hasApplication = InternshipApplication::where('participant_id', $participantId)
            ->whereHas('internship', fn($q) => $q->where('company_id', $company->id))
            ->exists();

        abort_unless($hasApplication, 403, 'Peserta tidak terdaftar di perusahaan Anda');

        $tasks = Task::with(['internship', 'application'])
            ->whereHas('application', function ($q) use ($participantId, $company) {
                $q->where('participant_id', $participantId)
                  ->whereHas('internship', fn($q2) => $q2->where('company_id', $company->id));
            })->latest()->paginate(10);

        return view('company.participants.tasks', compact('participant', 'tasks'));
    }

    public function index()
    {
        $company = Auth::user()->companyProfile;

        $tasks = Task::with(['internship', 'application.participant.user'])
            ->whereHas('internship', fn($q) => $q->where('company_id', $company->id))
            ->latest()
            ->paginate(15);

        return view('company.tasks.index', compact('tasks'));
    }

    public function create()
    {
        $company = Auth::user()->companyProfile;

        $postings = InternshipPosting::where('company_id', $company->id)
            ->where('status', 'active')
            ->get();

        if ($postings->isEmpty()) {
            return redirect()->route('company.tasks.index')->with('error', 'Anda harus memiliki lowongan aktif sebelum membuat tugas');
        }

        $applications = InternshipApplication::with('participant.user')
            ->where('status', 'accepted')
            ->where('result_received', true)
            ->whereHas('internship', fn($q) => $q->where('company_id', $company->id))
            ->get();

        return view('company.tasks.create', compact('postings', 'applications'));
    }

    public function store(Request $request)
    {
        $company = Auth::user()->companyProfile;

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'deadline' => 'required|date|after_or_equal:today',
            'status' => 'required|in:To Do,In Progress, Done',
            'internship_id' => 'required|exists:internship_postings,id',
            'file' => 'required|file|mimes:pdf,doc,docx,xls,xlsx,png,jpg,jpeg|max:5120',
        ], [
            'internship_id.required' => 'Pilih lowongan yang sesuai',
            'file.required' => 'File tugas harus diunggah',
            'file.mimes' => 'File harus berupa dokumen atau gambar',
            'file.max' => 'Ukuran file maksimal 5MB',
        ]);

        // Pastikan lowongan benar milik perusahaan
        $internship = InternshipPosting::where('id', $validated['internship_id'])
            ->where('company_id', $company->id)
            ->firstOrFail();

        // Proses upload file
        if ($request->hasFile('file')) {
            $validated['file_path'] = $request->file('file')->store('tasks', 'public');
        }

        Task::create($validated);

        return redirect()->route('company.tasks.index')->with('success', 'Tugas berhasil dibuat');
    }

    public function edit(Task $task)
    {
        $company = Auth::user()->companyProfile;

        abort_unless($task->internship->company_id === $company->id, 403);

        $postings = InternshipPosting::where('company_id', $company->id)->get();

        // Tampilkan semua aplikasi peserta untuk lowongan yang sama dengan task
        $applications = InternshipApplication::with('participant.user')
            ->where('status', 'accepted')
            ->where('result_received', true)
            ->where('internship_posting_id', $task->internship_id)
            ->get();

        return view('company.tasks.edit', compact('task', 'postings', 'applications'));
    }

    public function update(Request $request, Task $task)
    {
        $company = Auth::user()->companyProfile;

        abort_unless($task->internship->company_id === $company->id, 403);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'deadline' => 'required|date',
            'status' => 'required|in:To Do,In Progress,Done',
            'internship_id' => 'required|exists:internship_postings,id',
            'file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,png,jpg,jpeg|max:5120',
        ], [
            'internship_id.required' => 'Pilih lowongan yang sesuai',
            'file.required' => 'File tugas harus diunggah',
            'file.mimes' => 'File harus berupa dokumen atau gambar',
            'file.max' => 'Ukuran file maksimal 5MB',
        ]);

        // Validasi kepemilikan lowongan
        $internship = InternshipPosting::where('id', $validated['internship_id'])
            ->where('company_id', $company->id)
            ->firstOrFail();

        // Jika ada file baru, hapus file lama lalu simpan file baru
        if ($request->hasFile('file')) {
            if ($task->file_path) {
                Storage::disk('public')->delete($task->file_path);
            }
            $validated['file_path'] = $request->file('file')->store('tasks', 'public');
        }

        $task->update($validated);

        return redirect()->route('company.tasks.index')->with('success', 'Tugas berhasil diperbarui');
    }

    public function destroy(Task $task)
    {
        $company = Auth::user()->companyProfile;

        abort_unless($task->internship->company_id === $company->id, 403);

        if ($task->file_path) {
            Storage::disk('public')->delete($task->file_path);
        }

        $task->delete();

        return redirect()->back()->with('success', 'Tugas berhasil dihapus');
    }
}
