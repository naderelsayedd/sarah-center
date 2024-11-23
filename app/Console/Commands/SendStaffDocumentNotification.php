<?php
	
	namespace App\Console\Commands;
	
	use App\User;
	use App\SmStaff;
	use App\SmNotification;
	use Illuminate\Console\Command;
	use Illuminate\Support\Facades\Auth;
	use Illuminate\Support\Facades\Log;
	
	
	class SendStaffDocumentNotification extends Command
	{
		/**
			* The name and signature of the console command.
			*
			* @var string
		*/
		protected $signature = 'document_notification:reminder';
		
		/**
			* The console command description.
			*
			* @var string
		*/
		protected $description = 'Send reminder for staff to upload remaining document';
		
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
			
			$staff = SmStaff::withOutGlobalScope(ActiveStatusSchoolScope::class)
			->where('is_saas', 0)->where('active_status', 1)->get();
			if( $staff->count() > 0){
				foreach($staff as $key=>$val){
					if( $val->resume == ''){
						$smObj = SmNotification::where('user_id', $val->user_id)
						->where('message','Forget to upload resume.')
						->orderBy('id','DESC')
						->first();
						if(empty($smObj)){
							$notification1 = new SmNotification;
							$notification1->user_id = $val->user_id;
							//$notification1->role_id =  $val->role_id;
							$notification1->role_id = empty($val->role_id)?'5':$val->role_id; 
							$notification1->message =  'Forget to upload resume.';
							$notification1->url = 'view-staff/'.$val->id;
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
								$notification1->role_id = empty($val->role_id)?'5':$val->role_id; 
								$notification1->message =  'Forget to upload resume.';
								$notification1->url = 'view-staff/'.$val->id;
								$notification1->date = date('Y-m-d');
								$notification1->school_id = $val->school_id;
								$notification1->academic_id  = getAcademicId();
								$notification1->save();
							}
						}
					}
					
					if( $val->joining_letter == ''){
						$smObj2 = SmNotification::where('user_id', $val->user_id)
						->where('message','Forget to upload joining letter.')
						->orderBy('id','DESC')
						->first();
						if(empty($smObj2)){
							$notification2 = new SmNotification;
							$notification2->user_id = $val->user_id;
							$notification2->role_id = empty($val->role_id)?'5':$val->role_id; 
							$notification2->message = 'Forget to upload joining letter.';
							$notification2->url = 'view-staff/'.$val->id;
							$notification2->date = date('Y-m-d');
							$notification2->school_id = $val->school_id;
							$notification2->academic_id  = getAcademicId();
							$notification2->save();
						}
						else{
							if($smObj2->is_read == 0){
								$notification2 = new SmNotification;
								$notification2->user_id = $val->user_id;
								$notification2->role_id = empty($val->role_id)?'5':$val->role_id; 
								$notification2->message = 'Forget to upload joining letter.';
								$notification2->url = 'view-staff/'.$val->id;
								$notification2->date = date('Y-m-d');
								$notification2->school_id = $val->school_id;
								$notification2->academic_id  = getAcademicId();
								$notification2->save();
							}
						}
					}
					
					if( $val->other_document == ''){
						$smObj3 = SmNotification::where('user_id', $val->user_id)
						->where('message','Forget to upload other document.')
						->orderBy('id','DESC')
						->first();
						if(empty($smObj3)){
							$notification3 = new SmNotification;
							$notification3->user_id = $val->user_id;
							$notification3->role_id = empty($val->role_id)?'5':$val->role_id; 
							$notification3->message =  'Forget to upload other document.';
							$notification3->url = 'view-staff/'.$val->id;
							$notification3->date = date('Y-m-d');
							$notification3->school_id = $val->school_id;
							$notification3->academic_id  = getAcademicId();
							$notification3->save();
						}
						else{
							if($smObj3->is_read == 0){
								$notification3 = new SmNotification;
								$notification3->user_id = $val->user_id;
								$notification3->role_id = empty($val->role_id)?'5':$val->role_id; 
								$notification3->message =  'Forget to upload other document.';
								$notification3->url = 'view-staff/'.$val->id;
								$notification3->date = date('Y-m-d');
								$notification3->school_id = $val->school_id;
								$notification3->academic_id  = getAcademicId();
								$notification3->save();
							}
						}
					}
					
					if( $val->certificate == ''){
						$smObj4 = SmNotification::where('user_id', $val->user_id)
						->where('message','Forget to upload certificate document.')
						->orderBy('id','DESC')
						->first();
						if(empty($smObj4)){
							$notification4 = new SmNotification;
							$notification4->user_id = $val->user_id;
							$notification4->role_id = empty($val->role_id)?'5':$val->role_id; 
							$notification4->message =  'Forget to upload certificate document.';
							$notification4->url = 'view-staff/'.$val->id;
							$notification4->date = date('Y-m-d');
							$notification4->school_id = $val->school_id;
							$notification4->academic_id = getAcademicId();
							$notification4->save();
						}
						else{
							if($smObj4->is_read == 0){
								$notification4 = new SmNotification;
								$notification4->user_id = $val->user_id;
								$notification4->role_id = empty($val->role_id)?'5':$val->role_id; 
								$notification4->message =  'Forget to upload certificate document.';
								$notification4->url = 'view-staff/'.$val->id;
								$notification4->date = date('Y-m-d');
								$notification4->school_id = $val->school_id;
								$notification4->academic_id = getAcademicId();
								$notification4->save();
							}
						}
					}
					
					if( $val->specilized_certificate == ''){
						$smObj5 = SmNotification::where('user_id', $val->user_id)
						->where('message','Forget to upload specilized certificate.')
						->orderBy('id','DESC')
						->first();
						if(empty($smObj5)){
							$notification5 = new SmNotification;
							$notification5->user_id = $val->user_id;
							$notification5->role_id = empty($val->role_id)?'5':$val->role_id;  
							$notification5->message =  'Forget to upload specilized certificate.';
							$notification5->url = 'view-staff/'.$val->id;
							$notification5->date = date('Y-m-d');
							$notification5->school_id = $val->school_id;
							$notification4->academic_id = getAcademicId();
							$notification5->save();
						}
						else{
							if($smObj5->is_read == 0){
								$notification5 = new SmNotification;
								$notification5->user_id = $val->user_id;
								$notification5->role_id = empty($val->role_id)?'5':$val->role_id;  
								$notification5->message =  'Forget to upload specilized certificate.';
								$notification5->url = 'view-staff/'.$val->id;
								$notification5->date = date('Y-m-d');
								$notification5->school_id = $val->school_id;
								$notification4->academic_id = getAcademicId();
								$notification5->save();
							}
						}
					}
				}
			}
		}
	}
