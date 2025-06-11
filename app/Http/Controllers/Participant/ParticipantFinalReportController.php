<?php

namespace App\Http\Controllers\Participant;

use App\Http\Controllers\Controller;
use App\Models\FinalReport;
use App\Models\InternshipApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ParticipantFinalReportController extends Controller
{
    public function index(Request $request)
    {
        $participant = auth()->user()->participantProfile;
        abort_if(!$participant, 404, 'Profil peserta tidak ditemukan.');

        $applications = InternshipApplication::where('participant_id', $participant->id)
            ->where('status', 'accepted')
            ->where('result_received', true)
            ->get();

        $applicationIds = $applications->pluck('id')->toArray();

        $selectedApplicationId = $request->input('application_id');

        $query = FinalReport::whereIn('application_id', $applicationIds)->latest();

        if ($selectedApplicationId && in_array($selectedApplicationId, $applicationIds)) {
            $query->where('application_id', $selectedApplicationId);
        }

        $finalReports = $query->get();

        return view('participant.finalreports.index', compact('finalReports', 'applications', 'selectedApplicationId'));
    }

    public function create()
    {
        $participant = auth()->user()->participantProfile;
        abort_if(!$participant, 404, 'Profil peserta tidak ditemukan.');

        $applications = InternshipApplication::where('participant_id', $participant->id)
            ->where('status', 'accepted')
            ->where('result_received', true)
            ->get();

        if ($applications->isEmpty()) {
            return redirect()->route('participant.finalreports.index')
                ->with('error', 'Anda harus mengikuti magang terlebih dahulu sebelum membuat laporan akhir.');
        }

        return view('participant.finalreports.create', compact('applications'));
    }

    public function store(Request $request)
    {
        $participant = auth()->user()->participantProfile;
        abort_if(!$participant, 404, 'Profil peserta tidak ditemukan.');

        $request->validate([
            'application_id' => 'required|exists:internship_applications,id',
            'description' => 'required|string|max:255',
            'file' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ], [
            'application_id.required' => 'Pilih magang terlebih dahulu.',
            'application_id.exists' => 'Pilihan magang tidak valid.',
            'description.required' => 'Deskripsi wajib diisi.',
            'description.max' => 'Deskripsi tidak boleh lebih dari 255 karakter.',
            'file.file' => 'File harus berupa file yang valid.',
            'file.mimes' => 'File harus berformat pdf, doc, atau docx.',
            'file.max' => 'Ukuran file tidak boleh lebih dari 2MB.',
        ]);

        $application = InternshipApplication::where('participant_id', $participant->id)
            ->where('id', $request->application_id)
            ->firstOrFail();

        $exists = FinalReport::where('application_id', $application->id)->exists();

        if ($exists) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['application_id' => 'Anda sudah membuat laporan untuk magang ini. Tidak bisa membuat laporan duplikat.']);
        }

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
