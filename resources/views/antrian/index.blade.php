@extends('layouts.app')
@section('title', 'Antrian Saya')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">
        <i class="bi bi-ticket-perforated-fill text-primary me-2"></i>Antrian Saya
    </h4>
    <a href="/antrian/daftar" class="btn btn-primary btn-sm">
        <i class="bi bi-plus-circle me-1"></i>Daftar Antrian
    </a>
</div>

@forelse($antrian as $a)
<div class="card shadow-sm mb-3 border-start border-4
    {{ $a->status_antrian === 'menunggu' ? 'border-warning' :
       ($a->status_antrian === 'dipanggil' ? 'border-primary' :
       ($a->status_antrian === 'selesai' ? 'border-success' : 'border-danger')) }}">
    <div class="card-body">
        <div class="row align-items-center">

            {{-- Nomor Antrian --}}
            <div class="col-md-2 text-center">
                <div class="display-4 fw-bold text-primary">{{ $a->nomor_antrian }}</div>
                <small class="text-muted">No. Antrian</small>
            </div>

            {{-- Info --}}
            <div class="col-md-7">
                <h6 class="fw-bold mb-1">{{ $a->pasien->nama_lengkap }}</h6>
                <p class="mb-1 small">
                    <i class="bi bi-person-badge me-1 text-muted"></i>
                    {{ $a->dokter->nama_dokter }} — {{ $a->dokter->bidang_medis }}
                </p>
                <p class="mb-1 small">
                    <i class="bi bi-calendar me-1 text-muted"></i>
                    {{ \Carbon\Carbon::parse($a->tanggal_kunjungan)->translatedFormat('l, d M Y') }}
                </p>
                <p class="mb-0 small">
                    <i class="bi bi-clock me-1 text-muted"></i>
                    Estimasi: <strong>{{ \Carbon\Carbon::parse($a->estimasi_jam)->format('H:i') }} WIB</strong>
                </p>
            </div>

            {{-- Status & Aksi --}}
            <div class="col-md-3 text-end">
                <span class="badge fs-6 mb-2
                    {{ $a->status_antrian === 'menunggu' ? 'bg-warning text-dark' :
                       ($a->status_antrian === 'dipanggil' ? 'bg-primary' :
                       ($a->status_antrian === 'selesai' ? 'bg-success' : 'bg-danger')) }}">
                    {{ ucfirst($a->status_antrian) }}
                </span>

                @if($a->status_antrian === 'menunggu')
                <form action="/antrian/{{ $a->id }}/batal" method="POST"
                    onsubmit="return confirm('Yakin ingin membatalkan antrian ini?')">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-outline-danger btn-sm w-100">
                        <i class="bi bi-x-circle me-1"></i>Batalkan
                    </button>
                </form>
                @endif

                @if($a->status_antrian === 'dipanggil')
                <div class="alert alert-primary p-2 mt-2 mb-0 small">
                    <i class="bi bi-megaphone-fill me-1"></i>
                    Anda sedang dipanggil!
                </div>
                @endif
            </div>

        </div>
    </div>
</div>
@empty
<div class="text-center text-muted py-5">
    <i class="bi bi-ticket-perforated" style="font-size: 3rem;"></i>
    <p class="mt-3">Belum ada antrian.</p>
    <a href="/antrian/daftar" class="btn btn-primary btn-sm">
        <i class="bi bi-plus-circle me-1"></i>Daftar Sekarang
    </a>
</div>
@endforelse

@endsection