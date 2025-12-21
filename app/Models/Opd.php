<?php
// app\Models\Opd.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Opd extends Model
{
    use HasFactory;

    protected $table = 'opd';

    protected $primaryKey = 'kode';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'kode',
        'nama',
        'category_id', // 🔥 WAJIB
    ];

    // =====================
    // RELATIONS
    // =====================

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function services()
    {
        return $this->hasMany(Service::class, 'kode_opd', 'kode');
    }

    // (opsional, kalau memang ada)
    public function laporan()
    {
        return $this->hasMany(LaporanIkm::class, 'kode_opd', 'kode');
    }
}
