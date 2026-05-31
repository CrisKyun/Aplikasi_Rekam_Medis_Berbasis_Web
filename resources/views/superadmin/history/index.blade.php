@extends('layouts.dokter')
@section('title', 'History Aktivitas Staff')
@section('page-title', 'History Aktivitas Staff')

@section('content')

{{-- Filter --}}
<div class="card shadow-sm border-0 mb-4">
    <div class="card-body">
        <form action="/superadmin/history" method="GET" class="row g-2">
            <div class="col-md-4">
                <select name="user_id" class="form-select">
                    <option value="">-- Semua Staff --</option>
                    @foreach($staff as $s)
                    <option value="{{ $s->id }}" {{ $userId == $s->id ? 'selected' : '' }}>
                        {{ $s->nama_lengkap }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <select name="modul" class="form-select">
                    <option value="">-- Semua Modul --</option>
                    @foreach(['auth','rekam_medis','pasien','antrian','staff','dokter','klinik'] as $m)
                    <option value="{{ $m }}" {{ $modul == $m ? 'selected' : '' }}>
                        {{ ucfirst(str_replace('_', ' ', $m)) }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-filter me-1"></i>Filter
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Tabel History --}}
<div class="card shadow-sm border-0">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Waktu</th>
                        <th>Staff</th>
                        <th>Modul</th>
                        <th>Aktivitas</th>
                        <th>IP Address</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($history as $h)
                    <tr>
                        <td>
                            <small>{{ \Carbon\Carbon::parse($h->created_at)->format('d M Y H:i') }}</small>
                        </td>
                        <td>
                            <span class="fw-semibold">{{ $h->user->nama_lengkap ?? '-' }}</span>
                            <br>
                            <small class="badge {{ $h->user->role_id == 1 ? 'bg-danger' : 'bg-primary' }}">
                                {{ $h->user->role_id == 1 ? 'Superadmin' : 'Staff' }}
                            </small>
                        </td>
                        <td>
                            <span class="badge bg-secondary">
                                {{ ucfirst(str_replace('_', ' ', $h->modul)) }}
                            </span>
                        </td>
                        <td>{{ $h->deskripsi }}</td>
                        <td><small class="text-muted">{{ $h->ip_address }}</small></td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">
                            Belum ada aktivitas tercatat.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($history->hasPages())
        <div class="p-3">{{ $history->links() }}</div>
        @endif
    </div>
</div>

@endsection