<?php 
// app/Models/ThirdEvaluation.php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ThirdEvaluation extends Model
{
    protected $table = 'third_evaluation';

    protected $fillable = [
        'teacher_id',
        'submitted_date',
        'cheerful',
        'neat_appearance',
        'activeness',
        'helpful',
        'organized',
        'good_communication',
        'dealing_with_parents',
        'fast_typing',
        'attentive',
        'multitasking',
        'accounting_operations',
        'fast_data_entry',
        'onitoring_children_and_staff',
        'ecording_child_data',
        'contributing_to_management',
        'punctuality',
        'electing_good_images',
    ];

    protected $casts = [
        'cheerful' => 'integer',
        'submitted_date' => 'date',
        'neat_appearance' => 'integer',
        'activeness' => 'integer',
        'helpful' => 'integer',
        'organized' => 'integer',
        'good_communication' => 'integer',
        'dealing_with_parents' => 'integer',
        'fast_typing' => 'integer',
        'attentive' => 'integer',
        'multitasking' => 'integer',
        'accounting_operations' => 'integer',
        'fast_data_entry' => 'integer',
        'onitoring_children_and_staff' => 'integer',
        'ecording_child_data' => 'integer',
        'contributing_to_management' => 'integer',
        'punctuality' => 'integer',
        'electing_good_images' => 'integer',
    ];

}



 ?>