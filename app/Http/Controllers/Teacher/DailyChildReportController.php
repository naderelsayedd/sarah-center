<?php 
namespace App\Http\Controllers\teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\SmStudent;
use App\StudentDailyReport;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Brian2694\Toastr\Facades\Toastr;
use PDF;

class DailyChildReportController extends Controller
{   
    public function store(Request $request)
    {

        $request->request->remove('_token');

        $validator = Validator::make($request->all(),[
            'student_id' => 'required|exists:sm_students,id',
            'mood' => 'required',
            'mood_notes' => 'required',
            'bathroom' => 'required',
            'sleep_from' => 'required',
            'sleep_to' => 'required',
            'feeding_time' =>'required',
            'feeding_type' =>'required',
            'feeding_quantity' =>'required',
            'breakfast_time' =>'required',
            'breakfast_type' =>'required',
            'breakfast_quantity' =>'required',
            'snack_time' =>'required',
            'snack_type' =>'required',
            'snack_quantity' =>'required',
            'lunch_time' =>'required',
            'lunch_type' =>'required',
            'lunch_quantity' =>'required',
        ]);

        if ($validator->fails()) {
            Toastr::error('Validation Error','Failed');
            return redirect()->back();
        } else {
            $studentDailyReport                 = new StudentDailyReport();
            $studentDailyReport->student_id     = $request->student_id;
            $studentDailyReport->data           = json_encode($request->all());
            $studentDailyReport->teacher_id     = Auth::id();
            if ($studentDailyReport->save()) {
                Toastr::success('Operation Success','Success');
                return redirect()->route('dailyChildReport.view');
            }else{
                Toastr::error('Operation Fails','Failed');
                return redirect()->route('dailyChildReport.index');
            }
        }

        
    }

    public function index()
    {
        // Get the currently logged-in teacher's ID
        $teacherId = Auth::id();

        // Fetch all class IDs assigned to the logged-in teacher
        $classIds = DB::table('sm_class_teachers')
                      ->where('teacher_id', 31)
                      ->pluck('assign_class_teacher_id')
                      ->toArray();

        $students = SmStudent::whereIn('class_id',$classIds)->get();
        return view('backEnd.teacher.dailyReport.dailyStudentReport', compact('students'));
    }

    public function edit(StudentDailyReport $StudentdailyReport)
    {
        $students = SmStudent::all();
        return view('dailyChildReport.edit', compact('StudentdailyReport', 'students'));
    }

    public function destroy($id)
    {
        StudentdailyReport::where('id',$id)->delete();
        Toastr::success('Operation Success','Success');
        return redirect()->route('dailyChildReport.view');
    }


    public function view($value='')
    {
        $studentDailyReport = StudentDailyReport::all();
        return view('backEnd.teacher.dailyReport.index', compact('studentDailyReport'));
    }


    public function downloadPDF($id)
    {

        
        $report_data = StudentDailyReport::where('id',$id)->pluck('data')->first();
        $report_data = json_decode($report_data);
        // echo "<pre>";
        // print_r($report_data);die;
        $student_data = SmStudent::where('id',$report_data->student_id)->first();
        $data = ['title' => 'Student Report'];
        $pdf = PDF::loadView('backEnd.teacher.dailyReport.PDF', ['report_data'=>$report_data,'student_data'=>$student_data]);
        
        return $pdf->download('Student Daily Report.pdf');
    }
}
