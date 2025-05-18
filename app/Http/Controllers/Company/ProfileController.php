<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\CompanyProfile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function index(): View
    {
        $company = CompanyProfile::where('user_id', auth()->id())->firstOrFail();
        return view('company.profile.index', compact('company'));
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:2000',
            'address' => 'required|string|max:500',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $company = CompanyProfile::where('user_id', auth()->id())->firstOrFail();

        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($company->logo) {
                Storage::disk('public')->delete($company->logo);
            }

            $path = $request->file('logo')->store('company/logos', 'public');
            $validated['logo'] = $path;
        }

        $company->update($validated);

        return redirect()->route('company.profile.index')
            ->with('success', 'Profil perusahaan berhasil diperbarui');
    }
}
