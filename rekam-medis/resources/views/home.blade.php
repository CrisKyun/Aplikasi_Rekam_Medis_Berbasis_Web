@extends('layouts.app')
@section('title', 'Beranda - Praktik Mandiri dr. Luria Widijana Haribawanti.')

@section('content')

{{-- Hero Section --}}
<div class="p-5 mb-4 bg-primary text-white rounded-3">
    <div class="container-fluid py-3">
        <h1 class="display-5 fw-bold">
            <i class="bi bi-heart-pulse-fill me-2"></i>
            {{ $klinik->nama_klinik ?? 'Praktik Mandiri dr. Luria Widijana Haribawanti.' }}
        </h1>
        <p class="col-md-8 fs-5">{{ $klinik->deskripsi ?? 'Melayani dengan sepenuh hati.' }}</p>
        @if(!session('user_id'))
        <a href="/login" class="btn btn-light btn-lg">
            <i class="bi bi-box-arrow-in-right me-2"></i>Login untuk Lihat Rekam Medis
        </a>
        @else
        <a href="/dashboard" class="btn btn-light btn-lg">
            <i class="bi bi-speedometer2 me-2"></i>Ke Dashboard
        </a>
        @endif
    </div>
</div>

<div class="row g-4">

    {{-- Info Klinik --}}
    <div class="col-md-4">
        <div class="card shadow-sm h-100">
            <div class="card-header bg-primary text-white fw-bold">
                <i class="bi bi-info-circle me-2"></i>Informasi Klinik
            </div>
            <div class="card-body">
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <i class="bi bi-geo-alt-fill text-primary me-2"></i>
                        {{ $klinik->alamat ?? '-' }}
                    </li>
                    <li class="mb-2">
                        <i class="bi bi-telephone-fill text-primary me-2"></i>
                        {{ $klinik->no_telepon ?? '-' }}
                    </li>
                    <li class="mb-2">
                        <i class="bi bi-envelope-fill text-primary me-2"></i>
                        {{ $klinik->email ?? '-' }}
                    </li>
                </ul>
            </div>
        </div>
    </div>

    {{-- Jam Operasional --}}
    <div class="col-md-4">
        <div class="card shadow-sm h-100">
            <div class="card-header bg-primary text-white fw-bold">
                <i class="bi bi-clock-fill me-2"></i>Jam Operasional
            </div>
            <div class="card-body">
                @if($klinik && $klinik->jam_operasional)
                @php $jam = json_decode($klinik->jam_operasional, true); @endphp
                <ul class="list-unstyled">
                    @foreach($jam as $hari => $waktu)
                    <li class="d-flex justify-content-between mb-2">
                        <span class="fw-semibold">{{ $hari }}</span>
                        <span class="{{ $waktu == 'Tutup' ? 'text-danger' : 'text-success' }}">
                            {{ $waktu }}
                        </span>
                    </li>
                    @endforeach
                </ul>
                @else
                <p class="text-muted">Informasi belum tersedia.</p>
                @endif
            </div>
        </div>
    </div>

    {{-- Dokter --}}
    <div class="col-md-4">
        <div class="card shadow-sm h-100">
            <div class="card-header bg-primary text-white fw-bold">
                <i class="bi bi-person-badge-fill me-2"></i>Dokter & Jadwal
            </div>
            <div class="card-body">
                @forelse($dokter as $dr)
                <div class="mb-3">
                    <p class="fw-bold mb-1">
                        <i class="bi bi-person-circle text-primary me-1"></i>
                        {{ $dr->nama_dokter }}
                    </p>
                    <small class="text-muted">{{ $dr->bidang_medis }}</small>
                    <ul class="list-unstyled ms-3 mt-1">
                        @foreach($dr->jadwalDokter->where('status', 'Aktif') as $jadwal)
                        <li class="small">
                            <i class="bi bi-calendar2-check text-success me-1"></i>
                            {{ $jadwal->hari }},
                            {{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }} -
                            {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}
                        </li>
                        @endforeach
                    </ul>
                </div>
                @if(!$loop->last)
                <hr>@endif
                @empty
                <p class="text-muted">Belum ada data dokter.</p>
                @endforelse
            </div>
        </div>
    </div>

</div>
@endsection