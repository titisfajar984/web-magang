<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\CompanyProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        $company = CompanyProfile::where('user_id', Auth::id())->firstOrFail();
        return view('company.profile.index', compact('company'));
    }

    public function update(Request $request)
    {
        $company = CompanyProfile::where('user_id', Auth::id())->firstOrFail();

        $request->validate([
            'name' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'alamat' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,svg,webp|max:2048',
        ]);

        $data = $request->only('name', 'deskripsi', 'alamat');

        // handle file upload
        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            $filename = time().'_'.$logo->getClientOriginalName();
            $path = $logo->storeAs('logos', $filename, 'public');
            $data['logo'] = $path;
        }

        $company->update($data);

        return redirect()->route('company.profile.index')->with('success', 'Profil perusahaan berhasil diperbarui.');
    }
}
