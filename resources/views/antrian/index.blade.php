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
    <div class="antrian-grid">
        @forelse($antrian as $a)

            <div class="ticket-card">
                <div class="ticket-number-section">
                    <div class="ticket-number-label">
                        No. Antrian
                    </div>
                    <div class="ticket-number">
                        {{ str_pad($a->nomor_antrian, 2, '0', STR_PAD_LEFT)}}
                    </div>
                </div>

                <div class="ticket-divider"></div>

                <div class="ticket-info-section">
                    <div class="ticket-patient">
                        {{ $a->pasien->nama_lengkap }}
                    </div>
                    <div class="ticket-doctor">
                        <i class="bi bi-person-badge me-1"></i>
                        {{ $a->dokter->nama_dokter }}
                        — {{ $a->dokter->bidang_medis }}
                    </div>
                    <div class="ticket-info-row">
                        <i class="bi bi-calendar"></i>
                        <span>
                            {{ \Carbon\Carbon::parse($a->tanggal_kunjungan)->locale('id')->translatedFormat('l, d M Y') }}
                        </span>
                    </div>
                </div>

                <div class="ticket-divider"></div>

                <div class="ticket-middle">
                    <div class="ticket-time-block">
                        <div class="ticket-section-title">
                            Waktu Pendaftaran
                        </div>
                        <div class="ticket-time">
                            <i class="bi bi-clock-history"></i>
                            <strong>
                                {{ $a->created_at ? $a->created_at->format('H:i') : '-' }}
                            </strong>
                            <span>WIB</span>
                        </div>
                    </div>
                    <div class="ticket-time-block">
                        <div class="ticket-section-title">
                            Estimasi Pelayanan
                        </div>
                        <div class="ticket-time">
                            <i class="bi bi-clock"></i>
                            <strong>
                                {{ \Carbon\Carbon::parse($a->estimasi_jam)->format('H:i') }}
                            </strong>
                            <span>WIB</span>
                            <span class="datang-awal" style="margin-top: -3px">
                                (datang 15 menit lebih awal)
                            </span>
                        </div>
                    </div>
                </div>

                <div class="ticket-divider"></div>

                <div class="ticket-bottom">
                    <div class="ticket-status-label">Status Antrian</div>
                    @if($a->status_antrian === 'menunggu')
                        <span class="ticket-status ticket-status-menunggu">
                            <i class="bi bi-hourglass-split"></i>Menunggu</span>
                    @elseif($a->status_antrian === 'dipanggil')
                        <span class="ticket-status ticket-status-dipanggil">
                            <i class="bi bi-megaphone-fill"></i>Dipanggil</span>
                    @elseif($a->status_antrian === 'selesai')
                        <span class="ticket-status ticket-status-selesai">
                            <i class="bi bi-check-circle-fill"></i>Selesai</span>
                    @else
                        <span class="ticket-status ticket-status-batal">
                            <i class="bi bi-x-circle-fill"></i>
                            Batal
                        </span>
                    @endif
                    <div class="ticket-complaint">
                        <i class="bi bi-chat-left-text me-1"></i>
                        <strong>Keluhan:</strong>
                        {{ $a->keluhan_awal ?? '-' }}
                    </div>
                    @if($a->status_antrian === 'menunggu')
                        <form action="/antrian/{{ $a->id }}/batal" method="POST"
                            onsubmit="return confirm('Yakin ingin membatalkan antrian ini?')">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn-danger btn-outline-danger btn-sm" >
                                <i class="bi bi-x-circle me-1"></i>
                                Batalkan Antrian
                            </button>
                        </form>
                    @endif
                    @if($a->status_antrian === 'dipanggil')
                        <div class="ticket-called mt-2">
                            <i class="bi bi-megaphone-fill me-1"></i>
                            <strong>Anda sedang dipanggil!</strong>
                            Silakan menuju ruang pemeriksaan.
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <div class="text-center text-muted py-5">
                <i class="bi bi-ticket-perforated" style="font-size: 3rem;"></i>
                <p class="mt-3">
                    Belum ada antrian.
                </p>
                <a href="/antrian/daftar" class="btn btn-primary btn-sm">
                    <i class="bi bi-plus-circle me-1"></i>
                    Daftar Sekarang
                </a>
            </div>
        @endforelse
    </div>
@endsection