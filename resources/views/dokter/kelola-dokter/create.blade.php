@extends('layouts.dokter')
@section('title', 'Tambah Dokter')
@section('page-title', 'Tambah Dokter')

@section('content')

<div class="mb-3">
    <a href="/dokter/kelola-dokter" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i>Kembali
    </a>
</div>

<div class="card shadow-sm border-0">
    <div class="card-header bg-white fw-bold border-0 pt-3">
        <i class="bi bi-person-plus-fill text-primary me-2"></i>Tambah Dokter
    </div>
    <div class="card-body">
        <form action="/dokter/kelola-dokter/tambah" method="POST">
            @csrf

            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Nama Dokter <span class="text-danger">*</span></label>
                    <input type="text" name="nama_dokter"
                        class="form-control @error('nama_dokter') is-invalid @enderror"
                        value="{{ old('nama_dokter') }}" placeholder="dr. Nama Lengkap">
                    @error('nama_dokter')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Bidang Medis <span class="text-danger">*</span></label>
                    <input type="text" name="bidang_medis"
                        class="form-control @error('bidang_medis') is-invalid @enderror"
                        value="{{ old('bidang_medis') }}" placeholder="Umum, Gigi, dll">
                    @error('bidang_medis')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">No. HP</label>
                    <input type="text" name="no_hp" class="form-control"
                        value="{{ old('no_hp') }}" placeholder="08xxxxxxxxxx">
                </div>
            </div>

            <hr>

            {{-- Jadwal --}}
            <div class="d-flex justify-content-between align-items-center mb-3">
                <p class="fw-semibold text-primary mb-0">
                    <i class="bi bi-calendar-week me-1"></i>Jadwal Praktik
                </p>
                <button type="button" class="btn btn-outline-primary btn-sm" id="tambahJadwal">
                    <i class="bi bi-plus-circle me-1"></i>Tambah Jadwal
                </button>
            </div>

            <div id="jadwalContainer">
                <div class="row g-2 mb-2 jadwal-row">
                    <div class="col-md-4">
                        <select name="hari[]" class="form-select">
                            <option value="">-- Pilih Hari --</option>
                            @foreach(['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'] as $h)
                            <option value="{{ $h }}">{{ $h }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <input type="time" name="jam_mulai[]" class="form-control" value="08:00">
                    </div>
                    <div class="col-md-3">
                        <input type="time" name="jam_selesai[]" class="form-control" value="16:00">
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-danger btn-sm hapusJadwal w-100">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </div>
            </div>

            <hr>
            <div class="d-flex justify-content-end gap-2">
                <a href="/dokter/kelola-dokter" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-1"></i>Simpan
                </button>
            </div>

        </form>
    </div>
</div>

<script>
    const hariOptions = `
        <option value="">-- Pilih Hari --</option>
        @foreach(['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'] as $h)
            <option value="{{ $h }}">{{ $h }}</option>
        @endforeach
    `;

    document.getElementById('tambahJadwal').addEventListener('click', function() {
        const container = document.getElementById('jadwalContainer');
        const row = document.createElement('div');
        row.className = 'row g-2 mb-2 jadwal-row';
        row.innerHTML = `
            <div class="col-md-4">
                <select name="hari[]" class="form-select">${hariOptions}</select>
            </div>
            <div class="col-md-3">
                <input type="time" name="jam_mulai[]" class="form-control" value="08:00">
            </div>
            <div class="col-md-3">
                <input type="time" name="jam_selesai[]" class="form-control" value="16:00">
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-danger btn-sm hapusJadwal w-100">
                    <i class="bi bi-trash"></i>
                </button>
            </div>
        `;
        container.appendChild(row);
    });

    document.addEventListener('click', function(e) {
        if (e.target.closest('.hapusJadwal')) {
            e.target.closest('.jadwal-row').remove();
        }
    });
</script>

@endsection