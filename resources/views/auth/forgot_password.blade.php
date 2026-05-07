@extends('layouts.app')

@section('title', 'Lupa Password - Praktik Mandiri dr. Luria Widijana Haribawanti.')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center align-items-center">
        <div class="col-md-6 col-lg-5">

            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">

                {{-- Header --}}
                <div class="bg-primary bg-gradient text-white text-center py-4">

                    <div class="mb-3">
                        <div 
                            class="bg-white text-primary rounded-circle d-inline-flex justify-content-center align-items-center shadow"
                            style="width: 80px; height: 80px;"
                        >
                            <i class="bi bi-heart-pulse-fill fs-1"></i>
                        </div>
                    </div>

                    <h3 class="fw-bold mb-1">
                        Lupa Password
                    </h3>

                    <p class="mb-0 small opacity-75">
                        Praktik Mandiri dr. Luria Widijana Haribawanti.
                    </p>

                </div>

                {{-- Body --}}
                <div class="card-body p-4 p-md-5">

                    <div class="text-center mb-4">

                        <h5 class="fw-semibold mb-2">
                            Reset Password Akun Pasien
                        </h5>

                        <p class="text-muted small mb-0">
                            Masukkan email yang terdaftar untuk menerima
                            link reset password akun Anda.
                        </p>

                    </div>

                    {{-- Alert Success --}}
                    @if(session('success'))
                        <div class="alert alert-success rounded-3">
                            {{ session('success') }}
                        </div>
                    @endif

                    {{-- Alert Error --}}
                    @if(session('error'))
                        <div class="alert alert-danger rounded-3">
                            {{ session('error') }}
                        </div>
                    @endif

                    {{-- Form --}}
                    <form action="{{ route('password.email') }}" method="POST">
                        @csrf

                        <div class="mb-4">

                            <label class="form-label fw-semibold">
                                Alamat Email
                            </label>

                            <div class="input-group">

                                <span class="input-group-text bg-light border-end-0">
                                    <i class="bi bi-envelope-fill text-primary"></i>
                                </span>

                                <input
                                    type="email"
                                    name="email"
                                    class="form-control border-start-0 @error('email') is-invalid @enderror"
                                    placeholder="contoh@email.com"
                                    value="{{ old('email') }}"
                                >

                                @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>

                        </div>

                        <button
                            type="submit"
                            class="btn btn-primary w-100 py-2 fw-semibold rounded-3 shadow-sm"
                        >
                            <i class="bi bi-send-fill me-2"></i>
                            Kirim Link Reset Password
                        </button>

                    </form>

                    {{-- Divider --}}
                    <div class="text-center my-4">
                        <span class="text-muted small">
                            atau
                        </span>
                    </div>

                    {{-- Back Login --}}
                    <div class="text-center">

                        <a
                            href="/login"
                            class="text-decoration-none fw-semibold"
                        >
                            <i class="bi bi-arrow-left me-1"></i>
                            Kembali ke Login
                        </a>

                    </div>

                </div>

            </div>

        </div>
    </div>
</div>
@endsection