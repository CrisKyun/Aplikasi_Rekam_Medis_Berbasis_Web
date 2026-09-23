@extends('layouts.dokter')
@section('title', 'Kelola Antrian')
@section('page-title', 'Kelola Antrian')

@section('content')

{{-- Pengaturan Limit Antrian Harian --}}
<div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-white d-flex align-items-center justify-content-between py-3">
        <div class="fw-bold">
            <i class="bi bi-sliders me-2 text-primary"></i>Pengaturan Limit Antrian Harian
        </div>
        <span class="badge bg-info-subtle text-info">
            <i class="bi bi-info-circle me-1"></i>Default otomatis: 100 per dokter/hari
        </span>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-sm align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Dokter</th>
                        <th class="text-center">Limit Harian</th>
                        <th class="text-center">Terdaftar ({{ \Carbon\Carbon::parse($tanggal)->format('d M Y') }})</th>
                        <th class="text-center">Sisa Kuota</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($dokter as $dr)
                    @php
                    $d = $kuota[$dr->id] ?? ['limit' => 100, 'terisi' => 0];
                    $sisa = max($d['limit'] - $d['terisi'], 0);
                    @endphp
                    <tr>
                        <td>
                            <p class="mb-0 fw-semibold">{{ $dr->nama_dokter }}</p>
                            <small class="text-muted">{{ $dr->bidang_medis }}</small>
                        </td>
                        <td class="text-center">
                            <form action="/dokter/antrian/limit/{{ $dr->id }}" method="POST"
                                class="d-flex align-items-center justify-content-center gap-1">
                                @csrf @method('PATCH')
                                <button type="button" class="btn btn-outline-secondary btn-sm btn-step"
                                    data-target="limit-{{ $dr->id }}" data-step="-1">
                                    <i class="bi bi-dash-lg"></i>
                                </button>
                                <input type="number" name="limit_harian" id="limit-{{ $dr->id }}"
                                    value="{{ $d['limit'] }}" min="1" max="1000"
                                    class="form-control form-control-sm text-center fw-bold"
                                    style="width: 90px;">
                                <button type="button" class="btn btn-outline-secondary btn-sm btn-step"
                                    data-target="limit-{{ $dr->id }}" data-step="1">
                                    <i class="bi bi-plus-lg"></i>
                                </button>
                                <button type="submit" class="btn btn-primary btn-sm ms-1">
                                    <i class="bi bi-check-lg me-1"></i>Simpan
                                </button>
                            </form>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-light text-dark border">{{ $d['terisi'] }}</span>
                        </td>
                        <td class="text-center">
                            @if($sisa > 0)
                            <span class="badge bg-success-subtle text-success">
                                {{ $sisa }} tersisa
                            </span>
                            @else
                            <span class="badge bg-danger-subtle text-danger">
                                <i class="bi bi-x-circle me-1"></i>Penuh
                            </span>
                            @endif
                        </td>
                        <td class="text-end">
                            @if($d['terisi'] > $d['limit'])
                            <span class="small text-danger">
                                <i class="bi bi-exclamation-triangle me-1"></i>Melebihi limit
                            </span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">
                            Belum ada dokter terdaftar.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="form-text mt-2">
            <i class="bi bi-info-circle me-1"></i>
            Limit harian otomatis <strong>100 antrian per dokter per hari</strong>.
            Staff dan dokter dapat menambah atau mengurangi limit dengan tombol
            <strong>+</strong> / <strong>−</strong>, lalu klik <strong>Simpan</strong>.
            Setelah kuota penuh, pasien tidak dapat mendaftar antrian untuk dokter & tanggal tersebut.
        </div>
    </div>
</div>

{{-- Filter --}}
<div class="card shadow-sm border-0 mb-4">
    <div class="card-body">
        <form action="/dokter/antrian" method="GET" class="row g-2">
            <div class="col-md-4">
                <input type="date" name="tanggal" class="form-control"
                    value="{{ $tanggal }}">
            </div>
            <div class="col-md-5">
                <select name="dokter_id" class="form-select">
                    <option value="">-- Semua Dokter --</option>
                    @foreach($dokter as $dr)
                    <option value="{{ $dr->id }}" {{ $dokterId == $dr->id ? 'selected' : '' }}>
                        {{ $dr->nama_dokter }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-filter me-1"></i>Filter
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Statistik Hari Ini --}}
<div class="row g-3 mb-4">
    @php
    $menunggu = $antrian->where('status_antrian', 'menunggu')->count();
    $dipanggil = $antrian->where('status_antrian', 'dipanggil')->count();
    $selesai = $antrian->where('status_antrian', 'selesai')->count();
    $batal = $antrian->where('status_antrian', 'batal')->count();
    @endphp

    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="stat-icon yellow">
                <i class="bi bi-hourglass-split"></i>
            </div>
            <div>
                <p class="stat-label mb-1">Menunggu</p>
                <p class="stat-value">{{ $menunggu }}</p>
            </div>
        </div>
    </div>

    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="stat-icon blue">
                <i class="bi bi-megaphone-fill"></i>
            </div>
            <div>
                <p class="stat-label mb-1">Dipanggil</p>
                <p class="stat-value">{{ $dipanggil }}</p>
            </div>
        </div>
    </div>

    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="stat-icon green">
                <i class="bi bi-check-circle-fill"></i>
            </div>
            <div>
                <p class="stat-label mb-1">Selesai</p>
                <p class="stat-value">{{ $selesai }}</p>
            </div>
        </div>
    </div>

    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="stat-icon red">
                <i class="bi bi-x-circle-fill"></i>
            </div>
            <div>
                <p class="stat-label mb-1">Batal</p>
                <p class="stat-value">{{ $batal }}</p>
            </div>
        </div>
    </div>

