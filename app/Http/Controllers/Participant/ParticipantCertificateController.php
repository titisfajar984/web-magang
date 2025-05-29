<?php

namespace App\Http\Controllers\Participant;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Models\ParticipantProfile as Participant;
use App\Models\Certificate;

class ParticipantCertificateController extends Controller
{
    public function show(string $participantId)
    {
        $participant = Participant::with([
            'user',
            'applications' => function ($query) {
                $query->has('certificate')->with(['certificate', 'internship']);
            }
        ])->findOrFail($participantId);

        return view('participant.certificates.show', compact('participant'));
    }

    public function download(string $certificateId)
    {
        $certificate = Certificate::with('application.participant.user')->findOrFail($certificateId);

        if (Storage::disk('public')->exists($certificate->file_path)) {
            $participantName = $certificate->application->participant->user->name ?? 'participant';
            $safeName = preg_replace('/[^A-Za-z0-9\-]/', '_', strtolower($participantName));
            $filename = "sertifikat_{$safeName}.pdf";

            return Storage::disk('public')->download($certificate->file_path, $filename);
        }

        return redirect()->back()->with('error', 'File sertifikat tidak ditemukan.');
    }
}
