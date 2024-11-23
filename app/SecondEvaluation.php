<?php 

namespace App;

use Illuminate\Database\Eloquent\Model;

class SecondEvaluation extends Model
{
    protected $table = 'second_evaluations';

    protected $fillable = [
        'teacher_id',
        'submitted_date',
        'cheerful',
        'child_handling',
        'active',
        'helpful',
        'neat_appearance',
        'hygiene',
        'diaper_changing',
        'child_observation',
        'personality_traits',
        'guiding_children',
        'calm_voice',
        'afe_discipline',
    ];
}


 ?>