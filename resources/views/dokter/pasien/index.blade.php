@extends('layouts.dokter')
@section('title', 'Data Pasien')
@section('page-title', 'Data Pasien')

@section('content')

{{-- Search --}}
<div class="card shadow-sm border-0 mb-4">
    <div class="card-body">
        <form action="/dokter/pasien" method="GET" class="d-flex gap-2">
            <input type="text" name="search" class="form-control"
                placeholder="Cari nama atau NIK pasien..."
                value="{{ $search }}">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-search"></i>
            </button>
            @if($search)
            <a href="/dokter/pasien" class="btn btn-secondary">Reset</a>
            @endif
        </form>
    </div>
</div>

{{-- Tabel Pasien --}}
<div class="card shadow-sm border-0">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Nama Lengkap</th>
                        <th>NIK</th>
                        <th>Jenis Kelamin</th>
                        <th>Tgl Lahir</th>
                        <th>Hubungan KK</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pasien as $p)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $p->nama_lengkap }}</td>
                        <td>{{ $p->nik }}</td>
                        <td>{{ $p->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                        <td>{{ \Carbon\Carbon::parse($p->tanggal_lahir)->format('d M Y') }}</td>
                        <td><span class="badge bg-secondary">{{ $p->status_hubungan }}</span></td>
                        <td>
                            @php $up = \App\Models\User::find($p->user_id); @endphp
                            @if($up)
                            @if($up->expired_at && \Carbon\Carbon::parse($up->expired_at)->isFuture())
                            {{-- Belum permanen - tampilkan countdown --}}
                            <span class="badge"
                                style="background:#fef3c7;color:#92400e;font-size:0.72rem;">
                                <i class="bi bi-hourglass-split me-1"></i>
                                Belum Divalidasi
                            </span>
                            <br>
                            <small class="text-warning" style="font-size:0.7rem;">
                                Berakhir {{ \Carbon\Carbon::parse($up->expired_at)->diffForHumans() }}
                            </small>
                            @elseif($up->status === 'aktif')
                            <span class="badge" style="background:#dcfce7;color:#166534;">
                                <i class="bi bi-patch-check-fill me-1"></i>Tervalidasi
                            </span>
                            @else
                            <span class="badge" style="background:#fee2e2;color:#991b1b;">
                                <i class="bi bi-x-circle me-1"></i>Nonaktif
                            </span>
                            @endif
                            @endif
                        </td>
                        <td>
                            <a href="/dokter/pasien/{{ $p->id }}"
                                class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-eye me-1"></i>Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-3">
                            @if($search)
                            Tidak ada hasil untuk "{{ $search }}"
                            @else
                            Belum ada data pasien.
                            @endif
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($pasien->hasPages())
        <div class="p-3">
            {{ $pasien->links() }}
        </div>
        @endif

    </div>
</div>

@endsection