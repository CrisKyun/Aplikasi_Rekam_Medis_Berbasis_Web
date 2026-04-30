@extends('layouts.dokter')
@section('title', 'Edit Dokter')
@section('page-title', 'Edit Dokter')

@section('content')

<div class="mb-3">
    <a href="/dokter/kelola-dokter" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i>Kembali
    </a>
</div>

<div class="card shadow-sm border-0">
    <div class="card-header bg-white fw-bold border-0 pt-3">
        <i class="bi bi-pencil-fill text-warning me-2"></i>Edit Dokter
    </div>
    <div class="card-body">
        <form action="/dokter/kelola-dokter/{{ $dokter->id }}/edit" method="POST">
            @csrf
            @method('PUT')

            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Nama Dokter <span class="text-danger">*</span></label>
                    <input type="text" name="nama_dokter"
                        class="form-control @error('nama_dokter') is-invalid @enderror"
                        value="{{ old('nama_dokter', $dokter->nama_dokter) }}">
                    @error('nama_dokter')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Bidang Medis <span class="text-danger">*</span></label>
                    <input type="text" name="bidang_medis"
                        class="form-control @error('bidang_medis') is-invalid @enderror"
                        value="{{ old('bidang_medis', $dokter->bidang_medis) }}">
                    @error('bidang_medis')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">No. HP</label>
                    <input type="text" name="no_hp" class="form-control"
                        value="{{ old('no_hp', $dokter->no_hp) }}">
                </div>
            </div>

            <hr>

            <div class="d-flex justify-content-between align-items-center mb-3">
                <p class="fw-semibold text-primary mb-0">
                    <i class="bi bi-calendar-week me-1"></i>Jadwal Praktik
                </p>
                <button type="button" class="btn btn-outline-primary btn-sm" id="tambahJadwal">
                    <i class="bi bi-plus-circle me-1"></i>Tambah Jadwal
                </button>
            </div>

            <div id="jadwalContainer">
                @forelse($dokter->jadwalDokter as $jadwal)
                <div class="row g-2 mb-2 jadwal-row">
                    <div class="col-md-4">
                        <select name="hari[]" class="form-select">
                            @foreach(['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'] as $h)
                            <option value="{{ $h }}" {{ $jadwal->hari == $h ? 'selected' : '' }}>
                                {{ $h }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <input type="time" name="jam_mulai[]" class="form-control"
                            value="{{ $jadwal->jam_mulai }}">
                    </div>
                    <div class="col-md-3">
                        <input type="time" name="jam_selesai[]" class="form-control"
                            value="{{ $jadwal->jam_selesai }}">
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-danger btn-sm hapusJadwal w-100">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </div>
                @empty
                <p class="text-muted small">Belum ada jadwal.</p>
                @endforelse
            </div>

            <hr>
            <div class="d-flex justify-content-end gap-2">
                <a href="/dokter/kelola-dokter" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-warning">
                    <i class="bi bi-save me-1"></i>Simpan Perubahan
                </button>
            </div>

        </form>
    </div>
</div>

<script>
    const hariOptions = `@foreach(['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'] as $h)<option value="{{ $h }}">{{ $h }}</option>@endforeach`;

    document.getElementById('tambahJadwal').addEventListener('click', function() {
        const container = document.getElementById('jadwalContainer');
        const row = document.createElement('div');
        row.className = 'row g-2 mb-2 jadwal-row';
        row.innerHTML = `
            <div class="col-md-4">
                <select name="hari[]" class="form-select"><option value="">-- Pilih Hari --</option>${hariOptions}</select>
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