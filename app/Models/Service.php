<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Service extends Model
{
    protected $table = 'services';

    protected $fillable = [
        'opd_id', 'nama'
    ];

    public function dinas(): BelongsTo
    {
        return $this->belongsTo(Dinas::class, 'opd_id');
    }
}