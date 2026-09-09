@extends('layouts.dokter')
@section('title', 'Kelola Staff')
@section('page-title', 'Kelola Staff')

@section('content')

<div class="d-flex justify-content-end mb-3">
    <a href="/superadmin/staff/tambah" class="btn btn-primary btn-sm">
        <i class="bi bi-person-plus-fill me-1"></i>Tambah Staff
    </a>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>NIK</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($staff as $s)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $s->nama_lengkap ?? $s->username ?? '-' }}</td>
                    <td>{{ $s->email }}</td>
                    <td>{{ $s->nik }}</td>
                    <td>
                        @php
                        $roleConfig = [
                        1 => ['Superadmin', '#fee2e2', '#991b1b'],
                        2 => ['Admin', '#fef3c7', '#92400e'],
                        3 => ['Dokter', '#dbeafe', '#1e40af'],
                        ];
                        $rc = $roleConfig[$s->role_id] ?? ['Unknown', '#f8fafc', '#64748b'];
                        @endphp
                        <span class="badge"
                            style="background:{{ $rc[1] }};color:{{ $rc[2] }};">
                            {{ $rc[0] }}
                        </span>
                    </td>
                    <td>
                        <span class="badge {{ $s->status == 'aktif' ? 'bg-success' : 'bg-secondary' }}">
                            {{ ucfirst($s->status) }}
                        </span>
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="/superadmin/staff/{{ $s->id }}/edit"
                                class="btn btn-warning btn-sm">
                                <i class="bi bi-pencil"></i>
                            </a>
                            @if($s->id != session('user_id'))
                            <form action="/superadmin/staff/{{ $s->id }}/hapus" method="POST"
                                onsubmit="return confirm('Yakin hapus staff ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-3">Belum ada staff.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection