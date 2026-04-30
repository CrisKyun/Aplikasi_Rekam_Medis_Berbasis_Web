@extends('layouts.dokter')
@section('title', 'Kelola Dokter')
@section('page-title', 'Kelola Dokter')

@section('content')

<div class="d-flex justify-content-end mb-3">
    <a href="/dokter/kelola-dokter/tambah" class="btn btn-primary btn-sm">
        <i class="bi bi-plus-circle me-1"></i>Tambah Dokter
    </a>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Nama Dokter</th>
                    <th>Bidang Medis</th>
                    <th>No. HP</th>
                    <th>Jadwal</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($dokter as $dr)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $dr->nama_dokter }}</td>
                    <td>{{ $dr->bidang_medis }}</td>
                    <td>{{ $dr->no_hp ?? '-' }}</td>
                    <td>
                        @foreach($dr->jadwalDokter->where('status', 'Aktif') as $j)
                        <small class="badge bg-light text-dark border me-1">
                            {{ $j->hari }}
                        </small>
                        @endforeach
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="/dokter/kelola-dokter/{{ $dr->id }}/edit"
                                class="btn btn-warning btn-sm">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="/dokter/kelola-dokter/{{ $dr->id }}/hapus"
                                method="POST"
                                onsubmit="return confirm('Yakin hapus dokter ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-3">
                        Belum ada data dokter.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection