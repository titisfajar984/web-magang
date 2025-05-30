<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\FinalReport;
use App\Models\InternshipApplication;
use App\Models\ParticipantProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FinalReportController extends Controller
{
    public function show($participantId)
    {
        $company = Auth::user()->companyProfile;
        abort_if(!$company, 403, 'Profil perusahaan tidak ditemukan.');

        $participant = ParticipantProfile::with('user')->findOrFail($participantId);

        $application = InternshipApplication::with(['internship'])
            ->where('participant_id', $participantId)
            ->whereHas('internship', fn ($q) => $q->where('company_id', $company->id))
            ->latest()
            ->firstOrFail();

        $finalReport = FinalReport::with(['application.participant.user'])
            ->where('application_id', $application->id)
            ->latest()
            ->first();

        return view('company.finalreports.show', compact('finalReport', 'participant'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:reviewed,approved,rejected',
            'feedback' => 'nullable|string|max:1000',
        ]);

        $finalReport = FinalReport::with('application.internship')->findOrFail($id);

        $company = Auth::user()->companyProfile;
        abort_if(!$company, 403, 'Profil perusahaan tidak ditemukan.');

        abort_unless(
            $finalReport->application->internship->company_id === $company->id,
            403,
            'Anda tidak memiliki akses ke laporan ini.'
        );

        if ($request->status === 'reviewed' && empty($request->feedback)) {
            return back()->withErrors([
                'feedback' => 'Feedback wajib diisi saat status diubah menjadi reviewed.'
            ])->withInput();
        }

        $finalReport->update([
            'status' => $request->status,
            'feedback' => $request->feedback,
        ]);

        return back()->with('success', 'Status laporan akhir berhasil diperbarui.');
    }
}
