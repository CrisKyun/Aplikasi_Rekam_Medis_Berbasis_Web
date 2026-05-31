@extends('layouts.dokter')
@section('title', 'Detail Pasien')
@section('page-title', 'Detail Pasien')

@section('content')

<div class="mb-3">
    <a href="/dokter/pasien" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i>Kembali
    </a>
</div>

{{-- Grafik Tanda Vital --}}
@include('components.grafik-vital')

<div class="row g-4">

    {{-- Data Diri --}}
    <div class="col-md-4">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white fw-bold border-0 pt-3">
                <i class="bi bi-person-lines-fill text-primary me-2"></i>Data Diri
            </div>
            <div class="card-body small">
                <table class="table table-borderless table-sm">
                    <tr>
                        <td class="text-muted">Nama</td>
                        <td><strong>{{ $pasien->nama_lengkap }}</strong></td>
                    </tr>
                    <tr>
                        <td class="text-muted">NIK</td>
                        <td>{{ $pasien->nik }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Jenis Kelamin</td>
                        <td>{{ $pasien->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Tgl Lahir</td>
                        <td>{{ \Carbon\Carbon::parse($pasien->tanggal_lahir)->format('d M Y') }}</td>
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
                    <tr>
                        <td class="text-muted">Hubungan KK</td>
                        <td>
                            <span class="badge bg-secondary">{{ $pasien->status_hubungan }}</span>
                        </td>
                    </tr>
                    {{-- Status Akun --}}
                    <tr>
                        <td class="text-muted">Status Akun</td>
                        <td>
                            @php $userPasien = \App\Models\User::find($pasien->user_id); @endphp
                            @if($userPasien)
                            <span class="badge {{ $userPasien->status === 'aktif' ? 'bg-success' : 'bg-danger' }}">
                                {{ ucfirst($userPasien->status) }}
                            </span>
                            @if($userPasien->expired_at)
                            <br>
                            <small class="text-warning">
                                <i class="bi bi-clock me-1"></i>
                                Expired: {{ \Carbon\Carbon::parse($userPasien->expired_at)->format('d M Y') }}
                                ({{ \Carbon\Carbon::parse($userPasien->expired_at)->diffForHumans() }})
                            </small>
                            @else
                            <br>
                            <small class="text-success">
                                <i class="bi bi-infinity me-1"></i>Permanen
                            </small>
                            @endif
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        {{-- Toggle Status Akun --}}
        @php $userPasien = \App\Models\User::find($pasien->user_id); @endphp
        @if($userPasien)
        <div class="card shadow-sm border-0 mt-3">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="fw-bold mb-1">
                        Status Akun:
                        <span class="badge {{ $userPasien->status === 'aktif' ? 'bg-success' : 'bg-danger' }}">
                            {{ ucfirst($userPasien->status) }}
                        </span>
                    </h6>
                    <small class="text-muted">
                        {{ $userPasien->status === 'aktif' 
                    ? 'Pasien dapat login dan menggunakan layanan.' 
                    : 'Pasien tidak dapat login. Aktifkan jika ingin berobat.' }}
                    </small>
                </div>
                @php
                $konfirmasi = $userPasien->status === 'aktif' ? 'menonaktifkan' : 'mengaktifkan';
                @endphp
                <form action="/dokter/pasien/{{ $pasien->id }}/toggle-status" method="POST"
                    onsubmit="return confirm('Yakin ingin {{ $konfirmasi }} akun pasien ini?')">
                    @csrf
                    @method('PATCH')
                    <button type="submit"
                        class="btn btn-sm {{ $userPasien->status === 'aktif' ? 'btn-danger' : 'btn-success' }}">
                        <i class="bi bi-{{ $userPasien->status === 'aktif' ? 'x-circle' : 'check-circle' }} me-1"></i>
                        {{ $userPasien->status === 'aktif' ? 'Nonaktifkan' : 'Aktifkan' }}
                    </button>
                </form>
            </div>
        </div>
        @endif
    </div>

    {{-- Rekam Medis --}}
    <div class="col-md-8">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white border-0 pt-3 d-flex justify-content-between align-items-center">
                <span class="fw-bold">
                    <i class="bi bi-clipboard2-pulse-fill text-primary me-2"></i>Rekam Medis
                </span>
                <a href="/dokter/pasien/{{ $pasien->id }}/rekam-medis/tambah"
                    class="btn btn-primary btn-sm">
                    <i class="bi bi-plus-circle me-1"></i>Tambah
                </a>
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
                                    <strong>Dokter:</strong> {{ $rm->dokter }}
                                </p>
                                <p class="mb-1 small">
                                    <strong>Keluhan:</strong> {{ $rm->keluhan }}
                                </p>
                                <p class="mb-0 small">
                                    <strong>Diagnosis:</strong> {{ $rm->diagnosis }}
                                </p>
                            </div>
                            @if($rm->kode_icd10)
                            <p class="mb-1 small">
                                <strong>Diagnosis ICD-10:</strong>
                                <span class="badge bg-primary">{{ $rm->kode_icd10 }}</span>
                                {{ $rm->nama_icd10 }}
                            </p>
                            @endif
                            @if($rm->diagnosis)
                            <p class="mb-0 small text-muted">
                                <strong>Catatan:</strong> {{ $rm->diagnosis }}
                            </p>
                            @endif
                            <div class="d-flex gap-1">
                                <a href="/dokter/rekam-medis/{{ $rm->id }}/edit"
                                    class="btn btn-warning btn-sm">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="/dokter/rekam-medis/{{ $rm->id }}/hapus"
                                    method="POST"
                                    onsubmit="return confirm('Yakin hapus rekam medis ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center text-muted py-4">
                    <i class="bi bi-clipboard2-x" style="font-size: 2rem;"></i>
                    <p class="mt-2">Belum ada rekam medis.</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

</div>
@endsection