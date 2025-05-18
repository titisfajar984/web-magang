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
        $companyProfile = auth()->user()->companyProfile;
        abort_unless($companyProfile, 403, 'Please complete your company profile first');

        $postings = InternshipPosting::query()
            ->where('company_id', $companyProfile->id)
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
        $validated = $request->validate($this->validationRules());

        InternshipPosting::create([
            'company_id' => auth()->user()->companyProfile->id,
            ...$validated
        ]);

        return redirect()
            ->route('company.internships.index')
            ->with('success', 'Internship posting created successfully');
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

        $validated = $request->validate($this->validationRules());
        $internship->update($validated);

        return redirect()
            ->route('company.internships.index')
            ->with('success', 'Internship posting updated successfully');
    }

    public function destroy(InternshipPosting $internship): RedirectResponse
    {
        $this->abortIfNotOwned($internship);
        $internship->delete();

        return redirect()
            ->route('company.internships.index')
            ->with('success', 'Internship posting deleted successfully');
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

    protected function abortIfNotOwned(InternshipPosting $internship): void
    {
        $companyId = auth()->user()->companyProfile?->id;
        if ($internship->company_id !== $companyId) {
            abort(403, 'You are not authorized to access this internship posting.');
        }
    }
}
