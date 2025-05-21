<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CompanyProfile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CompanyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin');
    }

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
        ], [
            'user_id.required' => 'Data Pemilik akun harus diisi.',
            'user_id.exists' => 'Pemilik akun tidak valid.',
            'name.required' => 'Data Nama Perusahaan harus diisi.',
            'description.required' => 'Data Deskripsi harus diisi.',
            'address.required' => 'Data Alamat harus diisi.',
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
            ->with('success', 'Profil perusahaan berhasil dibuat.');
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
        ], [
            'user_id.required' => 'Data Pemilik akun harus diisi.',
            'user_id.exists' => 'Pemilik akun tidak valid.',
            'name.required' => 'Data Nama Perusahaan harus diisi.',
            'description.required' => 'Data Deskripsi harus diisi.',
            'address.required' => 'Data Alamat harus diisi.',
        ]);

        $logoPath = $company->logo;

        if ($request->hasFile('logo')) {
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
            ->with('success', 'Profil perusahaan berhasil diperbarui.');
    }

    public function destroy(CompanyProfile $company)
    {
        if ($company->logo) {
            Storage::disk('public')->delete($company->logo);
        }
        $company->delete();

        return redirect()->route('admin.company.index')
            ->with('success', 'Profil perusahaan berhasil dihapus.');
    }
}
