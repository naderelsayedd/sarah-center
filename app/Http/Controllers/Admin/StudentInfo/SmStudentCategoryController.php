<?php

namespace App\Http\Controllers\Admin\StudentInfo;

use App\SmStudentCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Brian2694\Toastr\Facades\Toastr;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Admin\StudentInfo\SmStudentCategoryRequest;

class SmStudentCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('PM');
    }

    public function index(Request $request)
    {
        try {
            $student_types = SmStudentCategory::get();
            return view('backEnd.studentInformation.student_category', compact('student_types'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }
    public function store(SmStudentCategoryRequest $request)
    {

        try {
            $student_type = new SmStudentCategory();
            $student_type->category_name = $request->category;
            $student_type->description = $request->description;
			 $student_type->details = $request->details;
			 $student_type->main_category = $request->main_category;
            $student_type->school_id = Auth::user()->school_id;
            $student_type->academic_id = getAcademicId();
            $student_type->duration = implode(', ', $request->duration);
                // Get the uploaded file
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '.' . $extension;
                $destinationPath = public_path('public/uploads/student/document/');
                $file->move($destinationPath, $filename);
                $student_type->image = $destinationPath.$filename;
            }

            $student_type->save();
            Toastr::success('Operation successful', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }
	
	public function storepop(SmStudentCategoryRequest $request)
    {
        try {
            $student_type = new SmStudentCategory();
            $student_type->category_name = $request->category;
            $student_type->description = $request->description;
            $student_type->school_id = Auth::user()->school_id;
            $student_type->academic_id = getAcademicId();
            $student_type->save();
             echo json_encode(['id' => $student_type->id, 'class_name' =>$request->category]);
        } catch (\Exception $e) {
            echo json_encode(['error' => true, 'message' => $e->getMessage()]);
        }
    }

    public function edit(Request $request, $id)
    {
        try {
            $student_type = SmStudentCategory::find($id);
            $student_types = SmStudentCategory::get();
            return view('backEnd.studentInformation.student_category', compact('student_types', 'student_type'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }
    public function update(SmStudentCategoryRequest $request)
    {
        try {
            $student_type = SmStudentCategory::find($request->id);
            $student_type->category_name = $request->category;
            $student_type->description = $request->description;
			 $student_type->details = $request->details;
			$student_type->main_category = $request->main_category;
            $student_type->duration = implode(', ', $request->duration);
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '.' . $extension;
                $destinationPath = public_path('public/uploads/student/document/');
                $file->move($destinationPath, $filename);
                $student_type->image = $destinationPath.$filename;
            }
            $student_type->save();

            Toastr::success('Operation successful', 'Success');
            return redirect('student-category');
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function delete(Request $request, $id)
    {
        try {
            $tables = \App\tableList::getTableList('student_category_id', $id);
            try {
                if ($tables==null) {
                    SmStudentCategory::find($id)->delete();
                } else {
                    $msg = 'This data already used in  : ' . $tables . ' Please remove those data first';
                    Toastr::error($msg, 'Failed');
                    return redirect()->back();
                }
                Toastr::success('Operation successful', 'Success');
                return redirect()->back();
            } catch (\Illuminate\Database\QueryException $e) {
                $msg = 'This data already used in  : ' . $tables . ' Please remove those data first';
                Toastr::error($msg, 'Failed');
                return redirect()->back();
            } catch (\Exception $e) {
                Toastr::error('Operation Failed', 'Failed');
                return redirect()->back();
            }
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }


    public function getDuration(Request $request)
    {
        $categoryId = $request->input('category_id');
        $category = SmStudentCategory::find($categoryId);
        $duration = explode(',', $category->duration);
        return $duration;
    }
}
