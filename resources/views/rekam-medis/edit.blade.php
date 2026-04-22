@extends('layouts.app')
@section('title', 'Edit Rekam Medis')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">

        <div class="mb-3">
            <a href="/pasien/{{ $pasien->id }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left me-1"></i>Kembali
            </a>
        </div>

        <div class="card shadow-sm">
            <div class="card-header bg-warning text-dark fw-bold">
                <i class="bi bi-pencil-fill me-2"></i>
                Edit Rekam Medis — {{ $pasien->nama_lengkap }}
            </div>
            <div class="card-body">
                <form action="/rekam-medis/{{ $rekamMedis->id }}/edit" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row g-3">

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Tanggal Periksa <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_periksa"
                                class="form-control @error('tanggal_periksa') is-invalid @enderror"
                                value="{{ old('tanggal_periksa', $rekamMedis->tanggal_periksa) }}">
                            @error('tanggal_periksa')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Nama Dokter <span class="text-danger">*</span></label>
                            <input type="text" name="dokter"
                                class="form-control @error('dokter') is-invalid @enderror"
                                value="{{ old('dokter', $rekamMedis->dokter) }}">
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
                                value="{{ old('tekanan_darah', $rekamMedis->tekanan_darah) }}" placeholder="120/80">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Berat Badan (kg)</label>
                            <input type="number" name="berat_badan" step="0.1" class="form-control"
                                value="{{ old('berat_badan', $rekamMedis->berat_badan) }}">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Tinggi Badan (cm)</label>
                            <input type="number" name="tinggi_badan" step="0.1" class="form-control"
                                value="{{ old('tinggi_badan', $rekamMedis->tinggi_badan) }}">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Suhu Tubuh (°C)</label>
                            <input type="number" name="suhu_tubuh" step="0.1" class="form-control"
                                value="{{ old('suhu_tubuh', $rekamMedis->suhu_tubuh) }}">
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold">Keluhan <span class="text-danger">*</span></label>
                            <textarea name="keluhan" rows="3"
                                class="form-control @error('keluhan') is-invalid @enderror">{{ old('keluhan', $rekamMedis->keluhan) }}</textarea>
                            @error('keluhan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold">Diagnosis <span class="text-danger">*</span></label>
                            <textarea name="diagnosis" rows="3"
                                class="form-control @error('diagnosis') is-invalid @enderror">{{ old('diagnosis', $rekamMedis->diagnosis) }}</textarea>
                            @error('diagnosis')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold">Resep Obat</label>
                            <textarea name="resep_obat" rows="3"
                                class="form-control">{{ old('resep_obat', $rekamMedis->resep_obat) }}</textarea>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold">Catatan Dokter</label>
                            <textarea name="catatan_dokter" rows="2"
                                class="form-control">{{ old('catatan_dokter', $rekamMedis->catatan_dokter) }}</textarea>
                        </div>

                    </div>

                    <hr>
                    <div class="d-flex gap-2 justify-content-end">
                        <a href="/pasien/{{ $pasien->id }}" class="btn btn-secondary">Batal</a>
                        <button type="submit" class="btn btn-warning">
                            <i class="bi bi-save me-1"></i>Simpan Perubahan
                        </button>
                    </div>

                </form>
            </div>
        </div>

        {{-- Hapus Rekam Medis --}}
        <div class="card shadow-sm mt-3 border-danger">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-danger fw-bold mb-1"><i class="bi bi-exclamation-triangle me-2"></i>Hapus Rekam Medis</h6>
                    <small class="text-muted">Data rekam medis ini akan terhapus permanen.</small>
                </div>
                <form action="/rekam-medis/{{ $rekamMedis->id }}/hapus" method="POST"
                    onsubmit="return confirm('Yakin ingin menghapus rekam medis ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">
                        <i class="bi bi-trash me-1"></i>Hapus
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection