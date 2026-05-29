<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tingkat extends Model
{
    use HasFactory;

    protected $table = 'tingkat';

    protected $fillable = [
        'nama_tingkat',
        'jenis_penilaian',
        'kkm',
        'urutan',
    ];

    // =========================
    // RELASI
    // =========================

    public function siswa()
    {
        return $this->hasMany(Siswa::class);
    }

    public function evaluasi()
    {
        return $this->hasMany(EvaluasiTingkat::class);
    }

    public function materiLatihans()
    {
        return $this->hasMany(MateriLatihan::class);
    }
}