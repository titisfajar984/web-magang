<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Logbook;
use App\Models\ParticipantProfile;
use App\Models\InternshipApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\Response;

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

    public function export(Request $request)
    {
        $participantId = $request->query('participant_id');

        abort_unless($participantId, Response::HTTP_BAD_REQUEST, 'Participant ID wajib diisi');

        $participant = ParticipantProfile::with('user')->findOrFail($participantId);

        $logbooks = Logbook::with('application.participant.user')
            ->whereHas('application', fn ($q) => $q->where('participant_id', $participantId))
            ->orderBy('tanggal', 'desc')
            ->get()
            ->map(function ($logbook) {
                return [
                    'Nama Peserta' => $logbook->application->participant->user->name ?? '-',
                    'Tanggal'      => $logbook->tanggal->format('Y-m-d'),
                    'Hari'         => $logbook->tanggal->translatedFormat('l'),
                    'Deskripsi'    => $logbook->deskripsi ?? '-',
                    'Kendala'      => $logbook->constraint ?? '-',
                ];
            });

        $fileName = 'logbook_' . str_replace(' ', '_', strtolower($participant->user->name)) . '.xlsx';

        return Excel::download(new class($logbooks) implements \Maatwebsite\Excel\Concerns\FromCollection, \Maatwebsite\Excel\Concerns\WithHeadings {
            protected $data;

            public function __construct(Collection $data)
            {
                $this->data = $data;
            }

            public function collection(): Collection
            {
                return $this->data;
            }

            public function headings(): array
            {
                return [
                    'Nama Peserta',
                    'Tanggal',
                    'Hari',
                    'Deskripsi',
                    'Kendala',
                ];
            }
        }, $fileName);
    }
}
