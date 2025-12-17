<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanIkm extends Model
{
    use HasFactory;

    protected $table = 'laporan_ikm';

    protected $fillable = [
        'opd_kode',
        'opd_nama',
        'judul',
        'ringkasan',
        'nilai_ikm',
        'status',
        'approved_by_kepala',
        'approved_at',
        'created_by',
    ];

    protected $casts = [
        'approved_by_kepala' => 'boolean',
        'approved_at' => 'datetime',
    ];

    // Relasi ke user (Admin penyusun)
    public function admin()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Relasi ke responden survei (SurveyResponse)
    public function responden()
    {
        return $this->hasMany(SurveyResponse::class, 'opd_kode', 'opd_kode');
    }

    // Relasi ke OPD
    public function opd()
    {
        return $this->belongsTo(Opd::class, 'opd_kode', 'kode');
    }
}