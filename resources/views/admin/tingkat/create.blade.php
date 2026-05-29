@extends('layout.main')

@section('title', 'Tambah Tingkat')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Tambah Tingkat</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.tingkat.index') }}">Data Tingkat</a></li>
                    <li class="breadcrumb-item active">Tambah</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Form Tambah Tingkat</h3>
                    </div>
                    <form action="{{ route('admin.tingkat.store') }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label for="nama_tingkat">Nama Tingkat</label>
                                <input type="text" class="form-control @error('nama_tingkat') is-invalid @enderror" id="nama_tingkat" name="nama_tingkat" value="{{ old('nama_tingkat') }}" placeholder="Masukkan nama tingkat" required>
                                @error('nama_tingkat')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="jenis_penilaian">Jenis Penilaian</label>
                                <select class="form-control @error('jenis_penilaian') is-invalid @enderror" id="jenis_penilaian" name="jenis_penilaian" required>
                                    <option value="">Pilih jenis penilaian</option>
                                    <option value="harian" {{ old('jenis_penilaian') == 'harian' ? 'selected' : '' }}>Harian</option>
                                    <option value="ujian" {{ old('jenis_penilaian') == 'ujian' ? 'selected' : '' }}>Ujian</option>
                                </select>
                                @error('jenis_penilaian')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="kkm">KKM (Kriteria Ketuntasan Minimal)</label>
                                <input type="number" class="form-control @error('kkm') is-invalid @enderror" id="kkm" name="kkm" value="{{ old('kkm', 75) }}" min="0" max="100" placeholder="Masukkan KKM" required>
                                @error('kkm')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="urutan">Urutan</label>
                                <input type="number" class="form-control @error('urutan') is-invalid @enderror" id="urutan" name="urutan" value="{{ old('urutan') }}" min="1" placeholder="Masukkan urutan" required>
                                @error('urutan')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{ route('admin.tingkat.index') }}" class="btn btn-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection