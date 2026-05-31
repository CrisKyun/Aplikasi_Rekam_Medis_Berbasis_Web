@extends('layouts.dokter')
@section('title', 'Edit Estimasi Antrian')
@section('page-title', 'Edit Estimasi Antrian')

@section('content')

<div class="mb-3">
    <a href="/dokter/antrian" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i>Kembali
    </a>
</div>

<div class="card shadow-sm border-0">
    <div class="card-header bg-white fw-bold border-0 pt-3">
        <i class="bi bi-clock-history text-primary me-2"></i>
        Edit Estimasi — {{ $antrian->dokter->nama_dokter }}
        ({{ \Carbon\Carbon::parse($antrian->tanggal_kunjungan)->format('d M Y') }})
    </div>
    <div class="card-body">

        <div class="alert alert-info small mb-4">
            <i class="bi bi-info-circle me-2"></i>
            Mengubah jam mulai akan <strong>menghitung ulang estimasi semua antrian</strong>
            yang masih menunggu/dipanggil pada tanggal tersebut. Setiap pasien mendapat
            jeda <strong>15 menit</strong>.
        </div>

        <form action="/dokter/antrian/{{ $antrian->id }}/edit-estimasi" method="POST">
            @csrf
            @method('PATCH')

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">
                        Jam Mulai Baru <span class="text-danger">*</span>
                    </label>
                    <input type="time" name="jam_mulai_baru"
                        class="form-control @error('jam_mulai_baru') is-invalid @enderror"
                        value="{{ old('jam_mulai_baru', \Carbon\Carbon::parse($antrian->estimasi_jam)->format('H:i')) }}">
                    @error('jam_mulai_baru')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="form-text">
                        Estimasi saat ini: {{ \Carbon\Carbon::parse($antrian->estimasi_jam)->format('H:i') }} WIB
                    </div>
                </div>
            </div>

            <hr>
            <div class="d-flex gap-2 justify-content-end">
                <a href="/dokter/antrian" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-arrow-clockwise me-1"></i>Perbarui Semua Estimasi
                </button>
            </div>

        </form>
    </div>
</div>

@endsection