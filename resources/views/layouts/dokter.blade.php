<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Panel Dokter - Klinik Sehat Bersama')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .sidebar {
            min-height: 100vh;
            background-color: #0d6efd;
        }

        .sidebar a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            display: block;
            padding: 10px 20px;
            border-radius: 8px;
            margin-bottom: 4px;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background-color: rgba(255, 255, 255, 0.2);
            color: white;
        }

        .main-content {
            background-color: #f8f9fa;
            min-height: 100vh;
        }
    </style>
</head>

<body>

    <div class="d-flex">

        {{-- Sidebar --}}
        <div class="sidebar p-3" style="width: 240px; min-width: 240px;">
            <div class="text-white mb-4 mt-2">
                <h6 class="fw-bold mb-0">
                    <i class="bi bi-heart-pulse-fill me-2"></i>Klinik Sehat
                </h6>
                <small class="opacity-75">Panel Dokter</small>
            </div>

            <hr class="border-white opacity-25">

            <a href="/dokter/dashboard"
                class="{{ request()->is('dokter/dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2 me-2"></i>Dashboard
            </a>

            <a href="/dokter/pasien"
                class="{{ request()->is('dokter/pasien*') ? 'active' : '' }}">
                <i class="bi bi-people-fill me-2"></i>Data Pasien
            </a>

            <a href="/dokter/kelola-dokter"
                class="{{ request()->is('dokter/kelola-dokter*') ? 'active' : '' }}">
                <i class="bi bi-person-badge-fill me-2"></i>Kelola Dokter
            </a>

            <a href="/dokter/antrian"
                class="{{ request()->is('dokter/antrian*') ? 'active' : '' }}"
                style="position: relative;">
                <i class="bi bi-ticket-perforated-fill me-2"></i>Antrian

                {{-- Badge notifikasi --}}
                @if(isset($badgeAntrian) && $badgeAntrian > 0)
                <span id="badgeAntrian" style="
            position: absolute;
            top: 6px;
            right: 10px;
            background: #dc3545;
            color: white;
            border-radius: 50%;
            min-width: 20px;
            height: 20px;
            font-size: 11px;
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0 4px;
        ">{{ $badgeAntrian > 99 ? '99+' : $badgeAntrian }}</span>
                @endif
            </a>

            <a href="/dokter/klinik"
                class="{{ request()->is('dokter/klinik*') ? 'active' : '' }}">
                <i class="bi bi-gear-fill me-2"></i>Info Klinik
            </a>

            {{-- Menu History (semua staff) --}}
            <a href="/dokter/history"
                class="{{ request()->is('dokter/history') ? 'active' : '' }}">
                <i class="bi bi-clock-history me-2"></i>History Saya
            </a>

            {{-- Menu Superadmin Only --}}
            @if(session('user_role') == 1)
            <hr class="border-white opacity-25">
            <small class="text-white-50 px-3" style="font-size:0.7rem;">SUPERADMIN</small>

            <a href="/superadmin/staff"
                class="{{ request()->is('superadmin/staff*') ? 'active' : '' }}">
                <i class="bi bi-people-fill me-2"></i>Kelola Staff
            </a>

            <a href="/superadmin/history"
                class="{{ request()->is('superadmin/history*') ? 'active' : '' }}">
                <i class="bi bi-journal-text me-2"></i>History Semua Staff
            </a>
            @endif

            <hr class="border-white opacity-25">

            <form action="/dokter/logout" method="POST">
                @csrf
                <button type="submit"
                    class="btn btn-link p-0 text-white-50 w-100 text-start ps-3">
                    <i class="bi bi-box-arrow-left me-2"></i>Logout
                </button>
            </form>

        </div>

        {{-- Main Content --}}
        <div class="main-content flex-grow-1 p-4">

            {{-- Topbar --}}
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-bold mb-0">@yield('page-title')</h5>
                <span class="text-muted small">
                    <i class="bi bi-person-circle me-1"></i>{{ session('user_nama') }}
                </span>
            </div>

            {{-- Alert --}}
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif
            @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            @yield('content')
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Refresh badge setiap 30 detik tanpa reload halaman
        setInterval(function() {
            fetch('/dokter/badge-count')
                .then(res => res.json())
                .then(data => {
                    const badge = document.getElementById('badgeAntrian');
                    if (data.antrian > 0) {
                        if (!badge) {
                            // buat badge baru kalau belum ada
                            location.reload();
                        } else {
                            badge.textContent = data.antrian > 99 ? '99+' : data.antrian;
                            badge.style.display = 'flex';
                        }
                    } else if (badge) {
                        badge.style.display = 'none';
                    }
                });
        }, 30000); // 30 detik
    </script>
</body>

</html>