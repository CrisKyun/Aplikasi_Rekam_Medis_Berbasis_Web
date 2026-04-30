<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Praktik Mandiri dr. Luria Widijana Haribawanti.')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body class="bg-light">

    {{-- Navbar --}}
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand fw-bold" href="/">
                <i class="bi bi-heart-pulse-fill me-2"></i>Praktik Mandiri dr. Luria Widijana Haribawanti.
            </a>
            <div class="d-flex gap-2">
                @if(session('user_id'))
                <span class="navbar-text text-white me-3">
                    <i class="bi bi-person-circle me-1"></i>{{ session('user_nama') }}
                </span>
                <form action="/logout" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-light btn-sm">
                        <i class="bi bi-box-arrow-right me-1"></i>Logout
                    </button>
                </form>
                @else
                <a href="/login" class="btn btn-outline-light btn-sm">
                    <i class="bi bi-box-arrow-in-right me-1"></i>Login
                </a>
                @endif
            </div>
        </div>
    </nav>

    {{-- Konten --}}
    <main class="container py-4">
        {{-- Alert sukses --}}
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        {{-- Alert error --}}
        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>