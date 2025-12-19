<?php
// app\Models\SurveyQuestion.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SurveyQuestion extends Model
{
    protected $table = 'survey_questions';

    protected $fillable = [
        'unsur',        // 1..9
        'kode',         // U1, U2, dst (opsional)
        'pertanyaan',   // teks pertanyaan
        'is_active',    // boolean
        'urutan',       // integer untuk sorting
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}