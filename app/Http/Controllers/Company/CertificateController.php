<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\InternshipApplication;
use App\Models\Certificate;

class CertificateController extends Controller
{
    public function create($participantId)
    {
        $application = InternshipApplication::with(['participant.user', 'internship', 'certificate'])
            ->where('participant_id', $participantId)
            ->firstOrFail();

        return view('company.certificates.create', compact('application'));
    }

    public function store(Request $request, $participantId)
    {
        $application = InternshipApplication::where('participant_id', $participantId)->firstOrFail();

        $request->validate([
            'certificate' => 'required|file|mimes:pdf|max:2048',
        ],
        [
            'certificate.required' => 'Sertifikat wajib diunggah.',
            'certificate.file' => 'File harus berupa file yang valid.',
            'certificate.mimes' => 'File harus berformat PDF.',
            'certificate.max' => 'Ukuran file tidak boleh lebih dari 2MB.',
        ]);

        // Hapus file lama jika ada
        if ($application->certificate && Storage::disk('public')->exists($application->certificate->file_path)) {
            Storage::disk('public')->delete($application->certificate->file_path);
        }

        $path = $request->file('certificate')->store('certificates', 'public');

        // Simpan/update sertifikat
        Certificate::updateOrCreate(
            ['application_id' => $application->id],
            ['file_path' => $path]
        );

        return redirect()->route('company.certificates.create', $participantId)
                         ->with('success', 'Sertifikat berhasil diunggah.');
    }
}
