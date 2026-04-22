@extends('layouts.app')
@section('title', 'Detail Pasien - ' . $pasien->nama_lengkap)

@section('content')

{{-- Header --}}
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <a href="/dashboard" class="btn btn-outline-secondary btn-sm mb-2">
            <i class="bi bi-arrow-left me-1"></i>Kembali
        </a>
        <h4 class="fw-bold mb-0">
            <i class="bi bi-person-fill text-primary me-2"></i>{{ $pasien->nama_lengkap }}
        </h4>
        <small class="text-muted">{{ $pasien->status_hubungan }}</small>
    </div>
    <div class="d-flex gap-2">
        <a href="/pasien/{{ $pasien->id }}/edit" class="btn btn-warning btn-sm">
            <i class="bi bi-pencil me-1"></i>Edit Data
        </a>
        <a href="/rekam-medis/{{ $pasien->id }}/tambah" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-circle me-1"></i>Tambah Rekam Medis
        </a>
    </div>
</div>

<div class="row g-4">

    {{-- Data Diri --}}
    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white fw-bold">
                <i class="bi bi-person-lines-fill me-2"></i>Data Diri
            </div>
            <div class="card-body small">
                <table class="table table-borderless table-sm">
                    <tr>
                        <td class="text-muted">NIK</td>
                        <td>{{ $pasien->nik }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Jenis Kelamin</td>
                        <td>{{ $pasien->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Tempat, Tgl Lahir</td>
                        <td>
                            {{ $pasien->tempat_lahir ?? '-' }},
                            {{ \Carbon\Carbon::parse($pasien->tanggal_lahir)->format('d M Y') }}
                        </td>
                    </tr>
                    <tr>
                        <td class="text-muted">Umur</td>
                        <td>{{ \Carbon\Carbon::parse($pasien->tanggal_lahir)->age }} tahun</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Gol. Darah</td>
                        <td>{{ $pasien->golongan_darah }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Agama</td>
                        <td>{{ $pasien->agama ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">No. HP</td>
                        <td>{{ $pasien->no_hp ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Alamat</td>
                        <td>{{ $pasien->alamat ?? '-' }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    {{-- Riwayat Rekam Medis --}}
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white fw-bold">
                <i class="bi bi-clipboard2-pulse-fill me-2"></i>Riwayat Rekam Medis
            </div>
            <div class="card-body">
                @forelse($pasien->rekamMedis->sortByDesc('tanggal_periksa') as $rm)
                <div class="card mb-3 border-start border-primary border-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <span class="badge bg-primary mb-1">
                                    {{ \Carbon\Carbon::parse($rm->tanggal_periksa)->format('d M Y') }}
                                </span>
                                <p class="mb-1 small">
                                    <i class="bi bi-person-badge me-1 text-muted"></i>
                                    <strong>Dokter:</strong> {{ $rm->dokter }}
                                </p>
                                <p class="mb-1 small">
                                    <i class="bi bi-chat-left-text me-1 text-muted"></i>
                                    <strong>Keluhan:</strong> {{ $rm->keluhan }}
                                </p>
                                <p class="mb-0 small">
                                    <i class="bi bi-file-medical me-1 text-muted"></i>
                                    <strong>Diagnosis:</strong> {{ $rm->diagnosis }}
                                </p>
                            </div>
                            <a href="/rekam-medis/{{ $rm->id }}/detail"
                                class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-eye me-1"></i>Detail
                            </a>
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center text-muted py-4">
                    <i class="bi bi-clipboard2-x" style="font-size: 2rem;"></i>
                    <p class="mt-2">Belum ada riwayat rekam medis.</p>
                    <a href="/rekam-medis/{{ $pasien->id }}/tambah" class="btn btn-primary btn-sm">
                        <i class="bi bi-plus-circle me-1"></i>Tambah Sekarang
                    </a>
                </div>
                @endforelse
            </div>
        </div>
    </div>

</div>
@endsection