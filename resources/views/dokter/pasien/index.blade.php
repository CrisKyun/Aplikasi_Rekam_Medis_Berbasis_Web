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
                            <span class="badge {{ $up->status === 'aktif' ? 'bg-success' : 'bg-danger' }}">
                                {{ ucfirst($up->status) }}
                            </span>
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