</div>

{{-- Tabel Antrian --}}
<div class="card shadow-sm border-0">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>No.</th>
                        <th>Pasien</th>
                        <th>Keluhan Awal</th>
                        <th>Dokter</th>
                        <th>Estimasi</th>
                        <th>Status</th>
                        <th>Aksi</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($antrian as $a)
                    <tr>
                        <td>
                            <span class="fw-bold fs-5 text-primary">{{ $a->nomor_antrian }}</span>
                        </td>
                        <td>
                            <p class="mb-0 fw-semibold">{{ $a->pasien->nama_lengkap }}</p>
                            <small class="text-muted">{{ $a->pasien->nik }}</small>
                        </td>
                        <td>
                            <span class="text-wrap" style="max-width: 200px; display: block;">
                                {{ $a->keluhan_awal ?? '-' }}
                            </span>
                        </td>
                        <td>
                            <p class="mb-0">{{ $a->dokter->nama_dokter }}</p>
                            <small class="text-muted">{{ $a->dokter->bidang_medis }}</small>
                        </td>
                        <td>
                            <i class="bi bi-clock me-1 text-muted"></i>
                            {{ \Carbon\Carbon::parse($a->estimasi_jam)->format('H:i') }} WIB
                        </td>
                        <td>
                            <span class="badge
                                {{ $a->status_antrian === 'menunggu'  ? 'bg-warning text-dark' :
                                   ($a->status_antrian === 'dipanggil' ? 'bg-primary' :
                                   ($a->status_antrian === 'selesai'   ? 'bg-success' : 'bg-danger')) }}">
                                {{ ucfirst($a->status_antrian) }}
                            </span>
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                @if($a->status_antrian === 'menunggu')
                                <form action="/dokter/antrian/{{ $a->id }}/panggil" method="POST">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="btn btn-primary btn-sm">
                                        <i class="bi bi-megaphone me-1"></i>Panggil
                                    </button>
                                </form>
                                @endif

                                @if($a->status_antrian === 'dipanggil')
                                <form action="/dokter/antrian/{{ $a->id }}/selesai" method="POST">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="btn btn-success btn-sm">
                                        <i class="bi bi-check-circle me-1"></i>Selesai
                                    </button>
                                </form>
                                @endif

                                @if(in_array($a->status_antrian, ['menunggu', 'dipanggil']))
                                <form action="/dokter/antrian/{{ $a->id }}/batal" method="POST"
                                    onsubmit="return confirm('Yakin batalkan antrian ini?')">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="bi bi-x-circle"></i>
                                    </button>
                                </form>
                                @endif

                                @if(in_array($a->status_antrian, ['menunggu', 'dipanggil']))
                                <a href="/dokter/antrian/{{ $a->id }}/edit-estimasi"
                                    class="btn btn-outline-secondary btn-sm"
                                    title="Edit Estimasi">
                                    <i class="bi bi-clock"></i>
                                </a>
                                @endif
                            </div>
                        </td>
                        <td>
                            <a href="/dokter/pasien/{{ $a->pasien_id }}?pendaftaran_id={{ $a->id }}"
                                class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-eye me-1"></i>Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">
                            <i class="bi bi-ticket-perforated" style="font-size: 2rem;"></i>
                            <p class="mt-2 mb-0">Tidak ada antrian untuk tanggal ini.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    // Tombol +/- untuk limit antrian harian
    document.querySelectorAll('.btn-step').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var input = document.getElementById(this.dataset.target);
            if (!input) return;
            var val = parseInt(input.value || 0, 10);
            var step = parseInt(this.dataset.step || 1, 10);
            val = isNaN(val) ? 100 : val + step;
            input.value = Math.min(Math.max(val, 1), 1000);
        });
    });
</script>

@endsection