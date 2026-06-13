@extends('layouts.dokter')
@section('title', 'Pengaturan Info Klinik')
@section('page-title', 'Info Klinik')

@section('content')

<div class="card shadow-sm border-0">
    <div class="card-header bg-white fw-bold border-0 pt-3">
        <i class="bi bi-gear-fill text-primary me-2"></i>Edit Informasi Klinik
    </div>
    <div class="card-body">
        <form action="/dokter/klinik" method="POST">
            @if($errors->any())
            <div class="alert alert-danger mb-3">
                <i class="bi bi-exclamation-circle me-2"></i>
                <strong>Terdapat kesalahan:</strong>
                <ul class="mb-0 mt-1">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            @csrf
            @method('PUT')

            <div class="row g-3">

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Nama Klinik <span class="text-danger">*</span></label>
                    <input type="text" name="nama_klinik" class="form-control @error('nama_klinik') is-invalid @enderror"
                        value="{{ old('nama_klinik', $klinik->nama_klinik ?? '') }}">
                    @error('nama_klinik')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">No. Telepon <span class="text-danger">*</span></label>
                    <input type="text" name="no_telepon" class="form-control @error('no_telepon') is-invalid @enderror"
                        value="{{ old('no_telepon', $klinik->no_telepon ?? '') }}">
                    @error('no_telepon')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Email</label>
                    <input type="email" name="email" class="form-control"
                        value="{{ old('email', $klinik->email ?? '') }}">
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Alamat <span class="text-danger">*</span></label>
                    <input type="text" name="alamat" class="form-control @error('alamat') is-invalid @enderror"
                        value="{{ old('alamat', $klinik->alamat ?? '') }}">
                    @error('alamat')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-12">
                    <label class="form-label fw-semibold">Deskripsi Klinik</label>
                    <textarea name="deskripsi" rows="3" class="form-control"
                        placeholder="Deskripsi singkat klinik...">{{ old('deskripsi', $klinik->deskripsi ?? '') }}</textarea>
                </div>

            </div>

            <hr>

            {{-- Jam Operasional --}}
            <div class="d-flex justify-content-between align-items-center mb-3">
                <p class="fw-semibold text-primary mb-0">
                    <i class="bi bi-clock me-1"></i>Jam Operasional
                </p>
                <button type="button" class="btn btn-outline-primary btn-sm" id="tambahJam">
                    <i class="bi bi-plus-circle me-1"></i>Tambah Baris
                </button>
            </div>

            <div id="jamContainer">
                @foreach($jamOperasional as $hari => $jam)
                <div class="row g-2 mb-2 jam-row">
                    <div class="col-md-5">
                        <input type="text" name="hari[]" class="form-control"
                            placeholder="Contoh: Senin - Jumat" value="{{ $hari }}">
                    </div>
                    <div class="col-md-5">
                        <input type="text" name="jam[]" class="form-control"
                            placeholder="Contoh: 08.00 - 16.00" value="{{ $jam }}">
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-danger btn-sm hapusJam w-100">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </div>
                @endforeach
            </div>

            <hr>
            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-1"></i>Simpan Perubahan
                </button>
            </div>

        </form>
    </div>
</div>

<script>
    // Tambah baris jam operasional
    document.getElementById('tambahJam').addEventListener('click', function() {
        const container = document.getElementById('jamContainer');
        const row = document.createElement('div');
        row.className = 'row g-2 mb-2 jam-row';
        row.innerHTML = `
            <div class="col-md-5">
                <input type="text" name="hari[]" class="form-control" placeholder="Contoh: Senin - Jumat">
            </div>
            <div class="col-md-5">
                <input type="text" name="jam[]" class="form-control" placeholder="Contoh: 08.00 - 16.00">
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-danger btn-sm hapusJam w-100">
                    <i class="bi bi-trash"></i>
                </button>
            </div>
        `;
        container.appendChild(row);
    });

    // Hapus baris jam operasional
    document.addEventListener('click', function(e) {
        if (e.target.closest('.hapusJam')) {
            e.target.closest('.jam-row').remove();
        }
    });
</script>

@endsection