@extends('layouts.app')
@section('title', 'Registrasi - Praktik Mandiri dr. Luria Widijana Haribawanti.')

@section('content')
<div class="row justify-content-center mt-4">
    <div class="col-md-7">
        <div class="card shadow">
            <div class="card-header bg-primary text-white fw-bold">
                <i class="bi bi-person-plus-fill me-2"></i>Registrasi Akun Pasien
            </div>
            <div class="card-body p-4">

                <form action="/register" method="POST">
                    @csrf

                    {{-- INFO AKUN --}}
                    <p class="fw-semibold text-primary mb-3">
                        <i class="bi bi-shield-lock me-1"></i>Informasi Akun
                    </p>

                    <div class="row g-3 mb-3">

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">NIK Kepala Keluarga <span class="text-danger">*</span></label>
                            <input type="text" name="nik"
                                class="form-control @error('nik') is-invalid @enderror"
                                value="{{ old('nik') }}" maxlength="16"
                                placeholder="16 digit NIK KTP">
                            @error('nik')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">No. Kartu Keluarga <span class="text-danger">*</span></label>
                            <input type="text" name="no_kk"
                                class="form-control @error('no_kk') is-invalid @enderror"
                                value="{{ old('no_kk') }}" maxlength="16"
                                placeholder="16 digit No. KK">
                            @error('no_kk')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-12">
                            <label class="form-label fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" name="username"
                                class="form-control @error('username') is-invalid @enderror"
                                value="{{ old('username') }}"
                                placeholder="Nama sesuai KTP">
                            @error('username')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-12">
                            <label class="form-label fw-semibold">Email</label>
                            <input type="email" name="email"
                                class="form-control"
                                value="{{ old('email') }}"
                                placeholder="Email (opsional)">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Password <span class="text-danger">*</span></label>
                            <input type="password" name="password"
                                class="form-control @error('password') is-invalid @enderror"
                                placeholder="Minimal 6 karakter">
                            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Konfirmasi Password <span class="text-danger">*</span></label>
                            <input type="password" name="password_confirmation"
                                class="form-control"
                                placeholder="Ulangi password">
                        </div>

                    </div>

                    <hr>

                    {{-- DATA DIRI --}}
                    <p class="fw-semibold text-primary mb-3">
                        <i class="bi bi-person-lines-fill me-1"></i>Data Diri Kepala Keluarga
                    </p>

                    <div class="row g-3">

                        <div class="col-md-12">
                            <label class="form-label fw-semibold">NIK untuk Rekam Medis <span class="text-danger">*</span></label>
                            <input type="text" name="nik_pasien"
                                class="form-control @error('nik_pasien') is-invalid @enderror"
                                value="{{ old('nik_pasien') }}" maxlength="16"
                                placeholder="Sama dengan NIK KTP di atas">
                            <div class="form-text">NIK yang digunakan untuk data rekam medis pasien.</div>
                            @error('nik_pasien')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Tanggal Lahir <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_lahir"
                                class="form-control @error('tanggal_lahir') is-invalid @enderror"
                                value="{{ old('tanggal_lahir') }}">
                            @error('tanggal_lahir')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Jenis Kelamin <span class="text-danger">*</span></label>
                            <select name="jenis_kelamin" class="form-select @error('jenis_kelamin') is-invalid @enderror">
                                <option value="">-- Pilih --</option>
                                <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                            @error('jenis_kelamin')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                    </div>

                    <hr>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-person-check-fill me-2"></i>Daftar Sekarang
                    </button>

                </form>

            </div>
        </div>

        <p class="text-center text-muted small mt-3">
            Sudah punya akun? <a href="/login">Login di sini</a>
        </p>

    </div>
</div>
@endsection