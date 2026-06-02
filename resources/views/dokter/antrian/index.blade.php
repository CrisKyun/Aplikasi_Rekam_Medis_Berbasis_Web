@extends('layouts.dokter')
@section('title', 'Kelola Antrian')
@section('page-title', 'Kelola Antrian')

@section('content')

{{-- Filter --}}
<div class="card shadow-sm border-0 mb-4">
    <div class="card-body">
        <form action="/dokter/antrian" method="GET" class="row g-2">
            <div class="col-md-4">
                <input type="date" name="tanggal" class="form-control"
                    value="{{ $tanggal }}">
            </div>
            <div class="col-md-5">
                <select name="dokter_id" class="form-select">
                    <option value="">-- Semua Dokter --</option>
                    @foreach($dokter as $dr)
                    <option value="{{ $dr->id }}" {{ $dokterId == $dr->id ? 'selected' : '' }}>
                        {{ $dr->nama_dokter }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-filter me-1"></i>Filter
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Statistik Hari Ini --}}
<div class="row g-3 mb-4">
    @php
    $menunggu = $antrian->where('status_antrian', 'menunggu')->count();
    $dipanggil = $antrian->where('status_antrian', 'dipanggil')->count();
    $selesai = $antrian->where('status_antrian', 'selesai')->count();
    $batal = $antrian->where('status_antrian', 'batal')->count();
    @endphp

    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="stat-icon yellow">
                <i class="bi bi-hourglass-split"></i>
            </div>
            <div>
                <p class="stat-label mb-1">Menunggu</p>
                <p class="stat-value">{{ $menunggu }}</p>
            </div>
        </div>
    </div>

    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="stat-icon blue">
                <i class="bi bi-megaphone-fill"></i>
            </div>
            <div>
                <p class="stat-label mb-1">Dipanggil</p>
                <p class="stat-value">{{ $dipanggil }}</p>
            </div>
        </div>
    </div>

    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="stat-icon green">
                <i class="bi bi-check-circle-fill"></i>
            </div>
            <div>
                <p class="stat-label mb-1">Selesai</p>
                <p class="stat-value">{{ $selesai }}</p>
            </div>
        </div>
    </div>

    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="stat-icon red">
                <i class="bi bi-x-circle-fill"></i>
            </div>
            <div>
                <p class="stat-label mb-1">Batal</p>
                <p class="stat-value">{{ $batal }}</p>
            </div>
        </div>
    </div>

</div>

{{-- Tabel Antrian --}}
<div class="card shadow-sm border-0">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>No.</th>
                        <th>Pasien</th>
                        <th>Keluhan Awal</th>
                        <th>Dokter</th>
                        <th>Estimasi</th>
                        <th>Status</th>
                        <th>Aksi</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($antrian as $a)
                    <tr>
                        <td>
                            <span class="fw-bold fs-5 text-primary">{{ $a->nomor_antrian }}</span>
                        </td>
                        <td>
                            <p class="mb-0 fw-semibold">{{ $a->pasien->nama_lengkap }}</p>
                            <small class="text-muted">{{ $a->pasien->nik }}</small>
                        </td>
                        <td>
                            <span class="text-wrap" style="max-width: 200px; display: block;">
                                {{ $a->keluhan_awal ?? '-' }}
                            </span>
                        </td>
                        <td>
                            <p class="mb-0">{{ $a->dokter->nama_dokter }}</p>
                            <small class="text-muted">{{ $a->dokter->bidang_medis }}</small>
                        </td>
                        <td>
                            <i class="bi bi-clock me-1 text-muted"></i>
                            {{ \Carbon\Carbon::parse($a->estimasi_jam)->format('H:i') }} WIB
                        </td>
                        <td>
                            <span class="badge
                                {{ $a->status_antrian === 'menunggu'  ? 'bg-warning text-dark' :
                                   ($a->status_antrian === 'dipanggil' ? 'bg-primary' :
                                   ($a->status_antrian === 'selesai'   ? 'bg-success' : 'bg-danger')) }}">
                                {{ ucfirst($a->status_antrian) }}
                            </span>
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                @if($a->status_antrian === 'menunggu')
                                <form action="/dokter/antrian/{{ $a->id }}/panggil" method="POST">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="btn btn-primary btn-sm">
                                        <i class="bi bi-megaphone me-1"></i>Panggil
                                    </button>
                                </form>
                                @endif

                                @if($a->status_antrian === 'dipanggil')
                                <form action="/dokter/antrian/{{ $a->id }}/selesai" method="POST">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="btn btn-success btn-sm">
                                        <i class="bi bi-check-circle me-1"></i>Selesai
                                    </button>
                                </form>
                                @endif

                                @if(in_array($a->status_antrian, ['menunggu', 'dipanggil']))
                                <form action="/dokter/antrian/{{ $a->id }}/batal" method="POST"
                                    onsubmit="return confirm('Yakin batalkan antrian ini?')">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="bi bi-x-circle"></i>
                                    </button>
                                </form>
                                @endif

                                @if(in_array($a->status_antrian, ['menunggu', 'dipanggil']))
                                <a href="/dokter/antrian/{{ $a->id }}/edit-estimasi"
                                    class="btn btn-outline-secondary btn-sm"
                                    title="Edit Estimasi">
                                    <i class="bi bi-clock"></i>
                                </a>
                                @endif
                            </div>
                        </td>
                        <td>
                            <a href="/dokter/pasien/{{ $a->id }}"
                                class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-eye me-1"></i>Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">
                            <i class="bi bi-ticket-perforated" style="font-size: 2rem;"></i>
                            <p class="mt-2 mb-0">Tidak ada antrian untuk tanggal ini.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection