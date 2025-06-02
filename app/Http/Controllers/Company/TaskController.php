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
    public function index(Request $request)
    {
        $company = Auth::user()->companyProfile;
        $participantId = $request->query('participant_id');
        $participant = null;

        $query = Task::with(['application.internship', 'application.participant.user'])
        ->whereHas('application.internship', fn($q) => $q->where('company_id', $company->id));

        if ($participantId) {
            $participant = ParticipantProfile::with('user')->findOrFail($participantId);

            $application = InternshipApplication::where('participant_id', $participant->id)
                ->whereHas('internship', fn($q) => $q->where('company_id', $company->id))
                ->where('status', 'accepted')
                ->where('result_received', true)
                ->first();

            abort_unless($application, 403, 'Peserta tidak memiliki aplikasi magang yang diterima di perusahaan Anda.');

            $query->where('application_id', $application->id);
        }

        $tasks = $query->latest()->paginate(15);

        return view('company.tasks.index', compact('tasks', 'participant'));
    }

    public function create(Request $request)
    {
        $company = Auth::user()->companyProfile;
        $participantId = $request->query('participant_id');

        $participant = $participantId
            ? ParticipantProfile::with('user')->findOrFail($participantId)
            : null;

        $applications = InternshipApplication::with('participant.user')
            ->where('status', 'accepted')
            ->where('result_received', true)
            ->whereHas('internship', fn($q) => $q->where('company_id', $company->id))
            ->get();

        return view('company.tasks.create', compact('applications', 'participant'));
    }

    public function store(Request $request)
    {
        $company = Auth::user()->companyProfile;

        $participantId = $request->input('participant_id');

        if ($participantId) {
            // Ambil aplikasi berdasarkan participant_id
            $application = InternshipApplication::where('participant_id', $participantId)
                ->whereHas('internship', fn($q) => $q->where('company_id', $company->id))
                ->where('status', 'accepted')
                ->where('result_received', true)
                ->firstOrFail();

            $request->merge(['application_id' => $application->id]);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'deadline' => 'required|date|after_or_equal:today',
            'status' => 'required|in:To Do,In Progress,Done',
            'application_id' => 'required|exists:internship_applications,id',
            'file' => 'required|file|mimes:pdf,doc,docx,xls,xlsx,png,jpg,jpeg|max:5120',
        ]);

        $application = InternshipApplication::where('id', $validated['application_id'])
            ->whereHas('internship', fn($q) => $q->where('company_id', $company->id))
            ->firstOrFail();

        if ($request->hasFile('file')) {
            $validated['file_path'] = $request->file('file')->store('tasks', 'public');
        }

        $validated['internship_id'] = $application->internship_id;

        Task::create($validated);

        return redirect()->route('company.tasks.index', ['participant_id' => $application->participant_id])
            ->with('success', 'Tugas berhasil dibuat');
    }


    public function edit(Task $task)
    {
        $company = Auth::user()->companyProfile;

        $applications = InternshipApplication::with('participant.user')
            ->where('status', 'accepted')
            ->where('result_received', true)
            ->whereHas('internship', fn($q) => $q->where('company_id', $company->id))
            ->get();

        return view('company.tasks.edit', compact('task', 'applications'));
    }

    public function update(Request $request, Task $task)
    {
        $company = Auth::user()->companyProfile;

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'deadline' => 'required|date|after_or_equal:today',
            'status' => 'required|in:To Do,In Progress,Done',
            'application_id' => 'required|exists:internship_applications,id',
            'file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,png,jpg,jpeg|max:5120',
        ]);

        $application = InternshipApplication::where('id', $validated['application_id'])
            ->whereHas('internship', fn($q) => $q->where('company_id', $company->id))
            ->firstOrFail();

        if ($request->hasFile('file')) {
            if ($task->file_path) {
                Storage::disk('public')->delete($task->file_path);
            }
            $validated['file_path'] = $request->file('file')->store('tasks', 'public');
        }

        $validated['internship_id'] = $application->internship_id;

        $task->update($validated);

        return redirect()->route('company.tasks.index', ['participant_id' => $application->participant_id])
            ->with('success', 'Tugas berhasil diperbarui');
    }

    public function destroy(Task $task)
    {
        $company = Auth::user()->companyProfile;

        if ($task->file_path) {
            Storage::disk('public')->delete($task->file_path);
        }

        $participantId = $task->application->participant_id;

        $task->delete();

        return redirect()->route('company.tasks.index', ['participant_id' => $participantId])
            ->with('success', 'Tugas berhasil dihapus');
    }

    public function updateStatus(Request $request, Task $task)
    {
        $company = Auth::user()->companyProfile;

        $validated = $request->validate([
            'status' => 'required|in:To Do,In Progress,Done',
        ]);

        $task->update(['status' => $validated['status']]);

        return back()->with('success', 'Status tugas berhasil diperbarui.');
    }

    public function viewSubmission(TaskSubmission $submission)
    {
        $company = Auth::user()->companyProfile;

        abort_unless(
            $submission->task->application->internship->company_id === $company->id,
            403,
            'Anda tidak memiliki akses ke jawaban ini'
        );

        return view('company.tasks.view-submission', [
            'task' => $submission->task,
            'submission' => $submission,
            'participant' => $submission->task->application->participant
        ]);
    }

    public function reviewSubmission(Request $request, TaskSubmission $submission)
    {
        $company = Auth::user()->companyProfile;

        abort_unless(
            $submission->task->application->internship->company_id === $company->id,
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


