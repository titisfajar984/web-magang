<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CompanyProfile;
use App\Models\User;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index()
    {
        $companies = CompanyProfile::with('user')->get();
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
            'deskripsi' => 'required|string',
            'alamat' => 'required|string|max:255',
        ]);

        CompanyProfile::create($request->all());

        return redirect()->route('admin.company.index')->with('success', 'Profil perusahaan berhasil ditambahkan.');
    }

    public function show(CompanyProfile $company)
    {
        return view('admin.company.show', compact('company'));
    }

    public function edit(CompanyProfile $company)
    {
        $users = User::where('role', 'perusahaan')->get();
        return view('admin.company.edit', compact('company', 'users'));
    }

    public function update(Request $request, CompanyProfile $company)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'alamat' => 'required|string|max:255',
        ]);

        $company->update($request->all());

        return redirect()->route('admin.company.index')->with('success', 'Profil perusahaan berhasil diperbarui.');
    }

    public function destroy(CompanyProfile $company)
    {
        $company->delete();
        return redirect()->route('admin.company.index')->with('success', 'Profil perusahaan berhasil dihapus.');
    }
}

