<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TeacherEvaluation;
use App\Models\TeacherAdminEvaluation;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use App\Models\TeacherEvaluationSetting;
use App\SmTeacherQuestionnair;
use Illuminate\Support\Facades\Validator;

class TeacherEvaluationController extends Controller
{
    public function teacherEvaluationSetting()
    {
        $teacherEvaluationSetting = TeacherEvaluationSetting::where('id', 1)->first();
		
        return view('backEnd.teacherEvaluation.setting.teacherEvaluationSetting', compact('teacherEvaluationSetting'));
    }
	
	
	public function teacherEvaluationQuestionnair()
    {
	
		$teacherEvaluationQuestionnair = SmTeacherQuestionnair::where('id','>','0')->get();
		
        return view('backEnd.teacherEvaluation.teacherEvaluationQuestionnair', compact('teacherEvaluationQuestionnair'));
    }
	
    public function teacherEvaluationSettingUpdate(Request $request)
    {
        try {
            $teacherEvaluationSetting = TeacherEvaluationSetting::find(1);
            if ($request->type == 'evaluation') {
                $teacherEvaluationSetting->is_enable = $request->is_enable;
                $teacherEvaluationSetting->auto_approval = $request->auto_approval;
            }
            if ($request->type == 'submission') {
                $teacherEvaluationSetting->submitted_by = $request->submitted_by ? $request->submitted_by : $teacherEvaluationSetting->submitted_by;
                $teacherEvaluationSetting->rating_submission_time = $request->rating_submission_time;
                $teacherEvaluationSetting->from_date = date('Y-m-d', strtotime($request->startDate));
                $teacherEvaluationSetting->to_date = date('Y-m-d', strtotime($request->endDate));
            }
            $teacherEvaluationSetting->update();
            return redirect()->back();
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }
	
	public function savTeacherEvaluationQuestionnair(Request $request)
    { 
        try {
            $teacherQuestionnair = new SmTeacherQuestionnair();
            $teacherQuestionnair->question = $request->questionnaire_title;
            $teacherQuestionnair->status ='1';
            $teacherQuestionnair->school_id = Auth()->user()->school_id;
            $teacherQuestionnair->academic_id = getAcademicId();
			//echo "<pre>";print_r($teacherQuestionnair);die;
            $results = $teacherQuestionnair->save();

            if ($results) {
                Toastr::success('Eveluation questionnair added successfully', 'Success');
                return redirect()->back();
            } else {
                Toastr::error('Operation Failed', 'Failed');
                return redirect()->back();
            }
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function teacherEvaluationQuestion(Request $request)
    {
        try {

            $input = $request->question_id;
            $rating = $request->rating;
			$comment = $request->comment;
			$evaluation = $request->evaluation;
            
            foreach ($input as $key => $value) {
                $teacherEvaluationSetting = TeacherEvaluationSetting::find(1);
                $teacherEvaluation = new TeacherEvaluation();
                $teacherEvaluation->question_id = $value;
                $teacherEvaluation->rating = isset($rating[$key]) ? $rating[$key] : '';
                $teacherEvaluation->comment = isset($comment[$key]) ? $comment[$key] : '';
				 $teacherEvaluation->evaluation = isset($evaluation[$key]) ? $evaluation[$key] : '';
                $teacherEvaluation->record_id = $request->record_id;
                $teacherEvaluation->subject_id = "0";
                $teacherEvaluation->teacher_id = $request->teacher_id;
                $teacherEvaluation->student_id = $request->student_id;
                $teacherEvaluation->parent_id = $request->parent_id;
                $teacherEvaluation->role_id = Auth::user()->role_id;
                $teacherEvaluation->academic_id = getAcademicId();
                if ($teacherEvaluationSetting->auto_approval == 0) {
                    $teacherEvaluation->status = 1;
                }
                $teacherEvaluation->save();
            }

            Toastr::success('Operation Successful', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }
	
	public function teacherEvaluationQuestionAdmin(Request $request)
    {
        try {

            $input = $request->question_id;
            $rating = $request->rating;
			$comment = $request->comment;
			$evaluation = $request->evaluation;
            
            foreach ($input as $key => $value) {
                $teacherEvaluationSetting = TeacherEvaluationSetting::find(1);
                $teacherEvaluation = new TeacherAdminEvaluation();
                $teacherEvaluation->question_id = $value;
                $teacherEvaluation->rating = isset($rating[$key]) ? $rating[$key] : '';
                $teacherEvaluation->comment = isset($comment[$key]) ? $comment[$key] : '';
				$teacherEvaluation->evaluation = isset($evaluation[$key]) ? $evaluation[$key] : '';
                $teacherEvaluation->teacher_id = $request->teacher_id;
                $teacherEvaluation->role_id = Auth::user()->role_id;
				$teacherEvaluation->admin_id = Auth::user()->id;
                $teacherEvaluation->academic_id = getAcademicId();
                if ($teacherEvaluationSetting->auto_approval == 0) {
                    $teacherEvaluation->status = 1;
                }
                $teacherEvaluation->save();
            }

            Toastr::success('Operation Successful', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            Toastr::error($e-getMessage(), 'Failed');
            return redirect()->back();
        }
    }
	
    public function teacherEvaluationSubmit(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'rating' => "required",
            'comment' => "required",
        ]);
        if ($validator->fails()) {
            Toastr::error('Empty Submission', 'Failed');
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        try {
            $teacherEvaluationSetting = TeacherEvaluationSetting::find(1);
            $teacherEvaluation = new TeacherEvaluation();
            $teacherEvaluation->rating = $request->rating;
            $teacherEvaluation->comment = $request->comment;
            $teacherEvaluation->record_id = $request->record_id;
            $teacherEvaluation->subject_id = $request->subject_id;
            $teacherEvaluation->teacher_id = $request->teacher_id;
            $teacherEvaluation->student_id = $request->student_id;
            $teacherEvaluation->parent_id = $request->parent_id;
            $teacherEvaluation->role_id = Auth::user()->role_id;
            $teacherEvaluation->academic_id = getAcademicId();
            if ($teacherEvaluationSetting->auto_approval == 0) {
                $teacherEvaluation->status = 1;
            }
            $teacherEvaluation->save();
            Toastr::success('Operation Successful', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }
	
	public function teacherEvaluationQuestionnairUpdateShow(Request $request)
    {   
        try {
            $teacherEvaluationSetting = SmTeacherQuestionnair::find($request->id);
           
           return $teacherEvaluationSetting->question;
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }
	
	public function teacherEvaluationQuestionnairUpdateSubmit(Request $request)
    {  
        try {
			$input  = $request->all();			
            $teacherEvaluation = SmTeacherQuestionnair::find( $input['id']);
            $teacherEvaluation->question =  $input['questionnaire_title'];
            $teacherEvaluation->update();
			Toastr::success('Operation Successful', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }
	
	public function questionnairItemView(Request $request, $id)
    {
        try{
            $title = __('common.are_you_sure_to_detete_this_item');
            $url = route('delete-item',$id);            
            return view('backEnd.modal.delete', compact('id', 'title', 'url'));
        }catch (\Exception $e) {
           Toastr::error('Operation Failed', 'Failed');
           return redirect()->back();
        }
    }

    public function questionnairItem(Request $request, $id)
    { 
        try {
            SmTeacherQuestionnair::destroy($id);
            Toastr::success('Operation successful', 'Success');
            return redirect()->back();
           
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }
}
