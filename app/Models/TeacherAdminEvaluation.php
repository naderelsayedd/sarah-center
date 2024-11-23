<?php

namespace App\Models;

use App\SmStaff;
use App\SmAssignSubject;
use App\Models\StudentRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TeacherAdminEvaluation extends Model
{
    use HasFactory;
    public function staff()
    {
        return $this->belongsTo(SmStaff::class, 'teacher_id', 'id')->withDefault();
    }
}
