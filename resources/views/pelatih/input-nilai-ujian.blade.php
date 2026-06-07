@extends('layout.main')

@section('page_title', 'Input Nilai Ujian')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Input Nilai Ujian</h1>
                <p class="text-muted mb-0 mt-1" style="font-size: 13px;">
                    Penilaian Akhir Oleh Penguji
                    @if($selectedTahunPeriode)
                    — Tahun Ajaran {{ $selectedTahunPeriode->periode }}
                    @endif
                </p>
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

        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
        @endif
        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
        @endif

        <div class="card card-outline card-primary mb-3">
            <div class="card-body">
                <p class="text-muted mb-3" style="font-size: 13px;">Penilaian tingkat ujian dengan 3 penguji — satu penilaian per siswa per periode</p>
                @if($tingkats->isEmpty())
                <div class="alert alert-warning">
                    Belum ada data tingkat dengan jenis penilaian ujian. Hubungi admin untuk menambahkan tingkat.
                </div>
                @endif
                <form method="GET" action="{{ route('pelatih.input-nilai-ujian') }}" id="formFilterUjian">
                    <div class="row align-items-end">
                        <div class="col-md-4 mb-3">
                            <label for="tingkat_id">Tingkat</label>
                            <select class="form-control" id="tingkat_id" name="tingkat_id" required {{ ($isApplied || $tingkats->isEmpty()) ? 'disabled' : '' }}>
                                <option value="">- Pilih Tingkat -</option>
                                @foreach($tingkats as $tingkat)
                                <option value="{{ $tingkat->id }}" {{ (string) $tingkat_id === (string) $tingkat->id ? 'selected' : '' }}>
                                    {{ $tingkat->nama_tingkat }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="tahun_periode_id">Periode</label>
                            <select class="form-control" id="tahun_periode_id" name="tahun_periode_id" {{ $isApplied ? 'disabled' : '' }}>
                                <option value="">- Pilih Periode -</option>
                                @foreach($tahunPeriodes as $periode)
                                <option value="{{ $periode->id }}" {{ (string) $tahun_periode_id === (string) $periode->id ? 'selected' : '' }}>
                                    {{ $periode->periode }}{{ $periode->is_default ? ' (Default)' : '' }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        @if($canSelectSiswa)
                        <div class="col-md-4 mb-3">
                            <label for="user_id">Nama Siswa</label>
                            <select class="form-control" id="user_id" name="user_id" {{ $isApplied ? 'disabled' : '' }}>
                                <option value="">- Pilih Siswa -</option>
                                @foreach($siswas as $siswa)
                                <option value="{{ $siswa->id }}" {{ (string) $user_id === (string) $siswa->id ? 'selected' : '' }}>
                                    {{ $siswa->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        @endif
                        <div class="col-md-12 mb-3">
                            <button type="submit" class="btn btn-primary" {{ ($isApplied || $tingkats->isEmpty()) ? 'disabled' : '' }}>Terapkan</button>
                            <a href="{{ route('pelatih.input-nilai-ujian') }}" class="btn btn-secondary ml-2">Reset</a>
                        </div>
                    </div>
                    @if($isApplied)
                    <div class="alert alert-success mt-2 mb-0">
                        Filter diterapkan. Isi penilaian 3 penguji lalu klik Simpan.
                    </div>
                    @elseif($canSelectSiswa)
                    <div class="alert alert-info mt-2 mb-0">
                        Pilih nama siswa, lalu klik Terapkan. Siswa yang sudah ujian tidak ditampilkan kecuali evaluasi ulang.
                    </div>
                    @elseif($tingkat_id)
                    <div class="alert alert-info mt-2 mb-0">
                        Pilih periode terlebih dahulu.
                    </div>
                    @endif
                </form>
            </div>
        </div>

        @if($isApplied && $selectedUser)
        <form method="POST" action="{{ route('pelatih.nilai-ujian.store') }}">
            @csrf
            <input type="hidden" name="tingkat_id" value="{{ $tingkat_id }}">
            <input type="hidden" name="tahun_periode_id" value="{{ $tahun_periode_id }}">
            <input type="hidden" name="user_id" value="{{ $user_id }}">

            <p class="text-muted small mb-3">Skor wiraga, wirama, dan wirasa setiap penguji: <strong>0,00 – 100,00</strong> (maks. 2 desimal).</p>
            <div class="row">
                @for($n = 1; $n <= 3; $n++)
                <div class="col-md-4 mb-3">
                    <div class="card card-outline card-secondary h-100">
                        <div class="card-header">
                            <h3 class="card-title mb-0">Penilaian Penguji {{ $n }}</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label>Wiraga</label>
                                <input type="number" class="form-control penguji-input penilaian-score-input" name="penguji[{{ $n }}][wiraga]"
                                    data-penguji="{{ $n }}" min="0" max="100" step="0.01" inputmode="decimal"
                                    title="Nilai 0,00 – 100,00 (maks. 2 desimal)"
                                    value="{{ old('penguji.'.$n.'.wiraga', number_format((float) ($pengujiScores[$n]['wiraga'] ?? 0), 2, '.', '')) }}" required>
                            </div>
                            <div class="form-group">
                                <label>Wirama</label>
                                <input type="number" class="form-control penguji-input penilaian-score-input" name="penguji[{{ $n }}][wirama]"
                                    data-penguji="{{ $n }}" min="0" max="100" step="0.01" inputmode="decimal"
                                    title="Nilai 0,00 – 100,00 (maks. 2 desimal)"
                                    value="{{ old('penguji.'.$n.'.wirama', number_format((float) ($pengujiScores[$n]['wirama'] ?? 0), 2, '.', '')) }}" required>
                            </div>
                            <div class="form-group mb-0">
                                <label>Wirasa</label>
                                <input type="number" class="form-control penguji-input penilaian-score-input" name="penguji[{{ $n }}][wirasa]"
                                    data-penguji="{{ $n }}" min="0" max="100" step="0.01" inputmode="decimal"
                                    title="Nilai 0,00 – 100,00 (maks. 2 desimal)"
                                    value="{{ old('penguji.'.$n.'.wirasa', number_format((float) ($pengujiScores[$n]['wirasa'] ?? 0), 2, '.', '')) }}" required>
                            </div>
                            <p class="text-muted small mt-2 mb-0">
                                Rata-rata: <strong id="rataPenguji{{ $n }}">{{ number_format($pengujiScores[$n]['rata'] ?? 0, 2) }}</strong>
                            </p>
                        </div>
                    </div>
                </div>
                @endfor
            </div>

            <div class="card card-outline card-info mb-3">
                <div class="card-header">
                    <h3 class="card-title mb-0">Rekapitulasi Hasil Ujian</h3>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-3">
                            <p class="text-muted mb-1">Rata-rata Penguji 1</p>
                            <h4 id="rekapPenguji1">{{ number_format($pengujiScores[1]['rata'] ?? 0, 2) }}</h4>
                        </div>
                        <div class="col-md-3">
                            <p class="text-muted mb-1">Rata-rata Penguji 2</p>
                            <h4 id="rekapPenguji2">{{ number_format($pengujiScores[2]['rata'] ?? 0, 2) }}</h4>
                        </div>
                        <div class="col-md-3">
                            <p class="text-muted mb-1">Rata-rata Penguji 3</p>
                            <h4 id="rekapPenguji3">{{ number_format($pengujiScores[3]['rata'] ?? 0, 2) }}</h4>
                        </div>
                        <div class="col-md-3">
                            <p class="text-muted mb-1">Nilai Akhir Ujian</p>
                            <h4 class="text-primary" id="nilaiFixMateri">0.00</h4>
                            <small class="text-muted">Rata-rata ketiga penguji</small>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </form>
        @endif

        <h5 class="mb-2">Rekap Nilai Ujian</h5>
        <div class="card mb-3">
            <div class="card-body p-0">
                @if($showRekap && $rekapNilai->isNotEmpty())
                <table class="table table-bordered table-striped mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th>Nama Siswa</th>
                            <th>Nilai Akhir</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($rekapNilai as $row)
                        <tr>
                            <td>{{ $row['siswa']->name }}</td>
                            <td>
                                @if(!is_null($row['average']))
                                    {{ number_format($row['average'], 1) }}
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                @if($row['status'] === \App\Models\RekapNilaiUjian::STATUS_SIAP_EVALUASI)
                                <span class="badge badge-success">{{ $row['status'] }}</span>
                                @else
                                <span class="badge badge-secondary">{{ $row['status'] }}</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @elseif($showRekap)
                <div class="p-3">
                    <p class="mb-0">Belum ada data nilai ujian untuk tingkat dan periode ini.</p>
                </div>
                @else
                <div class="p-3">
                    <p class="mb-0">Pilih tingkat dan periode untuk melihat rekap.</p>
                </div>
                @endif
                <div class="p-3 border-top bg-light">
                    <p class="mb-0 text-muted small">
                        Siswa <strong>Siap Evaluasi</strong> otomatis muncul di
                        <a href="{{ route('pelatih.evaluasi-kenaikan-tingkat', ['jenis_penilaian' => 'ujian']) }}">Evaluasi Kenaikan Tingkat</a> (filter jenis ujian).
                        Siswa yang <strong>mengulang tingkat</strong> dapat dinilai ulang; setelah siap evaluasi, simpan evaluasi ulang di halaman tersebut.
                    </p>
                </div>
            </div>
        </div>

    </div>
</section>
@endsection

@section('scripts')
@include('pelatih.partials.penilaian-score-script')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        function hitungRata(w, r, s) {
            const clamp = window.SipeketPenilaian ? window.SipeketPenilaian.clamp : (v) => parseFloat(v) || 0;
            return (clamp(w) + clamp(r) + clamp(s)) / 3;
        }

        function updateRekapitulasi() {
            const ratas = [];
            for (let n = 1; n <= 3; n++) {
                const byName = (part) => {
                    const el = document.querySelector('[name="penguji[' + n + '][' + part + ']"]');
                    return el ? el.value : 0;
                };
                const w = byName('wiraga');
                const r = byName('wirama');
                const s = byName('wirasa');
                const rata = hitungRata(w, r, s);
                ratas.push(rata);
                const elRata = document.getElementById('rataPenguji' + n);
                const elRekap = document.getElementById('rekapPenguji' + n);
                if (elRata) elRata.textContent = rata.toFixed(2);
                if (elRekap) elRekap.textContent = rata.toFixed(2);
            }
            const nilaiFix = ratas.length === 3
                ? (ratas.reduce((a, b) => a + b, 0) / 3)
                : 0;
            const elFix = document.getElementById('nilaiFixMateri');
            if (elFix) elFix.textContent = nilaiFix.toFixed(2);
        }

        document.querySelectorAll('.penguji-input').forEach(function (input) {
            input.addEventListener('input', updateRekapitulasi);
        });
        updateRekapitulasi();

        const filterForm = document.getElementById('formFilterUjian');
        if (filterForm && !{{ $isApplied ? 'true' : 'false' }}) {
            ['tingkat_id', 'tahun_periode_id', 'user_id'].forEach(function (id) {
                const el = document.getElementById(id);
                if (el) {
                    el.addEventListener('change', function () {
                        if (id !== 'user_id' || el.value) {
                            filterForm.submit();
                        }
                    });
                }
            });
        }
    });
</script>
@endsection
