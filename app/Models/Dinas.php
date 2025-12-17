<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Dinas extends Model
{
    protected $table = 'dinas';

    protected $fillable = [
        'kode', 'nama', 'category_id'
    ];

    public function services(): HasMany
    {
        return $this->hasMany(Service::class, 'opd_id');
    }
}