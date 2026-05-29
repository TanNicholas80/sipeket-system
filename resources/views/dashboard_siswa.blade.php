@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard Siswa</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('siswa.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Selamat Datang, {{ Auth::user()->name }}</h3>
                        </div>
                        <div class="card-body">
                            <p>Dashboard untuk siswa. Lencana dan progress akan ditampilkan di sini.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
</div>
@endsection
        /* ===== DASHBOARD SISWA FIX (Lencana center fix) ===== */
        .dashboard-wrapper {
            padding: 24px;
        }

        .dashboard-card {
            background: #ffffff;
            border-radius: 14px;
            padding: 32px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
            max-width: 1100px;
            margin: auto;
        }

        .dashboard-title {
            font-size: 20px;
            font-weight: 600;
        }

        .dashboard-alert {
            margin-top: 16px;
            background: #fff9d6;
            padding: 14px 20px;
            border-radius: 10px;
            font-size: 14px;
        }

        .dashboard-content {
            margin-top: 32px;
        }

        /* Lencana: judul + wrapper + image */
        .lencana-title {
            font-weight: 600;
            margin-bottom: 4px;
            /* DIPERKECIL */
            text-align: center;
        }

        /* wrap untuk memastikan layout vertikal dan center */
        .lencana-wrap {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        /* pastikan SVG tampil sebagai block dan tanpa whitespace */
        .lencana-img {
            display: block;
            margin-top: 0;
            /* rapat ke teks */
            width: 220px;
            /* DIPERBESAR */
            max-width: 100%;
            height: auto;
            object-fit: contain;
        }

        .stat-wrapper {
            display: flex;
            flex-direction: column;
            gap: 18px;
        }

        .stat-box {
            border: 1.8px solid #7fd6db;
            border-radius: 12px;
            padding: 20px 26px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .stat-left {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .stat-icon {
            font-size: 26px;
        }

        .stat-label {
            font-size: 16px;
            font-weight: 500;
        }

        .stat-number {
            font-size: 24px;
            font-weight: 700;
        }

        @media (max-width: 768px) {
            .dashboard-content {
                text-align: center;
            }

            .stat-box {
                padding: 16px 20px;
            }

            .lencana-img {
                margin-bottom: 20px;
                width: 130px;
            }
        }
    </style>

    <div class="content-wrapper dashboard-wrapper">
        <div class="dashboard-card">

            <!-- HEADER -->
            <div class="dashboard-title">
                Halo, {{ Auth::user()->name }} ({{ Auth::user()->kelas ?? 'IPA X A' }})
            </div>

            <!-- ALERT -->
            <div class="dashboard-alert">
                Yuks Selesaikan Kuis Bab Gerak !
            </div>

            <!-- CONTENT -->
            <div class="row dashboard-content align-items-center">

                <!-- LENCANA -->
                <div class="col-md-4">
                    <div class="lencana-wrap">
                        <div class="lencana-title">Lencana</div>

                        @if($badge && $badge->gambar_badge)
                            <img src="{{ asset('uploads/' . $badge->gambar_badge) }}" 
     class="lencana-img" 
     alt="{{ $badge->nama_badge }}" 
     title="{{ $badge->nama_badge }}">
                        @else
                            <div class="lencana-img" style="display:flex;align-items:center;justify-content:center;background:#f0f0f0;border-radius:12px;padding:20px;color:#999;">
                                <div style="text-align:center;">
                                    <i class="fas fa-medal" style="font-size:80px;margin-bottom:10px;"></i>
                                    <div style="font-size:14px;">Belum ada badge</div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- STAT -->
                <div class="col-md-8">
                    <div class="stat-wrapper">

                        <div class="stat-box">
                            <div class="stat-left">
                                <i class="fas fa-book stat-icon"></i>
                                <div class="stat-label">Materi</div>
                            </div>
                            <div class="stat-number">{{ $totalMateri ?? 0 }}</div>
                        </div>

                        <div class="stat-box">
                            <div class="stat-left">
                                <i class="fas fa-edit stat-icon"></i>
                                <div class="stat-label">Kuis</div>
                            </div>
                            <div class="stat-number">{{ $totalKuis ?? 0 }}</div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
