@extends('layouts.dokter')
@section('title', 'Edit Rekam Medis')
@section('page-title', 'Edit Rekam Medis')

@section('content')

<div class="mb-3">
    <a href="/dokter/pasien/{{ $rekamMedis->pasien_id }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i>Kembali
    </a>
</div>

<div class="card shadow-sm border-0">
    <div class="card-header bg-white fw-bold border-0 pt-3">
        <i class="bi bi-pencil-fill text-warning me-2"></i>
        Edit Rekam Medis — {{ $rekamMedis->pasien->nama_lengkap }}
    </div>
    <div class="card-body">
        <form action="/dokter/rekam-medis/{{ $rekamMedis->id }}/edit" method="POST">
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
                    <label class="form-label fw-semibold">Dokter Pemeriksa <span class="text-danger">*</span></label>
                    <select name="dokter" class="form-select @error('dokter') is-invalid @enderror">
                        <option value="">-- Pilih Dokter --</option>
                        @foreach($dokter as $dr)
                        <option value="{{ $dr->nama_dokter }}"
                            {{ old('dokter', $rekamMedis->dokter) == $dr->nama_dokter ? 'selected' : '' }}>
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

                {{-- Autocomplete ICD-10 (Edit) --}}
                <div class="col-12">
                    <label class="form-label fw-semibold">Diagnosis (ICD-10) <span class="text-danger">*</span></label>

                    <div class="position-relative">
                        <input type="text" id="icd10Search" class="form-control"
                            placeholder="Ketik kode atau nama diagnosis..."
                            autocomplete="off">
                        <div id="icd10Dropdown"
                            class="position-absolute w-100 bg-white border rounded shadow-sm"
                            style="z-index:1000; max-height:250px; overflow-y:auto; display:none;"></div>
                    </div>

                    <input type="hidden" name="kode_icd10" id="kodeIcd10" value="{{ old('kode_icd10', $rekamMedis->kode_icd10) }}">
                    <input type="hidden" name="nama_icd10" id="namaIcd10" value="{{ old('nama_icd10', $rekamMedis->nama_icd10) }}">

                    {{-- Tampil yang sudah terpilih --}}
                    <div id="icd10Terpilih" class="mt-2"
                        style="{{ $rekamMedis->kode_icd10 ? '' : 'display:none;' }}">
                        <span class="badge bg-primary fs-6 p-2">
                            <span id="tampilKode">{{ $rekamMedis->kode_icd10 }}</span> —
                            <span id="tampilNama">{{ $rekamMedis->nama_icd10 }}</span>
                            <button type="button" class="btn-close btn-close-white ms-2"
                                style="font-size:0.6rem;" onclick="hapusIcd10()"></button>
                        </span>
                    </div>
                </div>

                <div class="col-12">
                    <label class="form-label fw-semibold">Catatan Diagnosis Tambahan</label>
                    <textarea name="diagnosis" rows="2" class="form-control">{{ old('diagnosis', $rekamMedis->diagnosis) }}</textarea>
                    <div class="form-text">
                        <i class="bi bi-lock-fill me-1 text-muted"></i>Hanya terlihat oleh dokter.
                    </div>
                </div>

                <script>
                    let debounceTimer;

                    document.getElementById('icd10Search').addEventListener('input', function() {
                        clearTimeout(debounceTimer);
                        const keyword = this.value.trim();

                        if (keyword.length < 2) {
                            document.getElementById('icd10Dropdown').style.display = 'none';
                            return;
                        }

                        debounceTimer = setTimeout(() => {
                            fetch(`/dokter/icd10/cari?q=${encodeURIComponent(keyword)}`)
                                .then(res => res.json())
                                .then(data => {
                                    const dropdown = document.getElementById('icd10Dropdown');

                                    if (data.length === 0) {
                                        dropdown.innerHTML = '<div class="p-2 text-muted small">Tidak ditemukan.</div>';
                                        dropdown.style.display = 'block';
                                        return;
                                    }

                                    dropdown.innerHTML = data.map(item => `
                    <div class="p-2 border-bottom icd10-item"
                         style="cursor:pointer;"
                         onmouseover="this.style.background='#f8f9fa'"
                         onmouseout="this.style.background='white'"
                         onclick="pilihIcd10('${item.kode}', '${item.nama.replace(/'/g, "\\'")}', '${item.kategori}')">
                        <span class="badge bg-primary me-2">${item.kode}</span>
                        <span class="small">${item.nama}</span>
                        <br>
                        <span class="text-muted" style="font-size:0.75rem; margin-left: 3.5rem;">${item.kategori}</span>
                    </div>
                `).join('');

                                    dropdown.style.display = 'block';
                                });
                        }, 300);
                    });

                    function pilihIcd10(kode, nama, kategori) {
                        document.getElementById('kodeIcd10').value = kode;
                        document.getElementById('namaIcd10').value = nama;
                        document.getElementById('tampilKode').textContent = kode;
                        document.getElementById('tampilNama').textContent = nama;
                        document.getElementById('icd10Terpilih').style.display = 'block';
                        document.getElementById('icd10Search').value = '';
                        document.getElementById('icd10Dropdown').style.display = 'none';
                    }

                    function hapusIcd10() {
                        document.getElementById('kodeIcd10').value = '';
                        document.getElementById('namaIcd10').value = '';
                        document.getElementById('icd10Terpilih').style.display = 'none';
                    }

                    // Tutup dropdown kalau klik di luar
                    document.addEventListener('click', function(e) {
                        if (!e.target.closest('#icd10Search') && !e.target.closest('#icd10Dropdown')) {
                            document.getElementById('icd10Dropdown').style.display = 'none';
                        }
                    });
                </script>

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
                <a href="/dokter/pasien/{{ $rekamMedis->pasien_id }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-warning">
                    <i class="bi bi-save me-1"></i>Simpan Perubahan
                </button>
            </div>

        </form>
    </div>
</div>
@endsection