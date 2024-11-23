<?php

namespace App\Http\Controllers\Admin\FrontSettings;

use App\SmCourse;
use App\SmClass;
use App\SmCourseCategory;
use App\SmStudentCategory;
use App\SmGeneralSettings;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use App\Http\Requests\Admin\FrontSettings\SmCourseListRequest;

class SmCourseListController extends Controller
{
    public function __construct()
	{
        $this->middleware('PM');
	}
    public function index()
    {
        try{
            $course = SmCourse::where('school_id', app('school')->id)->get();
            $categories = SmCourseCategory::where('school_id', app('school')->id)->get();
			$courseSection = SmStudentCategory::where('school_id', app('school')->id)->get();
			$classes = SmClass::where('school_id', app('school')->id)->get();
            return view('backEnd.frontSettings.course.course_page', compact('course','categories','classes','courseSection'));
        }catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function store(SmCourseListRequest $request)
    {
       
        try {
            $destination = 'public/uploads/course/';
            $image = fileUpload($request->image,$destination);

            $course = new SmCourse();
            $course->title = $request->title;
            $course->image = $image;
            $course->category_id = $request->category_id;
			$course->class_id = 24;
            $course->overview = $request->overview;
			$course->course_section = $request->course_section;
            $course->outline = $request->outline;
            $course->prerequisites = $request->prerequisites;
            $course->resources = $request->resources;
            $course->stats = $request->stats;
            $course->school_id = app('school')->id;
            $result = $course->save();
        
                Toastr::success('Operation successful', 'Success');
                return redirect()->back();
           
        } catch (\Exception $e) {
             ;
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function edit($id)
    {
        try {

            if ($id == 1) {
                Toastr::error('Can not edit default course.', 'Failed');
                return redirect()->back();
            }

            $categories = SmCourseCategory::where('school_id', app('school')->id)->get();
            $course = SmCourse::where('school_id', app('school')->id)->get();
            $add_course = SmCourse::find($id);
			$classes = SmClass::where('school_id', app('school')->id)->get();
			$courseSection = SmStudentCategory::where('school_id', app('school')->id)->get();
            return view('backEnd.frontSettings.course.course_page', compact('categories','course', 'add_course','classes','courseSection'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function update(SmCourseListRequest $request)
    {
        
        try {
            $destination = 'public/uploads/course/';
          
            $course = SmCourse::find($request->id);
            $course->title = $request->title;
            
			
            $course->image = fileUpdate($course->image,$request->image,$destination);
            
            $course->category_id = $request->category_id;
			$course->class_id = 24;
            $course->overview = $request->overview;
            $course->outline = $request->outline;
			$course->course_section = $request->course_section;
            $course->prerequisites = $request->prerequisites;
            $course->resources = $request->resources;
            $course->stats = $request->stats;
            $course->school_id = app('school')->id;
            $result = $course->save();
          
            Toastr::success('Operation successful', 'Success');
            return redirect()->route('course-list');
           
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function destroy($id)
    {
        try {

            if ($id == 1) {
                Toastr::error('Can not delete default course.', 'Failed');
                return redirect()->back();
            }


            SmCourse::destroy($id);       
            Toastr::success('Operation successful', 'Success');
            return redirect()->back();
            
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }
    
    public function destroyLms($id)
    {
        try {
            \Modules\Lms\Entities\Course::destroy($id);
            if (moduleStatusCheck('OnlineExam')) {
                \Modules\OnlineExam\Entities\InfixOnlineExam::where('course_id', $id)->delete();
                \Modules\OnlineExam\Entities\InfixQuestionBank::where('course_id', $id)->delete();
            }
            Toastr::success('Operation successful', 'Success');
            return redirect()->back();
            
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function forDeleteCourse($id)
    {
        try {
            return view('backEnd.frontSettings.course.delete_modal', compact('id'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function courseDetails($id)
    {
        try {
             $course = SmCourse::find($id);
            return view('backEnd.frontSettings.course.course_details', compact('course'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }
	
	public function getSubCategories(Request $request)
    {
        try {
            $studentCategores = SmStudentCategory::where('main_category', $request->main_category)->where('school_id', app('school')->id)->get();
			$html = '<option value="">Select Section</option>';
            foreach($studentCategores as $category) {
				if($request->selected_category && $request->selected_category == $category->id) {
					$html .= '<option value="'.$category->id.'" selected>'.$category->category_name.'</option>';
				} else {
					$html .= '<option value="'.$category->id.'">'.$category->category_name.'</option>';
				}
			}
			return $html ;
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }
}
