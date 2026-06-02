@extends('layouts.app')
@section('title', 'Beranda - Klinik Sehat Bersama')

@section('content')

{{-- Hero --}}
<div class="card mb-4 border-0 overflow-hidden hero-section"
    style="background:linear-gradient(135deg,#2563eb,#1d4ed8);color:#fff;border-radius:16px!important;">
    <div class="card-body p-4 p-md-5">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="fw-bold mb-2" style="color:#fff;font-size:clamp(1.4rem,4vw,2rem);">
                    <i class="bi bi-heart-pulse-fill me-2"></i>
                    {{ $klinik->nama_klinik ?? 'Klinik Sehat Bersama' }}
                </h1>
                <p class="mb-3 opacity-90" style="font-size:1rem;">
                    {{ $klinik->deskripsi ?? 'Melayani dengan sepenuh hati.' }}
                </p>
                <div class="d-flex gap-2 flex-wrap">
                    @if(!session('user_id'))
                    <a href="/login" class="btn btn-light fw-semibold">
                        <i class="bi bi-box-arrow-in-right me-2"></i>Login Pasien
                    </a>
                    <a href="/register" class="btn btn-sm"
                        style="background:rgba(255,255,255,0.15);color:#fff;border:1.5px solid rgba(255,255,255,0.4);">
                        Daftar Akun
                    </a>
                    @else
                    <a href="/dashboard" class="btn btn-light fw-semibold">
                        <i class="bi bi-speedometer2 me-2"></i>Dashboard Saya
                    </a>
                    <a href="/antrian/daftar" class="btn btn-sm"
                        style="background:rgba(255,255,255,0.15);color:#fff;border:1.5px solid rgba(255,255,255,0.4);">
                        <i class="bi bi-ticket-perforated me-1"></i>Daftar Antrian
                    </a>
                    @endif
                </div>
            </div>
            <div class="col-md-4 d-none d-md-flex justify-content-end">
                <i class="bi bi-hospital" style="font-size:6rem;opacity:0.2;"></i>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">

    {{-- Info Klinik --}}
    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-header">
                <span class="fw-semibold">
                    <i class="bi bi-info-circle text-primary me-2"></i>Informasi Klinik
                </span>
            </div>
            <div class="card-body">
                <ul class="list-unstyled mb-0">
                    <li class="d-flex gap-2 mb-3">
                        <i class="bi bi-geo-alt-fill text-primary mt-1 flex-shrink-0"></i>
                        <span class="text-muted small">{{ $klinik->alamat ?? '-' }}</span>
                    </li>
                    <li class="d-flex gap-2 mb-3">
                        <i class="bi bi-telephone-fill text-primary mt-1 flex-shrink-0"></i>
                        <span class="text-muted small">{{ $klinik->no_telepon ?? '-' }}</span>
                    </li>
                    <li class="d-flex gap-2">
                        <i class="bi bi-envelope-fill text-primary mt-1 flex-shrink-0"></i>
                        <span class="text-muted small">{{ $klinik->email ?? '-' }}</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    {{-- Jam Operasional --}}
    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-header">
                <span class="fw-semibold">
                    <i class="bi bi-clock text-primary me-2"></i>Jam Operasional
                </span>
            </div>
            <div class="card-body">
                @if($klinik && $klinik->jam_operasional)
                @php $jam = json_decode($klinik->jam_operasional, true); @endphp
                <ul class="list-unstyled mb-0">
                    @foreach($jam as $hari => $waktu)
                    <li class="d-flex justify-content-between align-items-center mb-2">
                        <span class="small fw-medium">{{ $hari }}</span>
                        <span class="badge {{ $waktu == 'Tutup' ? 'status-nonaktif' : 'status-aktif' }}">
                            {{ $waktu }}
                        </span>
                    </li>
                    @endforeach
                </ul>
                @else
                <p class="text-muted small mb-0">Informasi belum tersedia.</p>
                @endif
            </div>
        </div>
    </div>

    {{-- Dokter --}}
    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-header">
                <span class="fw-semibold">
                    <i class="bi bi-person-badge text-primary me-2"></i>Dokter & Jadwal
                </span>
            </div>
            <div class="card-body">
                @forelse($dokter as $dr)
                <div class="{{ !$loop->last ? 'mb-3 pb-3 border-bottom' : '' }}">
                    <div class="d-flex align-items-center gap-2 mb-1">
                        <div style="width:32px;height:32px;background:#eff6ff;border-radius:50%;
                                        display:flex;align-items:center;justify-content:center;">
                            <i class="bi bi-person-fill text-primary" style="font-size:0.85rem;"></i>
                        </div>
                        <div>
                            <p class="mb-0 fw-semibold small">{{ $dr->nama_dokter }}</p>
                            <span class="text-muted" style="font-size:0.75rem;">{{ $dr->bidang_medis }}</span>
                        </div>
                    </div>
                    <div class="ms-5">
                        @foreach($dr->jadwalDokter->where('status', 'Aktif') as $jadwal)
                        <p class="mb-0" style="font-size:0.78rem;color:#64748b;">
                            <i class="bi bi-calendar2-check text-success me-1"></i>
                            {{ $jadwal->hari }},
                            {{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }}–{{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}
                        </p>
                        @endforeach
                    </div>
                </div>
                @empty
                <p class="text-muted small mb-0">Belum ada data dokter.</p>
                @endforelse
            </div>
        </div>
    </div>

</div>

@endsection