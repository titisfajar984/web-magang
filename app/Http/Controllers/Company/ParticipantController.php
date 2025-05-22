<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\InternshipApplication;
use Illuminate\Support\Facades\Auth;

class ParticipantController extends Controller
{
    public function index()
    {
        $company = Auth::user()->companyProfile;

        $applications = InternshipApplication::with(['participant.user', 'internship'])
            ->where('status', 'accepted')
            ->where('result_received', true)
            ->whereHas('internship', fn($q) => $q->where('company_id', $company->id))
            ->latest()
            ->paginate(15);

        return view('company.participants.index', compact('applications'));
    }
}
