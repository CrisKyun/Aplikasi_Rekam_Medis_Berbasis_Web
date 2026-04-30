@extends('layouts.app')
@section('title', 'Detail Rekam Medis')

@section('content')

<div class="mb-3 d-flex gap-2">
    <a href="/pasien/{{ $rekamMedis->pasien_id }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i>Kembali
    </a>
    <a href="/rekam-medis/{{ $rekamMedis->id }}/edit" class="btn btn-warning btn-sm">
        <i class="bi bi-pencil me-1"></i>Edit
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-header bg-primary text-white fw-bold">
        <i class="bi bi-clipboard2-pulse-fill me-2"></i>
        Detail Rekam Medis — {{ $rekamMedis->pasien->nama_lengkap }}
    </div>
    <div class="card-body">
        <div class="row g-4">

            <div class="col-md-6">
                <table class="table table-borderless table-sm">
                    <tr>
                        <td class="text-muted" width="40%">Tanggal Periksa</td>
                        <td><strong>{{ \Carbon\Carbon::parse($rekamMedis->tanggal_periksa)->format('d M Y') }}</strong></td>
                    </tr>
                    <tr>
                        <td class="text-muted">Dokter</td>
                        <td>{{ $rekamMedis->dokter }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Tekanan Darah</td>
                        <td>{{ $rekamMedis->tekanan_darah ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Berat Badan</td>
                        <td>{{ $rekamMedis->berat_badan ? $rekamMedis->berat_badan . ' kg' : '-' }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Tinggi Badan</td>
                        <td>{{ $rekamMedis->tinggi_badan ? $rekamMedis->tinggi_badan . ' cm' : '-' }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Suhu Tubuh</td>
                        <td>{{ $rekamMedis->suhu_tubuh ? $rekamMedis->suhu_tubuh . ' °C' : '-' }}</td>
                    </tr>
                </table>
            </div>

            <div class="col-md-6">
                <div class="mb-3">
                    <p class="fw-semibold text-muted mb-1">Keluhan</p>
                    <p class="border rounded p-2 bg-light">{{ $rekamMedis->keluhan }}</p>
                </div>
                <div class="mb-3">
                    <p class="fw-semibold text-muted mb-1">Diagnosis</p>
                    <p class="border rounded p-2 bg-light">{{ $rekamMedis->diagnosis }}</p>
                </div>
                <div class="mb-3">
                    <p class="fw-semibold text-muted mb-1">Resep Obat</p>
                    <p class="border rounded p-2 bg-light">{{ $rekamMedis->resep_obat ?? '-' }}</p>
                </div>
                <div>
                    <p class="fw-semibold text-muted mb-1">Catatan Dokter</p>
                    <p class="border rounded p-2 bg-light">{{ $rekamMedis->catatan_dokter ?? '-' }}</p>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection