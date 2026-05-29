<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pendaftaran extends Model
{
    use HasFactory;

    protected $table = 'pendaftaran';

    protected $fillable = [
        'nama_lengkap',
        'email',
        'tanggal_lahir',
        'tempat_lahir',
        'jenis_kelamin',
        'nama_panggilan',
        'asal_sekolah',
        'kontak_aktif',
        'akta_kelahiran',
        'alamat',
        'tingkat_id',
        'nama_orangtua',
        'pekerjaan_orangtua',
        'kontak_orangtua',
        'alamat_orangtua',
        'tanggal_daftar',
        'status',
        'catatan_admin'
    ];

    public function tingkat()
    {
        return $this->belongsTo(Tingkat::class);
    }
}
