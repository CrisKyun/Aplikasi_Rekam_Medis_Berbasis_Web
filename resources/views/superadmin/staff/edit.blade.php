@extends('layouts.dokter')
@section('title', 'Edit Staff')
@section('page-title', 'Edit Staff')

@section('content')

<div class="mb-3">
    <a href="/superadmin/staff" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i>Kembali
    </a>
</div>

<div class="card shadow-sm border-0">
    <div class="card-header bg-white fw-bold border-0 pt-3">
        <i class="bi bi-pencil-fill text-warning me-2"></i>Edit Staff — {{ $staff->nama_lengkap }}
    </div>
    <div class="card-body">
        <form action="/superadmin/staff/{{ $staff->id }}/edit" method="POST">
            @csrf @method('PUT')
            <div class="row g-3">

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
                    <input type="text" name="nama_lengkap"
                        class="form-control @error('nama_lengkap') is-invalid @enderror"
                        value="{{ old('nama_lengkap', $staff->nama_lengkap) }}">
                    @error('nama_lengkap')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                    <input type="email" name="email"
                        class="form-control @error('email') is-invalid @enderror"
                        value="{{ old('email', $staff->email) }}">
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Role <span class="text-danger">*</span></label>
                    <select name="role_id" class="form-select">
                        <option value="2" {{ $staff->role_id == 2 ? 'selected' : '' }}>Staff</option>
                        <option value="1" {{ $staff->role_id == 1 ? 'selected' : '' }}>Superadmin</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Password Baru</label>
                    <input type="password" name="password"
                        class="form-control @error('password') is-invalid @enderror"
                        placeholder="Kosongkan jika tidak diubah">
                    @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Konfirmasi Password Baru</label>
                    <input type="password" name="password_confirmation" class="form-control">
                </div>

            </div>

            <hr>
            <div class="d-flex gap-2 justify-content-end">
                <a href="/superadmin/staff" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-warning">
                    <i class="bi bi-save me-1"></i>Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

@endsection