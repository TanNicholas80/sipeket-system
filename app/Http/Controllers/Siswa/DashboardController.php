<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Siswa\Concerns\MapsSiswaEvaluasi;

class DashboardController extends Controller
{
    use MapsSiswaEvaluasi;

    public function index()
    {
        $user = $this->authSiswaUser();
        $siswa = $user->siswaProfile;

        $evaluasiRows = $this->evaluasiRowsForUser($user);
        $riwayatRows = $this->riwayatRowsForUser($user);

        $tingkatSaatIni = $siswa?->tingkat?->nama_tingkat ?? '-';
        $totalEvaluasi = $evaluasiRows->count();
        $totalRiwayat = $riwayatRows->count();
        $evaluasiTerakhir = $evaluasiRows->first();

        return view('siswa.dashboard', compact(
            'user',
            'tingkatSaatIni',
            'totalEvaluasi',
            'totalRiwayat',
            'evaluasiTerakhir',
        ));
    }

    public function profil()
    {
        $user = $this->authSiswaUser();
        $siswa = $user->siswaProfile;
        $tingkatSaatIni = $siswa?->tingkat?->nama_tingkat ?? '-';

        return view('siswa.profil', compact('user', 'siswa', 'tingkatSaatIni'));
    }

    public function evaluasi()
    {
        $user = $this->authSiswaUser();
        $evaluasiRows = $this->evaluasiRowsForUser($user);

        return view('siswa.evaluasi', compact('user', 'evaluasiRows'));
    }

    public function riwayat()
    {
        $user = $this->authSiswaUser();
        $riwayatRows = $this->riwayatRowsForUser($user);

        return view('siswa.riwayat', compact('user', 'riwayatRows'));
    }
}
