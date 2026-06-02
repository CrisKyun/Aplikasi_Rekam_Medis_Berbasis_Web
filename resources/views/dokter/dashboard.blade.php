@extends('layouts.dokter')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')

<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="stat-icon blue">
                <i class="bi bi-people-fill"></i>
            </div>
            <div>
                <p class="stat-label mb-1">Total Pasien</p>
                <p class="stat-value">{{ $totalPasien }}</p>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="stat-icon green">
                <i class="bi bi-clipboard2-pulse-fill"></i>
            </div>
            <div>
                <p class="stat-label mb-1">Rekam Medis</p>
                <p class="stat-value">{{ $totalRekamMedis }}</p>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="stat-icon yellow">
                <i class="bi bi-ticket-perforated-fill"></i>
            </div>
            <div>
                <p class="stat-label mb-1">Antrian Hari Ini</p>
                <p class="stat-value">{{ \App\Models\Pendaftaran::where('tanggal_kunjungan', today())->count() }}</p>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="stat-icon red">
                <i class="bi bi-clock-fill"></i>
            </div>
            <div>
                <p class="stat-label mb-1">Menunggu</p>
                <p class="stat-value">{{ \App\Models\Pendaftaran::where('tanggal_kunjungan', today())->where('status_antrian','menunggu')->count() }}</p>
            </div>
        </div>
    </div>
</div>

{{-- Pasien Terbaru --}}
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span class="fw-semibold">
            <i class="bi bi-clock-history text-primary me-2"></i>Pasien Terbaru
        </span>
        <a href="/dokter/pasien" class="btn btn-outline-primary btn-sm">Lihat Semua</a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th class="d-none d-md-table-cell">NIK</th>
                        <th class="d-none d-md-table-cell">Jenis Kelamin</th>
                        <th class="d-none d-sm-table-cell">Tgl Daftar</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pasienTerbaru as $p)
                    <tr>
                        <td>
                            <p class="mb-0 fw-semibold">{{ $p->nama_lengkap }}</p>
                            <small class="text-muted d-md-none">{{ $p->nik }}</small>
                        </td>
                        <td class="d-none d-md-table-cell text-muted">{{ $p->nik }}</td>
                        <td class="d-none d-md-table-cell">
                            {{ $p->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                        </td>
                        <td class="d-none d-sm-table-cell text-muted">
                            {{ \Carbon\Carbon::parse($p->tanggal_daftar)->format('d M Y') }}
                        </td>
                        <td>
                            <a href="/dokter/pasien/{{ $p->id }}"
                                class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-eye"></i>
                                <span class="d-none d-md-inline ms-1">Lihat</span>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">
                            Belum ada data pasien.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection