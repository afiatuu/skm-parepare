<?php
// app/Models/Service.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Service extends Model
{
    protected $table = 'services';

    protected $fillable = [
        'kode_opd',
        'nama'
    ];

    public function opd(): BelongsTo
    {
        return $this->belongsTo(Opd::class, 'kode_opd', 'kode');
    }  
}
