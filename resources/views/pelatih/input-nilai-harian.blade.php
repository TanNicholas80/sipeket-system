@extends('layout.main')

@section('page_title', 'Input Nilai Harian')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Input Nilai Harian</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('pelatih.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Input Nilai Harian</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">

        {{-- Statusbar --}}
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif

        {{-- Filter Card --}}
        <div class="card card-outline card-primary mb-3">
            <div class="card-body">
                <p class="text-muted mb-3" style="font-size: 13px;">Penilaian Berkala Selama Proses Latihan</p>
                <form method="GET" action="{{ route('pelatih.input-nilai-harian') }}">
                    <div class="row align-items-end">
                        <div class="col-md-3 mb-3">
                            <label for="tingkat_id">Tingkat</label>
                            <select class="form-control" id="tingkat_id" name="tingkat_id" required {{ $isApplied ? 'disabled' : '' }}>
                                <option value="">- Pilih Tingkat -</option>
                                @foreach($tingkats as $tingkat)
                                <option value="{{ $tingkat->id }}" {{ $tingkat_id == $tingkat->id ? 'selected' : '' }}>
                                    {{ $tingkat->nama_tingkat }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="tahun_periode_id">Tahun Periode</label>
                            <select class="form-control" id="tahun_periode_id" name="tahun_periode_id" {{ $isApplied ? 'disabled' : '' }}>
                                <option value="">- Pilih Tahun Periode -</option>
                                @foreach($tahunPeriodes as $periode)
                                <option value="{{ $periode->id }}" {{ $selectedTahunPeriodeId == $periode->id ? 'selected' : '' }}>
                                    {{ $periode->periode }}{{ $periode->is_default ? ' (Default)' : '' }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="materi_latihan_id">Materi Latihan</label>
                            <select class="form-control" id="materi_latihan_id" name="materi_latihan_id" {{ $isApplied ? 'disabled' : '' }}>
                                <option value="">- Pilih Materi Latihan -</option>
                                @foreach($materiLatihans as $materi)
                                <option value="{{ $materi->id }}" {{ $selectedMateriLatihanId == $materi->id ? 'selected' : '' }}>
                                    {{ $materi->nama }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2 mb-3">
                            <button type="submit" class="btn btn-primary btn-block" {{ $isApplied ? 'disabled' : '' }}>Terapkan</button>
                            <a href="{{ route('pelatih.input-nilai-harian') }}" class="btn btn-secondary btn-block mt-2">Reset</a>
                        </div>
                    </div>
                    @if($isApplied)
                    <div class="alert alert-success mt-2">
                        Pilihan tingkat, tahun periode, dan materi sudah diterapkan. Klik Reset untuk mengganti.
                    </div>
                    @elseif($tingkat_id)
                    <div class="alert alert-info mt-2">
                        Lengkapi pilihan tahun periode dan materi, lalu klik Terapkan untuk membuka form input.
                    </div>
                    @endif
                </form>
            </div>
        </div>

        {{-- Tabel Input Nilai Harian --}}
        @if($isApplied && count($siswas) > 0)
        <div class="card mb-3">
            <div class="card-body p-0">
                <form id="formNilaiHarian" action="{{ route('pelatih.nilai-harian.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="tingkat_id" value="{{ $tingkat_id }}">
                    <input type="hidden" name="tahun_periode_id" value="{{ $selectedTahunPeriodeId }}">
                    <input type="hidden" name="materi_latihan_id" value="{{ $selectedMateriLatihanId }}">
                    <table class="table table-bordered table-striped mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th>Nama Siswa</th>
                                <th>Wiraga</th>
                                <th>Wirasa</th>
                                <th>Wirama</th>
                                <th>Rata-Rata</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($siswas as $index => $siswa)
                            @php
                                $nilaiHarian = $nilaiHarians->where('user_id', $siswa->id)
                                    ->where('materi_latihan', optional($selectedMateriLatihan)->nama)
                                    ->first();
                                $wiraga = $nilaiHarian?->wiraga ?? 0;
                                $wirasa = $nilaiHarian?->wirasa ?? 0;
                                $wirama = $nilaiHarian?->wirama ?? 0;
                                $rata = ($wiraga + $wirasa + $wirama) / 3;
                            @endphp
                            <tr id="row-{{ $siswa->id }}">
                                <td>{{ $siswa->name }}</td>
                                <td class="nilai-cell">
                                    <span class="nilai-text">{{ $wiraga }}</span>
                                    <input type="number" class="form-control form-control-sm nilai-input d-none"
                                        name="wiraga[{{ $siswa->id }}]" value="{{ $wiraga }}" min="0" max="100">
                                </td>
                                <td class="nilai-cell">
                                    <span class="nilai-text">{{ $wirasa }}</span>
                                    <input type="number" class="form-control form-control-sm nilai-input d-none"
                                        name="wirasa[{{ $siswa->id }}]" value="{{ $wirasa }}" min="0" max="100">
                                </td>
                                <td class="nilai-cell">
                                    <span class="nilai-text">{{ $wirama }}</span>
                                    <input type="number" class="form-control form-control-sm nilai-input d-none"
                                        name="wirama[{{ $siswa->id }}]" value="{{ $wirama }}" min="0" max="100">
                                </td>
                                <td class="rata-rata">{{ number_format($rata, 1) }}</td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-warning btn-edit" data-row="{{ $siswa->id }}">Edit</button>
                                    <button type="button" class="btn btn-sm btn-success btn-save d-none" data-row="{{ $siswa->id }}">Simpan</button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-end p-2">
                        <button type="submit" class="btn btn-primary">Simpan Semua</button>
                    </div>
                </form>
            </div>
        </div>
        @elseif($isApplied && count($siswas) === 0)
        <div class="alert alert-info">
            Tidak ada siswa untuk tingkat yang dipilih.
        </div>
        @endif

        {{-- Tabel Rekap Nilai --}}
        <h5 class="mb-2">Rekap Nilai Harian</h5>
        <div class="card">
            <div class="card-body p-0">
                @if($showRekap && $materiColumns->count() > 0)
                <table class="table table-bordered table-striped mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th>Nama Siswa</th>
                            @foreach($materiColumns as $materi)
                            <th>{{ $materi }}</th>
                            @endforeach
                            <th>Rata-Rata</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rekapNilai as $row)
                        <tr>
                            <td>{{ $row['siswa']->name }}</td>
                            @foreach($materiColumns as $materi)
                            <td>
                                @if(!is_null($row['nilaiPerMateri'][$materi]))
                                    {{ number_format($row['nilaiPerMateri'][$materi], 1) }}
                                @else
                                    -
                                @endif
                            </td>
                            @endforeach
                            <td>
                                @if(!is_null($row['average']))
                                    {{ number_format($row['average'], 1) }}
                                @else
                                    -
                                @endif
                            </td>
                            <td>{{ $row['status'] }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @elseif($showRekap)
                <div class="p-3">
                    <p class="mb-0">Belum ada data rekap nilai harian untuk periode dan tingkat yang dipilih.</p>
                </div>
                @else
                <div class="p-3">
                    <p class="mb-0">Pilih tingkat dan tahun periode kemudian klik Terapkan untuk melihat rekap nilai.</p>
                </div>
                @endif
                <div class="d-flex justify-content-end p-2">
                    <button type="button" class="btn btn-primary" id="btnKirimNilai">Kirim Nilai Harian</button>
                </div>
            </div>
        </div>

    </div>
</section>
<div id="inputNilaiHarianData" data-is-applied="{{ $isApplied ? '1' : '0' }}" style="display:none"></div>

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const isApplied = document.getElementById('inputNilaiHarianData')?.dataset?.isApplied === '1';
        const filterForm = document.querySelector('form[action*="input-nilai-harian"]');

        if (filterForm && !isApplied) {
            ['tingkat_id', 'tahun_periode_id'].forEach(function (fieldId) {
                const select = filterForm.querySelector('#' + fieldId);
                if (select) {
                    select.addEventListener('change', function () {
                        filterForm.submit();
                    });
                }
            });
        }

        // Tombol Edit per baris
        document.querySelectorAll('.btn-edit').forEach(function(btn) {
            btn.addEventListener('click', function() {
                const row = this.dataset.row;
                const tr = document.getElementById('row-' + row);

                tr.querySelectorAll('.nilai-text').forEach(el => el.classList.add('d-none'));
                tr.querySelectorAll('.nilai-input').forEach(el => el.classList.remove('d-none'));

                tr.querySelector('.btn-edit').classList.add('d-none');
                tr.querySelector('.btn-save').classList.remove('d-none');
            });
        });

        // Tombol Simpan per baris (inline save)
        document.querySelectorAll('.btn-save').forEach(function(btn) {
            btn.addEventListener('click', function() {
                const row = this.dataset.row;
                const tr = document.getElementById('row-' + row);

                const inputs = tr.querySelectorAll('.nilai-input');
                let sum = 0;
                inputs.forEach(function(input) {
                    const val = parseFloat(input.value) || 0;
                    sum += val;
                    input.previousElementSibling.textContent = input.value;
                });

                const rata = (sum / inputs.length).toFixed(1);
                tr.querySelector('.rata-rata').textContent = rata;

                tr.querySelectorAll('.nilai-text').forEach(el => el.classList.remove('d-none'));
                tr.querySelectorAll('.nilai-input').forEach(el => el.classList.add('d-none'));

                tr.querySelector('.btn-edit').classList.remove('d-none');
                tr.querySelector('.btn-save').classList.add('d-none');
            });
        });
    });
</script>
@endsection
@endsection