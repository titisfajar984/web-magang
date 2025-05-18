<?php

namespace App\Http\Controllers\Participant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InternshipPosting;
use App\Models\CompanyProfile;
use App\Models\IntershipsApplication;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;


class ParticipantIntershipsController extends Controller
{
    public function index(Request $request)
    {
        $companies = CompanyProfile::orderBy('name')->get();

        $query = InternshipPosting::with('company')
            ->where('status', 'aktif');

        if ($request->filled('company_id')) {
            $query->where('company_id', $request->company_id);
        }

        if ($request->filled('periode_start') && $request->filled('periode_end')) {
            $query->whereBetween('periode_mulai', [$request->periode_start, $request->periode_end]);
        }

        $interns = $query->orderBy('created_at', 'desc')->paginate(10)->appends($request->query());

        return view('participant.internships.index', compact('interns', 'companies'));
    }

    public function show($id)
    {
        $intern = InternshipPosting::with('company')->findOrFail($id);
        $participantProfile = Auth::user()->participantProfile;
        $alreadyApplied = IntershipsApplication::where('internship_posting_id', $intern->id)
            ->where('participant_id', $participantProfile->id)
            ->exists();

                return view('participant.internships.show', compact('intern', 'alreadyApplied'));
            }

    public function apply(Request $request, $id)
    {
        $intern = InternshipPosting::findOrFail($id);
        $participantProfile = Auth::user()->participantProfile;

        if (!$participantProfile) {
            return redirect()->route('participant.profile.create')
                ->with('error', 'Silakan lengkapi profil peserta terlebih dahulu.');
        }

        $existingApplication = IntershipsApplication::where([
            'participant_id' => $participantProfile->id,
            'internship_posting_id' => $id
        ])->exists();

        if ($existingApplication) {
            return redirect()->back()
                ->with('error', 'Anda sudah apply intern ini sebelumnya.');
        }

        IntershipsApplication::create([
            'id' => (string) Str::uuid(),
            'participant_id' => $participantProfile->id,
            'internship_posting_id' => $id,
            'status' => 'Pending',
            'tanggal' => now(),
        ]);

        return redirect()->route('participant.apply.index')
            ->with('success', 'Lamaran berhasil dikirim.');
    }


    public function myApplications()
    {
        $participantProfile = Auth::user()->participantProfile;

        if (!$participantProfile) {
            return redirect()->route('participant.profile.create')
                ->with('error', 'Silakan lengkapi profil peserta terlebih dahulu.');
        }

        $applications = IntershipsApplication::with(['internship.company'])
            ->where('participant_id', $participantProfile->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('participant.apply.index', compact('applications'));
    }
}
