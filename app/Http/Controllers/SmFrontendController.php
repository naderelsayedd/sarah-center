<?php
	
	namespace App\Http\Controllers;
	
	use App\User;
	use App\SmExam;
	use App\SmParent;
	use App\SmNews;
	use App\SmPage;
	use App\SmClass;
	use App\SmEvent;
	use App\SmStaff;
	use App\SmCourse;
	use App\SmClassSection;
	use App\SmSchool;
	use App\SmSection;
	use App\SmStudent;
	use App\SmSubject;
	use App\SmWeekend;
	use App\YearCheck;
	use App\SmExamType;
	use App\SmNewsPage;
	use App\SmAboutPage;
	use App\SmCoursePage;
	use App\SmMarksGrade;
	use App\ApiBaseMethod;
	use App\SmContactPage;
	use App\SmExamSetting;
	use App\SmNoticeBoard;
	use App\SmResultStore;
	use App\SmTestimonial;
	use App\SmExamSchedule;
	use App\SmNewsCategory;
	use App\SmAssignSubject;
	use App\SmMarksRegister;
	use App\SmContactMessage;
	use App\SmCourseCategory;
	use App\SmGeneralSettings;
	use App\SmStudentCategory;
	use App\SmHomePageSetting;
	use App\SmSocialMediaIcon;
	use App\SmBackgroundSetting;
	use App\SmHeaderMenuManager;
	use Illuminate\Http\Request;
	use App\Models\StudentRecord;
	use App\SmClassRoutineUpdate;
	use App\SmFrontendPersmission;
	use App\SmClassOptionalSubject;
	use App\Models\SubscriptionPlan;
	use App\Models\UserSubscriptionPlan;
	use App\SmOptionalSubjectAssign;
	use App\Models\FrontendExamResult;
	use Illuminate\Support\Facades\DB;
	use Illuminate\Support\Facades\Log;
	use Brian2694\Toastr\Facades\Toastr;
	use Illuminate\Support\Facades\Auth;
	use Illuminate\Support\Facades\Hash;
	use Illuminate\Support\Facades\Crypt;
	use App\Models\SmClassExamRoutinePage;
	use Larabuild\Pagebuilder\Models\Page;
	use Illuminate\Support\Facades\Redirect;
	use Modules\Saas\Entities\SmPackagePlan;
	use Illuminate\Support\Facades\Validator;
	use Modules\RolePermission\Entities\InfixPermissionAssign;
	use App\Http\Requests\Admin\FrontSettings\ExamResultSearch;
	use Larabuild\Pagebuilder\Http\Controllers\PageBuilderController;
	use Illuminate\Support\Str;
	use App\SmNotification;
	
	class SmFrontendController extends Controller
	{
		
		public function __construct()
		{
			$this->middleware('PM');
			// User::checkAuth();
		}
			
		public function index()
		{
			try {
				if(activeTheme()){
					$home_page = Page::where('school_id',app('school')->id)->where('home_page',1)->first();
					if($home_page){
						$page = $home_page;
						}else{
						$page = Page::where('school_id',app('school')->id)->first();
					}
					return view('frontEnd.landing.index');
				}
				$setting = SmGeneralSettings::where('school_id', app('school')->id)->first();
				$permisions = SmFrontendPersmission::where('parent_id', 1)->where('is_published', 1)->get();
				$per = [];
				foreach ($permisions as $permision) {
					$per[$permision->name] = 1;
				}
				
				$data = [
                'setting' => $setting,
                'per' => $per,
				];
				
				$home_data = [
                'exams' => SmExam::where('school_id', app('school')->id)->get(),
                'news' => SmNews::where('school_id', app('school')->id)->orderBy('order', 'asc')->limit(3)->get(),
                'testimonial' => SmTestimonial::where('school_id', app('school')->id)->get(),
                'academics' => SmCourse::where('school_id', app('school')->id)->orderBy('id', 'asc')->limit(3)->get(),
                'exam_types' => SmExamType::where('school_id', app('school')->id)->get(),
                'events' => SmEvent::where('school_id', app('school')->id)->get(),
                'notice_board' => SmNoticeBoard::where('school_id', app('school')->id)->where('is_published', 1)->orderBy('created_at', 'DESC')->take(3)->get(),
                'classes' => SmClass::where('school_id', app('school')->id)->where('active_status', 1)->get(),
                'subjects' => SmSubject::where('school_id', app('school')->id)->where('active_status', 1)->get(),
                'section' => SmSection::where('school_id', app('school')->id)->where('active_status', 1)->get(),
                'homePage' => SmHomePageSetting::where('school_id', app('school')->id)->first(),
				];
				
				$url = explode('/', $setting->website_url);
				
				if ($setting->website_btn == 0) {
					if (auth()->check()) {
						return redirect('dashboard');
					}
					return redirect('login');
					} else {
					
					if ($setting->website_url == '') {
						return view('frontEnd.home.light_home')->with(array_merge($data, $home_data));
						} elseif ($url[max(array_keys($url))] == 'home') {
						
						
						return view('frontEnd.home.light_home')->with(array_merge($data, $home_data));
						} else if (rtrim($setting->website_url, '/') == url()->current()) {
						return view('frontEnd.home.light_home')->with(array_merge($data, $home_data));
						} else {
						$url = $setting->website_url;
						return Redirect::to($url);
					}
				}
				} catch (\Exception $e) {
				Toastr::error('Operation Failed', 'Failed');
				return redirect()->back();
			}
		}
		
		public function about()
		{
			try {
				$exams = SmExam::where('school_id', app('school')->id)->get();
				$exams_types = SmExamType::where('school_id', app('school')->id)->get();
				$classes = SmClass::where('active_status', 1)->where('school_id', app('school')->id)->get();
				$subjects = SmSubject::where('active_status', 1)->where('school_id', app('school')->id)->get();
				$sections = SmSection::where('active_status', 1)->where('school_id', app('school')->id)->get();
				$about = SmAboutPage::where('school_id', app('school')->id)->first();
				$testimonial = SmTestimonial::where('school_id', app('school')->id)->get();
				$totalStudents = SmStudent::where('active_status', 1)->where('school_id', app('school')->id)->get();
				$totalTeachers = SmStaff::where('active_status', 1)
                ->where(function ($q) {
                    $q->where('role_id', 4)->orWhere('previous_role_id', 4);
				})->where('school_id', app('school')->id)->get();
				$history = SmNews::with('category')->histories()->limit(3)->where('school_id', app('school')->id)->get();
				$mission = SmNews::with('category')->missions()->limit(3)->where('school_id', app('school')->id)->get();
				
				return view('frontEnd.home.light_about', compact('exams', 'classes', 'subjects', 'exams_types', 'sections', 'about', 'testimonial', 'totalStudents', 'totalTeachers', 'history', 'mission'));
				} catch (\Exception $e) {
				Toastr::error('Operation Failed', 'Failed');
				return redirect()->back();
			}
		}
		
		public function news()
		{
			try {
				$exams = SmExam::where('school_id', app('school')->id)->get();
				$exams_types = SmExamType::where('school_id', app('school')->id)->get();
				$classes = SmClass::where('school_id', app('school')->id)->where('active_status', 1)->get();
				$subjects = SmSubject::where('school_id', app('school')->id)->where('active_status', 1)->get();
				$sections = SmSection::where('school_id', app('school')->id)->where('active_status', 1)->get();
				return view('frontEnd.home.light_news', compact('exams', 'classes', 'subjects', 'exams_types', 'sections'));
				} catch (\Exception $e) {
				Toastr::error('Operation Failed', 'Failed');
				return redirect()->back();
			}
		}
		
		
		
		public function contact()
		{
			try {
				$exams = SmExam::where('school_id', app('school')->id)->get();
				$exams_types = SmExamType::where('school_id', app('school')->id)->get();
				$classes = SmClass::where('school_id', app('school')->id)->where('active_status', 1)->get();
				$subjects = SmSubject::where('school_id', app('school')->id)->where('active_status', 1)->get();
				$sections = SmSection::where('school_id', app('school')->id)->where('active_status', 1)->get();
				
				$contact_info = SmContactPage::where('school_id', app('school')->id)->first();
				return view('frontEnd.home.light_contact', compact('exams', 'classes', 'subjects', 'exams_types', 'sections', 'contact_info'));
				} catch (\Exception $e) {
				Toastr::error('Operation Failed', 'Failed');
				return redirect()->back();
			}
		}
		
		public function institutionPrivacyPolicy()
		{
			try {
				$exams = SmExam::where('school_id', app('school')->id)->get();
				$exams_types = SmExamType::where('school_id', app('school')->id)->get();
				$classes = SmClass::where('school_id', app('school')->id)->where('active_status', 1)->get();
				$subjects = SmSubject::where('school_id', app('school')->id)->where('active_status', 1)->get();
				$sections = SmSection::where('school_id', app('school')->id)->where('active_status', 1)->get();
				
				$contact_info = SmContactPage::where('school_id', app('school')->id)->first();
				return view('frontEnd.home.institutionPrivacyPolicy', compact('exams', 'classes', 'subjects', 'exams_types', 'sections', 'contact_info'));
				} catch (\Exception $e) {
				Toastr::error('Operation Failed', 'Failed');
				return redirect()->back();
			}
		}
		
		public function developerTool($purpose)
		{
			if ($purpose == 'debug_true') {
				envu([
                'APP_ENV' => 'local',
                'APP_DEBUG' => 'true',
				]);
				} elseif ($purpose == 'debug_false') {
				envu([
                'APP_ENV' => 'production',
                'APP_DEBUG' => 'false',
				]);
				} elseif ($purpose == "sync_true") {
				envu([
                'APP_SYNC' => 'true',
				]);
				} elseif ($purpose == "sync_false") {
				envu([
                'APP_SYNC' => 'false',
				]);
			}
		}
		
		public function institutionTermServices()
		{
			try {
				$exams = SmExam::where('school_id', app('school')->id)->get();
				$exams_types = SmExamType::where('school_id', app('school')->id)->get();
				$classes = SmClass::where('school_id', app('school')->id)->where('active_status', 1)->get();
				$subjects = SmSubject::where('school_id', app('school')->id)->where('active_status', 1)->get();
				$sections = SmSection::where('school_id', app('school')->id)->where('active_status', 1)->get();
				
				$contact_info = SmContactPage::where('school_id', app('school')->id)->first();
				return view('frontEnd.home.institutionTermServices', compact('exams', 'classes', 'subjects', 'exams_types', 'sections', 'contact_info'));
				} catch (\Exception $e) {
				Toastr::error('Operation Failed', 'Failed');
				return redirect()->back();
			}
		}
		
		public function newsDetails($id)
		{
			$news = SmNews::where('school_id', app('school')->id)->findOrFail($id);
			$otherNews = SmNews::where('school_id', app('school')->id)->orderBy('id', 'asc')->whereNotIn('id', [$id])->limit(3)->get();
			$notice_board = SmNoticeBoard::where('school_id', app('school')->id)->where('is_published', 1)->orderBy('created_at', 'DESC')->take(3)->get();
			
			return view('frontEnd.home.light_news_details', compact('news', 'notice_board', 'otherNews'));
		}
		
		public function newsPage()
		{
			try {
				$news = SmNews::where('school_id', app('school')->id)->paginate(8);
				$newsPage = SmNewsPage::where('school_id', app('school')->id)->first();
				return view('frontEnd.home.light_news', compact('news', 'newsPage'));
				} catch (\Exception $e) {
				Toastr::error('Operation Failed', 'Failed');
				return redirect()->back();
			}
		}
		
		public function loadMorenews(Request $request)
		{
			try {
				$count = SmNews::count();
				$skip = $request->skip;
				$limit = $count - $skip;
				$due_news = SmNews::skip($skip)->where('school_id', app('school')->id)->take(4)->get();
				return view('frontEnd.home.loadMoreNews', compact('due_news', 'skip', 'count'));
				} catch (\Exception $e) {
				return response('error');
			}
		}
		
		public function sendMessage(Request $request)
		{
			$request->validate([
            'name' => 'required',
            'email' => 'required',
            'subject' => 'required',
            'message' => 'required',
			]);
			try {
				$contact_message = new SmContactMessage();
				$contact_message->name = $request->name;
				$contact_message->email = $request->email;
				$contact_message->subject = $request->subject;
				$contact_message->message = $request->message;
				$contact_message->school_id = app('school')->id;
				$contact_message->save();
				
				$receiver_name = "System Admin";
				$compact['contact_name'] = $request->name;
				$compact['contact_email'] = $request->email;
				$compact['subject'] = $request->subject;
				$compact['contact_message'] = $request->message;
				$contact_page_email = SmContactPage::where('school_id', app('school')->id)->first();
				$setting = SmGeneralSettings::where('school_id', app('school')->id)->first();
				if ($contact_page_email->email) {
					$email = $contact_page_email->email;
					} else {
					$email = $setting->email;
				}
				@send_mail($email, $receiver_name, "frontend_contact", $compact);
				return response()->json(['success' => 'success']);
				} catch (\Exception $e) {
				return response()->json('error');
			}
		}
		
		public function contactMessage(Request $request)
		{
			try {
				$contact_messages = SmContactMessage::where('school_id', app('school')->id)->orderBy('id', 'desc')->get();
				$module_links = InfixPermissionAssign::where('role_id', Auth::user()->role_id)->where('school_id', Auth::user()->school_id)->pluck('module_id')->toArray();
				return view('frontEnd.contact_message', compact('contact_messages', 'module_links'));
				} catch (\Exception $e) {
				Toastr::error('Operation Failed', 'Failed');
				return redirect()->back();
			}
		}
		
		//user register method start
		public function register(Request $request)
		{				
			try {
					$login_background = SmBackgroundSetting::where([['is_default', 1], ['title', 'Login Background']])->first();
					$subscription_id = Crypt::decrypt($request->subscription_id);
    				$course_id = Crypt::decrypt($request->course_id);
					if (empty($login_background)) {
						$css = "";
						} else {
						if (!empty($login_background->image)) {
							$css = "background: url('" . url($login_background->image) . "')  no-repeat center;  background-size: cover;";
							} else {
							$css = "background:" . $login_background->color;
						}
					}

					if (!isset($request->class_id)) {
						$class_id = 24;
					}


					$SmStudent = SmStudent::where('active_status', 1)->get();
					$schools = SmSchool::where('active_status', 1)->get();
					$classes = SmClass::where('school_id', app('school')->id)->where('id',$class_id)->where('active_status', 1)->first();
					$classSection = SmClassSection::where('school_id', app('school')->id)->where('class_id',24)->first();
					$sections = SmSection::where('school_id', app('school')->id)->where('active_status', 1)->get();
					$setting = SmGeneralSettings::where('school_id', app('school')->id)->first();
					$course = SmCourse::where('school_id', app('school')->id)->where('id',$course_id)->with('sectionClass')->first();
					if(count($SmStudent) > 0) {
					$studentLastId = SmStudent::all()->last()->id + 1;
					} else {
					$studentLastId = 1;
					}
					$subscriptionPlans = SubscriptionPlan::where('id',$subscription_id)->with('courseCategory')->first();
					return view('auth.registerCodeCanyon', compact('schools','classes','sections','setting','studentLastId','class_id','course_id','course','classSection', 'css','subscriptionPlans'));
				} catch (\Exception $e) {
					echo $e->getMessage();die;
					Toastr::error($e->getMessage(), 'Failed');
					return redirect()->back();
			}
		}
		
		public function customer_register(Request $request)
		{


			$request->validate([
			'fathers_name' => 'required|min:3|max:100',
			'guardians_email' => 'required|email|unique:users,email',
			'fathers_password' => 'required|min:6',
			'student_category' => 'required',
            'fathers_password_confirmation' => 'required_with:fathers_password|same:fathers_password|min:6',
			]);
			
			try {
				
				if(empty($request->term_and_conditions)) {
					return redirect()->back()->with('message-danger', "Terms and Conditions required");
				}
				
				$emailParentEmailCheck = User::select('*')->where('email', $request->guardians_email)->first();
				if (!empty($emailParentEmailCheck)) {
					return redirect()->back()->with('message-danger', "Parent Email Already Exist, Please try an other email id again");
				}
				
				
				
				if(!empty($request->fathers_phone)) {
					$emailChildPhoneCheck = User::select('*')->where('phone_number', $request->fathers_phone)->first();
					if (!empty($emailChildPhoneCheck)) {
						return redirect()->back()->with('message-danger', "Father Phone Number Already Exist, Please try an other phone id again");
					}
				}
				
				
				$random = Str::random(32);
				/* insert data into user table for Parent */
				$user_parent = new User();
				$user_parent->role_id = 3;
				$user_parent->username = !empty($request->phone_number[0]) ? $request->phone_number[0] : $request->fathers_phone;
				$user_parent->full_name = $request->fathers_name;
				$user_parent->email = $request->guardians_email;
				$user_parent->phone_number = $request->fathers_phone;
				$user_parent->active_status = 1;
				$user_parent->access_status = 1;
				$user_parent->email_verify = 0;
				$user_parent->is_approved = 0;
				$user_parent->random_code = $random;
				$user_parent->password = Hash::make($request->fathers_password);
				$user_parent->language = 'ar';
				$user_parent->term_and_conditions = $request->term_and_conditions;
				$user_parent->school_id = app('school')->id;
				$user_parent->created_at = date('Y-m-d') . ' 12:00:00';
				$user_parent->save();
				$user_parent->toArray();
				$parentLastId = $user_parent->id;
				
				$parent = new SmParent();
				$parent->user_id = $parentLastId;
				$parent->fathers_name = $request->fathers_name;
				$parent->fathers_mobile = $request->fathers_phone;
				$parent->mothers_name = '';
				$parent->mothers_mobile = '';
				$parent->guardians_name = '';
				$parent->guardians_mobile = '';
				$parent->guardians_email = $request->guardians_email;
				$parent->guardians_relation = 'Father';
				$parent->active_status = 1;
				$parent->relation = 'F';
				$parent->school_id = app('school')->id;
				$parent->academic_id = 1;
				$parent->created_at = date('Y-m-d') . ' 12:00:00';
				$parent->save();
				$parent->toArray();
				$hasParent = $parent->id;
				
				foreach($request->first_name as $key => $studentData) {
					$childRandamNumber = rand(999999,9999999999999);
					$s = new User();
					$s->role_id = 2;
					$s->full_name = $studentData;
					$s->username = $childRandamNumber;
					$s->email = $key.$request->guardians_email;
					$s->active_status = 1;
					$s->email_verify = 1;
					$s->access_status = 1;
					$s->phone_number = '';
					$s->password = Hash::make($request->fathers_password);
					$s->language = 'ar';
					$s->term_and_conditions = $request->term_and_conditions;
					$s->school_id = app('school')->id;
					$s->created_at = date('Y-m-d') . ' 12:00:00';
					$s->save();
					$result = $s->toArray();
					$last_id = $s->id;
					
					
					$student = new SmStudent();
					$student->user_id = $last_id;
					$student->parent_id = $hasParent;
					$student->role_id = 2;
					$student->admission_no = $request->admission_number;
					$student->first_name = $studentData;
					$student->last_name = '';
					$student->full_name = $studentData;
					$student->gender_id = $request->gender[$key];
					$student->email = $key.$request->guardians_email;
					$student->mobile = $request->phone_number[$key];
					$student->school_id = app('school')->id;
					$student->category_duration = $request->duration[$key];
					$student->student_category_id = $request->student_category;
					$student->registered_by = $request->registered_by;
					$student->academic_id = 1;
					$student->active_status = 1;
					$student->created_at = date('Y-m-d') . ' 12:00:00';
					$student->save();
					$studentLast = $student->id;
					
					$studentRecord = new StudentRecord;
					$studentRecord->student_id = $studentLast;
					$studentRecord->is_default = 1;
					$studentRecord->class_id = $request->class_id;
					$studentRecord->course_id = $request->course_id;
					$studentRecord->section_id = $request->section_id;
					$studentRecord->session_id = 1;
					$studentRecord->active_status = 1;
					$studentRecord->school_id = app('school')->id;
					$studentRecord->academic_id = 1;
					$studentRecord->created_at = date('Y-m-d') . ' 12:00:00';
					$studentRecord->save();	
				}
				
				
				
				/*create a entry for subscription*/
				$subscriptionPlan = new UserSubscriptionPlan();
			    $subscriptionPlan->user_id = $parentLastId;
			    $subscriptionPlan->subscription_plan_id = $request->subscription_plan; // set to null for now
			    $subscriptionPlan->is_active = false;
			    $subscriptionPlan->expires_at = null;
			    $subscriptionPlan->save();
				

				
				/*----------email verification on the payment page if payment is successfull no verification needd
				------if payment failed send email for verification
				-------*/
				// $data['user_email'] = $request->guardians_email;
				// $data['id'] = $hasParent;
				// $data['random'] = $random;;
				// $data['role_id'] = 3;
				// $data['admission_number'] = "";
				// if($request->guardians_email) {
				// 	@send_mail($request->guardians_email, $request->fathers_name, "activate_account", $data);
				// }
				$notification2 = new SmNotification;
				$notification2->user_id = 46;
				$notification2->role_id = 5; 
				$notification2->message = 'New Student Registration. Parent Name: '.$request->fathers_name;
				$notification2->url = 'student-view/'.$studentLast;
				$notification2->date = date('Y-m-d');
				$notification2->school_id = app('school')->id;
				$notification2->academic_id  = getAcademicId();
				$notification2->save();
	
				
				$notification2 = new SmNotification;
				$notification2->user_id = 1;
				$notification2->role_id = 1; 
				$notification2->message = 'New Student Registration. Parent Name: '.$request->fathers_name;
				$notification2->url = 'student-view/'.$studentLast;
				$notification2->date = date('Y-m-d');
				$notification2->school_id = app('school')->id;
				$notification2->academic_id  = getAcademicId();
				$notification2->save();
				
				/*$subscriptionPlans = SubscriptionPlan::
									where('id',$request->subscription_plan)
									->first();  
				session()->put('parentLastId',$parentLastId);
				session()->put('subscriptionPlans',$subscriptionPlans);
				session()->put('subscriptionPlan',$subscriptionPlan);
				session()->put('userParent',$user_parent);
				session()->put('studentRecord',$student);
				
				Toastr::success('Your Account has been created successfully. Please complete your subscription here', 'Success');
				return redirect()->route('subscriptionList');*/
				
				Toastr::success('Your Account has been created successfully. Please check your registered email', 'Success');
                return redirect()->back()->with('message-success', 'Success ! Your Account has been created successfully. Please check your registered email');
				
				} catch (\Exception $e) {
				Log::info($e->getMessage());
				echo $e->getMessage(); die;
				Toastr::error('Operation Failed,' . $e->getMessage(), 'Failed');
				return redirect()->back()->with('message-danger', $e->getMessage());
			}
		}
		
		public function subscriptionList(Request $request)
		{
			$parentLastId = session()->get('parentLastId');
		    $subscriptionPlans = session()->get('subscriptionPlans');
		    $subscriptionPlan = session()->get('subscriptionPlan');
		    $userParent = session()->get('userParent');
		    $studentRecord = session()->get('studentRecord');
		    $studentDetails = StudentRecord::where('id',$studentRecord->id)->first();
		    $courseDetails = SmCourse::where('id',$studentDetails->course_id)->with('sectionClass','courseClass')->first();
		    return view('backEnd.parentPanel.subscription-list',compact('parentLastId','subscriptionPlans','subscriptionPlan','userParent','studentRecord','courseDetails'));
		}
		
		public function course()
		{
			try {
				$exams = SmExam::where('school_id', app('school')->id)->get();
				$course = SmCourse::where('school_id', app('school')->id)->paginate(3);
				$news = SmNews::where('school_id', app('school')->id)->orderBy('order', 'asc')->limit(4)->get();
				$exams_types = SmExamType::where('school_id', app('school')->id)->get();
				$coursePage = SmCoursePage::where('school_id', app('school')->id)->first();
				$classes = SmClass::where('school_id', app('school')->id)->where('active_status', 1)->get();
				$subjects = SmSubject::where('school_id', app('school')->id)->where('active_status', 1)->get();
				$sections = SmSection::where('school_id', app('school')->id)->where('active_status', 1)->get();
				return view('frontEnd.home.light_course', compact('exams', 'classes', 'coursePage', 'subjects', 'exams_types', 'sections', 'course', 'news'));
				} catch (\Exception $e) {
				Toastr::error('Operation Failed', 'Failed');
				return redirect()->back();
			}
		}
		
		public function courseDetails($id)
		{
			try {
				$course = SmCourse::where('school_id', app('school')->id)->find($id);
				$course_details = SmCoursePage::where('school_id', app('school')->id)->where('is_parent', 0)->first();
				$courses = SmCourse::where('school_id', app('school')->id)->orderBy('id', 'asc')->whereNotIn('id', [$id])->limit(3)->get();
				return view('frontEnd.home.light_course_details', compact('course', 'courses', 'course_details'));
				} catch (\Exception $e) {
				Toastr::error('Operation Failed', 'Failed');
				return redirect()->back();
			}
		}
		
		public function loadMoreCourse(Request $request)
		{
			try {
				$count = SmCourse::count();
				$skip = $request->skip;
				$limit = $count - $skip;
				$due_courses = SmCourse::skip($skip)->where('school_id', app('school')->id)->take(3)->get();
				return view('frontEnd.home.loadMorePage', compact('due_courses', 'skip', 'count'));
				} catch (\Exception $e) {
				return response('error');
			}
		}
		
		public function socialMedia()
		{
			$visitors = SmSocialMediaIcon::where('school_id', app('school')->id)->get();
			return view('frontEnd.socialMedia', compact('visitors'));
		}
		
		public function viewPage($slug)
		{
			try {
				$page = SmPage::where('slug', $slug)->where('school_id', app('school')->id)->first();
				return view('frontEnd.pages.pages', compact('page'));
				} catch (\Exception $e) {
				
				Toastr::error('Operation Failed', 'Failed');
				return redirect()->back();
			}
		}
		
		public function deletePage(Request $request)
		{
			try {
				$data = SmPage::find($request->id);
				
				if ($data->header_image != "") {
					unlink($data->header_image);
				}
				
				$result = SmPage::find($request->id)->delete();
				if ($result) {
					Toastr::success('Operation Successfull', 'Success');
					} else {
					Toastr::error('Operation Failed', 'Failed');
				}
				return redirect('page-list');
				} catch (\Exception $e) {
				Toastr::error('Operation Failed', 'Failed');
				return redirect()->back();
			}
		}
		
		public function deleteMessage($id)
		{
			try {
				SmContactMessage::find($id)->delete();
				Toastr::success('Operation successful', 'Success');
				return redirect('contact-message');
				} catch (\Exception $e) {
				Toastr::error('Operation Failed', 'Failed');
				return redirect()->back();
			}
		}
		
		public function examResult()
		{
			try {
				$exam_types = SmExamType::where('school_id', app('school')->id)->get();
				$page = FrontendExamResult::where('school_id', app('school')->id)->first();
				
				return view('frontEnd.home.examResult', compact('exam_types', 'page'));
				} catch (\Exception $e) {
				Toastr::error('Operation Failed', 'Failed');
				return redirect()->back();
			}
		}
		
		public function examResultSearch(ExamResultSearch $request)
		{
			try {
				$exam_types = SmExamType::where('school_id', app('school')->id)->get();
				$page = FrontendExamResult::where('school_id', app('school')->id)->first();
				$school_id = app('school')->id;
				$student = SmStudent::where('admission_no', $request->admission_number)->where('school_id', $school_id)->first();
				if ($student) {
					$exam_content = SmExamSetting::where('exam_type', $request->exam)
                    ->where('active_status', 1)
                    ->where('academic_id', getAcademicId())
                    ->where('school_id', app('school')->id)
                    ->first();
					
					$student_detail = $studentDetails = StudentRecord::where('student_id', $student->id)
                    ->where('academic_id', getAcademicId())
                    ->where('is_promote', 0)
                    ->where('school_id', $school_id)
                    ->first();
					
					$section_id = $student_detail->section_id;
					$class_id = $student_detail->class_id;
					$exam_type_id = $request->exam;
					$student_id = $student->id;
					$exam_id = $request->exam;
					
					$failgpa = SmMarksGrade::where('active_status', 1)
                    ->where('academic_id', getAcademicId())
                    ->where('school_id', $school_id)
                    ->min('gpa');
					
					$failgpaname = SmMarksGrade::where('active_status', 1)
                    ->where('academic_id', getAcademicId())
                    ->where('school_id', $school_id)
                    ->where('gpa', $failgpa)
                    ->first();
					
					$exams = SmExamType::where('active_status', 1)
                    ->where('academic_id', getAcademicId())
                    ->where('school_id', $school_id)
                    ->get();
					
					$classes = SmClass::where('active_status', 1)
                    ->where('academic_id', getAcademicId())
                    ->where('school_id', $school_id)
                    ->get();
					
					$examSubjects = SmExam::where([['exam_type_id',  $exam_type_id], ['section_id', $section_id], ['class_id', $class_id]])
                    ->where('school_id', $school_id)
                    ->where('academic_id', getAcademicId())
                    ->get();
					$examSubjectIds = [];
					foreach ($examSubjects as $examSubject) {
						$examSubjectIds[] = $examSubject->subject_id;
					}
					
					$subjects = $studentDetails->class->subjects->where('section_id', $section_id)
                    ->whereIn('subject_id', $examSubjectIds)
                    ->where('academic_id', getAcademicId())
                    ->where('school_id', $school_id);
					$subjects = $examSubjects;
					
					$exam_details = $exams->where('active_status', 1)->find($exam_type_id);
					
					$optional_subject = '';
					$get_optional_subject = SmOptionalSubjectAssign::where('record_id', '=', $student_detail->id)
                    ->where('session_id', '=', $student_detail->session_id)
                    ->first();
					
					if ($get_optional_subject != '') {
						$optional_subject = $get_optional_subject->subject_id;
					}
					
					$optional_subject_setup = SmClassOptionalSubject::where('class_id', '=', $class_id)
                    ->first();
					
					$mark_sheet = SmResultStore::where([['class_id', $class_id], ['exam_type_id', $request->exam], ['section_id', $section_id], ['student_id', $student_id]])
                    ->whereIn('subject_id', $subjects->pluck('subject_id')->toArray())
                    ->where('school_id', $school_id)
                    ->get();
					
					$grades = SmMarksGrade::where('active_status', 1)
                    ->where('academic_id', getAcademicId())
                    ->where('school_id', $school_id)
                    ->orderBy('gpa', 'desc')
                    ->get();
					
					$maxGrade = SmMarksGrade::where('academic_id', getAcademicId())
                    ->where('school_id', $school_id)
                    ->max('gpa');
					
					if (count($mark_sheet) == 0) {
						Toastr::error('Ops! Your result is not found! Please check mark register', 'Failed');
						return redirect()->back();
					}
					
					$is_result_available = SmResultStore::where([['class_id', $class_id], ['exam_type_id', $request->exam], ['section_id', $section_id], ['student_id', $student_id]])
                    ->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')
                    ->where('school_id', $school_id)
                    ->get();
					
					$marks_register = SmMarksRegister::where('exam_id', $request->exam)
                    ->where('student_id', $student_id)
                    ->first();
					
					$subjects = SmAssignSubject::where('class_id', $class_id)
                    ->where('section_id', $section_id)
                    ->whereIn('subject_id', $examSubjectIds)
                    ->where('academic_id', getAcademicId())
                    ->where('school_id', $school_id)
                    ->get();
					
					$exams = SmExamType::where('active_status', 1)
                    ->where('academic_id', getAcademicId())
                    ->where('school_id', $school_id)
                    ->get();
					
					$classes = SmClass::where('active_status', 1)
                    ->where('academic_id', getAcademicId())
                    ->where('school_id', $school_id)
                    ->get();
					
					$grades = SmMarksGrade::where('active_status', 1)
                    ->where('academic_id', getAcademicId())
                    ->where('school_id', $school_id)
                    ->get();
					
					$class = SmClass::find($class_id);
					$section = SmSection::find($section_id);
					$exam_detail = SmExam::find($request->exam);
					
					return view('frontEnd.home.examResult', compact(
                    'optional_subject',
                    'classes',
                    'studentDetails',
                    'exams',
                    'classes',
                    'marks_register',
                    'subjects',
                    'class',
                    'section',
                    'exam_detail',
                    'exam_content',
                    'grades',
                    'student_detail',
                    'mark_sheet',
                    'exam_details',
                    'maxGrade',
                    'failgpaname',
                    'exam_id',
                    'exam_type_id',
                    'class_id',
                    'section_id',
                    'student_id',
                    'optional_subject_setup',
                    'exam_types',
                    'page'
					));
					} else {
					Toastr::error('Student Not Found', 'Failed');
					return redirect()->back();
				}
				} catch (\Exception $e) {
				Toastr::error('Operation Failed', 'Failed');
				return redirect()->back();
			}
		}
		
		public function classExamRoutine()
		{
			try {
				$classes = SmClass::get();
				$sections = SmSection::get();
				$exam_types = SmExamType::where('school_id', app('school')->id)->get();
				$routine_page = SmClassExamRoutinePage::where('school_id', app('school')->id)->first();
				return view('frontEnd.home.classExamRoutine', compact('routine_page', 'exam_types', 'classes', 'sections'));
				} catch (\Exception $e) {
				Toastr::error('Operation Failed', 'Failed');
				return redirect()->back();
			}
		}
		public function classExamRoutineSearch(Request $request)
		{
			$input = $request->all(); {
				$validator = ($request->type == 'class') ? Validator::make($input, [
                'type' => 'required',
                'class' => 'required',
                'section' => 'required',
				]) : Validator::make($input, [
                'type' => 'required',
                'class' => 'required',
                'section' => 'required',
                'exam' => 'required',
				]);
			}
			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();
			}
			
			try {
				$classes = SmClass::get();
				$sections = SmSection::get();
				$exam_types = SmExamType::where('school_id', app('school')->id)->get();
				$routine_page = SmClassExamRoutinePage::where('school_id', app('school')->id)->first();
				$header_class = SmClass::where('id', $request->class)->first();
				$header_section = SmSection::where('id', $request->section)->first();
				$class_id = $request->class ? $request->class : 0;
				$section_id = $request->section ? $request->section : 0;
				$exam_type_id = $request->exam ? $request->exam : 0;
				
				$sm_weekends = ($request->type == 'class') ? SmWeekend::with(['classRoutine' => function ($q) use ($class_id, $section_id) {
					return $q->where('class_id', $class_id)
					->where('section_id', $section_id)
					->orderBy('start_time', 'asc');
				}, 'classRoutine.subject'])
				->where('school_id', app('school')->id)
				->orderBy('order', 'ASC')
				->where('active_status', 1)
				->get() : null;
				
				$exam_schedules = ($request->type == 'exam') ? SmExamSchedule::where('school_id', app('school')->id)
				->when($request->exam, function ($query) use ($request) {
					$query->where('exam_term_id', $request->exam);
				})
				->when($request->class, function ($query) use ($request) {
					$query->where('class_id', $request->class);
				})
				->when($request->section, function ($query) use ($request) {
					$query->where('section_id', $request->section);
				})
				->get() : null;
				
				return view('frontEnd.home.classExamRoutine', compact('routine_page', 'exam_types', 'classes', 'sections', 'sm_weekends', 'exam_schedules', 'header_class', 'header_section', 'class_id', 'section_id', 'exam_type_id'));
				} catch (\Exception $e) {
				Toastr::error('Routine Not Found', 'Failed');
				return redirect()->back();
			}
		}
	}
