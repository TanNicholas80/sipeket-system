@extends('layout.main')

@section('page_title', 'Evaluasi Kenaikan Tingkat')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Evaluasi Kenaikan Tingkat</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('pelatih.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Evaluasi Kenaikan Tingkat</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <p>Halaman evaluasi kenaikan tingkat untuk pelatih. Tambahkan fitur penilaian dan rekomendasi di sini.</p>
            </div>
        </div>
    </div>
</section>
@endsection
