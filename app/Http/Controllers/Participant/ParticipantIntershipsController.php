<?php

namespace App\Http\Controllers\Participant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InternshipPosting;
use App\Models\CompanyProfile;
use App\Models\InternshipApplication;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class ParticipantIntershipsController extends Controller
{
    public function index(Request $request)
    {
        $participantProfile = Auth::user()->participantProfile;

        if (!$participantProfile || !$participantProfile->isComplete()) {
            return redirect()->route('participant.profile.index')
                ->with('error', 'Silakan lengkapi profil peserta terlebih dahulu sebelum melihat lowongan.');
        }

        $companies = CompanyProfile::orderBy('name')->get();

        $query = InternshipPosting::with('company')
            ->where('status', 'active');

        if ($request->filled('company_id')) {
            $query->where('company_id', $request->company_id);
        }

        if ($request->filled('location')) {
            $query->where('location', 'like', '%' . $request->location . '%');
        }

        if ($request->filled('title')) {
            $query->where('title', 'like', '%' . $request->title . '%');
        }

        $interns = $query->orderBy('created_at', 'desc')->paginate(9)->appends($request->query());

        return view('participant.internships.index', compact('interns', 'companies'));
    }


    public function show($id)
    {
        $intern = InternshipPosting::with('company')->findOrFail($id);
        $participantProfile = Auth::user()->participantProfile;

        if (!$participantProfile || !$participantProfile->isComplete()) {
            return redirect()->route('participant.profile.index')->with('error', 'Silakan lengkapi profil peserta terlebih dahulu.');
        }

        $alreadyApplied = InternshipApplication::where('internship_posting_id', $intern->id)
            ->where('participant_id', $participantProfile->id)
            ->exists();
                return view('participant.internships.show', compact('intern', 'alreadyApplied'));
            }

    public function apply(Request $request, $id)
    {
        $intern = InternshipPosting::findOrFail($id);
        $participantProfile = Auth::user()->participantProfile;

        if (!$participantProfile) {
            return redirect()->route('participant.profile.index')
                ->with('error', 'Silakan lengkapi profil peserta terlebih dahulu.');
        }

        $existingApplication = InternshipApplication::where([
            'participant_id' => $participantProfile->id,
            'internship_posting_id' => $id
        ])->exists();

        if ($existingApplication) {
            return redirect()->back()
                ->with('error', 'Anda sudah apply intern ini sebelumnya.');
        }

        InternshipApplication::create([
            'id' => (string) Str::uuid(),
            'participant_id' => $participantProfile->id,
            'internship_posting_id' => $id,
            'status' => 'pending',
            'tanggal' => now(),
        ]);

        return redirect()->route('participant.apply.index')
            ->with('success', 'Lamaran berhasil dikirim.');
    }

    public function confirmPage($id)
    {
        $intern = InternshipPosting::with('company')->findOrFail($id);
        $participantProfile = Auth::user()->participantProfile;

        if (!$participantProfile) {
            return redirect()->route('participant.profile.index')
                ->with('error', 'Silakan lengkapi profil peserta terlebih dahulu.');
        }

        $alreadyApplied = InternshipApplication::where([
            'participant_id' => $participantProfile->id,
            'internship_posting_id' => $id
        ])->exists();

        if ($alreadyApplied) {
            return redirect()->route('participant.internships.show', $id)
                ->with('error', 'Anda sudah mendaftar pada magang ini.');
        }

        return view('participant.internships.confirmation', compact('intern'));
    }

    public function myApplications()
    {
        $participantProfile = Auth::user()->participantProfile;

        if (!$participantProfile) {
            return redirect()->route('participant.profile.index')
                ->with('error', 'Silakan lengkapi profil peserta terlebih dahulu.');
        }
        InternshipApplication::where('participant_id', $participantProfile->id)
        ->where('status', 'Accepted')
        ->where('result_received', false)
        ->whereDate('updated_at', '<=', now()->subDays(3))
        ->update(['status' => 'Rejected']);

        $applications = InternshipApplication::with(['internship.company'])
            ->where('participant_id', $participantProfile->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('participant.apply.index', compact('applications'));
    }

    public function receiveResult($id)
    {
        $participant = Auth::user()->participantProfile;
        $app = InternshipApplication::where([
                    'id'             => $id,
                    'participant_id' => $participant->id,
                ])->firstOrFail();

        if ($app->status !== 'accepted') {
            return back()->with('error', 'Hanya lamaran yang Diterima yang bisa dikonfirmasi.');
        }

        $app->update(['result_received' => true]);

        return back()->with('success', 'Konfirmasi penerimaan hasil berhasil.');
    }

    public function confirmReceive($id)
    {
        $participant = Auth::user()->participantProfile;

        $application = InternshipApplication::with('internship.company')
            ->where('id', $id)
            ->where('participant_id', $participant->id)
            ->firstOrFail();

        if ($application->result_received) {
            return redirect()->route('participant.apply.index')->with('success', 'Anda sudah mengkonfirmasi penerimaan hasil.');
        }

        return view('participant.apply.confirm_receive', compact('application'));
    }
}
