<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    protected $fillable = ['category_id', 'title', 'description', 'image_url'];

    public function getTotalQuestionTimeAttribute() {
        return $this->questions->sum('question_time');
    }

    public function category()
    {
        return $this->belongsTo(QuizCategory::class);
    }

    public function questions(){
        return $this->hasMany(QuizQuestionAnswer::class);
    }
}