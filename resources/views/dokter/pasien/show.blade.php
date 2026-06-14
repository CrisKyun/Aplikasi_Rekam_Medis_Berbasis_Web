@extends('layouts.dokter')
@section('title', 'Detail Pasien')
@section('page-title', 'Detail Pasien')

@section('content')

<div class="mb-3">
    <a href="/dokter/pasien" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i>Kembali
    </a>
</div>

{{-- Grafik Tanda Vital --}}
@include('components.grafik-vital')

<div class="row g-4">

    {{-- Data Diri --}}
    <div class="col-md-4">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white fw-bold border-0 pt-3">
                <i class="bi bi-person-lines-fill text-primary me-2"></i>Data Diri
            </div>
            <div class="card-body small">
                <table class="table table-borderless table-sm">
                    <tr>
                        <td class="text-muted">Nama</td>
                        <td><strong>{{ $pasien->nama_lengkap }}</strong></td>
                    </tr>
                    <tr>
                        <td class="text-muted">NIK</td>
                        <td>{{ $pasien->nik }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Jenis Kelamin</td>
                        <td>{{ $pasien->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Tgl Lahir</td>
                        <td>{{ \Carbon\Carbon::parse($pasien->tanggal_lahir)->format('d M Y') }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Umur</td>
                        <td>{{ \Carbon\Carbon::parse($pasien->tanggal_lahir)->age }} tahun</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Gol. Darah</td>
                        <td>{{ $pasien->golongan_darah }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Agama</td>
                        <td>{{ $pasien->agama ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">No. HP</td>
                        <td>{{ $pasien->no_hp ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Alamat</td>
                        <td>{{ $pasien->alamat ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Hubungan KK</td>
                        <td>
                            <span class="badge bg-secondary">{{ $pasien->status_hubungan }}</span>
                        </td>
                    </tr>
                    {{-- Status Akun --}}
                    <tr>
                        <td>
                            @php
                            $userPasien = \App\Models\User::find($pasien->user_id);
                            $belumPermanen = $userPasien && $userPasien->expired_at
                            && \Carbon\Carbon::parse($userPasien->expired_at)->isFuture();
                            @endphp

                            @if($belumPermanen)
                            {{-- Banner peringatan akun belum permanen --}}
                            <div class="alert mb-4"
                                style="background:#fffbeb;border-left:4px solid #d97706;color:#92400e;border-radius:8px;">
                                <div class="d-flex align-items-start gap-2">
                                    <i class="bi bi-hourglass-split mt-1" style="font-size:1.1rem;"></i>
                                    <div>
                                        <p class="fw-bold mb-1">Akun Belum Divalidasi Permanen</p>
                                        <p class="mb-1 small">
                                            Pasien ini mendaftar secara mandiri dan belum pernah berobat.
                                            Akun akan otomatis <strong>nonaktif</strong> jika tidak ada kunjungan sebelum:
                                        </p>
                                        <p class="fw-bold mb-2" style="font-size:1rem;">
                                            <i class="bi bi-calendar-x me-1"></i>
                                            {{ \Carbon\Carbon::parse($userPasien->expired_at)->format('d M Y, H:i') }} WIB
                                            <span class="badge ms-2"
                                                style="background:#fde68a;color:#92400e;font-size:0.8rem;"
                                                id="countdownBadge">
                                                Menghitung...
                                            </span>
                                        </p>
                                        <p class="mb-0 small text-muted">
                                            Akun akan otomatis permanen setelah dokter menginput rekam medis pertama.
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <script>
                                // Countdown timer
                                const expiredAt = new Date("{{ \Carbon\Carbon::parse($userPasien->expired_at)->toIso8601String() }}");

                                function updateCountdown() {
                                    const now = new Date();
                                    const diff = expiredAt - now;

                                    if (diff <= 0) {
                                        document.getElementById('countdownBadge').textContent = 'Sudah berakhir';
                                        return;
                                    }

                                    const days = Math.floor(diff / (1000 * 60 * 60 * 24));
                                    const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                    const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                                    const seconds = Math.floor((diff % (1000 * 60)) / 1000);

                                    let text = '';
                                    if (days > 0) text += days + 'h ';
                                    if (hours > 0) text += hours + 'j ';
                                    text += minutes + 'm ' + seconds + 'd';

                                    document.getElementById('countdownBadge').textContent = '⏱ ' + text;
                                }

                                updateCountdown();
                                setInterval(updateCountdown, 1000);
                            </script>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        {{-- Toggle Status Akun --}}
        @php $userPasien = \App\Models\User::find($pasien->user_id); @endphp
        @if($userPasien)
        <div class="card shadow-sm border-0 mt-3">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="fw-bold mb-1">
                        Status Akun:
                        <span class="badge {{ $userPasien->status === 'aktif' ? 'bg-success' : 'bg-danger' }}">
                            {{ ucfirst($userPasien->status) }}
                        </span>
                    </h6>
                    <small class="text-muted">
                        {{ $userPasien->status === 'aktif' 
                    ? 'Pasien dapat login dan menggunakan layanan.' 
                    : 'Pasien tidak dapat login. Aktifkan jika ingin berobat.' }}
                    </small>
                </div>
                @php
                $konfirmasi = $userPasien->status === 'aktif' ? 'menonaktifkan' : 'mengaktifkan';
                @endphp
                <form action="/dokter/pasien/{{ $pasien->id }}/toggle-status" method="POST"
                    onsubmit="return confirm('Yakin ingin {{ $konfirmasi }} akun pasien ini?')">
                    @csrf
                    @method('PATCH')
                    <button type="submit"
                        class="btn btn-sm {{ $userPasien->status === 'aktif' ? 'btn-danger' : 'btn-success' }}">
                        <i class="bi bi-{{ $userPasien->status === 'aktif' ? 'x-circle' : 'check-circle' }} me-1"></i>
                        {{ $userPasien->status === 'aktif' ? 'Nonaktifkan' : 'Aktifkan' }}
                    </button>
                </form>
            </div>
        </div>
        @endif
    </div>

    {{-- Rekam Medis --}}
    <div class="col-md-8">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white border-0 pt-3 d-flex justify-content-between align-items-center">
                <span class="fw-bold">
                    <i class="bi bi-clipboard2-pulse-fill text-primary me-2"></i>Rekam Medis
                </span>
                <a href="/dokter/pasien/{{ $pasien->id }}/rekam-medis/tambah"
                    class="btn btn-primary btn-sm">
                    <i class="bi bi-plus-circle me-1"></i>Tambah
                </a>
            </div>
            <div class="card-body">
                @forelse($pasien->rekamMedis->sortByDesc('tanggal_periksa') as $rm)
                <div class="card mb-3 border-start border-primary border-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <span class="badge bg-primary mb-1">
                                    {{ \Carbon\Carbon::parse($rm->tanggal_periksa)->format('d M Y') }}
                                </span>
                                <p class="mb-1 small">
                                    <strong>Dokter:</strong> {{ $rm->dokter }}
                                </p>
                                <p class="mb-1 small">
                                    <strong>Keluhan:</strong> {{ $rm->keluhan }}
                                </p>
                                <p class="mb-0 small">
                                    <strong>Diagnosis:</strong> {{ $rm->diagnosis }}
                                </p>
                            </div>
                            @if($rm->kode_icd10)
                            <p class="mb-1 small">
                                <strong>Diagnosis ICD-10:</strong>
                                <span class="badge bg-primary">{{ $rm->kode_icd10 }}</span>
                                {{ $rm->nama_icd10 }}
                            </p>
                            @endif
                            @if($rm->diagnosis)
                            <p class="mb-0 small text-muted">
                                <strong>Catatan:</strong> {{ $rm->diagnosis }}
                            </p>
                            @endif
                            <div class="d-flex gap-1">
                                <a href="/dokter/rekam-medis/{{ $rm->id }}/edit"
                                    class="btn btn-warning btn-sm">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="/dokter/rekam-medis/{{ $rm->id }}/hapus"
                                    method="POST"
                                    onsubmit="return confirm('Yakin hapus rekam medis ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center text-muted py-4">
                    <i class="bi bi-clipboard2-x" style="font-size: 2rem;"></i>
                    <p class="mt-2">Belum ada rekam medis.</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

</div>
@endsection