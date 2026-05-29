@extends('layout.main')

@section('page_title', 'Input Nilai Ujian')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Input Nilai Ujian</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('pelatih.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Input Nilai Ujian</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <p>Halaman input nilai ujian untuk pelatih. Tambahkan formulir atau tabel nilai ujian di sini.</p>
            </div>
        </div>
    </div>
</section>
@endsection
