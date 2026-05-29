<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Sanggar Seni Dharmo Yuwono Purwokerto</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="/images/logo1.png">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
        }

        /* Navbar */
        .navbar {
            background-color: #0b3d2e;
        }

        /* Hero */
        .hero {
            background:
                linear-gradient(rgba(11, 61, 46, 0.65), rgba(11, 61, 46, 0.65)),
                url("/images/hero-bg.jpg");
            background-size: cover;
            background-position: center;
            color: white;
            padding: 120px 0;
        }

        .hero img {
            width: 110px;
            margin-bottom: 20px;
        }

        /* Section Title */
        .section-title {
            font-weight: 600;
            margin-bottom: 40px;
            position: relative;
        }

        .section-title::after {
            content: "";
            width: 60px;
            height: 3px;
            background: #0b3d2e;
            display: block;
            margin: 10px auto 0;
        }

        .section-light {
            background-color: #f5f5f5;
        }

        /* Gallery */
        .gallery img {
            border-radius: 8px;
            transition: 0.3s ease;
        }

        .gallery img:hover {
            transform: scale(1.05);
        }

        /* Footer */
        .footer {
            background-color: #0b3d2e;
            color: white;
            padding: 25px 0;
            font-size: 14px;
        }

        /* Button */
        .btn-primary {
            background-color: #0b3d2e;
            border: none;
        }

        .btn-primary:hover {
            background-color: #145c43;
        }
    </style>
</head>

<body>

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-dark shadow-sm">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="/">
                <img src="/images/logo1.png" width="40" class="me-2">
                <span class="fw-semibold">Sanggar Seni Dharmo Yuwono</span>
            </a>

            <div>
                <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm me-2">
                    Login
                </a>
                <a href="{{ route('pendaftaran.index') }}" class="btn btn-light btn-sm">
                    Pendaftaran Siswa
                </a>
            </div>
        </div>
    </nav>

    <!-- HERO -->
    <section class="hero text-center">
        <div class="container" data-aos="fade-up">
            <img src="/images/logo1.png">
            <h1 class="fw-bold mt-3">Sanggar Seni Dharmo Yuwono</h1>
            <h5>Purwokerto</h5>

            <p class="lead mx-auto mt-4" style="max-width: 750px;">
                Lembaga pendidikan seni tari yang berkomitmen melestarikan budaya bangsa
                serta membentuk generasi yang disiplin, kreatif, dan berprestasi.
            </p>

            <a href="{{ route('pendaftaran.index') }}" class="btn btn-primary mt-4 px-4">
                Daftar Sekarang
            </a>
        </div>
    </section>

    <!-- PROFIL -->
    <section class="py-5">
        <div class="container text-center" data-aos="fade-up">
            <h3 class="section-title">Profil Singkat</h3>
            <p class="mx-auto" style="max-width: 850px;">
                Sanggar Seni Dharmo Yuwono Purwokerto merupakan lembaga pendidikan seni
                yang fokus pada pembinaan tari tradisional dan kreasi.
                Dengan sistem pelatihan terstruktur dan pelatih profesional,
                sanggar ini telah berkontribusi dalam berbagai festival dan pertunjukan seni.
            </p>
        </div>
    </section>

    <!-- PROGRAM -->
    <section class="section-light py-5">
        <div class="container text-center">
            <h3 class="section-title" data-aos="fade-up">Program Pelatihan</h3>

            <div class="row">
                <div class="col-md-4" data-aos="fade-up">
                    <h5 class="fw-bold">Tari Tradisional</h5>
                    <p>Pembelajaran tari daerah sebagai pelestarian budaya.</p>
                </div>

                <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                    <h5 class="fw-bold">Tari Kreasi</h5>
                    <p>Pengembangan kreativitas melalui karya inovatif.</p>
                </div>

                <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                    <h5 class="fw-bold">Persiapan Lomba</h5>
                    <p>Pembinaan intensif untuk kompetisi dan pentas seni.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- GALERI -->
    <section class="py-5">
        <div class="container text-center">
            <h3 class="section-title" data-aos="fade-up">Galeri Kegiatan</h3>

            <div class="row gallery">
                <div class="col-md-4 mb-4" data-aos="zoom-in">
                    <img src="/images/gallery1.jpg" class="img-fluid">
                </div>
                <div class="col-md-4 mb-4" data-aos="zoom-in" data-aos-delay="100">
                    <img src="/images/gallery2.jpg" class="img-fluid">
                </div>
                <div class="col-md-4 mb-4" data-aos="zoom-in" data-aos-delay="200">
                    <img src="/images/gallery3.jpg" class="img-fluid">
                </div>
            </div>
        </div>
    </section>

    <!-- VISI MISI -->
    <section class="section-light py-5">
        <div class="container">
            <h3 class="section-title text-center" data-aos="fade-up">Visi & Misi</h3>

            <div class="row mt-4">
                <div class="col-md-6" data-aos="fade-right">
                    <h5 class="fw-bold">Visi</h5>
                    <p>
                        Menjadi sanggar tari unggulan dalam pembinaan seni budaya
                        serta berkontribusi dalam pelestarian tari Indonesia.
                    </p>
                </div>

                <div class="col-md-6" data-aos="fade-left">
                    <h5 class="fw-bold">Misi</h5>
                    <ul>
                        <li>Menyelenggarakan pelatihan berkualitas.</li>
                        <li>Mengembangkan kreativitas peserta didik.</li>
                        <li>Mendorong partisipasi dalam kegiatan budaya.</li>
                        <li>Menanamkan nilai disiplin dan tanggung jawab.</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="footer text-center">
        <div class="container">
            © {{ date('Y') }} Sanggar Seni Dharmo Yuwono Purwokerto.
            <br>
            Website Resmi Sanggar Seni Dharmo Yuwono
        </div>
    </footer>

    <!-- JS -->
    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 800,
            once: true
        });
    </script>

</body>

</html>