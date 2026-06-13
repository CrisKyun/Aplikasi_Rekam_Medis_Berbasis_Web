<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Panel Dokter')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="/css/app.css" rel="stylesheet">
</head>

<body>

    {{-- Sidebar Overlay (mobile) --}}
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>

    {{-- Sidebar --}}
    <div class="sidebar" id="sidebar">
        <div class="brand">
            <h6 class="mb-0">
                <i class="bi bi-heart-pulse-fill me-2"></i>Klinik Sehat
            </h6>
            <small>Panel {{ session('user_role_nama') ?? 'Dokter' }}</small>
        </div>

        <nav class="py-1">
            <a href="/dokter/dashboard"
                class="{{ request()->is('dokter/dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2 me-2"></i>Dashboard
            </a>

            <a href="/dokter/pasien"
                class="{{ request()->is('dokter/pasien*') ? 'active' : '' }}">
                <i class="bi bi-people-fill me-2"></i>Data Pasien
            </a>

            <a href="/dokter/antrian"
                class="{{ request()->is('dokter/antrian*') ? 'active' : '' }}"
                style="position:relative;">
                <i class="bi bi-ticket-perforated-fill me-2"></i>Antrian
                @if(isset($badgeAntrian) && $badgeAntrian > 0)
                <span id="badgeAntrian" style="
                    position:absolute; top:6px; right:10px;
                    background:#dc2626; color:#fff;
                    border-radius:50%; min-width:20px; height:20px;
                    font-size:11px; font-weight:700;
                    display:flex; align-items:center; justify-content:center;
                    padding:0 4px;">
                    {{ $badgeAntrian > 99 ? '99+' : $badgeAntrian }}
                </span>
                @endif
            </a>

            <a href="/dokter/kelola-dokter"
                class="{{ request()->is('dokter/kelola-dokter*') ? 'active' : '' }}">
                <i class="bi bi-person-badge-fill me-2"></i>Kelola Dokter
            </a>

            <a href="/dokter/klinik"
                class="{{ request()->is('dokter/klinik*') ? 'active' : '' }}">
                <i class="bi bi-gear-fill me-2"></i>Info Klinik
            </a>

            <a href="/dokter/history"
                class="{{ request()->is('dokter/history*') ? 'active' : '' }}">
                <i class="bi bi-clock-history me-2"></i>History Aktivitas
            </a>

            @if(session('user_role') == 1)
            <div class="section-label">Superadmin</div>

            <a href="/superadmin/staff"
                class="{{ request()->is('superadmin/staff*') ? 'active' : '' }}">
                <i class="bi bi-people-fill me-2"></i>Kelola Staff
            </a>
            @endif

        </nav>

        <div class="mt-auto p-3" style="border-top:1px solid var(--border); margin-top:auto;">
            <div class="d-flex align-items-center gap-2 mb-2">
                <div style="width:32px;height:32px;background:#eff6ff;border-radius:50%;
                        display:flex;align-items:center;justify-content:center;
                        color:var(--primary);font-size:0.9rem;">
                    <i class="bi bi-person-fill"></i>
                </div>
                <div style="overflow:hidden;">
                    <p class="mb-0 fw-semibold" style="font-size:0.8rem;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                        {{ session('user_nama') }}
                    </p>
                    <p class="mb-0 text-muted" style="font-size:0.72rem;">
                        {{ session('user_role_nama') ?? 'Staff' }}
                    </p>
                </div>
            </div>
            <form action="/dokter/logout" method="POST">
                @csrf
                <button type="submit" class="btn btn-sm w-100"
                    style="background:#fee2e2;color:#991b1b;font-size:0.8rem;">
                    <i class="bi bi-box-arrow-left me-1"></i>Logout
                </button>
            </form>
        </div>
    </div>

    {{-- Main Content --}}
    <div class="main-content">

        {{-- Topbar --}}
        <div class="topbar">
            <div class="d-flex align-items-center gap-3">
                <button class="sidebar-toggle" onclick="toggleSidebar()">
                    <i class="bi bi-list"></i>
                </button>
                <h5 class="page-title">@yield('page-title')</h5>
            </div>
            <span class="text-muted small d-none d-md-block">
                <i class="bi bi-person-circle me-1"></i>{{ session('user_nama') }}
            </span>
        </div>

        {{-- Content --}}
        <div class="content-area">

            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-3">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show mb-3">
                <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            @yield('content')

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Sidebar toggle mobile
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('open');
            document.getElementById('sidebarOverlay').classList.toggle('open');
        }

        function closeSidebar() {
            document.getElementById('sidebar').classList.remove('open');
            document.getElementById('sidebarOverlay').classList.remove('open');
        }

        // Auto refresh badge antrian
        setInterval(function() {
            fetch('/dokter/badge-count')
                .then(res => res.json())
                .then(data => {
                    const badge = document.getElementById('badgeAntrian');
                    if (data.antrian > 0) {
                        if (!badge) location.reload();
                        else {
                            badge.textContent = data.antrian > 99 ? '99+' : data.antrian;
                            badge.style.display = 'flex';
                        }
                    } else if (badge) {
                        badge.style.display = 'none';
                    }
                }).catch(() => {});
        }, 30000);
    </script>
</body>

</html>