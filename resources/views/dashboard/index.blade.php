@extends('layouts.app')
@section('title', 'Dashboard - Praktik Mandiri dr. Luria Widijana Haribawanti.')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-0">
            <i class="bi bi-people-fill text-primary me-2"></i>Data Keluarga
        </h4>
        <small class="text-muted">No. KK: {{ session('no_kk') }}</small>
    </div>
    <a href="{{ route('pasien.create') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-person-plus-fill me-1"></i>Tambah Anggota
    </a>
</div>

@if($anggotaKeluarga->isEmpty())
<div class="alert alert-info">
    <i class="bi bi-info-circle me-2"></i>
    Belum ada anggota keluarga terdaftar.
    <a href="{{ route('pasien.create') }}">Tambahkan sekarang</a>
</div>
@else
<div class="row g-3">
    @foreach($anggotaKeluarga as $pasien)
    <div class="col-md-4">
        <div class="card shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3"
                        style="width:45px; height:45px; font-size:1.3rem;">
                        {{ $pasien->jenis_kelamin == 'L' ? '👨' : '👩' }}
                    </div>
                    <div>
                        <h6 class="mb-0 fw-bold">{{ $pasien->nama_lengkap }}</h6>
                        <small class="text-muted">{{ $pasien->status_hubungan }}</small>
                    </div>
                </div>
                <ul class="list-unstyled small text-muted mb-3">
                    <li><i class="bi bi-credit-card me-2"></i>{{ $pasien->nik }}</li>
                    <li><i class="bi bi-calendar me-2"></i>{{ \Carbon\Carbon::parse($pasien->tanggal_lahir)->format('d M Y') }}</li>
                    <li><i class="bi bi-droplet-fill me-2"></i>Gol. Darah: {{ $pasien->golongan_darah }}</li>
                </ul>
                <a href="/pasien/{{ $pasien->id }}" class="btn btn-outline-primary btn-sm w-100">
                    <i class="bi bi-clipboard2-pulse me-1"></i>Lihat Rekam Medis
                </a>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endif
@endsection