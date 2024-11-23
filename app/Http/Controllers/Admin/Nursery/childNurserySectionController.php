<?php

namespace App\Http\Controllers\Admin\Nursery;

use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use App\SmStudent;
use App\ChildCleaningReport;
use App\ChildNutritionReport;
use App\ChildSleepReport;
use App\ChildMedicationReport;
use Illuminate\Http\Request;
use PDF;
class childNurserySectionController extends Controller
{
    public function index()
    {   
        $reports = ChildCleaningReport::take(10)->orderBy('id','DESC')->get();
        $students = SmStudent::where('active_status', 1)->get();
        return view('backEnd.nursery.child_cleaning_report',compact('students','reports'));
    }

    public function saveReport(Request $request)
    {

        try {
            $obj = new ChildCleaningReport();
            $obj->student_id = $request->student_id;
            $obj->date = $request->date;
            $obj->hair = $request->hair;
            $obj->cloth = $request->cloth;
            $obj->body = $request->body;
            $obj->general_cleanliness_description = $request->general_cleanliness_description;
            $obj->showering = $request->showering;
            $obj->general_cleanliness_description_second = $request->general_cleanliness_description_second;
            $obj->diaper_status_first = $request->diaper_status_first;
            $obj->diaper_status_second = $request->diaper_status_second;
            $obj->diaper_status_third = $request->diaper_status_third;
            $obj->diaper_status_fourth = $request->diaper_status_fourth;
            $obj->other_notes = $request->other_notes;

            if ($obj->save()) {
                Toastr::success('Operation Successful', 'Success');
                return redirect()->back();
            }else{
                Toastr::error('Operation Failed', 'Failed');
                return redirect()->back();
            } 

        } catch (Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }

    }


    public function nutritionReport()
    {
        $nutrition_report = ChildNutritionReport::take(10)->orderBy('id','DESC')->get();
        $students = SmStudent::where('active_status',1)->get();
        return view('backEnd.nursery.child_nutrition_report',compact('students','nutrition_report'));
    }

    public function nutritionReportPost(Request $request)
    {
        
        try {
            $request->request->remove('_token');
            $student_id = $request->student_id;
            $date   = $request->date;
            
            for ($i=0; $i < sizeof($request->meal) ; $i++) {
                $obj    = new ChildNutritionReport(); 
                $obj->meal = $request->meal[$i];
                $obj->quantity = $request->quantity[$i];
                $obj->time = $request->time[$i];
                $obj->note = $request->notes[$i];
                $obj->date = $date;
                $obj->student_id = $student_id;
                $obj->save();
            }

            Toastr::success('Operation Successful', 'Success');
            return redirect()->back();

        } catch (Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }


    public function childSleepReport()
    {
        $reports = ChildSleepReport::take(10)->orderBy('id','DESC')->get();
        $students = SmStudent::where('active_status',1)->get();
        return view('backEnd.nursery.child_sleep_report',compact('students','reports'));
    }


    public function sleepReportPost(Request $request)
    {
        try {
            $request->request->remove('_token');
            $student_id = $request->student_id;
            $date   = $request->date;
            
            for ($i=0; $i < sizeof($request->sleep_from) ; $i++) {
                $obj    = new ChildSleepReport(); 
                $obj->sleep_from     = $request->sleep_from [$i];
                $obj->sleep_till = $request->sleep_till[$i];
                $obj->quality_of_sleep = $request->quality_of_sleep[$i];
                $obj->notes = $request->notes[$i];
                $obj->date = $date;
                $obj->student_id = $student_id;
                $obj->save();
            }

            Toastr::success('Operation Successful', 'Success');
            return redirect()->back();

        } catch (Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function medicationReport()
    {
        $reports = ChildMedicationReport::take(10)->orderBy('id','DESC')->get();
        $students = SmStudent::where('active_status',1)->get();
        return view('backEnd.nursery.child_medication_report',compact('students','reports'));
    }

    public function medicationReportPost(Request $request)
    {

        try {
            $request->request->remove('_token');
            $student_id = $request->student_id;
            $date   = $request->date;
            
            for ($i=0; $i < sizeof($request->medication_name) ; $i++) {
                $obj    = new ChildMedicationReport(); 
                $obj->medication_name     = $request->medication_name [$i];
                $obj->dosage = $request->dosage[$i];
                $obj->time = $request->time[$i];
                $obj->notes = $request->notes[$i];
                $obj->date = $date;
                $obj->student_id = $student_id;
                $obj->save();
            }

            Toastr::success('Operation Successful', 'Success');
            return redirect()->back();

        } catch (Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function getReport()
    {
        $students = SmStudent::where('active_status',1)->get();
        return view('backEnd.nursery.get_report',compact('students'));
    }

    public function postNurseryReport(Request $request)
    {
        try {
             $request->request->remove('_token');
             /*
                1 = child_medication_report
                2 = child_nutrition_report
                3 = child_cleaning_report
                4 = child_sleep_report
             */

            if ($request->report_type == 1) {
                $data = ChildMedicationReport::where(['student_id' => $request->student_id,'date' => $request->date])->get();
                return view('backEnd.nursery.reports.child_medication_report',compact('data'));
            } else if ($request->report_type == 2){
                $data = ChildNutritionReport::where(['student_id' => $request->student_id,'date' => $request->date])->get();
                return view('backEnd.nursery.reports.child_nutrition_report',compact('data'));
            } else if($request->report_type == 3){
                $data = ChildCleaningReport::where(['student_id' => $request->student_id,'date' => $request->date])->first();
                return view('backEnd.nursery.reports.child_cleaning_report',compact('data'));
            }else{
                $data = ChildSleepReport::where(['student_id' => $request->student_id,'date' => $request->date])->get();
                return view('backEnd.nursery.reports.child_sleep_report',compact('data'));
            }


        } catch (Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function downloadChildCleaningReport($id)
    {
        $data = ChildCleaningReport::find($id);
        $pdf = PDF::loadView('backEnd.nursery.reports.child_cleaning_report_pdf', compact('data'));
        return $pdf->download('child_cleaning_report.pdf');
    }

    public function downloadChildMedicationReport($id,$date)
    {
       $data = ChildMedicationReport::where(['student_id' => $id,'date' => $date])->get();
       $pdf = PDF::loadView('backEnd.nursery.reports.child_medication_report_pdf', compact('data'));
        return $pdf->download('child_medication_report.pdf');
    }

    public function downloadChildNutritionReport($id,$date)
    {
        $data = ChildNutritionReport::where(['student_id' => $id,'date' => $date])->get();
       $pdf = PDF::loadView('backEnd.nursery.reports.child_nutrition_report_pdf', compact('data'));
        return $pdf->download('child_nutrition_report.pdf');
    }

    public function downloadChildSleepReport($id,$date)
    {
        $data = ChildSleepReport::where(['student_id' => $id,'date' => $date])->get();
        $pdf = PDF::loadView('backEnd.nursery.reports.child_sleep_report_pdf', compact('data'));
        return $pdf->download('child_sleep_report.pdf');
    }

    

}