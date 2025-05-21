<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\TaskSubmission;
use App\Models\InternshipPosting;
use App\Models\ParticipantProfile;
use App\Models\InternshipApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Carbon;

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

    public function index(Request $request)
    {
        $company = Auth::user()->companyProfile;
        $participantId = $request->query('participant_id');

        $query = Task::with(['internship', 'application.participant.user'])
            ->whereHas('internship', fn($q) => $q->where('company_id', $company->id));

        $participant = null;
        if ($participantId) {
            $participant = ParticipantProfile::with('user')->findOrFail($participantId);

            $hasApplication = InternshipApplication::where('participant_id', $participantId)
                ->whereHas('internship', fn($q) => $q->where('company_id', $company->id))
                ->exists();

            abort_unless($hasApplication, 403, 'Peserta tidak terdaftar di perusahaan Anda');

            $query->whereHas('application', fn($q) => $q->where('participant_id', $participantId));
        }

        $tasks = $query->latest()->paginate(15);

        return view('company.tasks.index', compact('tasks', 'participant'));
    }

    public function tasksByParticipant(ParticipantProfile $participant)
    {
        $company = Auth::user()->companyProfile;

        abort_unless(
            InternshipApplication::where('participant_id', $participant->id)
                ->whereHas('internship', fn($q) => $q->where('company_id', $company->id))
                ->exists(),
            403,
            'Peserta tidak terdaftar di perusahaan Anda'
        );

        $tasks = Task::with(['internship', 'application.participant.user'])
            ->whereHas('application', fn($q) => $q->where('participant_id', $participant->id))
            ->whereHas('internship', fn($q) => $q->where('company_id', $company->id))
            ->latest()
            ->paginate(15);

        return view('company.tasks.index', [
            'tasks' => $tasks,
            'participant' => $participant->load('user')
        ]);
    }

    public function updateStatus(Request $request, Task $task)
    {
        $company = Auth::user()->companyProfile;

        abort_unless($task->internship->company_id === $company->id, 403);

        $validated = $request->validate([
            'status' => 'required|in:To Do,In Progress,Done',
        ]);

        $task->status = $validated['status'];
        $task->save();

        return back()->with('success', 'Status tugas berhasil diperbarui.');
    }


    public function create()
    {
        $company = Auth::user()->companyProfile;

        $postings = InternshipPosting::where('company_id', $company->id)
            ->where('status', 'active')
            ->get();

        if ($postings->isEmpty()) {
            return redirect()->route('company.tasks.index')
                ->with('error', 'Anda harus memiliki lowongan aktif sebelum membuat tugas');
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
            'status' => 'required|in:To Do,In Progress,Done',
            'internship_id' => 'required|exists:internship_postings,id',
            'file' => 'required|file|mimes:pdf,doc,docx,xls,xlsx,png,jpg,jpeg|max:5120',
        ], [
            'internship_id.required' => 'Pilih lowongan yang sesuai',
            'file.required' => 'File tugas harus diunggah',
            'file.mimes' => 'File harus berupa dokumen atau gambar',
            'file.max' => 'Ukuran file maksimal 5MB',
        ]);

        $internship = InternshipPosting::where('id', $validated['internship_id'])
            ->where('company_id', $company->id)
            ->firstOrFail();

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
            'deadline' => 'required|date|after_or_equal:today',
            'status' => 'required|in:To Do,In Progress,Done',
            'internship_id' => 'required|exists:internship_postings,id',
            'file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,png,jpg,jpeg|max:5120',
        ], [
            'internship_id.required' => 'Pilih lowongan yang sesuai',
            'file.mimes' => 'File harus berupa dokumen atau gambar',
            'file.max' => 'Ukuran file maksimal 5MB',
        ]);

        $internship = InternshipPosting::where('id', $validated['internship_id'])
            ->where('company_id', $company->id)
            ->firstOrFail();

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

    public function viewSubmission(TaskSubmission $submission)
    {
        $company = Auth::user()->companyProfile;

        abort_unless(
            $submission->task->internship->company_id === $company->id,
            403,
            'Anda tidak memiliki akses ke jawaban ini'
        );

        return view('company.tasks.view-submission', [
            'task' => $submission->task,
            'submission' => $submission,
            'participant' => $submission->user->participantProfile
        ]);
    }

    public function reviewSubmission(Request $request, TaskSubmission $submission)
    {
        $company = Auth::user()->companyProfile;

        abort_unless(
            $submission->task->internship->company_id === $company->id,
            403,
            'Anda tidak memiliki akses ke jawaban ini'
        );

        $validated = $request->validate([
            'review_status' => 'required|in:approved,rejected,revision,pending',
            'review_notes' => 'nullable|string|max:1000',
        ]);

        $validated['review_date'] = Carbon::now();

        $submission->update($validated);

        return redirect()->route('company.tasks.view-submission', $submission)
                        ->with('success', 'Ulasan berhasil disimpan.');
    }

}
