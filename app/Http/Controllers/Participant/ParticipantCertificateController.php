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
}
