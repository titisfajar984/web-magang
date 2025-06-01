<?php

namespace App\Http\Controllers;

use App\Models\CompanyProfile;
use App\Models\InternshipApplication;
use App\Models\InternshipPosting;
use App\Models\ParticipantProfile;
use App\Models\Task;
use App\Models\TaskSubmission;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik Utama Admin
        $stats = [
            'totalCompanies' => CompanyProfile::count(),
            'activeInternships' => InternshipPosting::where('status', 'active')->count(),
            'totalParticipants' => ParticipantProfile::count(),
            'pendingApplications' => InternshipApplication::where('status', 'pending')->count(),
        ];

        // Data Terbaru Admin
        $latest = [
            'internships' => InternshipPosting::with('company')
                ->latest()
                ->take(10)
                ->get(),
            'applications' => InternshipApplication::with(['participant.user', 'internship.company'])
                ->latest()
                ->take(10)
                ->get(),
        ];

        return view('admin.index', compact('stats', 'latest'));
    }

    public function companyIndex()
    {
        $company = auth()->user()->companyProfile;

        $internshipIds = $company->internships()->pluck('id');

        // Statistik Perusahaan
        $stats = [
            'active_internships' => $company->internships()->where('status', 'active')->count(),
            'total_applications' => InternshipApplication::whereIn('internship_posting_id', $internshipIds)->count(),
            'pending_tasks' => Task::whereIn('internship_id', $internshipIds)->where('status', 'To Do')->count(),
            'new_applicants' => InternshipApplication::whereIn('internship_posting_id', $internshipIds)
                ->whereDate('created_at', today())
                ->count(),
        ];

        // Data Terbaru Perusahaan
        $latest = [
            'applications' => InternshipApplication::with(['participant.user', 'internship'])
                ->whereIn('internship_posting_id', $internshipIds)
                ->latest()
                ->take(5)
                ->get(),

            'internships' => $company->internships()
                ->withCount('applications')
                ->latest()
                ->take(3)
                ->get(),
        ];

        return view('company.index', compact('stats', 'latest'));
    }

    public function participantIndex()
    {
        $participant = auth()->user()->participantProfile;

        if (!$participant) {
            // Jika profil peserta belum dibuat
            $stats = [
                'total_applications' => 0,
                'active_internships' => 0,
                'pending_tasks' => 0,
                'completed_tasks' => 0,
            ];

            $latest = [
                'applications' => [],
                'tasks' => [],
            ];

            return view('participant.index', compact('stats', 'latest'))
                ->with('warning', 'Silakan lengkapi profil peserta terlebih dahulu.');
        }

        $taskIds = Task::whereHas('internship.applications', function ($query) use ($participant) {
            $query->where('participant_id', $participant->id)
                ->where('status', 'accepted');
        })->pluck('id');

        // Statistik Peserta
        $stats = [
            'total_applications' => $participant->applications()->count(),
            'active_internships' => $participant->applications()->where('status', 'accepted')->count(),
            'pending_tasks' => TaskSubmission::whereIn('task_id', $taskIds)
                ->where('user_id', auth()->id())
                ->where('status', 'Late')
                ->count(),
            'completed_tasks' => Task::whereIn('id', $taskIds)
                ->where('status', 'Done')
                ->whereHas('submissions', function ($q) {
                    $q->where('user_id', auth()->id());
                })
                ->count(),
        ];

        // Data Terbaru
        $latest = [
            'applications' => $participant->applications()
                ->with('internship.company')
                ->latest()
                ->take(5)
                ->get(),

            'tasks' => Task::whereIn('id', $taskIds)
                ->with(['submissions' => function ($q) {
                    $q->where('user_id', auth()->id());
                }])
                ->whereDate('deadline', '>=', now()->toDateString())
                ->orderBy('deadline')
                ->take(5)
                ->get(),
        ];

        return view('participant.index', compact('stats', 'latest'));
    }

    public function showParticipantPage()
    {
        $internships = InternshipPosting::with('company')
            ->where('status', 'active')
            ->inRandomOrder()
            ->take(6)
            ->get();

        return view('landing-page.participant', compact('internships'));
    }

}
