<?php

namespace App\Console\Commands;

use App\User;
use App\SmStudent;
use App\SmNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class SendStudentDocumentNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'student_document_notification:reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send reminder for student to upload remaining document';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        //date_default_timezone_set(timeZone());

        $staff = SmStudent::withOutGlobalScope(ActiveStatusSchoolScope::class)
				->where('active_status', 1)->get();
		if( $staff->count() > 0){
			foreach($staff as $key=>$val){				
                if( $val->document_file_1 == ''){
					$smObj = SmNotification::where('user_id', $val->user_id)
							->where('message','Forget to upload document 1')
							->orderBy('id','DESC')
							->first();
					if(empty($smObj)){
						$notification1 = new SmNotification;
						$notification1->user_id = $val->user_id;
						//$notification1->role_id =  $val->role_id;
						$notification1->role_id = empty($val->role_id)?'2':$val->role_id; 
						$notification1->message =  'Forget to upload document 1';
						$notification1->url = 'student-view/'.$val->id;
						$notification1->date = date('Y-m-d');
						$notification1->school_id = $val->school_id;
						$notification1->academic_id  = getAcademicId();
						$notification1->save();
					}
					else{
						if($smObj->is_read == 0){
							$notification1 = new SmNotification;
							$notification1->user_id = $val->user_id;
							//$notification1->role_id =  $val->role_id;
							$notification1->role_id = empty($val->role_id)?'2':$val->role_id; 
							$notification1->message =  'Forget to upload document 1';
							$notification1->url = 'student-view/'.$val->id;
							$notification1->date = date('Y-m-d');
							$notification1->school_id = $val->school_id;
							$notification1->academic_id  = getAcademicId();
							$notification1->save();
						}
					}
					
				}
					
				if( $val->document_file_2 == ''){
					$smObj2 = SmNotification::where('user_id', $val->user_id)
					->where('message','Forget to upload document 2')
					->orderBy('id','DESC')
					->first();
					if(empty($smObj2)){
						$notification2 = new SmNotification;
						$notification2->user_id = $val->user_id;
						$notification2->role_id = empty($val->role_id)?'2':$val->role_id; 
						$notification2->message = 'Forget to upload document 2';
						$notification2->url = 'student-view/'.$val->id;
						$notification2->date = date('Y-m-d');
						$notification2->school_id = $val->school_id;
						$notification2->academic_id  = getAcademicId();
						$notification2->save();
					}
					else{
						if($smObj2->is_read == 0){
							$notification1 = new SmNotification;
							$notification1->user_id = $val->user_id;
							//$notification1->role_id =  $val->role_id;
							$notification1->role_id = empty($val->role_id)?'2':$val->role_id; 
							$notification1->message =  'Forget to upload document 1';
							$notification1->url = 'student-view/'.$val->id;
							$notification1->date = date('Y-m-d');
							$notification1->school_id = $val->school_id;
							$notification1->academic_id  = getAcademicId();
							$notification1->save();
						}
					}
				}
					
				if( $val->document_file_3 == ''){
					$smObj3 = SmNotification::where('user_id', $val->user_id)
					->where('message','Forget to upload document 3')
					->orderBy('id','DESC')
					->first();
					if(empty($smObj3)){
						$notification3 = new SmNotification;
						$notification3->user_id = $val->user_id;
						$notification3->role_id = empty($val->role_id)?'2':$val->role_id; 
						$notification3->message =  'Forget to upload document 3';
						$notification3->url = 'student-view/'.$val->id;
						$notification3->date = date('Y-m-d');
						$notification3->school_id = $val->school_id;
						$notification3->academic_id  = getAcademicId();
						$notification3->save();
					}
					else {
						if($smObj3->is_read == 0){
							$notification3 = new SmNotification;
							$notification3->user_id = $val->user_id;
							$notification3->role_id = empty($val->role_id)?'2':$val->role_id; 
							$notification3->message =  'Forget to upload document 3';
							$notification3->url = 'student-view/'.$val->id;
							$notification3->date = date('Y-m-d');
							$notification3->school_id = $val->school_id;
							$notification3->academic_id  = getAcademicId();
							$notification3->save();
						}
					}
				}
					
				if( $val->document_file_4 == ''){
					$smObj4 = SmNotification::where('user_id', $val->user_id)
					->where('message','Forget to upload document 4')
					->orderBy('id','DESC')
					->first();
					if(empty($smObj4)){
						$notification4 = new SmNotification;
						$notification4->user_id = $val->user_id;
						$notification4->role_id = empty($val->role_id)?'2':$val->role_id; 
						$notification4->message =  'Forget to upload document 4';
						$notification4->url = 'student-view/'.$val->id;
						$notification4->date = date('Y-m-d');
						$notification4->school_id = $val->school_id;
						$notification4->academic_id = getAcademicId();
						$notification4->save();
					}
					else{
						if($smObj4->is_read == 0){
							$notification4 = new SmNotification;
							$notification4->user_id = $val->user_id;
							$notification4->role_id = empty($val->role_id)?'2':$val->role_id; 
							$notification4->message =  'Forget to upload document 4';
							$notification4->url = 'student-view/'.$val->id;
							$notification4->date = date('Y-m-d');
							$notification4->school_id = $val->school_id;
							$notification4->academic_id = getAcademicId();
							$notification4->save();
						}
					}
				}
					
				
			}
		}
    }
}
