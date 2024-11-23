<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuizCategory extends Model
{
    protected $fillable = ['name', 'description'];

    public function quizzes()
    {
        return $this->hasMany(Quiz::class);
    }
}