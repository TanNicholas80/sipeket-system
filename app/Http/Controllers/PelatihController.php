<?php

namespace App\Http\Controllers;

use App\Models\MateriLatihan;
use App\Models\NilaiHarian;
use App\Models\Pendaftaran;
use App\Models\RekapNilaiHarian;
use App\Models\Tingkat;
use App\Models\TahunPeriode;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PelatihController extends Controller
{
    public function dashboard()
    {
        $totalSiswaAktif = User::where('role', 'siswa')->where('status', 'aktif')->count();
        $totalPendaftar = Pendaftaran::count();
        $pendaftarTerbaru = Pendaftaran::with('tingkat')->latest()->take(5)->get();

        return view('pelatih.dashboard', compact(
            'totalSiswaAktif',
            'totalPendaftar',
            'pendaftarTerbaru'
        ));
    }

    public function dataSiswa(Request $request)
    {
        $search = $request->query('search');
        $tingkat_id = $request->query('tingkat_id');
        $status = $request->query('status');

        $query = User::where('role', 'siswa')
            ->with(['siswaProfile.tingkat']);

        if ($search) {
            $query->where('name', 'like', "%{$search}%");
        }

        if ($tingkat_id) {
            $query->whereHas('siswaProfile', function ($q) use ($tingkat_id) {
                $q->where('tingkat_id', $tingkat_id);
            });
        }

        if ($status) {
            $query->where('status', $status);
        }

        $siswas = $query->get();
        $tingkats = Tingkat::all();

        return view('pelatih.data-siswa', compact('siswas', 'tingkats', 'search', 'tingkat_id', 'status'));
    }

    public function inputNilaiHarian(Request $request)
    {
        $tingkat_id = $request->query('tingkat_id');
        $tahun_periode_id = $request->query('tahun_periode_id');
        $materi_latihan_id = $request->query('materi_latihan_id');

        $tingkats = Tingkat::all();
        $tahunPeriodes = TahunPeriode::orderByDesc('is_default')->orderBy('periode')->get();
        $materiLatihans = collect();

        if ($tingkat_id) {
            $materiLatihans = MateriLatihan::where('tingkat_id', $tingkat_id)
                ->orderBy('nama')
                ->get();
        }

        $defaultTahunPeriode = TahunPeriode::where('is_default', true)->first();
        $selectedTahunPeriode = $tahun_periode_id ? TahunPeriode::find($tahun_periode_id) : $defaultTahunPeriode;
        $selectedMateriLatihan = $materi_latihan_id ? MateriLatihan::find($materi_latihan_id) : null;
        $selectedTahunPeriodeId = optional($selectedTahunPeriode)->id;
        $selectedMateriLatihanId = $selectedMateriLatihan ? $selectedMateriLatihan->id : null;
        $isApplied = !empty($tingkat_id) && !empty($tahun_periode_id) && !empty($materi_latihan_id) && $selectedTahunPeriode && $selectedMateriLatihan;
        $showRekap = !empty($tingkat_id) && $selectedTahunPeriode;

        $siswas = collect();
        $nilaiHarians = collect();
        $materiColumns = collect();
        $rekapNilai = collect();

        if ($tingkat_id) {
            $siswas = User::where('role', 'siswa')
                ->with(['siswaProfile.tingkat', 'nilaiHarian'])
                ->whereHas('siswaProfile', function ($q) use ($tingkat_id) {
                    $q->where('tingkat_id', $tingkat_id);
                })
                ->get();
        }

        if ($showRekap) {
            $nilaiHarians = NilaiHarian::with('user')
                ->whereIn('user_id', $siswas->pluck('id'))
                ->where('tingkat_id', $tingkat_id)
                ->where('tahun_periode', $selectedTahunPeriode->periode)
                ->get();

            $materiColumns = $nilaiHarians->pluck('materi_latihan')->unique()->sort()->values();

            $rekapNilai = $siswas->map(function ($siswa) use ($nilaiHarians, $materiColumns) {
                $nilaiPerMateri = [];

                foreach ($materiColumns as $materi) {
                    $nilai = $nilaiHarians->first(function ($record) use ($siswa, $materi) {
                        return $record->user_id === $siswa->id && $record->materi_latihan === $materi;
                    });

                    $nilaiPerMateri[$materi] = $nilai ? round((($nilai->wiraga ?? 0) + ($nilai->wirasa ?? 0) + ($nilai->wirama ?? 0)) / 3, 1) : null;
                }

                $availableNilai = array_filter($nilaiPerMateri, function ($value) {
                    return !is_null($value);
                });

                $average = count($availableNilai) > 0 ? round(array_sum($availableNilai) / count($availableNilai), 1) : null;
                $status = 'Belum Lengkap';

                if (count($availableNilai) === count($materiColumns) && count($materiColumns) > 0) {
                    $status = $average >= 75 ? 'Siap Evaluasi' : 'Belum Siap Evaluasi';
                }

                return [
                    'siswa' => $siswa,
                    'nilaiPerMateri' => $nilaiPerMateri,
                    'average' => $average,
                    'status' => $status,
                ];
            });
        }

        return view('pelatih.input-nilai-harian', compact(
            'tingkats',
            'tingkat_id',
            'selectedTahunPeriodeId',
            'selectedMateriLatihanId',
            'tahunPeriodes',
            'materiLatihans',
            'selectedTahunPeriode',
            'selectedMateriLatihan',
            'defaultTahunPeriode',
            'isApplied',
            'showRekap',
            'siswas',
            'nilaiHarians',
            'materiColumns',
            'rekapNilai'
        ));
    }

    public function storeNilaiHarian(Request $request)
    {
        $validated = $request->validate([
            'tingkat_id' => 'required|exists:tingkat,id',
            'tahun_periode_id' => 'required|exists:tahun_periode,id',
            'materi_latihan_id' => 'required|exists:materi_latihan,id',
            'wiraga' => 'required|array',
            'wirasa' => 'required|array',
            'wirama' => 'required|array',
        ]);

        $tingkat_id = $validated['tingkat_id'];
        $tahunPeriode = TahunPeriode::findOrFail($validated['tahun_periode_id']);
        $materiLatihan = MateriLatihan::findOrFail($validated['materi_latihan_id']);
        $wiraga = $validated['wiraga'];
        $wirasa = $validated['wirasa'];
        $wirama = $validated['wirama'];

        $pelatih_id = Auth::user()->pelatihProfile?->id;
        if (!$pelatih_id) {
            abort(403, 'Akses pelatih diperlukan untuk menyimpan data.');
        }

        foreach ($wiraga as $user_id => $nilai) {
            $siswa = User::with('siswaProfile')->find($user_id);
            if (!$siswa || !$siswa->siswaProfile) {
                continue;
            }

            $wiragaValue = floatval($nilai);
            $wirasaValue = floatval($wirasa[$user_id] ?? 0);
            $wiramaValue = floatval($wirama[$user_id] ?? 0);
            $averageValue = round(($wiragaValue + $wirasaValue + $wiramaValue) / 3, 2);

            NilaiHarian::updateOrCreate(
                [
                    'user_id' => $user_id,
                    'tingkat_id' => $tingkat_id,
                    'tahun_periode' => $tahunPeriode->periode,
                    'materi_latihan' => $materiLatihan->nama,
                ],
                [
                    'siswa_id' => $siswa->siswaProfile->id,
                    'pelatih_id' => $pelatih_id,
                    'wiraga' => $wiragaValue,
                    'wirasa' => $wirasaValue,
                    'wirama' => $wiramaValue,
                    'nilai' => $averageValue,
                    'tanggal' => now()->toDateString(),
                    'tahun_periode' => $tahunPeriode->periode,
                    'materi_latihan' => $materiLatihan->nama,
                ]
            );
        }

        $nilaiHarians = NilaiHarian::where('tingkat_id', $tingkat_id)
            ->where('tahun_periode', $tahunPeriode->periode)
            ->whereIn('user_id', array_keys($wiraga))
            ->get();

        $materiColumns = $nilaiHarians->pluck('materi_latihan')->unique()->values();

        foreach ($nilaiHarians->groupBy('user_id') as $user_id => $records) {
            $siswa = User::with('siswaProfile')->find($user_id);
            if (!$siswa || !$siswa->siswaProfile) {
                continue;
            }

            $nilaiPerMateri = [];
            foreach ($materiColumns as $materi) {
                $record = $records->firstWhere('materi_latihan', $materi);
                $nilaiPerMateri[$materi] = $record ? round((($record->wiraga ?? 0) + ($record->wirasa ?? 0) + ($record->wirama ?? 0)) / 3, 1) : null;
            }

            $filledCount = count(array_filter($nilaiPerMateri, function ($value) {
                return !is_null($value);
            }));
            $materiCount = $materiColumns->count();
            $average = $filledCount > 0 ? round(array_sum(array_filter($nilaiPerMateri, function ($value) {
                return !is_null($value);
            })) / $filledCount, 1) : null;
            $status = 'Belum Lengkap';

            if ($filledCount === $materiCount && $materiCount > 0) {
                $status = $average >= 75 ? 'Siap Evaluasi' : 'Belum Siap Evaluasi';
            }

            RekapNilaiHarian::updateOrCreate(
                [
                    'user_id' => $user_id,
                    'tingkat_id' => $tingkat_id,
                    'tahun_periode' => $tahunPeriode->periode,
                ],
                [
                    'siswa_id' => $siswa->siswaProfile->id,
                    'pelatih_id' => $pelatih_id,
                    'average' => $average,
                    'status' => $status,
                    'materi_count' => $materiCount,
                    'filled_count' => $filledCount,
                ]
            );
        }

        return redirect()->route('pelatih.input-nilai-harian', [
            'tingkat_id' => $tingkat_id,
            'tahun_periode_id' => $tahunPeriode->id,
            'materi_latihan_id' => $materiLatihan->id,
        ])->with('success', 'Nilai harian berhasil disimpan.');
    }

    public function inputNilaiUjian()
    {
        return view('pelatih.input-nilai-ujian');
    }

    public function evaluasiKenaikanTingkat()
    {
        return view('pelatih.evaluasi-kenaikan-tingkat');
    }

    public function showSiswa(User $siswa)
    {
        if ($siswa->role !== 'siswa') {
            abort(404);
        }

        $siswa->load(['pendaftaran.tingkat', 'siswaProfile.tingkat']);

        return view('pelatih.siswa.show', compact('siswa'));
    }
}

