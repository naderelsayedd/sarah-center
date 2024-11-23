<?php

namespace App\Http\Controllers\Admin\SystemSettings;

use App\User;
use App\SmNotification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\SmAcademicYear;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use App\Models\SmNotificationSetting;

class SmNotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('PM');
    }

    public function index()
    {
        try {
            $notificationSettings = SmNotificationSetting::where('school_id', auth()->user()->school_id)->get();
            return view('backEnd.notification_setting.notification_setting', compact('notificationSettings'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function notificationEventModal($id, $key)
    {
        try {
            $eventModal = SmNotificationSetting::find($id);
            $data = [];
            $data['id'] = $id;
            $data['key'] = $key;
            $data['shortcode'] = $eventModal->shortcode[$key];
            $data['subject'] = $eventModal->subject[$key];
            $data['emailBody'] = $eventModal->template[$key]['Email'];
            $data['smsBody'] = $eventModal->template[$key]['SMS'];
            $data['appBody'] = $eventModal->template[$key]['App'];
            $data['webBody'] = $eventModal->template[$key]['Web'];

            return view('backEnd.notification_setting.notification_setting_modal', $data);
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function notificationSettingsUpdate(Request $request)
    {
        try {
            $id = $request->id;
            $settings = SmNotificationSetting::where('id', $id)
                ->where('school_id', auth()->user()->school_id)
                ->firstOrFail();

            if ($request->type == 'destination') {
                $destinations = $settings->destination;
                if (array_key_exists($request->destination, $destinations)) {
                    $destinations[$request->destination] = (int)$request->status;
                }
                $settings->destination = $destinations;
                $settings->save();
            }
            if ($request->type == 'recipient-status') {
                $recipients = $settings->recipient;
                if (array_key_exists($request->recipient, $recipients)) {
                    $recipients[$request->recipient] = (int)$request->status;
                }
                $settings->recipient = $recipients;
                $settings->save();
            }
            if ($request->type == 'recipient') {
                $subjects = $settings->subject;
                if (array_key_exists($request->key, $subjects)) {
                    $subjects[$request->key] = $request->subject;
                }
                $templates = $settings->template;
                if (array_key_exists($request->key, $templates)) {
                    $templates[$request->key]['Email'] = $request->email_body;
                    $templates[$request->key]['SMS'] = $request->sms_body;
                    $templates[$request->key]['Web'] = $request->web_body;
                    $templates[$request->key]['App'] = $request->app_body;
                }
                $settings->subject = $subjects;
                $settings->template = $templates;
                $settings->save();
            }
            return response()->json();
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function insertdata()
    {
        $datas = SmNotificationSetting::all();
        foreach ($datas as $data) {
            $data->delete();
        }
       
    }
	
	public function sendNotificationWhenParentReachedWeb(Request $request) {
			
			
			if($request->type == 'pick') {
				$custommessage = ' has reached to school for pick-up his childs. Please Call Student ';
			}
			if($request->type == 'drop') {
				$custommessage = ' has leaving from school with his childs. Student has been Arrieved ';
			}
			$getParentData = DB::table('sm_parents')->select('sm_parents.user_id as parent_user_id')->where('sm_parents.id', trim($request->id))->first();
			if(empty($getParentData)) {
				$getParentData = DB::table('sm_parents')->select('sm_parents.user_id as parent_user_id')->where('sm_parents.user_id', trim($request->id))->first();
			}
			
			if(empty($getParentData)) {
				return 'Parent Not Exist';
			}
			
			$parents = User::where('id', '=', $getParentData->parent_user_id)->select('id', 'full_name','email','device_token','device_id')->first();
			$admins = User::where('role_id', '=', 5)->select('id', 'full_name','email','device_token','device_id')->get();
			if(!empty($admins)) {
				foreach($admins as $adminValue) {
					if($adminValue->device_id) {
						$body['title'] = 'Parent '.$parents->full_name.$custommessage;
						$body['type'] = 'admin';
						$body['message'] = 'Parent '.$parents->full_name.$custommessage.' at '.date('Y-m-d H:i:s');
						$title = 'Parent '.$parents->full_name.$custommessage;
						$device_id = $adminValue->device_token;
						$response = PushNotification('Android',true,$device_id,$title,$body);
					}
					
					$notification = new SmNotification;
					$notification->user_id = $adminValue->id;
					$notification->role_id = 5;
					$notification->school_id = auth()->user()->school_id;
					$notification->academic_id = SmAcademicYear::SINGLE_SCHOOL_API_ACADEMIC_YEAR();
					$notification->date = date('Y-m-d');
					$notification->message = 'Parent '.$parents->full_name.$custommessage.' at '.date('Y-m-d H:i:s');
					$notification->save();
				}
				
					$notification = new SmNotification;
					$notification->user_id = 1;
					$notification->role_id = 1;
					$notification->school_id = auth()->user()->school_id;
					$notification->academic_id = SmAcademicYear::SINGLE_SCHOOL_API_ACADEMIC_YEAR();
					$notification->date = date('Y-m-d');
					$notification->message = 'Parent '.$parents->full_name.$custommessage.' at '.date('Y-m-d H:i:s');
					$notification->save();
			}
			return 'Parent '.$parents->full_name.$custommessage.' at '.date('Y-m-d H:i:s');
			
		}
}
