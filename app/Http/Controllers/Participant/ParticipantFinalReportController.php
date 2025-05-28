<?php

namespace App\Http\Controllers\Participant;

use App\Http\Controllers\Controller;
use App\Models\FinalReport;
use App\Models\InternshipApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ParticipantFinalReportController extends Controller
{
    public function index()
    {
        $participant = auth()->user()->participantProfile;
        abort_if(!$participant, 404, 'Profil peserta tidak ditemukan.');

        $application = InternshipApplication::where('participant_id', $participant->id)
            ->latest()
            ->firstOrFail();

        // Ambil hanya laporan peserta ini
        $finalReports = FinalReport::where('application_id', $application->id)
            ->latest()
            ->get();

        return view('participant.finalreports.index', compact('finalReports'));
    }

    public function create()
    {
        return view('participant.finalreports.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required|string|max:255',
            'file' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $participant = auth()->user()->participantProfile;
        abort_if(!$participant, 404, 'Profil peserta tidak ditemukan.');

        $application = InternshipApplication::where('participant_id', $participant->id)
            ->latest()
            ->firstOrFail();

        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('finalreports', 'public');
        }

        FinalReport::create([
            'application_id' => $application->id,
            'description' => $request->description,
            'file_path' => $filePath,
            'submission_date' => now(),
            'status' => 'submitted',
        ]);

        return redirect()->route('participant.finalreports.index')
            ->with('success', 'Laporan akhir berhasil dikirim.');
    }

    public function show(string $id)
    {
        $participant = auth()->user()->participantProfile;
        abort_if(!$participant, 404, 'Profil peserta tidak ditemukan.');

        $finalReport = FinalReport::findOrFail($id);

        // Pastikan laporan ini milik peserta yg login
        abort_if($finalReport->application->participant_id !== $participant->id, 403, 'Akses ditolak.');

        return view('participant.finalreports.show', compact('finalReport'));
    }

    public function edit(string $id)
    {
        $participant = auth()->user()->participantProfile;
        abort_if(!$participant, 404, 'Profil peserta tidak ditemukan.');

        $finalReport = FinalReport::findOrFail($id);

        // Cek kepemilikan & status laporan
        abort_if($finalReport->application->participant_id !== $participant->id, 403, 'Akses ditolak.');
        abort_if($finalReport->status !== 'reviewed', 403, 'Laporan belum bisa direvisi.');

        return view('participant.finalreports.edit', compact('finalReport'));
    }

    public function update(Request $request, string $id)
    {
        $participant = auth()->user()->participantProfile;
        abort_if(!$participant, 404, 'Profil peserta tidak ditemukan.');

        $finalReport = FinalReport::findOrFail($id);

        abort_if($finalReport->application->participant_id !== $participant->id, 403, 'Akses ditolak.');
        abort_if($finalReport->status !== 'reviewed', 403, 'Laporan belum bisa direvisi.');

        $request->validate([
            'description' => 'required|string|max:255',
            'file' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        if ($request->hasFile('file')) {
            if ($finalReport->file_path) {
                Storage::disk('public')->delete($finalReport->file_path);
            }
            $finalReport->file_path = $request->file('file')->store('finalreports', 'public');
        }

        $finalReport->update([
            'description' => $request->description,
            'status' => 'submitted',
            'submission_date' => now(),
        ]);

        return redirect()->route('participant.finalreports.index')
            ->with('success', 'Laporan akhir berhasil diperbarui.');
    }
}
