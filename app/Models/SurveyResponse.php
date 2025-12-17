<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SurveyResponse extends Model
{
    protected $table = 'survey_responses'; // tambahkan ini biar jelas

    protected $fillable = [
        'nama','no_wa','gender','usia','pendidikan','pekerjaan',
        'kecamatan','kelurahan',
        'category_id','opd_id','service_id',
        'opd_kode','opd_nama','layanan_nama',
        'u1','u2','u3','u4','u5','u6','u7','u8','u9',
        'saran',
        'completed','nilai_ikm','approved_by_kepala','approved_at',
    ];

    protected $casts = [
        'u1' => 'integer','u2' => 'integer','u3' => 'integer',
        'u4' => 'integer','u5' => 'integer','u6' => 'integer',
        'u7' => 'integer','u8' => 'integer','u9' => 'integer',
        'completed' => 'boolean',
        'nilai_ikm' => 'decimal:2',
        'approved_by_kepala' => 'boolean',
        'approved_at' => 'datetime',
    ];

    public function dinas()
    {
        return $this->belongsTo(Dinas::class);
    }

    public function laporan()
    {
        return $this->belongsTo(LaporanIkm::class, 'opd_kode', 'opd_kode');
    }
}