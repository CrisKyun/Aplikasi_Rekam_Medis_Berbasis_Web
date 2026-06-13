@extends('layouts.app')
@section('title', 'Login - Praktik Mandiri dr. Luria Widijana Haribawanti.')

@section('content')
<div class="row justify-content-center mt-5">
    <div class="col-md-5">
        <div class="card shadow">
            <div class="card-body p-4">

                <div class="text-center mb-4">
                    <i class="bi bi-heart-pulse-fill text-primary" style="font-size: 2.5rem;"></i>
                    <h4 class="mt-2 fw-bold">Login Pasien</h4>
                    <p class="text-muted small">Masuk menggunakan NIK & Password</p>
                </div>

                <form action="/login" method="POST">
                    @csrf

                    {{-- NIK --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">NIK (16 digit)</label>
                        <input
                            type="text"
                            name="nik"
                            class="form-control @error('nik') is-invalid @enderror"
                            placeholder="Masukkan NIK KTP"
                            value="{{ old('nik') }}"
                            maxlength="16">
                        @error('nik')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Password</label>
                        <input
                            type="password"
                            name="password"
                            class="form-control @error('password') is-invalid @enderror"
                            placeholder="Masukkan password">
                        @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <p class="text-end small mb-0 pt-2"><a href="{{ route('password.request') }}">Lupa Password</a>
                    </p>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-box-arrow-in-right me-2"></i>Login
                    </button>
                </form>

                {{-- tambahkan ini --}}
                <hr>
                <p class="text-center small mb-0">
                    Belum punya akun? <a href="/register">Daftar di sini</a>
                </p>

            </div>
        </div>
        <p class="text-center text-muted small mt-3">
            Belum terdaftar? Hubungi staf klinik.
        </p>
    </div>
</div>
@endsection
