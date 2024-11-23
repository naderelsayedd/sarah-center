<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmCourse extends Model
{
    use HasFactory;

    public function courseCategory()
    {
        return $this->belongsTo('App\SmCourseCategory', 'category_id', 'id')->withDefault();
    }
	
	public function courseClass()
    {
        return $this->belongsTo('App\SmClass', 'class_id', 'id')->withDefault();
    }
	
	public function sectionClass()
    {
        return $this->belongsTo('App\SmStudentCategory', 'course_section', 'id')->withDefault();
    }
}
