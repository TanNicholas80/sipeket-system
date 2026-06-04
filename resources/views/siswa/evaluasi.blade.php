@extends('layout.main')

@section('page_title', 'Hasil Evaluasi')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Hasil Evaluasi Kenaikan Tingkat</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('siswa.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Hasil Evaluasi</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header border-transparent">
                <h3 class="card-title"><i class="fas fa-chart-line mr-1"></i> Daftar Evaluasi</h3>
                <div class="card-tools">
                    <a href="{{ route('siswa.dashboard') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> Dashboard
                    </a>
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body p-0">
                @include('siswa.partials.tabel-evaluasi')
            </div>
            @if($evaluasiRows->isNotEmpty())
            <div class="card-footer text-muted small">
                Hasil evaluasi dicatat oleh pelatih setelah penilaian harian atau ujian selesai direkap.
            </div>
            @endif
        </div>
    </div>
</section>
@endsection
