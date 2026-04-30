@extends('layouts.app')
@section('title', 'Edit Data Pasien')

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
                <i class="bi bi-pencil-fill me-2"></i>Edit Data — {{ $pasien->nama_lengkap }}
            </div>
            <div class="card-body">
                <form action="/pasien/{{ $pasien->id }}/edit" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row g-3">

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">NIK <span class="text-danger">*</span></label>
                            <input type="text" name="nik"
                                class="form-control @error('nik') is-invalid @enderror"
                                value="{{ old('nik', $pasien->nik) }}" maxlength="16">
                            @error('nik')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" name="nama_lengkap"
                                class="form-control @error('nama_lengkap') is-invalid @enderror"
                                value="{{ old('nama_lengkap', $pasien->nama_lengkap) }}">
                            @error('nama_lengkap')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Jenis Kelamin <span class="text-danger">*</span></label>
                            <select name="jenis_kelamin" class="form-select">
                                <option value="L" {{ $pasien->jenis_kelamin == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="P" {{ $pasien->jenis_kelamin == 'P' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Status Hubungan <span class="text-danger">*</span></label>
                            <select name="status_hubungan" class="form-select">
                                @foreach(['Kepala Keluarga','Istri','Anak','Orang Tua','Lainnya'] as $status)
                                <option value="{{ $status }}" {{ $pasien->status_hubungan == $status ? 'selected' : '' }}>
                                    {{ $status }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Tempat Lahir</label>
                            <input type="text" name="tempat_lahir"
                                class="form-control" value="{{ old('tempat_lahir', $pasien->tempat_lahir) }}">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Tanggal Lahir <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_lahir"
                                class="form-control @error('tanggal_lahir') is-invalid @enderror"
                                value="{{ old('tanggal_lahir', $pasien->tanggal_lahir) }}">
                            @error('tanggal_lahir')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Golongan Darah</label>
                            <select name="golongan_darah" class="form-select">
                                @foreach(['-','A','B','AB','O'] as $gol)
                                <option value="{{ $gol }}" {{ $pasien->golongan_darah == $gol ? 'selected' : '' }}>
                                    {{ $gol }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Agama</label>
                            <select name="agama" class="form-select">
                                <option value="">-- Pilih --</option>
                                @foreach(['Islam','Kristen','Katolik','Hindu','Buddha','Konghucu','Lainnya'] as $agama)
                                <option value="{{ $agama }}" {{ $pasien->agama == $agama ? 'selected' : '' }}>
                                    {{ $agama }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">No. HP</label>
                            <input type="text" name="no_hp"
                                class="form-control" value="{{ old('no_hp', $pasien->no_hp) }}">
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold">Alamat</label>
                            <textarea name="alamat" class="form-control" rows="2">{{ old('alamat', $pasien->alamat) }}</textarea>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Kecamatan</label>
                            <input type="text" name="kecamatan"
                                class="form-control" value="{{ old('kecamatan', $pasien->kecamatan) }}">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Provinsi</label>
                            <input type="text" name="provinsi"
                                class="form-control" value="{{ old('provinsi', $pasien->provinsi) }}">
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

        {{-- Hapus Pasien --}}
        <div class="card shadow-sm mt-3 border-danger">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-danger fw-bold mb-1"><i class="bi bi-exclamation-triangle me-2"></i>Hapus Pasien</h6>
                    <small class="text-muted">Data pasien dan semua rekam medisnya akan terhapus permanen.</small>
                </div>
                <form action="/pasien/{{ $pasien->id }}/hapus" method="POST"
                    onsubmit="return confirm('Yakin ingin menghapus data {{ $pasien->nama_lengkap }}? Semua rekam medis akan ikut terhapus!')">
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