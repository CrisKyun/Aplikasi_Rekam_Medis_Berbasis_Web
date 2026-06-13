@extends('layouts.app')
@section('title', 'Daftar Antrian')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-7">

        <div class="mb-3">
            <a href="/antrian" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left me-1"></i>Kembali
            </a>
        </div>

        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white fw-bold">
                <i class="bi bi-ticket-perforated-fill me-2"></i>Daftar Antrian Online
            </div>
            <div class="card-body">

                @if($klinikTutup)
                {{-- Klinik Tutup --}}
                <div class="text-center py-4">
                    <i class="bi bi-door-closed" style="font-size:3rem;color:#94a3b8;"></i>
                    <h5 class="mt-3 fw-semibold">Klinik Sedang Tutup</h5>
                    <p class="text-muted">{{ $pesanTutup }}</p>
                    <a href="/" class="btn btn-outline-primary btn-sm mt-2">
                        <i class="bi bi-arrow-left me-1"></i>Kembali ke Beranda
                    </a>
                </div>

                @elseif(count($tanggalTersedia) === 0)
                {{-- Tidak ada jadwal --}}
                <div class="text-center py-4">
                    <i class="bi bi-calendar-x" style="font-size:3rem;color:#94a3b8;"></i>
                    <h5 class="mt-3 fw-semibold">Tidak Ada Jadwal Tersedia</h5>
                    <p class="text-muted">
                        Tidak ada dokter yang praktik dalam 3 hari ke depan.<br>
                        Silakan hubungi klinik untuk informasi lebih lanjut.
                    </p>
                    <a href="/" class="btn btn-outline-primary btn-sm mt-2">
                        <i class="bi bi-arrow-left me-1"></i>Kembali ke Beranda
                    </a>
                </div>

                @else
                {{-- Form Antrian --}}
                <form action="/antrian/daftar" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Untuk Siapa? <span class="text-danger">*</span>
                        </label>
                        <select name="pasien_id"
                            class="form-select @error('pasien_id') is-invalid @enderror">
                            <option value="">-- Pilih Anggota Keluarga --</option>
                            @foreach($anggotaKeluarga as $p)
                            <option value="{{ $p->id }}"
                                {{ old('pasien_id') == $p->id ? 'selected' : '' }}>
                                {{ $p->nama_lengkap }} ({{ $p->status_hubungan }})
                            </option>
                            @endforeach
                        </select>
                        @error('pasien_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Pilih Dokter <span class="text-danger">*</span>
                        </label>
                        <select name="dokter_id" id="dokterSelect"
                            class="form-select @error('dokter_id') is-invalid @enderror"
                            onchange="updateJadwal()">
                            <option value="">-- Pilih Dokter --</option>
                            @foreach($dokter as $dr)
                            <option value="{{ $dr->id }}"
                                data-jadwal="{{ $dr->jadwalDokter->where('status','Aktif')->pluck('hari')->join(', ') }}"
                                {{ old('dokter_id') == $dr->id ? 'selected' : '' }}>
                                {{ $dr->nama_dokter }} — {{ $dr->bidang_medis }}
                            </option>
                            @endforeach
                        </select>
                        @error('dokter_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div id="jadwalInfo" class="form-text text-muted mt-1"></div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Tanggal Kunjungan <span class="text-danger">*</span>
                        </label>
                        <select name="tanggal_kunjungan"
                            class="form-select @error('tanggal_kunjungan') is-invalid @enderror">
                            <option value="">-- Pilih Tanggal --</option>
                            @foreach($tanggalTersedia as $tgl)
                            <option value="{{ $tgl['nilai'] }}"
                                data-hari="{{ $tgl['hari'] }}"
                                {{ old('tanggal_kunjungan') == $tgl['nilai'] ? 'selected' : '' }}>
                                {{ $tgl['label'] }}
                            </option>
                            @endforeach
                        </select>
                        @error('tanggal_kunjungan')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Keluhan Awal <span class="text-danger">*</span>
                        </label>
                        <textarea name="keluhan_awal" rows="4"
                            class="form-control @error('keluhan_awal') is-invalid @enderror"
                            placeholder="Ceritakan keluhan Anda secara singkat...">{{ old('keluhan_awal') }}</textarea>
                        @error('keluhan_awal')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">
                            <i class="bi bi-info-circle me-1"></i>
                            Keluhan ini akan dilihat dokter sebelum Anda dipanggil.
                        </div>
                    </div>

                    <div class="alert alert-info small">
                        <i class="bi bi-info-circle me-2"></i>
                        Estimasi waktu dihitung otomatis. Setiap pasien mendapat waktu
                        <strong>15 menit</strong>.
                    </div>

                    <hr>
                    <div class="d-flex gap-2 justify-content-end">
                        <a href="/antrian" class="btn btn-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-ticket-perforated me-1"></i>Daftar Antrian
                        </button>
                    </div>

                </form>
                @endif

            </div>
        </div>

    </div>
</div>

<script>
    function updateJadwal() {
        const select = document.getElementById('dokterSelect');
        const option = select.options[select.selectedIndex];
        const jadwal = option.getAttribute('data-jadwal');
        const info = document.getElementById('jadwalInfo');

        if (jadwal) {
            info.innerHTML = '<i class="bi bi-calendar-check me-1"></i>Jadwal praktik: <strong>' +
                jadwal + '</strong>';
        } else {
            info.innerHTML = '';
        }
    }
</script>

@endsection