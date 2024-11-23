<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InterviewSchedule extends Model
{
    protected $table = 'interview_schedules';

    protected $fillable = [
        'user_id',
        'interview_date',
        'interview_time',
        'comment',
        'admin_comment',
        'status',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}



 ?>