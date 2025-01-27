<?php

namespace App\View\Components;

use App\SmCourse;
use Closure;
use App\Models\SubscriptionPlan;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\SmStudentCategory;

class Course extends Component
{
    public $count;
    public $column;
    public $sorting;
    /**
     * Create a new component instance.
     */
    public function __construct($count = 3, $column = 4, $sorting = 'asc')
    {
        $this->count = $count;
        $this->column = $column;
        $this->sorting = $sorting;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
         $courses = SmCourse::query();
         $courses->where('school_id', app('school')->id)->with('courseCategory');
         if($this->sorting =='asc'){
            $courses->orderBy('id','asc');
         }
         elseif($this->sorting =='desc'){
            $courses->orderBy('id','desc');
         }
         else{
            $courses->inRandomOrder();
         }
        $courses = $courses->take($this->count)->get();

        $course_category = SmStudentCategory::where('main_category','<=',2)->orderBy('id','DESC')->with('mainCategory')->get();
        // echo "<pre>"; print_r($course_category);die;
        return view('components.'.activeTheme().'.course', compact('courses','course_category'));
    }
}
