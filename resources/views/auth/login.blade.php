@extends('layouts.app')
@section('title', 'Login - Praktik Mandiri dr. Luria Widijana Haribawanti.')

@section('content')
<div class="login-page">

    {{-- BACKGROUND --}}
    <div class="bg-animation">
        <span class="circle c1"></span>
        <span class="circle c2"></span>
        <span class="circle c3"></span>

        <span class="plus p1">+</span>
        <span class="plus p2">+</span>

        <i class="bi bi-heart-pulse-fill medical-icon icon1"></i>
        <i class="bi bi-shield-plus medical-icon icon2"></i>
        <i class="bi bi-capsule-pill medical-icon icon3"></i>
        <i class="bi bi-bandaid-fill medical-icon icon4"></i>
        <i class="bi bi-hospital medical-icon icon5"></i>
    </div>
    
    <div class="row justify-content-center align-items-center min-vh-100 py-5">    
        <div class="col-11 col-sm-10 col-md-7 col-lg-5">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-body p-4 p-md-5">
                    
                    <div class="text-center mb-4">
                        <i class="bi bi-heart-pulse-fill text-primary" style="font-size: 2.5rem;"></i>
                        <h4 class="mt-2 fw-bold">Login Pasien</h4>
                        <p class="text-muted small">Masuk menggunakan Username atau NIK & Password</p>
                    </div>

                    <form action="/login" method="POST">
                        @csrf

                        {{-- Login --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Username atau NIK</label>
                            <input
                                type="text"
                                name="nik"
                                class="form-control @error('login') is-invalid @enderror"
                                placeholder="Masukkan username atau NIK"
                                value="{{ old('login') }}">
                            @error('login')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Password --}}
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Password</label>
                            <div class="position-relative">
                                <input
                                    type="password"
                                    name="password"
                                    id="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    placeholder="Masukkan password">

                                <i class="bi bi-eye-slash-fill"
                                    id="togglePassword"
                                    style="
                                        position:absolute;
                                        top:50%;
                                        right:15px;
                                        transform:translateY(-50%);
                                        cursor:pointer;
                                        color:#6c757d;
                                        ">
                                </i>
                            </div>

                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Remember + Forgot --}}
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="form-check">
                                <label class="form-check-label" for="remember"> Remember Me</label>
                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        name="remember"
                                        id="remember">
                            </div>
                        
                            <a href="{{ route('password.request') }}" class="small text-decoration-none"> Lupa Password? </a>
                        </div>

                        {{-- Button --}}
                        <button type="submit" class="btn btn-primary w-100 py-2 login-btn" href="{{  route('dashboard')  }}">
                            <i class="bi bi-box-arrow-in-right me-2"></i>Login
                        </button>
                    </form>

                    {{-- tambahkan ini --}}
                    <hr>
                    <p class="text-center small mb-0">Belum punya akun?
                        <a href="/register" class="register-link ms-1">Daftar disini</a>
                    </p>
                </div>
            </div>
            
            <p class="text-center text-muted small mt-3">
                Belum terdaftar? Hubungi staf klinik.
            </p>

        </div>
    </div>
</div>
@endsection