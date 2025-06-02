<?php

namespace App\Http\Controllers\Participant;

use App\Http\Controllers\Controller;
use App\Models\Logbook;
use App\Models\InternshipApplication;
use Illuminate\Http\Request;

class ParticipantLogbookController extends Controller
{
    public function index(Request $request)
    {
        $participant = auth()->user()->participantProfile;

        if (!$participant) {
            abort(404, 'Profil peserta tidak ditemukan.');
        }

        $applications = InternshipApplication::where('participant_id', $participant->id)
            ->where('status', 'accepted')
            ->where('result_received', true)
            ->get();

        $selectedApplicationId = $request->get('application_id') ?? $applications->first()?->id;

        $logbooks = Logbook::where('application_id', $selectedApplicationId)->latest()->get();

        return view('participant.logbooks.index', compact('applications', 'selectedApplicationId', 'logbooks'));
    }

    public function create(Request $request)
    {
        $participant = auth()->user()->participantProfile;

        if (!$participant) {
            abort(404, 'Profil peserta tidak ditemukan.');
        }

        $applications = InternshipApplication::where('participant_id', $participant->id)
            ->where('status', 'accepted')
            ->where('result_received', true)
            ->get();

        $selectedApplicationId = $request->get('application_id') ?? $applications->first()?->id;

        return view('participant.logbooks.create', compact('applications', 'selectedApplicationId'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'application_id' => 'required|exists:internship_applications,id',
            'tanggal' => 'required|date',
            'deskripsi' => 'required|string|max:255',
            'constraint' => 'nullable|string|max:255',
        ]);

        $participant = auth()->user()->participantProfile;

        if (!$participant) {
            abort(404, 'Profil peserta tidak ditemukan.');
        }

        $application = InternshipApplication::where('id', $request->application_id)
            ->where('participant_id', $participant->id)
            ->firstOrFail();

        Logbook::create([
            'application_id' => $application->id,
            'tanggal' => $request->tanggal,
            'deskripsi' => $request->deskripsi,
            'constraint' => $request->constraint,
        ]);

        return redirect()->route('participant.logbooks.index', ['application_id' => $application->id])
            ->with('success', 'Logbook berhasil ditambahkan.');
    }

    public function edit(Logbook $logbook)
    {
        $this->authorize('update', $logbook);
        return view('participant.logbooks.edit', compact('logbook'));
    }

    public function update(Request $request, Logbook $logbook)
    {
        $this->authorize('update', $logbook);

        $request->validate([
            'tanggal' => 'required|date',
            'deskripsi' => 'required|string|max:255',
            'constraint' => 'nullable|string|max:255',
        ]);

        $logbook->update($request->only(['tanggal', 'deskripsi', 'constraint']));

        return redirect()->route('participant.logbooks.index', ['application_id' => $logbook->application_id])
            ->with('success', 'Logbook berhasil diperbarui.');
    }

    public function destroy(Logbook $logbook)
    {
        $this->authorize('delete', $logbook);
        $logbook->delete();
        return back()->with('success', 'Logbook berhasil dihapus.');
    }
}


