@extends('layout.main')

@section('page_title', 'Laporan')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Laporan</h4>
                    <p class="mb-0">Pilih laporan yang ingin dicetak atau dilihat.</p>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div class="card h-100 border-primary">
                                <div class="card-body">
                                    <h5 class="card-title">Cetak Data Siswa</h5>
                                    <p class="card-text">Akses data siswa dan gunakan fitur cetak pada halaman daftar siswa.</p>
                                    <a href="{{ route('admin.siswa.index') }}" class="btn btn-primary">Buka Data Siswa</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="card h-100 border-success">
                                <div class="card-body">
                                    <h5 class="card-title">Cetak Hasil Evaluasi</h5>
                                    <p class="card-text">Lihat dan cetak hasil evaluasi siswa dari halaman laporan evaluasi.</p>
                                    <a href="{{ route('admin.laporan.evaluasi') }}" class="btn btn-success">Lihat Laporan Evaluasi</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="card h-100 border-info">
                                <div class="card-body">
                                    <h5 class="card-title">Riwayat Kenaikan Tingkat</h5>
                                    <p class="card-text">Tampilkan riwayat kenaikan tingkat dan cetak dokumen riwayat.</p>
                                    <a href="{{ route('admin.laporan.riwayat') }}" class="btn btn-info">Buka Riwayat Tingkat</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Kembali ke Dashboard</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection