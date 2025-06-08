@extends('layouts.participant')

@section('title', 'Laporan Akhir Magang')

@section('content')
<div class="container mx-auto max-w-3xl">

  <!-- Header -->
  <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
    <div>
      <h1 class="text-2xl font-bold text-gray-900">Laporan Akhir Magang</h1>
      <p class="text-gray-600 mt-1">Manajemen laporan akhir magang Anda. Pastikan laporan sudah sesuai dengan ketentuan sebelum mengirim.</p>

      <div class="mt-4 p-4 bg-blue-50 border border-blue-200 rounded-lg">
        <p class="text-blue-800 text-sm">
          ⚠️ Anda hanya dapat mengirim laporan akhir satu kali. Pastikan data sudah benar sebelum submit.
        </p>
      </div>
    </div>

    <a href="{{ route('participant.finalreports.create') }}"
       class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm
              text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
      <i data-feather="plus" class="w-4 h-4 mr-2"></i> Buat Laporan Baru
    </a>
  </div>

  <!-- Tabel laporan -->
  <div class="bg-white shadow rounded-lg overflow-hidden">
    <div class="overflow-x-auto">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
          <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Kirim</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Magang</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          @forelse($finalReports as $report)
          <tr class="hover:bg-gray-50 transition-colors">
            <td class="px-6 py-4 whitespace-nowrap text-gray-800">
              {{ \Carbon\Carbon::parse($report->submission_date)->translatedFormat('d M Y') }}
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-gray-800">
              {{ $report->application->internship->title ?? '-' }}
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              @php
                $statusColors = [
                  'submitted' => 'bg-blue-100 text-blue-800',
                  'reviewed' => 'bg-yellow-100 text-yellow-800',
                  'approved' => 'bg-green-100 text-green-800',
                ];
                $statusText = [
                  'submitted' => 'Dikirimkan',
                  'reviewed' => 'Revisi',
                  'approved' => 'Disetujui',
                ];
                $statusClass = $statusColors[$report->status] ?? 'bg-gray-100 text-gray-800';
                $statusLabel = $statusText[$report->status] ?? 'Tidak Diketahui';
              @endphp
              <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $statusClass }}">
                {{ $statusLabel }}
              </span>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-center">
              <div class="flex justify-center items-center space-x-2">
                <a href="{{ route('participant.finalreports.show', $report->id) }}"
                   class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-blue-600 bg-blue-50 hover:bg-blue-100 rounded-md transition"
                   title="Detail">
                  <i data-feather="eye" class="w-4 h-4 mr-1.5"></i> Detail
                </a>

                @if($report->status === 'reviewed')
                  <a href="{{ route('participant.finalreports.edit', $report->id) }}"
                     class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-yellow-600 bg-yellow-50 hover:bg-yellow-100 rounded-md transition"
                     title="Revisi">
                    <i data-feather="edit" class="w-4 h-4 mr-1.5"></i> Revisi
                  </a>
                @endif
              </div>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="5" class="px-6 py-4 text-center text-gray-500">
              Belum ada laporan akhir yang dikirim.
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', () => {
    if(window.feather) {
      window.feather.replace();
    }
  });
</script>
@endsection
