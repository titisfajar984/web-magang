<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InternshipApplication;

class InternshipsController extends Controller
{
    public function applications()
    {
        $company = auth()->user()->companyProfile;
        $applications = InternshipApplication::with(['internship', 'participant.user'])
            ->whereHas('internship', function($query) use ($company) {
                $query->where('company_id', $company->id);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('company.apply.index', compact('applications'));
    }

    public function showApplication($id)
    {
        $application = InternshipApplication::with(['internship', 'participant.user'])
            ->findOrFail($id);

        return view('company.apply.show', compact('application'));
    }

    public function updateApplication(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,accepted,rejected',
        ]);

        $application = InternshipApplication::findOrFail($id);
        $application->update([
            'status' => $request->status,
        ]);

        return back()->with('success', 'Status lamaran berhasil diperbarui');
    }
}
