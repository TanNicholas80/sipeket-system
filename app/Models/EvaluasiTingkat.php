<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EvaluasiTingkat extends Model
{
    use HasFactory;

    protected $table = 'evaluasi_tingkat';

    protected $fillable = [
        'siswa_id',
        'tingkat_id',
        'rata_rata_nilai',
        'status',
        'keputusan_manual',
        'pelatih_id',
        'tanggal_evaluasi',
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function tingkat()
    {
        return $this->belongsTo(Tingkat::class);
    }

    public function pelatih()
    {
        return $this->belongsTo(Pelatih::class);
    }
}