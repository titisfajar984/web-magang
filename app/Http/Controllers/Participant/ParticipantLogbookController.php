<?php

namespace App\Http\Controllers\Participant;

use App\Http\Controllers\Controller;
use App\Models\Logbook;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\InternshipApplication;

class ParticipantLogbookController extends Controller
{
    public function index()
    {
        $participant = auth()->user()->participantProfile;

        if (!$participant) {
            abort(404, 'Profil peserta tidak ditemukan.');
        }

        $application = InternshipApplication::where('participant_id', $participant->id)
            ->latest()
            ->firstOrFail();

        $logbooks = Logbook::where('application_id', $application->id)->latest()->get();

        return view('participant.logbooks.index', compact('logbooks'));
    }

    public function create()
    {
        return view('participant.logbooks.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'deskripsi' => 'required|string|max:255',
            'constraint' => 'nullable|string|max:255',
        ],
        [
            'tanggal.required' => 'Tanggal wajib diisi.',
            'tanggal.date' => 'Tanggal harus berupa tanggal yang valid.',
            'deskripsi.required' => 'Deskripsi wajib diisi.',
            'deskripsi.max' => 'Deskripsi tidak boleh lebih dari 255 karakter.',
            'constraint.max' => 'Constraint tidak boleh lebih dari 255 karakter.',
        ]);

        $participant = auth()->user()->participantProfile;

        if (!$participant) {
            abort(404, 'Profil peserta tidak ditemukan.');
        }

        $application = InternshipApplication::where('participant_id', $participant->id)
            ->latest()
            ->firstOrFail();

        Logbook::create([
            'application_id' => $application->id,
            'tanggal' => $request->tanggal,
            'deskripsi' => $request->deskripsi,
            'constraint' => $request->constraint,
        ]);


        return redirect()->route('participant.logbooks.index')->with('success', 'Logbook berhasil ditambahkan.');
    }

    public function edit(Logbook $logbook)
    {
        return view('participant.logbooks.edit', compact('logbook'));
    }

    public function update(Request $request, Logbook $logbook)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'deskripsi' => 'required|string|max:255',
            'constraint' => 'nullable|string|max:255',
        ]);

        $logbook->update([
            'tanggal' => $request->tanggal,
            'deskripsi' => $request->deskripsi,
            'constraint' => $request->constraint,
        ]);

        return redirect()->route('participant.logbooks.index')->with('success', 'Logbook berhasil diperbarui.');
    }


    public function destroy(Logbook $logbook)
    {
        $logbook->delete();
        return back()->with('success', 'Logbook berhasil dihapus.');
    }
}
