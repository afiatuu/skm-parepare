<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanIkmArsip extends Model
{
    use HasFactory;

    protected $table = 'laporan_ikm_arsip';

    // Kolom yang bisa diisi saat create/update
    protected $fillable = [
        'opd_kode',
        'nilai_ikm',
        'total_responden',
        'detail_gender',
        'detail_usia',
        'detail_pendidikan',
        'detail_pekerjaan',
        'detail_unsur',
        'mutu',
        'published_at',
    ];

    // Casting JSON ke array otomatis
    protected $casts = [
        'detail_gender'     => 'array',
        'detail_usia'       => 'array',
        'detail_pendidikan' => 'array',
        'detail_pekerjaan'  => 'array',
        'detail_unsur'      => 'array',
        'published_at'      => 'datetime',
    ];
}