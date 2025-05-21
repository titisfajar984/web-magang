<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\InternshipPosting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class InternshipPostingsController extends Controller
{
    public function index(): View
    {
        $company = auth()->user()->companyProfile;
        abort_unless($company, 403, 'Harap lengkapi profil perusahaan Anda terlebih dahulu.');

        $postings = InternshipPosting::where('company_id', $company->id)
            ->latest()
            ->get();

        return view('company.internships.index', compact('postings'));
    }

    public function create(): View
    {
        return view('company.internships.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate($this->validationRules(), $this->validationMessages());

        InternshipPosting::create(array_merge($validated, [
            'company_id' => auth()->user()->companyProfile->id,
        ]));

        return redirect()
            ->route('company.internships.index')
            ->with('success', 'Lowongan magang berhasil dibuat.');
    }

    public function show(InternshipPosting $internship): View
    {
        $this->abortIfNotOwned($internship);
        return view('company.internships.show', compact('internship'));
    }

    public function edit(InternshipPosting $internship): View
    {
        $this->abortIfNotOwned($internship);
        return view('company.internships.edit', compact('internship'));
    }

    public function update(Request $request, InternshipPosting $internship): RedirectResponse
    {
        $this->abortIfNotOwned($internship);

        $validated = $request->validate($this->validationRules(), $this->validationMessages());
        $internship->update($validated);

        return redirect()
            ->route('company.internships.index')
            ->with('success', 'Lowongan magang berhasil diperbarui.');
    }

    public function destroy(InternshipPosting $internship): RedirectResponse
    {
        $this->abortIfNotOwned($internship);
        $internship->delete();

        return redirect()
            ->route('company.internships.index')
            ->with('success', 'Lowongan magang berhasil dihapus.');
    }

    protected function validationRules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:5000',
            'quota' => 'required|integer|min:1|max:100',
            'location' => 'required|string|max:255',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|in:active,inactive',
        ];
    }

    protected function validationMessages(): array
    {
        return [
            'title.required' => 'Judul lowongan harus diisi.',
            'description.required' => 'Deskripsi lowongan harus diisi.',
            'quota.required' => 'Jumlah kuota harus diisi.',
            'location.required' => 'Lokasi harus diisi.',
            'start_date.required' => 'Tanggal mulai harus diisi.',
            'end_date.required' => 'Tanggal selesai harus diisi.',
            'status.required' => 'Status harus dipilih.',
            'start_date.after_or_equal' => 'Tanggal mulai harus hari ini atau setelahnya.',
            'end_date.after_or_equal' => 'Tanggal selesai harus setelah atau sama dengan tanggal mulai.',
        ];
    }

    protected function abortIfNotOwned(InternshipPosting $internship): void
    {
        $companyId = auth()->user()->companyProfile?->id;

        abort_if(
            !$companyId || $internship->company_id !== $companyId,
            403,
            'Anda tidak memiliki akses ke lowongan magang ini.'
        );
    }
}
