<?php

namespace App\Http\Controllers\teacher;

use App\SmStaff;
use App\YearCheck;
use App\ApiBaseMethod;
use App\SmLeaveRequest;
use App\SmGeneralSettings;
use App\EventTimeTable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class EventTimeTableController extends Controller
{
    public function __construct()
	{
        $this->middleware('PM');
        // User::checkAuth();
	}

    public function addEventTimeTable(Request $request)
    {   
        $validator = Validator::make($request->all(), [
            'title'      => 'required',
            'start_time' => 'required',
            'end_time'   => 'required',
            'days'       => 'required',
			'date'       => 'required',
        ]);
        if ($validator->fails()) {
            Toastr::error($validator->errors()->first(), 'Failed');
            return redirect()->back();
        }else{
            try {
				$destination ='public/uploads/events/';
                $user_info = Auth::user();
				$request->date = date('Y-m-d');
                $eventDataUpdate = EventTimeTable::where([
                    'teacher_id' => $user_info->id,
                    'start_time' => $request->start_time,
                    'end_time'   => $request->end_time,
                    'day'        => $request->days,
					'date'        => $request->date,
                ])->delete();

                $eventData              = new EventTimeTable();
                $eventData->teacher_id  = $user_info->id;
                $eventData->title       = $request->title;
                $eventData->start_time  = $request->start_time;
                $eventData->end_time    = $request->end_time;
                $eventData->day         = $request->days;
				$eventData->date         = $request->date;
				$eventData->photo = fileUpload($request->photo,$destination);

                if ($eventData->save()) {
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
    }

}
