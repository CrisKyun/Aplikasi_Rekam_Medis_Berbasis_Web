<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Klinik Sehat dr. Luria')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="/css/app.css" rel="stylesheet">
</head>

<script>
    // Highlight nav link aktif saat scroll
    const sections = document.querySelectorAll('.section-anchor');
    const navLinks = document.querySelectorAll('.nav-section-link');

    if (sections.length && navLinks.length) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    navLinks.forEach(link => {
                        link.style.color = '#64748b';
                        link.style.background = 'transparent';
                    });
                    const active = document.querySelector(
                        `.nav-section-link[href="#${entry.target.id}"]`
                    );
                    if (active) {
                        active.style.color = '#2563eb';
                        active.style.background = '#eff6ff';
                        active.style.fontWeight = '600';
                    }
                }
            });
        }, {
            threshold: 0.3
        });

        sections.forEach(s => observer.observe(s));
    }
</script>

<body>

    <!-- {{-- Navbar --}}
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="/">
                <i class="bi bi-heart-pulse-fill me-2" style="color:var(--primary)"></i>
                Klinik Sehat dr. Luria
            </a>

            {{-- Mobile toggle --}}
            <button class="navbar-toggler border-0" type="button"
                data-bs-toggle="collapse" data-bs-target="#navMenu">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navMenu">
                <div class="ms-auto d-flex align-items-center gap-2 mt-2 mt-lg-0">
                    @if(session('user_id'))
                    <a href="/antrian" class="btn btn-outline-primary btn-sm">
                        <i class="bi bi-ticket-perforated me-1"></i>Antrian
                    </a>
                    <a href="/dashboard" class="btn btn-outline-primary btn-sm">
                        <i class="bi bi-speedometer2 me-1"></i>Dashboard
                    </a>
                    <span class="text-muted small d-none d-lg-inline">
                        {{ session('user_nama') }}
                    </span>
                    <form action="/logout" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-sm"
                            style="background:#fee2e2;color:#991b1b;">
                            <i class="bi bi-box-arrow-right me-1"></i>Logout
                        </button>
                    </form>
                    @else
                    <a href="/login" class="btn btn-primary btn-sm">
                        <i class="bi bi-box-arrow-in-right me-1"></i>Login
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </nav> -->

    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="/">
                <i class="bi bi-heart-pulse-fill me-2" style="color:var(--primary)"></i>
                {{ $klinik->nama_klinik ?? 'Klinik Sehat' }}
            </a>

            <button class="navbar-toggler border-0" type="button"
                data-bs-toggle="collapse" data-bs-target="#navMenu">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navMenu">

                {{-- Anchor links — hanya tampil di halaman home --}}
                @if(request()->is('/') || request()->is(''))
                <ul class="navbar-nav mx-auto gap-1">
                    @foreach([
                    ['#beranda', 'Beranda'],
                    ['#tentang', 'Tentang'],
                    ['#fitur', 'Fitur'],
                    ['#alur', 'Alur Sistem'],
                    ['#dokter', 'Dokter'],
                    ] as $nav)
                    <li class="nav-item">
                        <a class="nav-link nav-section-link px-3 py-2"
                            href="{{ $nav[0] }}"
                            style="font-size:0.875rem;font-weight:500;color:#64748b;
                              border-radius:8px;transition:all 0.2s;">
                            {{ $nav[1] }}
                        </a>
                    </li>
                    @endforeach
                </ul>
                @endif

                <div class="ms-auto d-flex align-items-center gap-2 mt-2 mt-lg-0">
                    @if(session('user_id'))
                    <a href="/antrian" class="btn btn-outline-primary btn-sm">
                        <i class="bi bi-ticket-perforated me-1"></i>Antrian
                    </a>
                    <a href="/dashboard" class="btn btn-outline-primary btn-sm">
                        <i class="bi bi-speedometer2 me-1"></i>Dashboard
                    </a>
                    <span class="text-muted small d-none d-lg-inline">
                        {{ session('user_nama') }}
                    </span>
                    <form action="/logout" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-sm"
                            style="background:#fee2e2;color:#991b1b;">
                            <i class="bi bi-box-arrow-right me-1"></i>Logout
                        </button>
                    </form>
                    @else
                    <a href="/login" class="btn btn-outline-primary btn-sm">Login Pasien</a>
                    <a href="/dokter/login" class="btn btn-outline-secondary btn-sm">Login Staff</a>
                    <a href="/register" class="btn btn-primary btn-sm">Daftar</a>
                    @endif
                </div>
            </div>
        </div>
    </nav>


    {{-- Main Content --}}
    <main class="container py-4" style="flex:1;">

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
    </main>
    {{-- Footer --}}
    @include('components.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>