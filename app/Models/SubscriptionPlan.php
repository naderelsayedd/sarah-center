<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\SmCourse;
use App\SmCourseCategory;
use App\SmStudentCategory;
class SubscriptionPlan extends Model
{
    protected $table = 'subscription_plans';

    protected $fillable = [
        'name',
        'description',
        'price',
        'duration',
    ];


    public function courseCategory()
    {
        return $this->belongsTo('App\SmCourseCategory', 'category_id', 'id')->withDefault();
    }
	
	public function sectionClass()
    {
        return $this->belongsTo('App\SmStudentCategory', 'course_section', 'id')->withDefault();
    }
}


?>