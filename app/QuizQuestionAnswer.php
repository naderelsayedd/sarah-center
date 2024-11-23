<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizQuestionAnswer extends Model
{
    use HasFactory;
    protected $table = 'quiz_questions_answers';
    public function category()
    {
        return $this->belongsTo(QuizCategory::class);
    }

    public function options()
    {
        return $this->hasMany(QuizQuestionOptions::class,'question_id');
    }
}
