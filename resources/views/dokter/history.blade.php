@extends('layouts.dokter')
@section('title', 'History Aktivitas')
@section('page-title', 'History Aktivitas')

@section('content')

{{-- Filter --}}
<div class="card mb-4">
    <div class="card-body">
        <form action="/dokter/history" method="GET">
            <div class="row g-2">

                <div class="col-md-3">
                    <select name="user_id" class="form-select">
                        <option value="">-- Semua Staff --</option>
                        @foreach($staff as $s)
                        <option value="{{ $s->id }}"
                            {{ isset($userId) && $userId == $s->id ? 'selected' : '' }}>
                            {{ $s->nama_lengkap }}
                            ({{ $s->role_id == 1 ? 'Superadmin' : 'Staff' }})
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <select name="modul" class="form-select">
                        <option value="">-- Semua Modul --</option>
                        @foreach([
                        'auth' => 'Login / Logout',
                        'rekam_medis' => 'Rekam Medis',
                        'pasien' => 'Pasien',
                        'antrian' => 'Antrian',
                        'dokter' => 'Dokter',
                        'klinik' => 'Info Klinik',
                        'staff' => 'Kelola Staff',
                        ] as $val => $label)
                        <option value="{{ $val }}"
                            {{ isset($modul) && $modul == $val ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <input type="date" name="tanggal" class="form-control"
                        value="{{ $tanggal ?? '' }}"
                        placeholder="Filter tanggal">
                </div>

                <div class="col-md-3 d-flex gap-2">
                    <button type="submit" class="btn btn-primary flex-grow-1">
                        <i class="bi bi-filter me-1"></i>Filter
                    </button>
                    <a href="/dokter/history" class="btn btn-outline-secondary">
                        <i class="bi bi-x"></i>
                    </a>
                </div>

            </div>
        </form>
    </div>
</div>

{{-- Tabel --}}
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span class="fw-semibold">
            <i class="bi bi-journal-text text-primary me-2"></i>Log Aktivitas
        </span>
        <small class="text-muted">{{ $history->total() }} aktivitas ditemukan</small>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>Waktu</th>
                        <th>Staff</th>
                        <th>Modul</th>
                        <th>Aktivitas</th>
                        <th class="d-none d-md-table-cell">IP</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($history as $h)
                    <tr>
                        <td style="white-space:nowrap;">
                            <p class="mb-0 small fw-medium">
                                {{ \Carbon\Carbon::parse($h->created_at)->format('d M Y') }}
                            </p>
                            <small class="text-muted">
                                {{ \Carbon\Carbon::parse($h->created_at)->format('H:i:s') }}
                            </small>
                        </td>
                        <td>
                            <p class="mb-0 fw-semibold small">
                                {{ $h->user->nama_lengkap ?? 'Unknown' }}
                            </p>
                            <span class="badge"
                                style="{{ ($h->user->role_id ?? 0) == 1
                                    ? 'background:#fee2e2;color:#991b1b;'
                                    : 'background:#dbeafe;color:#1e40af;' }}">
                                {{ ($h->user->role_id ?? 0) == 1 ? 'Superadmin' : 'Staff' }}
                            </span>
                        </td>
                        <td>
                            @php
                            $modulLabel = [
                            'auth' => ['Login/Logout', '#f0fdf4', '#166534'],
                            'rekam_medis' => ['Rekam Medis', '#eff6ff', '#1e40af'],
                            'pasien' => ['Pasien', '#faf5ff', '#6b21a8'],
                            'antrian' => ['Antrian', '#fff7ed', '#9a3412'],
                            'dokter' => ['Dokter', '#f0fdfa', '#065f46'],
                            'klinik' => ['Info Klinik', '#fefce8', '#854d0e'],
                            'staff' => ['Staff', '#fdf2f8', '#9d174d'],
                            ][$h->modul] ?? [$h->modul, '#f8fafc', '#64748b'];
                            @endphp
                            <span class="badge"
                                style="background:{{ $modulLabel[1] }};color:{{ $modulLabel[2] }};">
                                {{ $modulLabel[0] }}
                            </span>
                        </td>
                        <td>
                            <span class="small">{{ $h->deskripsi }}</span>
                        </td>
                        <td class="d-none d-md-table-cell">
                            <small class="text-muted">{{ $h->ip_address ?? '-' }}</small>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-5">
                            <i class="bi bi-journal-x" style="font-size:2rem;"></i>
                            <p class="mt-2 mb-0">Belum ada aktivitas tercatat.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($history->hasPages())
        <div class="p-3 border-top">
            {{ $history->appends(request()->query())->links() }}
        </div>
        @endif

    </div>
</div>

@endsection
