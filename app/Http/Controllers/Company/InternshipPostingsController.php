<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\InternshipPosting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class InternshipPostingsController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $companyProfile = $user->companyProfile;

        if (!$companyProfile) {
            return redirect()->route('company.profile.create')
                ->with('error', 'Silakan lengkapi profil perusahaan terlebih dahulu.');
        }

        $postings = InternshipPosting::where('company_id', $companyProfile->id)
            ->latest()
            ->get();

        return view('company.internships.index', compact('postings'));
    }

    public function create()
    {
        return view('company.internships.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'kuota' => 'required|integer|min:1',
            'lokasi' => 'required|string|max:255',
            'periode_mulai' => 'required|date',
            'periode_selesai' => 'required|date|after_or_equal:periode_mulai',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        InternshipPosting::create([
            'id' => (string) Str::uuid(),
            'company_id' => Auth::user()->companyProfile->id,
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'kuota' => $request->kuota,
            'lokasi' => $request->lokasi,
            'periode_mulai' => $request->periode_mulai,
            'periode_selesai' => $request->periode_selesai,
            'status' => $request->status,
        ]);

        return redirect()->route('company.internships.index')->with('success', 'Lowongan berhasil dibuat.');
    }

    public function show(InternshipPosting $internship)
    {
        if ($internship->company_id !== Auth::user()->companyProfile->id) {
            abort(403);
        }
        return view('company.internships.show', compact('internship'));
    }

    public function edit(InternshipPosting $internship)
    {
        if ($internship->company_id !== Auth::user()->companyProfile->id) {
            abort(403);
        }
        return view('company.internships.edit', compact('internship'));
    }

    public function update(Request $request, InternshipPosting $internship)
    {
        if ($internship->company_id !== Auth::user()->companyProfile->id) {
            abort(403);
        }

        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'kuota' => 'required|integer|min:1',
            'lokasi' => 'required|string|max:255',
            'periode_mulai' => 'required|date',
            'periode_selesai' => 'required|date|after_or_equal:periode_mulai',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        $internship->update($request->only([
            'judul', 'deskripsi', 'kuota', 'lokasi', 'periode_mulai', 'periode_selesai', 'status'
        ]));

        return redirect()->route('company.internships.index')->with('success', 'Lowongan berhasil diperbarui.');
    }

    public function destroy(InternshipPosting $internship)
    {
        if ($internship->company_id !== Auth::user()->companyProfile->id) {
            abort(403);
        }

        $internship->delete();
        return redirect()->route('company.internships.index')->with('success', 'Lowongan berhasil dihapus.');
    }
}
