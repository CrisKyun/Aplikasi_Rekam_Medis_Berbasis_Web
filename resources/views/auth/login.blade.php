@extends('layouts.app')
@section('title', 'Login - Praktik Mandiri dr. Luria Widijana Haribawanti.')

@section('content')
<div class="row justify-content-center align-items-center" style="min-height:70vh;">
    <div class="col-md-10 col-lg-8">
        <div class="card border-0 overflow-hidden" style="border-radius:20px!important;
             box-shadow:0 20px 60px rgba(37,99,235,0.1)!important;">
            <div class="row g-0">

                {{-- Kiri: Ilustrasi --}}
                <div class="col-md-5 d-none d-md-flex flex-column justify-content-between p-5"
                    style="background:linear-gradient(135deg,#1e3a8a,#2563eb,#3b82f6);">

                    <div>
                        <div class="d-flex align-items-center gap-2 mb-4">
                            <i class="bi bi-heart-pulse-fill" style="color:#fff;font-size:1.4rem;"></i>
                            <span class="fw-bold" style="color:#fff;font-size:1rem;">
                                Praktik Mandiri dr. Luria Widijana Haribawanti.
                            </span>
                        </div>
                        <h3 class="fw-bold mb-3" style="color:#fff;font-size:1.4rem;line-height:1.4;">
                            Selamat Datang di Layanan Kesehatan Digital
                        </h3>
                        <p style="color:rgba(255,255,255,0.75);font-size:0.875rem;line-height:1.7;">
                            Satu platform untuk antrian online, rekam medis digital, dan pantauan kesehatan keluarga.
                        </p>
                    </div>

                    {{-- Fitur singkat --}}
                    <div class="d-flex flex-column gap-3">
                        @foreach([
                        ['bi-ticket-perforated-fill', 'Antrian Online'],
                        ['bi-clipboard2-pulse-fill', 'Rekam Medis Digital'],
                        ['bi-people-fill', 'Satu Akun Keluarga'],
                        ] as $f)
                        <div class="d-flex align-items-center gap-2">
                            <div style="width:32px;height:32px;background:rgba(255,255,255,0.15);
                                        border-radius:8px;display:flex;align-items:center;
                                        justify-content:center;">
                                <i class="bi {{ $f[0] }}" style="color:#fff;font-size:0.9rem;"></i>
                            </div>
                            <span style="color:rgba(255,255,255,0.85);font-size:0.82rem;font-weight:500;">
                                {{ $f[1] }}
                            </span>
                        </div>
                        @endforeach
                    </div>

                </div>

                {{-- Kanan: Form --}}
                <div class="col-md-7">
                    <div class="p-4 p-md-5 pt-md-5 mt-md-4">
                        <form action="/login" method="POST">
                            @csrf

                            {{-- Alert error umum --}}
                            @if($errors->any())
                            <div class="alert mb-4 p-3"
                                style="background:#fef2f2;border-left:4px solid #dc2626;
                border-radius:10px;color:#991b1b;">
                                <div class="d-flex align-items-start gap-2">
                                    <i class="bi bi-exclamation-circle-fill mt-1 flex-shrink-0"></i>
                                    <div>
                                        <p class="fw-semibold mb-1" style="font-size:0.875rem;">
                                            Login gagal
                                        </p>
                                        @foreach($errors->all() as $error)
                                        <p class="mb-0 small">{{ $error }}</p>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            @endif

                            {{-- Input NIK / Email --}}
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Username</label>
                                <div style="position:relative;">
                                    <input type="text"
                                        name="kredensial"
                                        id="kredensialInput"
                                        class="form-control @error('kredensial') is-invalid @enderror"
                                        value="{{ old('kredensial') }}"
                                        placeholder="Masukkan Username"
                                        autocomplete="username"
                                        oninput="detectInput(this.value)">
                                    <span id="inputBadge"
                                        style="position:absolute;right:12px;top:50%;
                                                 transform:translateY(-50%);font-size:0.7rem;
                                                 padding:2px 8px;border-radius:50px;
                                                 display:none;">
                                    </span>
                                </div>
                                @error('kredensial')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Password --}}
                            <div class="mb-4">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <label class="form-label fw-semibold mb-0">Password</label>
                                    <a href="/lupa-password"
                                        style="font-size:0.78rem;color:#2563eb;text-decoration:none;">
                                        Lupa password?
                                    </a>
                                </div>
                                <div style="position:relative;">
                                    <input type="password"
                                        name="password"
                                        id="passwordInput"
                                        class="form-control @error('password') is-invalid @enderror"
                                        placeholder="Masukkan password"
                                        autocomplete="current-password">
                                    <button type="button"
                                        onclick="togglePassword()"
                                        style="position:absolute;right:12px;top:50%;
                                                   transform:translateY(-50%);background:none;
                                                   border:none;color:#94a3b8;cursor:pointer;
                                                   padding:0;">
                                        <i class="bi bi-eye" id="eyeIcon"></i>
                                    </button>
                                </div>
                                @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold"
                                style="border-radius:10px;font-size:0.95rem;">
                                <i class="bi bi-box-arrow-in-right me-2"></i>Masuk
                            </button>

                        </form>

                        <hr style="border-color:#e2e8f0;margin:1.5rem 0;">

                        <p class="text-center small text-muted mb-0">
                            Belum punya akun pasien?
                            <a href="/register" style="color:#2563eb;font-weight:600;">
                                Daftar Gratis →
                            </a>
                        </p>

                    </div>
                </div>

            </div>
        </div>

        {{-- Info tambahan --}}
        <p class="text-center text-muted small mt-3">
            <i class="bi bi-shield-check me-1 text-success"></i>
            Data Anda dilindungi dan dienkripsi secara aman.
        </p>

    </div>
</div>

<script>
    // Toggle show/hide password
    function togglePassword() {
        const input = document.getElementById('passwordInput');
        const icon = document.getElementById('eyeIcon');

        if (input.type === 'password') {
            input.type = 'text';
            icon.className = 'bi bi-eye-slash';
        } else {
            input.type = 'text';
            input.type = 'password';
            icon.className = 'bi bi-eye';
        }
    }
</script>

@endsection