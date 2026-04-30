@extends('layouts.app')
@section('title', 'Login Dokter')

@section('content')
<div class="row justify-content-center mt-5">
    <div class="col-md-5">
        <div class="card shadow">
            <div class="card-body p-4">

                <div class="text-center mb-4">
                    <i class="bi bi-person-badge-fill text-primary" style="font-size: 2.5rem;"></i>
                    <h4 class="mt-2 fw-bold">Login Dokter</h4>
                    <p class="text-muted small">Masuk menggunakan Email & Password</p>
                </div>

                <form action="/dokter/login" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Email</label>
                        <input type="email" name="email"
                            class="form-control @error('email') is-invalid @enderror"
                            value="{{ old('email') }}"
                            placeholder="Email terdaftar">
                        @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Password</label>
                        <input type="password" name="password"
                            class="form-control @error('password') is-invalid @enderror"
                            placeholder="Password">
                        @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-box-arrow-in-right me-2"></i>Login
                    </button>

                </form>

            </div>
        </div>
        <p class="text-center text-muted small mt-3">
            <a href="/">← Kembali ke Beranda</a>
        </p>
    </div>
</div>
@endsection