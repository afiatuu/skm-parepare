<?php

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
    ];

    // Relasi ke laporan IKM
    public function laporan()
    {
        return $this->hasMany(LaporanIkm::class, 'opd_kode', 'kode');
    }
}