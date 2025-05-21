<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InternshipApplication;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class InternshipsController extends Controller
{
    public function applications(): View
    {
        $company = auth()->user()->companyProfile;
        abort_unless($company, 403, 'Harap lengkapi profil perusahaan Anda terlebih dahulu.');

        $applications = InternshipApplication::with(['internship', 'participant.user'])
            ->whereHas('internship', function ($query) use ($company) {
                $query->where('company_id', $company->id);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('company.apply.index', compact('applications'));
    }

    protected function abortIfNotOwned(InternshipApplication $application): void
    {
        $companyId = auth()->user()->companyProfile?->id;

        abort_if(
            !$companyId || $application->internship?->company_id !== $companyId,
            403,
            'Anda tidak berwenang mengakses lamaran ini.'
        );
    }

    public function showApplication(int $id): View
    {
        $application = InternshipApplication::with(['internship', 'participant.user'])->findOrFail($id);

        $this->abortIfNotOwned($application);

        return view('company.apply.show', compact('application'));
    }

    public function updateApplication(Request $request, int $id): RedirectResponse
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,accepted,rejected',
        ], [
            'status.required' => 'Status lamaran harus dipilih.',
            'status.in' => 'Status lamaran tidak valid.',
        ]);

        $application = InternshipApplication::findOrFail($id);

        $this->abortIfNotOwned($application);

        $application->update([
            'status' => $validated['status'],
        ]);

        return back()->with('success', 'Status lamaran berhasil diperbarui.');
    }
}
