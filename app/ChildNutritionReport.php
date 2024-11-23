<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChildNutritionReport extends Model
{
    use HasFactory;
    protected $table = 'child_nutrition_report';
    protected $fillable = ['meal', 'quantity', 'time', 'notes','student_id','date'];
}
