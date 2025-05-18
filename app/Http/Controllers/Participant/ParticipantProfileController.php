<?php

namespace App\Http\Controllers\Participant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ParticipantProfile;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ParticipantProfileController extends Controller
{
    public function index()
    {
        $participant = Auth::user()->participantProfile;
        return view('participant.profile.index', compact('participant'));
    }

    public function update(Request $request)
    {
        $participant = Auth::user()->participantProfile;

        if (!$participant) {
            $participant = Auth::user()->participantProfile()->create([]);
        }

        $request->validate([
            'no_telepon' => 'required|string|max:20',
            'alamat' => 'required|string|max:255',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable|in:Laki-laki,Perempuan',
            'university' => 'nullable|string|max:255',
            'program_studi' => 'nullable|string|max:255',
            'cv' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'transkrip' => 'nullable|numeric|between:0,4',
            'portofolio' => 'nullable|string|max:255',
        ]);

        $data = $request->only([
            'no_telepon', 'alamat', 'tanggal_lahir', 'jenis_kelamin',
            'university', 'program_studi', 'transkrip', 'portofolio'
        ]);

        if ($request->hasFile('cv')) {
            if ($participant->cv) Storage::disk('public')->delete($participant->cv);
            $data['cv'] = $request->file('cv')->store('participants/cv', 'public');
        }

        if ($request->hasFile('foto')) {
            if ($participant->foto) Storage::disk('public')->delete($participant->foto);
            $data['foto'] = $request->file('foto')->store('participants/foto', 'public');
        }

        $participant->update($data);

        return redirect()->route('participant.profile.index')->with('success', 'Profil berhasil diperbarui.');
    }
}
