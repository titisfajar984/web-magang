<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Illuminate\Support\Collection;

class ParticipantUserController extends Controller
{
    public function index()
    {
        $participants = User::with('participantProfile')
            ->where('role', 'participant')
            ->latest()
            ->paginate(6);

        return view('admin.participants.index', compact('participants'));
    }

    public function show($id)
    {
        $participant = User::with('participantProfile')
            ->where('role', 'participant')
            ->findOrFail($id);

        return view('admin.participants.show', compact('participant'));
    }

    public function export()
    {
        $export = new class implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize {
            public function collection()
            {
                return User::with('participantProfile')
                    ->where('role', 'participant')
                    ->get();
            }

            public function headings(): array
            {
                return ['Nama', 'Email', 'No HP', 'Alamat', 'Tanggal Lahir', 'Jenis Kelamin', 'Universitas', 'Program Studi', 'IPK', 'Portofolio', 'Foto', 'CV'];
            }

            public function map($user): array
            {
                $profile = $user->participantProfile;

                return [
                    $user->name,
                    $user->email,
                    $profile->phone_number ?? '-',
                    $profile->address ?? '-',
                    $profile->birth_date ?? '-',
                    $profile->gender ?? '-',
                    $profile->university ?? '-',
                    $profile->study_program ?? '-',
                    $profile->gpa ?? '-',
                    $profile->portfolio_url ?? '-',
                    $profile->photo ? asset('storage/' . $profile->photo) : '-',
                    $profile->cv ? asset('storage/' . $profile->cv) : '-',
                ];
            }
        };

        return Excel::download($export, 'data_peserta.xlsx');
    }
}

