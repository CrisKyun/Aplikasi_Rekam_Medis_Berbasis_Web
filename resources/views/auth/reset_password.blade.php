@extends('layouts.app')

@section('title', 'Reset Password - Praktik Mandiri dr. Luria Widijana Haribawanti.')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center align-items-center">
        <div class="col-md-6 col-lg-5">

            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">

                <div class="bg-primary bg-gradient text-white text-center py-4">
                    <div class="mb-3">
                        <div class="bg-white text-primary rounded-circle d-inline-flex justify-content-center align-items-center shadow"
                            style="width: 80px; height: 80px;">
                            <i class="bi bi-heart-pulse-fill fs-1"></i>
                        </div>
                    </div>

                    <h3 class="fw-bold mb-1">
                        Reset Password
                    </h3>

                    <p class="mb-0 small opacity-75">
                        Praktik Mandiri dr. Luria Widijana Haribawanti.
                    </p>
                </div>

                <div class="card-body p-4 p-md-5">

                    <div class="text-center mb-4">
                        <h5 class="fw-semibold mb-2">
                            Buat Password Baru
                        </h5>

                        <p class="text-muted small mb-0">
                            Silakan masukkan password baru untuk akun pasien Anda.
                        </p>
                    </div>

                    @if(session('success'))
                        <div class="alert alert-success rounded-3">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger rounded-3">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('password.update') }}" method="POST">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                Password Baru
                            </label>

                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="bi bi-lock-fill text-primary"></i>
                                </span>

                                <input
                                    type="password"
                                    name="password"
                                    class="form-control border-start-0 @error('password') is-invalid @enderror"
                                    placeholder="Masukkan password baru"
                                >

                                @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                Konfirmasi Password
                            </label>

                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="bi bi-shield-lock-fill text-primary"></i>
                                </span>

                                <input
                                    type="password"
                                    name="password_confirmation"
                                    class="form-control border-start-0"
                                    placeholder="Ulangi password baru"
                                >
                            </div>
                        </div>

                        <button
                            type="submit"
                            class="btn btn-primary w-100 py-2 fw-semibold rounded-3 shadow-sm"
                        >
                            <i class="bi bi-check-circle-fill me-2"></i>
                            Simpan Password Baru
                        </button>
                    </form>

                </div>

            </div>

        </div>
    </div>
</div>
@endsection