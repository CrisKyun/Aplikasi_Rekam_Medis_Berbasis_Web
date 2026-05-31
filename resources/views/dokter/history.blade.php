@extends('layouts.dokter')
@section('title', 'History Aktivitas Saya')
@section('page-title', 'History Aktivitas Saya')

@section('content')

<div class="card shadow-sm border-0">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Waktu</th>
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
                            <span class="badge bg-secondary">
                                {{ ucfirst(str_replace('_', ' ', $h->modul)) }}
                            </span>
                        </td>
                        <td>{{ $h->deskripsi }}</td>
                        <td><small class="text-muted">{{ $h->ip_address }}</small></td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted py-4">
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