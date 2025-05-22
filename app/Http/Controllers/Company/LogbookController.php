<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Logbook;
use App\Models\ParticipantProfile;
use App\Models\InternshipApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogbookController extends Controller
{
    public function index(Request $request)
    {
        $company = Auth::user()->companyProfile;
        $participantId = $request->query('participant_id');

        $query = Logbook::with(['application.participant.user'])
            ->whereHas('application.internship', fn($q) => $q->where('company_id', $company->id));

        $participant = null;
        if ($participantId) {
            $participant = ParticipantProfile::with('user')->findOrFail($participantId);

            $hasApplication = InternshipApplication::where('participant_id', $participantId)
                ->whereHas('internship', fn($q) => $q->where('company_id', $company->id))
                ->exists();

            abort_unless($hasApplication, 403, 'Peserta tidak terdaftar di perusahaan Anda');

            $query->whereHas('application', fn($q) => $q->where('participant_id', $participantId));
        }

        $logbooks = $query->orderBy('tanggal', 'desc')->paginate(15);

        return view('company.logbooks.index', compact('logbooks', 'participant'));
    }

    public function show($id)
    {
        $logbook = Logbook::with('application.participant.user')->findOrFail($id);

        $participant = $logbook->application->participant ?? null;

        return view('company.logbooks.show', compact('logbook', 'participant'));
    }
}
