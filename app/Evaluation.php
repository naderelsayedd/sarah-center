<?php 
namespace App;

use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{

	protected $table = "evaluations";
    protected $fillable = [
        'teacher_id',
        'submitted_date',
        'rating',
        'evaluation',
    ];

    protected $casts = [
        'rating' => 'array',
        'evaluation' => 'array',
    ];
}



 ?>