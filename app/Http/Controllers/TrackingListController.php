<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\SmStaff;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use App\Traits\NotificationSend;
use Illuminate\Support\Facades\DB;
use App\ApiBaseMethod;
use App\SmStudent;
use Illuminate\Support\Facades\Auth;

class TrackingListController extends Controller
{
    use NotificationSend;
    public function index(Request $request)
    {
        try {
			$role_id = Auth::user()->role_id;

			$drivers = [];
			$driver_tracking_list = [];
			if($role_id == 1){
            	$drivers = SmStaff::where("active_status",1)->where("role_id" ,9)->get();
			}
			if($role_id == 9){
				$staff_id = Auth::user()->id;
				$driver_tracking_list = DB::table('sm_staff_driver_trakings')->where('driver_id', '=', $staff_id)->whereNotNull("address")->whereNotNull("address_end")->whereNotNull("traking_start")->whereNotNull("traking_end")->get();
			}
			if($role_id == 3){
				return redirect('driver-route-list/0/parent');
			}
            return view('backEnd.tracking.tracking_list', compact('role_id','drivers', 'driver_tracking_list'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function getDriverTrakingList(Request $request)
	{
		if($request->type == 'admin') {
			$driver_list = DB::table('sm_staff_driver_trakings')->where('driver_id', '=', $request->staff_id)->whereNotNull("address")->whereNotNull("address_end")->whereNotNull("traking_start")->whereNotNull("traking_end")->get();
		} else if($request->type == 'parent') {
			$driver_list = DB::table('sm_staff_driver_trakings')->where('driver_id', '=', $request->staff_id)->get();	
		} else if($request->type == 'driver') {
			$driver_list = DB::table('sm_staff_driver_trakings')->where('driver_id', '=', $request->staff_id)->get();
		}


		return response()->json($driver_list);
	}
		
	public function getDriverTrakingRouteList($track_id,$type)
	{
		try {
			$driver_track_list = [];
			if($type == 'admin' || $type == 'driver') {

				$driver_track_list = DB::table('sm_staff_driver_traking_routes')->where('track_id', '=', $track_id)->get();

				// $student_traking_list = DB::table('sm_staff_driver_student_traking_routes')->leftJoin("sm_students","sm_students.id","sm_staff_driver_student_traking_routes.student_id")->where('track_id', '=', $track_id)->select("sm_staff_driver_student_traking_routes.*","sm_students.full_name")->where("sm_staff_driver_student_traking_routes.student_id",">",0)->get();

				$query = DB::table('sm_staff_driver_student_traking_routes')->leftJoin("sm_students","sm_students.id","sm_staff_driver_student_traking_routes.student_id")->where('track_id', '=', $track_id)->select("sm_staff_driver_student_traking_routes.*","sm_students.full_name")->where("sm_staff_driver_student_traking_routes.student_id",">",0);
				$student_traking_cordinates = $query->get();
				$student_traking_list = $query->groupBy("sm_students.id")->get();


				/* if($request->student_id && $request->track_id) {
					$data['student_traking_list'] = DB::table('sm_staff_driver_student_traking_routes')->where('track_id', '=', $request->track_id)->where('student_id', '=', $request->student_id)->get();
				} else {
					$data['driver_list'] = DB::table('sm_staff_driver_traking_routes')->where('track_id', '=', $request->track_id)->get();
					$student_ids = str_replace('"','',$request->student_ids);
					$data['student_traking_list'] = DB::table('sm_staff_driver_student_traking_routes')->where('track_id', '=', $request->track_id)->whereIn('student_id', explode(',',$student_ids))->get();
					
					// $trakings->student_ids = $request->student_ids;
					$data['student'] = SmStudent::whereIn('id', explode(',',$student_ids))->get();
				} */
			}
			
			if($type == 'parent') {

				$parent_id = Auth::user()->id;
				$student = SmStudent::where('user_id', $parent_id)->first();

				$query = DB::table('sm_staff_driver_student_traking_routes')->leftJoin("sm_students","sm_students.id","sm_staff_driver_student_traking_routes.student_id")->where('student_id', '=', $student->id)->select("sm_staff_driver_student_traking_routes.*","sm_students.full_name")->where("sm_staff_driver_student_traking_routes.student_id",">",0);
				$student_traking_cordinates = $query->get();
				$student_traking_list = $query->groupBy("sm_students.id")->get();

			}
			

			/* echo "<pre>";
			print_r($student_traking_list);
			echo "<pre>";
			print_r($student_traking_cordinates);
			exit; */


			$coordinates = [];
			if(!empty($driver_track_list)){
				foreach($driver_track_list as $track){
					$coordinates[] = [ $track->latitute, $track->longitute];
				}
			}

			$student_coordinates = [];
			if(!empty($student_traking_cordinates)){
				foreach($student_traking_cordinates as $student_cordinate){
					$student_coordinates[$student_cordinate->student_id][] = [ $student_cordinate->student_latitute, $student_cordinate->student_longitute];
				}
			}

            return view('backEnd.tracking.student_list_with_map', compact('type','driver_track_list', 'coordinates', 'student_coordinates', 'student_traking_list'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
	}

	public function getStudentsTrakingRouteList(Request $request)
	{
		if($request->type == 'admin' || $request->type == 'driver') {
			$student_traking_list = DB::table('sm_staff_driver_student_traking_routes')->leftJoin("sm_students","sm_students.id","sm_staff_driver_student_traking_routes.student_id")->where('track_id', '=', $request->track_id)->select("sm_staff_driver_student_traking_routes.*","sm_students.full_name")->where("sm_staff_driver_student_traking_routes.student_id",">",0)->get();
			return 	$student_traking_list;
		}
		
		if($request->type == 'parent') {
			$student_traking_list = DB::table('sm_staff_driver_student_traking_routes')->leftJoin("sm_students","sm_students.id","sm_staff_driver_student_traking_routes.student_id")->where('track_id', '=', $request->track_id)->select("sm_staff_driver_student_traking_routes.*","sm_students.full_name")->whereNotNull("sm_staff_driver_student_traking_routes.student_id")->get();		
		}
		return response()->json($student_traking_list);
	}

}