@extends('layouts.dokter')
@section('title', 'Tambah Rekam Medis')
@section('page-title', 'Tambah Rekam Medis')

@section('content')

<div class="mb-3">
    <a href="/dokter/pasien/{{ $pasien->id }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i>Kembali
    </a>
</div>

<div class="card shadow-sm border-0">
    <div class="card-header bg-white fw-bold border-0 pt-3">
        <i class="bi bi-clipboard2-plus-fill text-primary me-2"></i>
        Rekam Medis — {{ $pasien->nama_lengkap }}
    </div>
    <div class="card-body">
        <form action="/dokter/pasien/{{ $pasien->id }}/rekam-medis/tambah" method="POST">
            @csrf
            <div class="row g-3">

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Tanggal Periksa <span class="text-danger">*</span></label>
                    <input type="date" name="tanggal_periksa"
                        class="form-control @error('tanggal_periksa') is-invalid @enderror"
                        value="{{ old('tanggal_periksa', date('Y-m-d')) }}">
                    @error('tanggal_periksa')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Dokter Pemeriksa <span class="text-danger">*</span></label>
                    <select name="dokter" class="form-select @error('dokter') is-invalid @enderror">
                        <option value="">-- Pilih Dokter --</option>
                        @foreach($dokter as $dr)
                        <option value="{{ $dr->nama_dokter }}" {{ old('dokter') == $dr->nama_dokter ? 'selected' : '' }}>
                            {{ $dr->nama_dokter }} - {{ $dr->bidang_medis }}
                        </option>
                        @endforeach
                    </select>
                    @error('dokter')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-12">
                    <p class="fw-semibold text-primary mb-2">
                        <i class="bi bi-activity me-1"></i>Tanda Vital
                    </p>
                </div>

                <div class="col-md-3">
                    <label class="form-label fw-semibold">Tekanan Darah</label>
                    <input type="text" name="tekanan_darah" class="form-control"
                        value="{{ old('tekanan_darah') }}" placeholder="120/80">
                </div>

                <div class="col-md-3">
                    <label class="form-label fw-semibold">Berat Badan (kg)</label>
                    <input type="number" name="berat_badan" step="0.1" class="form-control"
                        value="{{ old('berat_badan') }}">
                </div>

                <div class="col-md-3">
                    <label class="form-label fw-semibold">Tinggi Badan (cm)</label>
                    <input type="number" name="tinggi_badan" step="0.1" class="form-control"
                        value="{{ old('tinggi_badan') }}">
                </div>

                <div class="col-md-3">
                    <label class="form-label fw-semibold">Suhu Tubuh (°C)</label>
                    <input type="number" name="suhu_tubuh" step="0.1" class="form-control"
                        value="{{ old('suhu_tubuh') }}">
                </div>

                <div class="col-12">
                    <label class="form-label fw-semibold">Keluhan <span class="text-danger">*</span></label>
                    <textarea name="keluhan" rows="3"
                        class="form-control @error('keluhan') is-invalid @enderror"
                        placeholder="Keluhan pasien...">{{ old('keluhan') }}</textarea>
                    @error('keluhan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-12">
                    <label class="form-label fw-semibold">Diagnosis <span class="text-danger">*</span></label>
                    <textarea name="diagnosis" rows="3"
                        class="form-control @error('diagnosis') is-invalid @enderror"
                        placeholder="Diagnosis...">{{ old('diagnosis') }}</textarea>
                    @error('diagnosis')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-12">
                    <label class="form-label fw-semibold">Resep Obat</label>
                    <textarea name="resep_obat" rows="3" class="form-control"
                        placeholder="Nama obat, dosis, aturan pakai...">{{ old('resep_obat') }}</textarea>
                </div>

                <div class="col-12">
                    <label class="form-label fw-semibold">Catatan Dokter</label>
                    <textarea name="catatan_dokter" rows="2" class="form-control"
                        placeholder="Catatan tambahan...">{{ old('catatan_dokter') }}</textarea>
                </div>

            </div>

            <hr>
            <div class="d-flex gap-2 justify-content-end">
                <a href="/dokter/pasien/{{ $pasien->id }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-1"></i>Simpan
                </button>
            </div>

        </form>
    </div>
</div>
@endsection