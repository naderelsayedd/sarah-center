<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizQuestionOptions extends Model
{
    use HasFactory;
    protected $table = 'quiz_options';

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    public function questions()
    {
        return $this->hasOne(QuizQuestionAnswer::class);
    }
}
