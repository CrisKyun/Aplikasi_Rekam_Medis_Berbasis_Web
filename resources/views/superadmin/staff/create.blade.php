@extends('layouts.dokter')
@section('title', 'Tambah Staff')
@section('page-title', 'Tambah Staff')

@section('content')

<div class="mb-3">
    <a href="/superadmin/staff" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i>Kembali
    </a>
</div>

<div class="card shadow-sm border-0">
    <div class="card-header bg-white fw-bold border-0 pt-3">
        <i class="bi bi-person-plus-fill text-primary me-2"></i>Tambah Akun Staff
    </div>
    <div class="card-body">
        <form action="/superadmin/staff/tambah" method="POST">
            @csrf
            <div class="row g-3">

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
                    <input type="text" name="nama_lengkap"
                        class="form-control @error('nama_lengkap') is-invalid @enderror"
                        value="{{ old('nama_lengkap') }}" placeholder="dr. Nama Lengkap">
                    @error('nama_lengkap')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                    <input type="email" name="email"
                        class="form-control @error('email') is-invalid @enderror"
                        value="{{ old('email') }}">
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">NIK <span class="text-danger">*</span></label>
                    <input type="text" name="nik"
                        class="form-control @error('nik') is-invalid @enderror"
                        value="{{ old('nik') }}" maxlength="16" placeholder="16 digit NIK">
                    @error('nik')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Role <span class="text-danger">*</span></label>
                    <select name="role_id" class="form-select @error('role_id') is-invalid @enderror">
                        <option value="2" {{ old('role_id') == 2 ? 'selected' : '' }}>Staff</option>
                        <option value="1" {{ old('role_id') == 1 ? 'selected' : '' }}>Superadmin</option>
                    </select>
                    @error('role_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
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
                    <input type="password" name="password_confirmation" class="form-control">
                </div>

            </div>

            <hr>
            <div class="d-flex gap-2 justify-content-end">
                <a href="/superadmin/staff" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-1"></i>Simpan
                </button>
            </div>
        </form>
    </div>
</div>

@endsection