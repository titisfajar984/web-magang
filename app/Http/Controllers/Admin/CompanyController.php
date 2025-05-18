<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CompanyProfile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CompanyController extends Controller
{
    public function index()
    {
        $companies = CompanyProfile::with('user')->latest()->paginate(10);
        return view('admin.company.index', compact('companies'));
    }

    public function create()
    {
        $users = User::where('role', 'company')->get();
        return view('admin.company.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'address' => 'required|string|max:500',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $logoPath = null;
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('company-logos', 'public');
        }

        CompanyProfile::create([
            'user_id' => $request->user_id,
            'name' => $request->name,
            'description' => $request->description,
            'address' => $request->address,
            'logo' => $logoPath,
        ]);

        return redirect()->route('admin.company.index')
                        ->with('success', 'Company profile created successfully.');
    }

    public function show(CompanyProfile $company)
    {
        return view('admin.company.show', compact('company'));
    }

    public function edit(CompanyProfile $company)
    {
        $users = User::where('role', 'company')->get();
        return view('admin.company.edit', compact('company', 'users'));
    }

    public function update(Request $request, CompanyProfile $company)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'address' => 'required|string|max:500',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $logoPath = $company->logo;
        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($company->logo) {
                Storage::disk('public')->delete($company->logo);
            }
            $logoPath = $request->file('logo')->store('company-logos', 'public');
        }

        $company->update([
            'user_id' => $request->user_id,
            'name' => $request->name,
            'description' => $request->description,
            'address' => $request->address,
            'logo' => $logoPath,
        ]);

        return redirect()->route('admin.company.index')
                        ->with('success', 'Company profile updated successfully.');
    }

    public function destroy(CompanyProfile $company)
    {
        if ($company->logo) {
            Storage::disk('public')->delete($company->logo);
        }

        $company->delete();

        return redirect()->route('admin.company.index')
                        ->with('success', 'Company profile deleted successfully.');
    }
}
