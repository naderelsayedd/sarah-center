<?php 
// app/Models/FourthEvaluation.php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FourthEvaluation extends Model
{
    protected $fillable = [
        'teacher_id',
        'question',
        'rating',
        'submitted_date',
    ];

    protected $dates = [
        'submitted_date',
        'created_at',
        'updated_at',
    ];

}

