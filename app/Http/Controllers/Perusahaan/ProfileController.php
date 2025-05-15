<?php

namespace App\Http\Controllers\Perusahaan;

use App\Http\Controllers\Controller;
use App\Models\CompanyProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function edit()
    {
        $company = CompanyProfile::where('user_id', Auth::id())->firstOrFail();
        return view('perusahaan.profile.index', compact('company'));
    }

    public function update(Request $request)
    {
        $company = CompanyProfile::where('user_id', Auth::id())->firstOrFail();

        $request->validate([
            'name' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'alamat' => 'required|string|max:255',
        ]);

        $company->update($request->only('name', 'deskripsi', 'alamat'));

        return redirect()->route('perusahaan.profile.index')->with('success', 'Profil perusahaan berhasil diperbarui.');
    }
}
