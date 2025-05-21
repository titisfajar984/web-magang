<?php

namespace App\Http\Controllers\Participant;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\TaskSubmission;
use App\Models\InternshipApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class ParticipantTaskSubmissionController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $participantId = optional($user->participantProfile)->id;

        if (!$participantId) {
            abort(403, 'Profile peserta tidak ditemukan.');
        }

        $internshipIds = InternshipApplication::where('participant_id', $participantId)->pluck('internship_posting_id');

        $tasks = Task::with('internship')
            ->whereIn('internship_id', $internshipIds)
            ->latest()
            ->paginate(10);

        return view('participant.tasks.index', compact('tasks'));
    }

    public function show($taskId)
    {
        $task = Task::with('internship')->findOrFail($taskId);
        $submission = TaskSubmission::where('task_id', $taskId)
            ->where('user_id', Auth::id())
            ->first();

        return view('participant.tasks.show', compact('task', 'submission'));
    }

    public function store(Request $request, $taskId)
    {
        $request->validate([
            'submission_text' => 'required|string',
            'attachment_file' => 'nullable|file|max:5120|mimes:pdf,doc,docx,jpg,png',
        ]);

        $task = Task::findOrFail($taskId);
        $user = Auth::user();

        $deadline = Carbon::parse($task->deadline)->setTimezone(config('app.timezone'));
        $now = Carbon::now();

        $isLate = $now->gt($deadline);
        $status = $isLate ? 'Late' : 'Submitted';

        $data = [
            'task_id' => $task->id,
            'user_id' => $user->id,
            'submission_text' => $request->submission_text,
            'submission_date' => $now->toDateTimeString(),
            'status' => $status,
        ];

        if ($request->hasFile('attachment_file')) {
            $data['attachment_file'] = $request->file('attachment_file')->store('submissions', 'public');
        }

        TaskSubmission::updateOrCreate(
            ['task_id' => $task->id, 'user_id' => $user->id],
            $data
        );

        return redirect()->back()->with('success', 'Tugas berhasil dikumpulkan');
    }

    public function edit($taskId)
    {
        $submission = TaskSubmission::where('task_id', $taskId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('participant.tasks.edit', compact('submission'));
    }

    public function update(Request $request, $taskId)
    {
        $submission = TaskSubmission::where('task_id', $taskId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $request->validate([
            'submission_text' => 'required|string',
            'attachment_file' => 'nullable|file|max:5120|mimes:pdf,doc,docx,jpg,png',
        ]);

        $deadline = Carbon::parse($submission->task->deadline)->setTimezone(config('app.timezone'));
        $now = Carbon::now();

        $data = [
            'submission_text' => $request->submission_text,
            'submission_date' => $now->toDateTimeString(),
            'status' => $now->gt($deadline) ? 'Late' : 'Submitted',
        ];

        if ($request->hasFile('attachment_file')) {
            if ($submission->attachment_file) {
                Storage::disk('public')->delete($submission->attachment_file);
            }
            $data['attachment_file'] = $request->file('attachment_file')->store('submissions', 'public');
        }

        $submission->update($data);

        return redirect()->route('participant.tasks.show', $taskId)->with('success', 'Jawaban tugas berhasil diperbarui');
    }
}
