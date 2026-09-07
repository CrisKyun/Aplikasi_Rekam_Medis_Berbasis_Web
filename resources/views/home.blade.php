@extends('layouts.app')
@section('title', 'Beranda - ' . ($klinik->nama_klinik ?? 'Klinik Sehat Bersama'))

@section('content')

{{-- CSS Khusus Landing Page --}}
<style>
    /* Animasi */
    @keyframes pulse-dot {

        0%,
        100% {
            opacity: 1;
            transform: scale(1);
        }

        50% {
            opacity: 0.5;
            transform: scale(1.4);
        }
    }

    @keyframes float {

        0%,
        100% {
            transform: translateY(0px);
        }

        50% {
            transform: translateY(-10px);
        }
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes slideInRight {
        from {
            opacity: 0;
            transform: translateX(40px);
        }

        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes countUp {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }

    .animate-fade-up {
        animation: fadeInUp 0.7s ease forwards;
    }

    .animate-slide-right {
        animation: slideInRight 0.7s ease forwards;
    }

    .delay-1 {
        animation-delay: 0.1s;
        opacity: 0;
    }

    .delay-2 {
        animation-delay: 0.2s;
        opacity: 0;
    }

    .delay-3 {
        animation-delay: 0.3s;
        opacity: 0;
    }

    .delay-4 {
        animation-delay: 0.4s;
        opacity: 0;
    }

    /* Floating card */
    .float-card {
        animation: float 4s ease-in-out infinite;
    }

    .float-card-2 {
        animation: float 4s ease-in-out infinite;
        animation-delay: 1s;
    }

    /* Hero gradient */
    .hero-section {
        background: linear-gradient(135deg, #1e3a8a 0%, #1d4ed8 40%, #2563eb 70%, #3b82f6 100%);
        border-radius: 20px;
        overflow: hidden;
        position: relative;
    }

    .hero-section::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 500px;
        height: 500px;
        background: radial-gradient(circle, rgba(255, 255, 255, 0.08) 0%, transparent 70%);
        border-radius: 50%;
    }

    .hero-section::after {
        content: '';
        position: absolute;
        bottom: -30%;
        left: -10%;
        width: 400px;
        height: 400px;
        background: radial-gradient(circle, rgba(96, 165, 250, 0.15) 0%, transparent 70%);
        border-radius: 50%;
    }

    /* Section anchor */
    .section-anchor {
        scroll-margin-top: 80px;
    }

    /* Stat card hover */
    .stat-item {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        cursor: default;
    }

    .stat-item:hover {
        transform: translateY(-4px);
    }

    /* Feature card */
    .feature-card {
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 1.5rem;
        background: #fff;
        transition: all 0.3s ease;
        height: 100%;
    }

    .feature-card:hover {
        border-color: #2563eb;
        box-shadow: 0 8px 24px rgba(37, 99, 235, 0.12);
        transform: translateY(-4px);
    }

    .feature-icon {
        width: 52px;
        height: 52px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.4rem;
        margin-bottom: 1rem;
        transition: transform 0.3s ease;
    }

    .feature-card:hover .feature-icon {
        transform: scale(1.1) rotate(-5deg);
    }

    /* Step card */
    .step-card {
        position: relative;
        text-align: center;
        padding: 2rem 1.5rem;
        border-radius: 16px;
        background: #fff;
        border: 1px solid #e2e8f0;
        transition: all 0.3s ease;
    }

    .step-card:hover {
        box-shadow: 0 8px 24px rgba(37, 99, 235, 0.1);
        transform: translateY(-4px);
    }

    .step-number {
        position: absolute;
        top: -12px;
        right: 16px;
        font-size: 3rem;
        font-weight: 900;
        color: #eff6ff;
        line-height: 1;
        user-select: none;
    }

    /* Floating badge */
    .floating-badge {
        background: rgba(255, 255, 255, 0.95);
        border-radius: 12px;
        padding: 0.6rem 1rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
        backdrop-filter: blur(10px);
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.82rem;
        font-weight: 600;
        color: #0f172a;
        white-space: nowrap;
    }

    /* CTA banner */
    .cta-banner {
        background: linear-gradient(135deg, #1e3a8a, #2563eb);
        border-radius: 20px;
        padding: 2.5rem;
        position: relative;
        overflow: hidden;
    }

    .cta-banner::before {
        content: '';
        position: absolute;
        top: -40%;
        right: -10%;
        width: 300px;
        height: 300px;
        background: radial-gradient(circle, rgba(255, 255, 255, 0.08) 0%, transparent 70%);
        border-radius: 50%;
    }

    /* Team card */
    .team-card {
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        padding: 1.5rem;
        text-align: center;
        background: #fff;
        transition: all 0.3s ease;
    }

    .team-card:hover {
        box-shadow: 0 8px 24px rgba(37, 99, 235, 0.1);
        transform: translateY(-4px);
        border-color: #bfdbfe;
    }

    /* Smooth scroll */
    html {
        scroll-behavior: smooth;
    }

    /* Navbar section active */
    .nav-section-link.active {
        color: #2563eb !important;
    }

    /* Jam highlight */
    .jam-highlight {
        background: #eff6ff;
        border-radius: 8px;
        padding: 0.4rem 0.75rem;
    }
</style>

{{-- ===================== HERO ===================== --}}
<section id="beranda" class="section-anchor mb-5">
    <div class="hero-section p-4 p-md-5">
        <div class="row align-items-center g-4" style="position:relative;z-index:1;">

            {{-- Kiri: Teks --}}
            <div class="col-md-6">
                <div class="animate-fade-up delay-1">
                    <span class="badge mb-3 px-3 py-2"
                        style="background:rgba(255,255,255,0.15);color:#fff;
                                 font-size:0.78rem;border-radius:50px;">
                        <span style="width:7px;height:7px;background:#4ade80;border-radius:50%;
                                     display:inline-block;margin-right:6px;
                                     animation:pulse-dot 2s infinite;"></span>
                        Layanan Kesehatan Digital
                    </span>
                </div>

                <h1 class="animate-fade-up delay-2 fw-bold mb-3"
                    style="color:#fff;font-size:clamp(1.6rem,4vw,2.4rem);line-height:1.2;">
                    Kesehatan Keluarga,<br>
                    <span style="color:#93c5fd;">Terpantau Digital.</span>
                </h1>

                <p class="animate-fade-up delay-3 mb-4"
                    style="color:rgba(255,255,255,0.8);max-width:460px;line-height:1.7;">
                    {{ $klinik->nama_klinik ?? 'Klinik Sehat Bersama' }} hadir dengan
                    sistem rekam medis digital, antrian online, dan pantauan kesehatan
                    keluarga dalam genggaman.
                </p>

                <div class="animate-fade-up delay-4 d-flex gap-2 flex-wrap">
                    @if(!session('user_id'))
                    <a href="/register"
                        class="btn fw-semibold px-4"
                        style="background:#fff;color:#1d4ed8;border-radius:10px;">
                        <i class="bi bi-person-plus me-2"></i>Daftar Gratis
                    </a>
                    <a href="/login"
                        class="btn fw-medium px-4"
                        style="background:rgba(255,255,255,0.15);color:#fff;
                                  border:1.5px solid rgba(255,255,255,0.35);border-radius:10px;">
                        Sudah punya akun →
                    </a>
                    @else
                    <a href="/antrian/daftar"
                        class="btn fw-semibold px-4"
                        style="background:#fff;color:#1d4ed8;border-radius:10px;">
                        <i class="bi bi-ticket-perforated me-2"></i>Daftar Antrian
                    </a>
                    <a href="/dashboard"
                        class="btn fw-medium px-4"
                        style="background:rgba(255,255,255,0.15);color:#fff;
                                  border:1.5px solid rgba(255,255,255,0.35);border-radius:10px;">
                        <i class="bi bi-speedometer2 me-1"></i>Dashboard
                    </a>
                    @endif
                </div>

                {{-- Stats kecil --}}
                <div class="d-flex gap-4 mt-4 flex-wrap animate-fade-up delay-4">
                    <div>
                        <p class="fw-bold mb-0" style="color:#fff;font-size:1.4rem;">
                            100%
                        </p>
                        <p style="color:rgba(255,255,255,0.6);font-size:0.75rem;margin:0;">
                            Digital
                        </p>
                    </div>
                    <div style="width:1px;background:rgba(255,255,255,0.2);"></div>
                    <div>
                        <p class="fw-bold mb-0" style="color:#fff;font-size:1.4rem;">
                            24/7
                        </p>
                        <p style="color:rgba(255,255,255,0.6);font-size:0.75rem;margin:0;">
                            Akses Data
                        </p>
                    </div>
                    <div style="width:1px;background:rgba(255,255,255,0.2);"></div>
                    <div>
                        <p class="fw-bold mb-0" style="color:#fff;font-size:1.4rem;">
                            Gratis
                        </p>
                        <p style="color:rgba(255,255,255,0.6);font-size:0.75rem;margin:0;">
                            Untuk Pasien
                        </p>
                    </div>
                </div>
            </div>

            {{-- Kanan: Visual Card --}}
            <div class="col-md-6 d-none d-md-block">
                <div style="position:relative;padding:2rem 1rem;">

                    {{-- Card utama --}}
                    <div class="float-card"
                        style="background:rgba(255,255,255,0.12);backdrop-filter:blur(12px);
                                border:1px solid rgba(255,255,255,0.2);border-radius:20px;
                                padding:1.5rem;color:#fff;">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div style="width:44px;height:44px;background:rgba(255,255,255,0.2);
                                        border-radius:12px;display:flex;align-items:center;
                                        justify-content:center;font-size:1.3rem;">
                                <i class="bi bi-clipboard2-pulse-fill"></i>
                            </div>
                            <div>
                                <p class="fw-bold mb-0" style="font-size:0.9rem;">Rekam Medis Digital</p>
                                <p style="font-size:0.75rem;opacity:0.7;margin:0;">Tersimpan & aman</p>
                            </div>
                        </div>
                        <div class="d-flex gap-2 flex-wrap">
                            @foreach(['Keluhan', 'Diagnosis ICD-10', 'Resep Obat', 'Tanda Vital'] as $item)
                            <span style="background:rgba(255,255,255,0.15);color:#fff;
                                         font-size:0.72rem;padding:0.25rem 0.6rem;
                                         border-radius:50px;">{{ $item }}</span>
                            @endforeach
                        </div>
                    </div>

                    {{-- Badge floating kanan bawah --}}
                    <div class="float-card-2"
                        style="position:absolute;bottom:-10px;right:0;
                                background:#fff;border-radius:14px;padding:0.75rem 1rem;
                                box-shadow:0 8px 24px rgba(0,0,0,0.15);
                                display:flex;align-items:center;gap:0.5rem;">
                        <div style="width:36px;height:36px;background:#dcfce7;border-radius:10px;
                                    display:flex;align-items:center;justify-content:center;">
                            <i class="bi bi-ticket-perforated-fill" style="color:#16a34a;"></i>
                        </div>
                        <div>
                            <p class="fw-bold mb-0" style="font-size:0.78rem;color:#0f172a;">
                                Antrian Online
                            </p>
                            <p style="font-size:0.7rem;color:#64748b;margin:0;">
                                Tidak perlu antre lama
                            </p>
                        </div>
                    </div>

                    {{-- Badge floating kiri atas --}}
                    <div style="position:absolute;top:-10px;left:0;
                                background:#fff;border-radius:14px;padding:0.6rem 0.9rem;
                                box-shadow:0 8px 24px rgba(0,0,0,0.12);
                                display:flex;align-items:center;gap:0.5rem;">
                        <i class="bi bi-people-fill" style="color:#2563eb;font-size:1rem;"></i>
                        <span style="font-size:0.78rem;font-weight:600;color:#0f172a;">
                            Satu akun, seluruh keluarga
                        </span>
                    </div>

                </div>
            </div>

        </div>
    </div>
</section>

{{-- ===================== TENTANG ===================== --}}
<section id="tentang" class="section-anchor mb-5">
    <div class="row align-items-center g-4">

        <div class="col-md-6">
            <p class="fw-bold mb-1" style="color:#2563eb;font-size:0.8rem;
               text-transform:uppercase;letter-spacing:0.08em;">
                — Tentang Klinik
            </p>
            <h2 class="fw-bold mb-3" style="font-size:clamp(1.4rem,3vw,1.9rem);line-height:1.3;">
                Pelayanan Kesehatan yang<br>
                <span style="color:#2563eb;">Modern & Terpercaya.</span>
            </h2>
            <p class="text-muted mb-4" style="line-height:1.8;">
                {{ $klinik->deskripsi ?? 'Klinik kami berkomitmen memberikan pelayanan kesehatan terbaik dengan sistem digital yang memudahkan pasien.' }}
            </p>

            <div class="d-flex flex-column gap-3">
                @foreach([
                ['bi-geo-alt-fill', $klinik->alamat ?? '-', 'Lokasi Klinik'],
                ['bi-telephone-fill', $klinik->no_telepon ?? '-', 'Telepon'],
                ['bi-envelope-fill', $klinik->email ?? '-', 'Email'],
                ] as $info)
                <div class="d-flex align-items-center gap-3">
                    <div style="width:40px;height:40px;background:#eff6ff;border-radius:10px;
                                display:flex;align-items:center;justify-content:center;
                                flex-shrink:0;">
                        <i class="bi {{ $info[0] }}" style="color:#2563eb;"></i>
                    </div>
                    <div>
                        <p style="font-size:0.72rem;color:#94a3b8;margin:0;">{{ $info[2] }}</p>
                        <p style="font-size:0.88rem;font-weight:500;color:#0f172a;margin:0;">
                            {{ $info[1] }}
                        </p>
                    </div>
                </div>
                @endforeach
            </div>

            <a href="tel:{{ $klinik->no_telepon ?? '' }}"
                class="btn btn-primary mt-4 px-4"
                style="border-radius:10px;">
                <i class="bi bi-telephone me-2"></i>Hubungi Kami
            </a>
        </div>

        {{-- Jam Operasional --}}
        <div class="col-md-6">
            <div class="card" style="border-radius:20px!important;overflow:hidden;">
                <div class="card-header py-3"
                    style="background:linear-gradient(135deg,#1d4ed8,#2563eb);border:none;">
                    <p class="fw-bold mb-0 text-white">
                        <i class="bi bi-clock-fill me-2"></i>Jam Operasional
                    </p>
                </div>
                <div class="card-body p-0">
                    @if($klinik && $klinik->jam_operasional)
                    @php
                    $jam = json_decode($klinik->jam_operasional, true);
                    $hariIni = strtolower(\Carbon\Carbon::now()->locale('id')->dayName);
                    @endphp
                    @foreach($jam as $hari => $waktu)
                    @php
                    $tutup = strtolower(trim($waktu)) === 'tutup';
                    $relevan = str_contains(strtolower($hari), $hariIni);
                    @endphp
                    <div class="d-flex justify-content-between align-items-center px-4 py-3
                                {{ !$loop->last ? 'border-bottom' : '' }}"
                        style="{{ $relevan ? 'background:#eff6ff;' : '' }}
                                        border-color:#e2e8f0!important;">
                        <div class="d-flex align-items-center gap-2">
                            @if($relevan)
                            <span style="width:8px;height:8px;background:#2563eb;
                                                     border-radius:50%;display:inline-block;
                                                     animation:pulse-dot 2s infinite;"></span>
                            @endif
                            <span class="small {{ $relevan ? 'fw-bold text-primary' : 'text-muted' }}">
                                {{ $hari }}
                                @if($relevan)
                                <span style="font-size:0.7rem;background:#dbeafe;
                                                         color:#1d4ed8;padding:1px 6px;
                                                         border-radius:50px;margin-left:4px;">
                                    Hari ini
                                </span>
                                @endif
                            </span>
                        </div>
                        <span class="badge"
                            style="{{ $tutup
                                          ? 'background:#fee2e2;color:#991b1b;'
                                          : ($relevan
                                              ? 'background:#dbeafe;color:#1d4ed8;'
                                              : 'background:#f0fdf4;color:#166534;') }}
                                             font-size:0.78rem;padding:0.3em 0.8em;">
                            {{ $waktu }}
                        </span>
                    </div>
                    @endforeach
                    @endif
                </div>
            </div>
        </div>

    </div>
</section>

{{-- ===================== FITUR ===================== --}}
<section id="fitur" class="section-anchor mb-5">
    <div class="text-center mb-4">
        <p class="fw-bold mb-1" style="color:#2563eb;font-size:0.8rem;
           text-transform:uppercase;letter-spacing:0.08em;">
            — Fitur Unggulan
        </p>
        <h2 class="fw-bold" style="font-size:clamp(1.4rem,3vw,1.9rem);">
            Semua dalam Satu Platform
        </h2>
        <p class="text-muted" style="max-width:480px;margin:0 auto;">
            Dirancang untuk memudahkan pasien dan tenaga medis bekerja lebih efisien.
        </p>
    </div>

    <div class="row g-3">
        @foreach([
        ['bi-ticket-perforated-fill', '#eff6ff', '#1d4ed8',
        'Antrian Online', 'Daftar antrian dari rumah, pilih dokter & jadwal, dapat nomor + estimasi waktu otomatis.'],
        ['bi-clipboard2-pulse-fill', '#f0fdf4', '#16a34a',
        'Rekam Medis Digital', 'Riwayat kesehatan seluruh keluarga tersimpan rapi dengan diagnosis ICD-10.'],
        ['bi-people-fill', '#faf5ff', '#7c3aed',
        'Satu Akun Keluarga', 'Login sekali, kelola data kesehatan semua anggota keluarga dalam satu akun.'],
        ['bi-graph-up', '#fff7ed', '#c2410c',
        'Grafik Tanda Vital', 'Pantau perkembangan berat badan, tekanan darah, suhu, dan BMI secara visual.'],
        ['bi-shield-check', '#f0fdf4', '#15803d',
        'Data Aman & Terproteksi', 'Akses data dibatasi berdasarkan peran pasien, staff, dan superadmin.'],
        ['bi-bell-fill', '#fffbeb', '#b45309',
        'Notifikasi Status', 'Pantau status antrian secara realtime langsung dari dashboard pasien.'],
        ] as $f)
        <div class="col-md-4 col-6">
            <div class="feature-card">
                <div class="feature-icon"
                    style="background:{{ $f[1] }};color:{{ $f[2] }};">
                    <i class="bi {{ $f[0] }}"></i>
                </div>
                <p class="fw-bold mb-1" style="font-size:0.9rem;">{{ $f[3] }}</p>
                <p class="text-muted mb-0" style="font-size:0.8rem;line-height:1.6;">
                    {{ $f[4] }}
                </p>
            </div>
        </div>
        @endforeach
    </div>
</section>

{{-- ===================== ALUR SISTEM ===================== --}}
<section id="alur" class="section-anchor mb-5">
    <div class="text-center mb-4">
        <p class="fw-bold mb-1" style="color:#2563eb;font-size:0.8rem;
           text-transform:uppercase;letter-spacing:0.08em;">
            — Alur Sistem
        </p>
        <h2 class="fw-bold" style="font-size:clamp(1.4rem,3vw,1.9rem);">
            Mudah dalam 4 Langkah
        </h2>
    </div>

    <div class="row g-3">
        @foreach([
        ['01', 'bi-person-plus-fill', '#eff6ff', '#1d4ed8',
        'Daftar Akun', 'Input NIK & No. KK untuk membuat akun keluarga.'],

        ['02', 'bi-ticket-perforated-fill', '#f0fdf4', '#16a34a',
        'Pilih Antrian', 'Pilih dokter, tanggal, dan ceritakan keluhan awal.'],

        ['03', 'bi-hospital-fill', '#fff7ed', '#c2410c',
        'Datang ke Klinik', 'Hadir sesuai estimasi waktu antrian Anda.'],

        ['04', 'bi-clipboard2-pulse-fill', '#faf5ff', '#7c3aed',
        'Lihat Rekam Medis', 'Riwayat tersimpan & bisa dipantau kapan saja.'],

        ] as $s)

        <div class="col-6 col-md-3">
            <div class="step-card">

                <span class="step-number">{{ $s[0] }}</span>

                <div style="
                    width:52px;
                    height:52px;
                    background:{{ $s[2] }};
                    border-radius:14px;
                    display:flex;
                    align-items:center;
                    justify-content:center;
                    margin:0 auto 1rem;
                    font-size:1.4rem;
                    color:{{ $s[3] }};
                ">
                    <i class="bi {{ $s[1] }}"></i>
                </div>

                {{-- JUDUL --}}
                <p class="fw-bold mb-1 small">
                    {{ $s[4] }}
                </p>

                {{-- DESKRIPSI --}}
                <p class="text-muted mb-0"
                    style="font-size:0.78rem;line-height:1.6;">
                    {{ $s[5] }}
                </p>

            </div>
        </div>

        @endforeach
    </div>
</section>

{{-- ===================== DOKTER ===================== --}}
<section id="dokter" class="section-anchor mb-5">
    <div class="text-center mb-4">
        <p class="fw-bold mb-1" style="color:#2563eb;font-size:0.8rem;
           text-transform:uppercase;letter-spacing:0.08em;">
            — Tenaga Medis
        </p>
        <h2 class="fw-bold" style="font-size:clamp(1.4rem,3vw,1.9rem);">
            Dokter Kami
        </h2>
    </div>

    <div class="row g-3 justify-content-center">
        @forelse($dokter as $dr)
        <div class="col-md-4 col-6">
            <div class="card h-100 text-center" style="border-radius:16px!important;">
                <div class="card-body p-4">
                    <div style="width:64px;height:64px;background:linear-gradient(135deg,#1d4ed8,#3b82f6);
                                border-radius:50%;display:flex;align-items:center;justify-content:center;
                                margin:0 auto 1rem;font-size:1.6rem;color:#fff;">
                        <i class="bi bi-person-fill"></i>
                    </div>
                    <p class="fw-bold mb-1">{{ $dr->nama_dokter }}</p>
                    <span class="badge mb-3"
                        style="background:#eff6ff;color:#1d4ed8;font-size:0.75rem;">
                        {{ $dr->bidang_medis }}
                    </span>

                    @php
                    $jadwalAktif = $dr->jadwalDokter->where('status', 'Aktif');
                    $hariList = $jadwalAktif->pluck('hari')->join(', ');
                    $jam = $jadwalAktif->first();
                    @endphp

                    @if($jadwalAktif->count() > 0)
                    <div style="background:#f8fafc;border-radius:10px;padding:0.75rem;">
                        <p class="small text-muted mb-1">
                            <i class="bi bi-calendar2-week text-primary me-1"></i>
                            {{ $hariList }}
                        </p>
                        @if($jam)
                        <p class="small fw-semibold mb-0" style="color:#0f172a;">
                            <i class="bi bi-clock text-primary me-1"></i>
                            {{ \Carbon\Carbon::parse($jam->jam_mulai)->format('H:i') }}
                            –
                            {{ \Carbon\Carbon::parse($jam->jam_selesai)->format('H:i') }}
                        </p>
                        @endif
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center text-muted py-4">
            <i class="bi bi-person-x" style="font-size:2rem;"></i>
            <p class="mt-2">Belum ada data dokter.</p>
        </div>
        @endforelse
    </div>
</section>

{{-- ===================== CTA ===================== --}}
<section class="mb-5">
    <div class="cta-banner text-center text-md-start">
        <div class="row align-items-center g-3" style="position:relative;z-index:1;">
            <div class="col-md-8">
                <p class="fw-bold mb-2"
                    style="color:#fff;font-size:clamp(1.2rem,3vw,1.6rem);">
                    @if(!session('user_id'))
                    Siap mulai menggunakan layanan digital kami?
                    @else
                    Ingin berobat hari ini?
                    @endif
                </p>
                <p style="color:rgba(255,255,255,0.75);margin:0;font-size:0.9rem;">
                    @if(!session('user_id'))
                    Daftar gratis sekarang dan nikmati kemudahan antrian & rekam medis digital.
                    @else
                    Daftar antrian online sekarang, estimasi waktu langsung tersedia.
                    @endif
                </p>
            </div>
            <div class="col-md-4 text-md-end">
                @if(!session('user_id'))
                <a href="/register"
                    class="btn fw-semibold px-4 py-2"
                    style="background:#fff;color:#1d4ed8;border-radius:10px;">
                    <i class="bi bi-arrow-right me-2"></i>Daftar Sekarang
                </a>
                @else
                <a href="/antrian/daftar"
                    class="btn fw-semibold px-4 py-2"
                    style="background:#fff;color:#1d4ed8;border-radius:10px;">
                    <i class="bi bi-ticket-perforated me-2"></i>Daftar Antrian
                </a>
                @endif
            </div>
        </div>
    </div>
</section>

{{-- ===================== TIM PENGEMBANG ===================== --}}
<section id="tim" class="section-anchor mb-2">
    <div class="text-center mb-4">
        <p class="fw-bold mb-1" style="color:#2563eb;font-size:0.8rem;
           text-transform:uppercase;letter-spacing:0.08em;">
            — Dikembangkan Oleh
        </p>
        <h2 class="fw-bold" style="font-size:clamp(1.2rem,3vw,1.6rem);">
            Tim di Balik Sistem Ini
        </h2>
    </div>

    <div class="row g-3 justify-content-center">

        <div class="col-md-4">
            <div class="team-card">
                <img src="/images/logo-poliwangi.png" alt="Poliwangi"
                    style="height:52px;object-fit:contain;margin-bottom:1rem;"
                    onerror="this.style.display='none'">
                <p class="fw-bold mb-1">Poliwangi</p>
                <p class="text-muted small mb-0">Politeknik Negeri Banyuwangi</p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="team-card" style="border-color:#bfdbfe;">
                <img src="/images/logo-pyk.png" alt="PYK Team"
                    style="height:52px;object-fit:contain;margin-bottom:1rem;"
                    onerror="this.style.display='none'">
                <p class="fw-bold mb-1">PYK Team</p>
                <p class="text-muted small mb-3">Tim Pengembang Aplikasi</p>
                <div class="d-flex gap-2 justify-content-center">
                    <a href="https://wa.me/6281253347412" target="_blank"
                        class="btn btn-sm"
                        style="background:#dcfce7;color:#166534;border-radius:8px;">
                        <i class="bi bi-whatsapp me-1"></i>WhatsApp
                    </a>
                    <a href="mailto:pykteam1@gmail.com"
                        class="btn btn-sm"
                        style="background:#dbeafe;color:#1e40af;border-radius:8px;">
                        <i class="bi bi-envelope me-1"></i>Email
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="team-card">
                <img src="/images/logo-rediswangi.png" alt="Rediswangi"
                    style="height:52px;object-fit:contain;margin-bottom:1rem;"
                    onerror="this.style.display='none'">
                <p class="fw-bold mb-1">Rediswangi</p>
                <p class="text-muted small mb-0">Mitra Kesehatan</p>
            </div>
        </div>

    </div>
</section>

@endsection