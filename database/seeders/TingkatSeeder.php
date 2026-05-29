<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tingkat;

class TingkatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Tingkat::insert([
            ['nama_tingkat' => 'Tingkat Pradasar', 'jenis_penilaian' => 'harian', 'kkm' => 75, 'urutan' => 1],
            ['nama_tingkat' => 'Tingkat Dasar 1.1', 'jenis_penilaian' => 'harian', 'kkm' => 75, 'urutan' => 2],
            ['nama_tingkat' => 'Tingkat Dasar 1.2', 'jenis_penilaian' => 'ujian', 'kkm' => 75, 'urutan' => 3],
            ['nama_tingkat' => 'Tingkat Dasar 2.1', 'jenis_penilaian' => 'harian', 'kkm' => 75, 'urutan' => 4],
            ['nama_tingkat' => 'Tingkat Dasar 2.2', 'jenis_penilaian' => 'ujian', 'kkm' => 75, 'urutan' => 5],
            ['nama_tingkat' => 'Tingkat Terampil', 'jenis_penilaian' => 'ujian', 'kkm' => 75, 'urutan' => 6],
            ['nama_tingkat' => 'Tingkat Lanjut', 'jenis_penilaian' => 'ujian', 'kkm' => 75, 'urutan' => 7],
        ]);
    }
}
