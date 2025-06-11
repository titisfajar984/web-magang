<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\InternshipApplication;
use App\Models\Certificate;
use Illuminate\Support\Facades\Auth;

class CertificateController extends Controller
{
    public function create($participantId)
    {
        $company = Auth::user()->companyProfile;

        $application = InternshipApplication::with(['participant.user', 'internship', 'certificate'])
            ->where('participant_id', $participantId)
            ->where('status', 'accepted')
            ->where('result_received', true)
            ->whereHas('internship', fn($q) => $q->where('company_id', $company->id))
            ->firstOrFail();

        return view('company.certificates.create', compact('application'));
    }

    public function store(Request $request, $participantId)
    {
        $company = Auth::user()->companyProfile;

        $application = InternshipApplication::where('participant_id', $participantId)
            ->where('status', 'accepted')
            ->where('result_received', true)
            ->whereHas('internship', fn($q) => $q->where('company_id', $company->id))
            ->firstOrFail();

        $request->validate([
            'certificate' => 'required|file|mimes:pdf|max:2048',
        ], [
            'certificate.required' => 'Sertifikat wajib diunggah.',
            'certificate.file' => 'File harus berupa file yang valid.',
            'certificate.mimes' => 'File harus berformat PDF.',
            'certificate.max' => 'Ukuran file tidak boleh lebih dari 2MB.',
        ]);

        if ($application->certificate && Storage::disk('public')->exists($application->certificate->file_path)) {
            Storage::disk('public')->delete($application->certificate->file_path);
        }

        $path = $request->file('certificate')->store('certificates', 'public');

        Certificate::updateOrCreate(
            ['application_id' => $application->id],
            ['file_path' => $path]
        );

        return redirect()->route('company.certificates.create', $participantId)
                        ->with('success', 'Sertifikat berhasil diunggah.');
    }
}
