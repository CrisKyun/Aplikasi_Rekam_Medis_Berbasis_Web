@extends('layouts.dokter')
@section('title', 'Dashboard Dokter')
@section('page-title', 'Dashboard')

@section('content')

{{-- Statistik --}}
<div class="row g-3 mb-4">
    <div class="col-md-6">
        <div class="card shadow-sm border-0">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="bg-primary text-white rounded-3 p-3" style="font-size: 1.8rem;">
                    <i class="bi bi-people-fill"></i>
                </div>
                <div>
                    <p class="text-muted small mb-0">Total Pasien</p>
                    <h3 class="fw-bold mb-0">{{ $totalPasien }}</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card shadow-sm border-0">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="bg-success text-white rounded-3 p-3" style="font-size: 1.8rem;">
                    <i class="bi bi-clipboard2-pulse-fill"></i>
                </div>
                <div>
                    <p class="text-muted small mb-0">Total Rekam Medis</p>
                    <h3 class="fw-bold mb-0">{{ $totalRekamMedis }}</h3>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Pasien Terbaru --}}
<div class="card shadow-sm border-0">
    <div class="card-header bg-white fw-bold border-0 pt-3">
        <i class="bi bi-clock-history text-primary me-2"></i>Pasien Terbaru
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Nama</th>
                        <th>NIK</th>
                        <th>Jenis Kelamin</th>
                        <th>Tgl Daftar</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pasienTerbaru as $p)
                    <tr>
                        <td>{{ $p->nama_lengkap }}</td>
                        <td>{{ $p->nik }}</td>
                        <td>{{ $p->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                        <td>{{ \Carbon\Carbon::parse($p->tanggal_daftar)->format('d M Y') }}</td>
                        <td>
                            <a href="/dokter/pasien/{{ $p->id }}"
                                class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-eye me-1"></i>Lihat
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-3">
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