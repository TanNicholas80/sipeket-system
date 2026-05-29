<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RekapNilaiHarian extends Model
{
    use HasFactory;

    protected $table = 'rekap_nilai_harian';

    protected $fillable = [
        'user_id',
        'siswa_id',
        'pelatih_id',
        'tingkat_id',
        'tahun_periode',
        'average',
        'status',
        'materi_count',
        'filled_count',
    ];
}
