<?php

namespace App\Http\Controllers\Participant;

use App\Http\Controllers\Controller;
use App\Models\ParticipantProfile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ParticipantProfileController extends Controller
{
    public function index(): View
    {
        $participant = ParticipantProfile::firstOrCreate(
            ['user_id' => auth()->id()],
            [
                'phone_number' => '',
                'address' => '',
                'birth_date' => null,
                'gender' => null,
                'university' => '',
                'study_program' => '',
                'portfolio_url' => '',
                'photo' => null,
                'cv' => null,
                'gpa' => null,
            ]
        );

        return view('participant.profile.index', compact('participant'));
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'phone_number' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'birth_date' => 'nullable|date',
            'gender' => 'nullable|in:male,female',
            'university' => 'nullable|string|max:255',
            'study_program' => 'nullable|string|max:255',
            'portfolio_url' => 'nullable|url|max:255',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'cv' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'gpa' => 'nullable|numeric|between:0,4',
        ]);

        // Ambil profil peserta, jika tidak ada buat baru
        $participant = ParticipantProfile::firstOrCreate(
            ['user_id' => auth()->id()],
            []
        );

        if ($request->hasFile('photo')) {
            if ($participant->photo) {
                Storage::disk('public')->delete($participant->photo);
            }
            $validated['photo'] = $request->file('photo')->store('participants/photos', 'public');
        }

        if ($request->hasFile('cv')) {
            if ($participant->cv) {
                Storage::disk('public')->delete($participant->cv);
            }
            $validated['cv'] = $request->file('cv')->store('participants/cvs', 'public');
        }

        $participant->update($validated);

        return redirect()->route('participant.profile.index')
            ->with('success', 'Profil berhasil diperbarui');
    }
}

