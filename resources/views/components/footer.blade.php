<footer class="site-footer">
    <div class="container">
        <div class="row g-4">

            {{-- Brand & Deskripsi --}}
            <div class="col-md-4">
                <div class="footer-brand">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <i class="bi bi-heart-pulse-fill text-primary" style="font-size:1.4rem;"></i>
                        <h6 class="mb-0">{{ $klinik->nama_klinik ?? 'Klinik Sehat dr. Luria' }}</h6>
                    </div>
                    <p>{{ $klinik->deskripsi ?? 'Melayani kesehatan masyarakat dengan sepenuh hati.' }}</p>

                    @if($klinik)
                    <ul class="list-unstyled mb-0">
                        <li class="d-flex gap-2 mb-1">
                            <i class="bi bi-geo-alt text-primary flex-shrink-0 mt-1" style="font-size:0.85rem;"></i>
                            <span class="text-muted" style="font-size:0.82rem;">{{ $klinik->alamat }}</span>
                        </li>
                        <li class="d-flex gap-2 mb-1">
                            <i class="bi bi-telephone text-primary flex-shrink-0 mt-1" style="font-size:0.85rem;"></i>
                            <span class="text-muted" style="font-size:0.82rem;">{{ $klinik->no_telepon }}</span>
                        </li>
                        @if($klinik->email)
                        <li class="d-flex gap-2">
                            <i class="bi bi-envelope text-primary flex-shrink-0 mt-1" style="font-size:0.85rem;"></i>
                            <span class="text-muted" style="font-size:0.82rem;">{{ $klinik->email }}</span>
                        </li>
                        @endif
                    </ul>
                    @endif
                </div>
            </div>

            {{-- Link Cepat --}}
            <div class="col-6 col-md-2">
                <p class="footer-title">Menu</p>
                <a href="/" class="footer-link">
                    <i class="bi bi-house me-1"></i>Beranda
                </a>
                <a href="/login" class="footer-link">
                    <i class="bi bi-box-arrow-in-right me-1"></i>Login Pasien
                </a>
                <a href="/register" class="footer-link">
                    <i class="bi bi-person-plus me-1"></i>Daftar Akun
                </a>
                @if(session('user_id'))
                <a href="/antrian/daftar" class="footer-link">
                    <i class="bi bi-ticket-perforated me-1"></i>Daftar Antrian
                </a>
                @endif
            </div>

            {{-- Kontak Person --}}
            <div class="col-md-3">
                <p class="footer-title">Kontak Pengembang</p>

                <div class="d-flex flex-column gap-2">
                    <a href="https://wa.me/6281253347412"
                        target="_blank"
                        class="d-flex align-items-center gap-2 text-decoration-none"
                        style="color:#64748b;">
                        <div style="width:32px;height:32px;background:#dcfce7;border-radius:50%;
                                    display:flex;align-items:center;justify-content:center;
                                    flex-shrink:0;">
                            <i class="bi bi-whatsapp" style="color:#16a34a;font-size:0.9rem;"></i>
                        </div>
                        <div>
                            <p class="mb-0 fw-semibold" style="font-size:0.82rem;">Tim PYK</p>
                            <p class="mb-0 text-muted" style="font-size:0.75rem;">Hubungi via WhatsApp</p>
                        </div>
                    </a>

                    <a href="mailto:pykteam1@gmail.com"
                        class="d-flex align-items-center gap-2 text-decoration-none"
                        style="color:#64748b;">
                        <div style="width:32px;height:32px;background:#dbeafe;border-radius:50%;
                                    display:flex;align-items:center;justify-content:center;
                                    flex-shrink:0;">
                            <i class="bi bi-envelope" style="color:#1e40af;font-size:0.9rem;"></i>
                        </div>
                        <div>
                            <p class="mb-0 fw-semibold" style="font-size:0.82rem;">Email Kami</p>
                            <p class="mb-0 text-muted" style="font-size:0.75rem;">pykteam1@gmail.com</p>
                        </div>
                    </a>
                </div>
            </div>

            {{-- Partner Logos --}}
            <div class="col-md-3">
                <p class="footer-title">Dikembangkan Oleh</p>
                <div class="d-flex flex-column gap-3">


                    <div class="d-flex align-items-center gap-2">
                        <img src="/images/logo-pyk.png"
                            alt="PYK Team"
                            class="logo-partner"
                            style="height:36px;"
                            onerror="this.style.display='none'">
                        <div>
                            <p class="mb-0 fw-semibold" style="font-size:0.82rem;">PYK Team</p>
                            <p class="mb-0 text-muted" style="font-size:0.72rem;">Tim Pengembang Aplikasi</p>
                        </div>
                    </div>

                    <div class="d-flex align-items-center gap-2">
                        <img src="/images/logo-rediswangi.png"
                            alt="Rediswangi"
                            class="logo-partner"
                            style="height:36px;"
                            onerror="this.style.display='none'">
                        <div>
                            <p class="mb-0 fw-semibold" style="font-size:0.82rem;">Rediswangi</p>
                            <p class="mb-0 text-muted" style="font-size:0.72rem;">Mitra Kesehatan</p>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

    {{-- Footer Bottom --}}
    <div class="footer-bottom mt-4">
        <div class="container">
            <div class="d-flex flex-column flex-md-row justify-content-center align-items-center gap-2">
                <p class="text-muted mb-0" style="font-size:0.78rem;">
                    © {{ date('Y') }} {{ $klinik->nama_klinik ?? 'Klinik Sehat dr. Luria' }}.
                    Dikembangkan oleh <strong>PYK Team</strong> — Poliwangi.
                </p>
                <div class="d-flex align-items-center gap-3">
                    <img src="/images/logo-poliwangi.png" alt="Poliwangi" style="height:24px;opacity:0.6;"
                        onerror="this.style.display='none'">
                    <img src="/images/logo-pyk.png" alt="PYK" style="height:24px;opacity:0.6;"
                        onerror="this.style.display='none'">
                    <img src="/images/logo-rediswangi.png" alt="Rediswangi" style="height:24px;opacity:0.6;"
                        onerror="this.style.display='none'">
                </div>
            </div>
        </div>
    </div>
</footer>