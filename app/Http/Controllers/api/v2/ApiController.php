<?php
	
	namespace App\Http\Controllers\api\v2;
	
	use App\Http\Controllers\Controller;
	use App\Http\Resources\v2\TeachersListResource;
	use App\Models\StudentRecord;
	use App\Models\TeacherEvaluationSetting;
	use App\SmAssignSubject;
	use App\SmNotification;
	use App\SmStudent;
	use App\User;
	use App\SmBook;
	use App\SmStaff;
	use App\SmClass;
	use App\SmSection;
	use App\SmVisitor;
	use App\SmWeekend;
	use App\SmHomework;
	use App\SmClassRoom;
	use App\SmClassTime;
	use App\SmComplaint;
	use App\ApiBaseMethod;
	use App\SmNoticeBoard;
	use App\SmAcademicYear;
	use App\SmPhoneCallLog;
	use App\SmClassTeacher;
	use App\SmPostalReceive;
	use App\SmStudentIdCard;
	use App\SmPostalDispatch;
	use App\SmAdmissionQuery;
	use App\SmAssignClassTeacher;
	use App\SmStudentCertificate;
	use App\SmClassRoutineUpdate;
	use App\SmTeacherUploadContent;
	use Validator;
	use Illuminate\Support\Facades\Log;
	use Illuminate\Support\Facades\Notification;
	use App\Notifications\StudyMeterialCreatedNotification;
	use App\Http\Controllers\Admin\StudentInfo\SmStudentReportController;
	use Modules\RolePermission\Entities\InfixRole;
	use Illuminate\Http\Request;
	use Illuminate\Support\Facades\Auth;
	use App\Traits\NotificationSend;
	
	class ApiController extends Controller
	{
	    public function addmissionQuery()
		{
			try {
				$admission_query = SmAdmissionQuery::all();
				if ($admission_query->isNotEmpty()) {
					return response()->json([
                    'status' => 200,
                    'message' => 'success',
                    'data' => $admission_query
					], 200);
					
					}else{
					return response()->json([
                    'status' => 404,
                    'message' => 'Data not found',
					], 200);
				}
				} catch (Exception $e) {
				return response()->json(['status' => 400,'error' => 'Something went wrong, please try again.'], 400);  
			}
		}
		
		public function visitorList()
		{
			try {
				$visitor = SmVisitor::all();
				if ($visitor->isNotEmpty()) {
					return response()->json([
                    'status' => 200,
                    'message' => 'success',
                    'data' => $visitor
					], 200);
					
					}else{
					return response()->json([
                    'status' => 404,
                    'message' => 'Data not found',
					], 200);
				}
				} catch (Exception $e) {
				return response()->json(['status' => 400,'error' => 'Something went wrong, please try again.'], 400);  
			}
		}
		
		public function complaintList()
		{
			try {
				$complaints = SmComplaint::with('complaintType','complaintSource')->get();
				if ($complaints->isNotEmpty()) {
					return response()->json([
                    'status' => 200,
                    'message' => 'success',
                    'data' => $complaints
					], 200);
					
					}else{
					return response()->json([
                    'status' => 404,
                    'message' => 'Data not found',
					], 200);
				}
				} catch (Exception $e) {
				return response()->json(['status' => 400,'error' => 'Something went wrong, please try again.'], 400);  
			}
		}
		
		public function postalList()
		{
			try {
				$postal = SmPostalReceive::all();
				if ($postal->isNotEmpty()) {
					return response()->json([
                    'status' => 200,
                    'message' => 'success',
                    'data' => $postal
					], 200);
					
					}else{
					return response()->json([
                    'status' => 404,
                    'message' => 'Data not found',
					], 200);
				}
				} catch (Exception $e) {
				return response()->json(['status' => 400,'error' => 'Something went wrong, please try again.'], 400);  
			}
		}
		
		
		public function postalDispatchList()
		{
			try {
				$postal = SmPostalDispatch::all();
				if ($postal->isNotEmpty()) {
					return response()->json([
                    'status' => 200,
                    'message' => 'success',
                    'data' => $postal
					], 200);
					
					}else{
					return response()->json([
                    'status' => 404,
                    'message' => 'Data not found',
					], 200);
				}
				} catch (Exception $e) {
				return response()->json(['status' => 400,'error' => 'Something went wrong, please try again.'], 400);  
			}
		}
		
		
		public function callLogList()
		{
			try {
				$callLogs = SmPhoneCallLog::all();
				if ($callLogs->isNotEmpty()) {
					return response()->json([
                    'status' => 200,
                    'message' => 'success',
                    'data' => $callLogs
					], 200);
					
					}else{
					return response()->json([
                    'status' => 404,
                    'message' => 'Data not found',
					], 200);
				}
				} catch (Exception $e) {
				return response()->json(['status' => 400,'error' => 'Something went wrong, please try again.'], 400);  
			}
		}
		
		
		public function idCardList()
		{
			try {
				$id_cards = SmStudentIdCard::where('active_status', 1)->where('school_id', Auth::user()->school_id)->get();
				if ($id_cards->isNotEmpty()) {
					return response()->json([
                    'status' => 200,
                    'message' => 'success',
                    'data' => $id_cards
					], 200);
					
					}else{
					return response()->json([
                    'status' => 404,
                    'message' => 'Data not found',
					], 200);
				}
				} catch (Exception $e) {
				return response()->json(['status' => 400,'error' => 'Something went wrong, please try again.'], 400);  
			}
		}
		
		public function studentCertificateList()
		{
			try {
				$certificates = SmStudentCertificate::where('active_status', 1)->where('school_id',Auth::user()->school_id)->get();
				if ($certificates->isNotEmpty()) {
					return response()->json([
                    'status' => 200,
                    'message' => 'success',
                    'data' => $certificates
					], 200);
					
					}else{
					return response()->json([
                    'status' => 404,
                    'message' => 'Data not found',
					], 200);
				}
				} catch (Exception $e) {
				return response()->json(['status' => 400,'error' => 'Something went wrong, please try again.'], 400);  
			}
		}
		
		public function notificationList(Request $request)
		{
			try {
				$user_id = Auth::user()->id;
				$role_id =  Auth::user()->role_id;
				
				$new_notifications = SmNotification::where('user_id', $user_id)
	            ->where('role_id', $role_id)
	            ->get();
				
				if ($new_notifications->isNotEmpty()) {
					return response()->json([
                    'status' => 200,
                    'message' => 'success',
                    'data' => $new_notifications
					], 200);
					
					}else{
					return response()->json([
                    'status' => 404,
                    'message' => 'Data not found',
					], 200);
				}
				} catch (Exception $e) {
				return response()->json(['status' => 400,'error' => 'Something went wrong, please try again.'], 400);  
			}
		}
		
		public function libraryBookList(Request $request)
		{
			try {
				$books = SmBook::leftjoin('sm_subjects', 'sm_books.book_subject_id', '=', 'sm_subjects.id')
				->leftjoin('sm_book_categories', 'sm_books.book_category_id', '=', 'sm_book_categories.id')
				->select('sm_books.*', 'sm_subjects.subject_name', 'sm_book_categories.category_name')
				->orderby('sm_books.id', 'DESC')
				->get(); // Add the get method to execute the query
				
				if ($books->isNotEmpty()) {
					return response()->json([
                    'status' => 200,
                    'message' => 'success',
                    'data' => $books
					], 200);
					
					}else{
					return response()->json([
                    'status' => 404,
                    'message' => 'Data not found',
					], 200);
				}
				} catch (Exception $e) {
				return response()->json(['status' => 400,'error' => 'Something went wrong, please try again.'], 400);  
			}
			
		}
		
		public function studentTeacher($record_id)
		{
			$record = StudentRecord::findOrFail($record_id);
			$result = SmAssignSubject::with('teacher', 'subject')->where('class_id', $record->class_id)
            ->where('section_id', $record->section_id)->distinct('teacher_id')->get();
			$data = TeachersListResource::collection($result);
			$response = [
            'success' => true,
            'data'    => $data,
            'message' => 'Operation successful',
			];
			return response()->json($response, 200);
		}
		
		// Search students by name with %LIKE%
		public function searchByName(Request $request)
		{
			try {
				$request->validate([
                'name' => 'required|string',
				]);
				
				$name = $request->input('name');
				$students = SmStudent::where('role_id', 2)
				->where('full_name', 'LIKE', "%{$name}%")
				->get();
				if ($students) {
					return response()->json([
					'status' => 200,
					'message' => 'success',
					'data' => $students,
                    ], 200);
					}else{
					return response()->json([
					'status' => 404,
					'message' => 'Data not found',
                    ], 200);
				}
				
				} catch (Exception $e) {
				return response()->json(['status' => 400,'error' => 'Something went wrong, please try again.'], 400);   
			}
			
		}
		
		// Fetch student profile by roll number or ID
		public function getProfile(Request $request)
		{
			try {
				$request->validate([
                'identifier' => 'required',
                'type' => 'required|in:id,roll_number'
				]);
				
				$identifier = $request->input('identifier');
				$type = $request->input('type');
				
				$query = SmStudent::where('active_status', 1);
				
				if ($type === 'id') {
					$query->where('id', $identifier);
					} else {
					$query->where('roll_no', $identifier);
				}
				
				$student = $query->firstOrFail();
				if ($student) {
					return response()->json([
					'status' => 200,
					'message' => 'success',
					'data' => $student,
                    ], 200);
					}else{
					return response()->json([
					'status' => 404,
					'message' => 'Data not found',
                    ], 200);
				}
				} catch (Exception $e) {
				return response()->json(['status' => 400,'error' => 'Something went wrong, please try again.'], 400);   
			}
			
		}
		
		
		public function getClassRoutine(Request $request)
		{
			try {
				
				$teacherId = auth()->id();
				$teacherStaffId = SmStaff::where('user_id',$teacherId)->pluck('id')->first();
				$data = SmClassTeacher::where('teacher_id',$teacherStaffId)->with(['teacherClass.class'])->get();
				if ($data) {
					return response()->json([
					'status' => 200,
					'message' => 'success',
					'data' => $data,
                    ], 200);
					}else{
					return response()->json([
					'status' => 404,
					'message' => 'Data not found',
                    ], 200);
				}
				} catch (Exception $e) {
				return response()->json(['status' => 400,'error' => 'Something went wrong, please try again.'], 400);   
			}
		}
		
		public function searchAttendance(Request $request)
		{
			try {
				$date = $request->attendance_date;
				
				$teacher_info = SmStaff::where('user_id', auth()->id())->first();
				$classes = $teacher_info->classes;
				
				$students = StudentRecord::with('studentDetail', 'studentDetail.DateWiseAttendances')
                ->when($request->class_id, function ($query) use ($request) {
                    $query->where('class_id', $request->class_id);
				})
                ->whereHas('studentDetail', function ($q) {
                    $q->where('active_status', 1);
				})
                ->where('school_id', auth()->user()->school_id)
                ->get()->sortBy('roll_no');
				
				if ($students->isEmpty()) {
					return response()->json([
					'status' => 404,
					'message' => 'Data not found',
                    ], 200);
					}else{
					return response()->json([
                    'status' => 200,
                    'message' => 'success',
                    'data' => $students,
					], 200);
				}
				
				} catch (\Exception $e) {
				json_encode($e);die;
				return response()->json(['status' => 400,'error' => 'Something went wrong, please try again.'], 400);   
			}
		}
		
		public function contentList($value='')
		{
			try {
				$uploadContents = SmTeacherUploadContent::query()->with('classes', 'sections');
				if (teacherAccess()) {
                    $uploadContents->where(function ($q) {
                        $q->where('created_by', auth()->id())->orWhere('available_for_admin', 1);
					});
				}
				$uploadContents = $uploadContents->where('school_id', Auth::user()->school_id)
				->where('course_id', '=', null)
				->where('chapter_id', '=', null)
				->where('lesson_id', '=', null)
				->orderby('id', 'DESC')
				->get();
				if ($uploadContents->isEmpty()) {
					return response()->json([
					'status' => 404,
					'message' => 'Data not found',
                    ], 200);
					}else{
					return response()->json([
                    'status' => 200,
                    'message' => 'success',
                    'data' => $uploadContents,
					], 200);
				}
				} catch (\Exception $e) {
				return response()->json(['status' => 400,'error' => 'Something went wrong, please try again.'], 400);  
			}
		}
		
		public function contentUpload(Request $request)
		{
			$maxFileSize = generalSetting()->file_size*1024;
			$validator = Validator::make($request->all(), [
            'content_title' => "required|max:200",
            'content_type' => "required",
            'available_for' => 'required|array',
            'content_file' => "sometimes|nullable|mimes:pdf,doc,docx,jpg,jpeg,png,mp4,mp3,txt|max:".$maxFileSize,
            'description' =>'sometimes|nullable',
            'source_url' => 'sometimes|nullable|url',
            'section'   => 'sometimes|nullable',
			]);
			
			if ($validator->fails()) {
				return response()->json([
                'status' => 401,
                'message' => 'validation error',
                'errors' => $validateData->errors()
				], 200);
			}
			
			try {
				$student_ids = SmStudentReportController::classSectionStudent($request);
				$destination='public/uploads/upload_contents/';
				if ($request->section == "all") {
					
					} else {
                    $uploadContents = new SmTeacherUploadContent();
                    $uploadContents->content_title = $request->content_title;
                    $uploadContents->content_type = $request->content_type;
                    $uploadContents->school_id = Auth::user()->school_id;
                    $uploadContents->academic_id = getAcademicId();
                    foreach ($request->available_for as $value) {
                        if ($value == 'admin') {
                            $uploadContents->available_for_admin = 1;
						}
                        if ($value == 'student') {
                            if (isset($request->all_classes)) {
                                $uploadContents->available_for_all_classes = 1;
								} else {
                                $uploadContents->class = $request->class;
                                $uploadContents->section = $request->section;
							}
						}
					}
                    $uploadContents->upload_date = \Carbon\Carbon::now()->toDateString();
                    $uploadContents->description = $request->description;
                    $uploadContents->source_url = $request->source_url;
                    $uploadContents->upload_file = fileUpload($request->content_file, $destination);
                    if($request->status == 'lmsStudyMaterial'){
                        if($request->parent_course){
                            $uploadContents->parent_course_id = $request->course_id;
							}else{
                            $uploadContents->course_id = $request->course_id;
						}
                        $uploadContents->chapter_id = $request->chapter_id;
                        $uploadContents->lesson_id = $request->lesson_id;
					}
                    $uploadContents->created_by = auth()->user()->id;
                    $results = $uploadContents->save();
					
				}
				
				if ($request->content_type == 'as') {
					$purpose = 'assignment';
					$url = 'student-assignment';
					} elseif ($request->content_type == 'st') {
					$purpose = 'Study Material';
					$url = 'student-study-materia';
					} elseif ($request->content_type == 'sy') {
					$purpose = 'Syllabus';
					$url = 'student-syllabus';
					} elseif ($request->content_type == 'ot') {
					$purpose = 'Others Download';
					$url = 'student-others-download';
				}
				
				foreach ($request->available_for as $value) {
					if ($value == 'admin') {
						$roles = InfixRole::where('id', '=', 1) /* ->where('id', '!=', 2)->where('id', '!=', 3)->where('id', '!=', 9) */->where(function ($q) {
							$q->where('school_id', Auth::user()->school_id)->orWhere('type', 'System');
						})->get();
						foreach ($roles as $role) {
							$staffs = SmStaff::where('role_id', $role->id)->where('school_id', Auth::user()->school_id)->get();
							foreach ($staffs as $staff) {
								
								$notification = new SmNotification;
								$notification->user_id = $staff->user_id;
								$notification->role_id = $role->id;
								$notification->school_id = Auth::user()->school_id;
								if(moduleStatusCheck('University')){
									$notification->un_academic_id = getAcademicId();
									}else{
									$notification->academic_id = getAcademicId();
								}
								if ($request->content_type == 'as') {
									$notification->url = 'assignment-list';
									} elseif ($request->content_type == 'st') {
									$notification->url = 'study-metarial-list';
									} elseif ($request->content_type == 'sy') {
									$notification->url = 'syllabus-list';
									} elseif ($request->content_type == 'ot') {
									$notification->url = 'other-download-list';
								}
								$notification->date = date('Y-m-d');
								$notification->message = $purpose . ' '.app('translator')->get('common.uploaded');
								$notification->save();
								
								try {
									$user=User::find($notification->user_id);
									Notification::send($user, new StudyMeterialCreatedNotification($notification));
									} catch (\Exception $e) {
									Log::info($e->getMessage());
								}
							}
						}
					}
					if (($value == 'student') && ($request->status != 'lmsStudyMaterial') ) {
						if (isset($request->all_classes)) {
							$records = StudentRecord::with('studentDetail', 'class', 'section')
							->where('is_promote', 0)
							->where('active_status', 1)
							->where('school_id', auth()->user()->school_id)
							->where('academic_id', getAcademicId())
							->distinct('student_id')
							->get();
							foreach ($records as $record) {
								$data ['student_name'] = $record->studentDetail->full_name;
								$data ['assignment'] = $request->content_title;
								$data ['class'] = $record->class->class_name;
								$data ['section'] = $record->section->section_name;;
								$data ['subject'] = $purpose;
								$data ['url'] = $url;
								if ($request->content_type == 'as') {
									$this->sent_notifications('Assignment', (array)$record->studentDetail->user_id, $data, ['Student', 'Parent']);
									} elseif ($request->content_type == 'sy') {
									$this->sent_notifications('Syllabus', (array)$record->studentDetail->user_id, $data, ['Student', 'Parent']);
									} elseif ($request->content_type == 'ot') {
									$this->sent_notifications('Other_Downloads', (array)$record->studentDetail->user_id, $data, ['Student', 'Parent']);
								}
							}
							} elseif ((!is_null($request->class)) &&   ($request->section == '')) {
							$records = StudentRecord::with('studentDetail', 'class', 'section')
							->where('is_promote', 0)
							->where('active_status', 1)
							->whereIn('student_id', $student_ids)
							->where('school_id', auth()->user()->school_id)
							->where('academic_id', getAcademicId())
							->get();
							
							foreach ($records as $record) {
								$data ['student_name'] = $record->studentDetail->full_name;
								$data ['assignment'] = $request->content_title;
								$data ['class'] = $record->class->class_name;
								$data ['section'] = $record->section->section_name;;
								$data ['subject'] = $purpose;
								$data ['url'] = $url;
								if ($request->content_type == 'as') {
									$this->sent_notifications('Assignment', (array)$record->studentDetail->user_id, $data, ['Student', 'Parent']);
									} elseif ($request->content_type == 'sy') {
									$this->sent_notifications('Syllabus', (array)$record->studentDetail->user_id, $data, ['Student', 'Parent']);
									} elseif ($request->content_type == 'ot') {
									$this->sent_notifications('Other_Downloads', (array)$record->studentDetail->user_id, $data, ['Student', 'Parent']);
								}
							}
							} else {
							$records = StudentRecord::with('studentDetail', 'class', 'section')
							->where('is_promote', 0)
							->where('active_status', 1)
							->whereIn('student_id', $student_ids)
							->where('school_id', auth()->user()->school_id)
							->where('academic_id', getAcademicId())
							->get();
							foreach ($records as $record) {
								$data ['student_name'] = $record->studentDetail->full_name;
								$data ['assignment'] = $request->content_title;
								$data ['class'] = $record->class->class_name;
								$data ['section'] = $record->section->section_name;;
								$data ['subject'] = $purpose;
								$data ['url'] = $url;
								if ($request->content_type == 'as') {
									$this->sent_notifications('Assignment', (array)$record->studentDetail->user_id, $data, ['Student', 'Parent']);
									} elseif ($request->content_type == 'sy') {
									$this->sent_notifications('Syllabus', (array)$record->studentDetail->user_id, $data, ['Student', 'Parent']);
									} elseif ($request->content_type == 'ot') {
									$this->sent_notifications('Other_Downloads', (array)$record->studentDetail->user_id, $data, ['Student', 'Parent']);
								}
							}
						}
					}
				}
				
				if ($results) {
					return response()->json([
                    'status' => 200,
                    'message' => 'Content uploaded successfully',
					], 200);
					}else{
					return response()->json([
                    'status' => 400,
                    'message' => 'Operation failed',
					], 200);
				}
				} catch (\Exception $e) {
				print_r($e->getMessage());die;
				return response()->json(['status' => 400,'error' => 'Something went wrong, please try again.'], 400);  
			}
		}
		
		
		public function noticeList(Request $request)
		{
			try {
				$allNotices = SmNoticeBoard::with('users')
				->orderBy('id', 'DESC')
				->get();
				if ($allNotices->isEmpty()) {
					return response()->json([
					'status' => 404,
					'message' => 'Data not found',
                    ], 200);
					}else{
					return response()->json([
                    'status' => 200,
                    'message' => 'success',
                    'data' => $allNotices,
					], 200);
				}
				} catch (\Exception $e) {
				return response()->json(['status' => 400,'error' => 'Something went wrong, please try again.'], 400);  
			}
		}
		
		public function bookList(Request $request)
		{
			
			try {
				$books = SmBook::leftjoin('library_subjects', 'sm_books.book_subject_id', '=', 'library_subjects.id')
                ->leftjoin('sm_book_categories', 'sm_books.book_category_id', '=', 'sm_book_categories.id')
                ->select('sm_books.*', 'library_subjects.subject_name', 'sm_book_categories.category_name')
                ->orderby('sm_books.id', 'DESC')
                ->get();
				
				if ($books->isEmpty()) {
					return response()->json([
					'status' => 404,
					'message' => 'Data not found',
                    ], 200);
					}else{
					return response()->json([
                    'status' => 200,
                    'message' => 'success',
                    'data' => $books,
					], 200);
				}
				} catch (\Exception $e) {
				return response()->json(['status' => 400,'error' => 'Something went wrong, please try again.'], 400);  
			}
		}
		
		
		public function addHomework(Request $request)
		{
			// Define validation rules
			$validator = Validator::make($request->all(), [
            'class_id' => 'required|integer',
            'subject_id' => 'required|integer',
            'section_id' => 'required|array',
            'section_id.*' => 'integer',
            'homework_date' => 'required|date_format:m/d/Y',
            'submission_date' => 'required|date_format:m/d/Y',
            'marks' => 'required|integer',
            'description' => 'required|string',
            'homework_file' => 'nullable|file'
			]);
			
			// Check if validation fails
			if ($validator->fails()) {
				return response()->json([
                'success' => false,
                'errors' => $validator->errors()
				], 422);
			}
			
			try {
				$destination = 'public/uploads/homeworkcontent/';
				$sections = [];
				$upload_file = fileUpload($request->homework_file, $destination);
				
				if (moduleStatusCheck('University')) {
					$labels = UnSemesterLabel::find($request->un_semester_label_id);
					$sections = $labels->labelSections;
					
					if (is_null($request->section_id)) {
						foreach ($sections as $section) {
							$homeworks = new SmHomework();
							$homeworks->un_subject_id = $request->un_subject_id;
							$homeworks->homework_date = date('Y-m-d', strtotime($request->homework_date));
							$homeworks->submission_date = date('Y-m-d', strtotime($request->submission_date));
							$homeworks->marks = $request->marks;
							$homeworks->description = $request->description;
							$homeworks->file = $upload_file;
							$homeworks->created_by = auth()->user()->id;
							$homeworks->school_id = auth()->user()->school_id;
							$interface = App::make(UnCommonRepositoryInterface::class);
							$interface->storeUniversityData($homeworks, $request);
							$homeworks->un_section_id = $section->id;
							$homeworks->save();
						}
						} else {
						$homeworks = new SmHomework();
						$homeworks->un_subject_id = $request->un_subject_id;
						$homeworks->homework_date = date('Y-m-d', strtotime($request->homework_date));
						$homeworks->submission_date = date('Y-m-d', strtotime($request->submission_date));
						$homeworks->marks = $request->marks;
						$homeworks->description = $request->description;
						$homeworks->file = $upload_file;
						$homeworks->created_by = auth()->user()->id;
						$homeworks->school_id = auth()->user()->school_id;
						$interface = App::make(UnCommonRepositoryInterface::class);
						$interface->storeUniversityData($homeworks, $request);
						$homeworks->save();
					}
					} else {
					if ($request->status == "lmsHomework") {
						$classes = SmClassSection::when($request->class_id, function ($query) use ($request) {
							$query->where('class_id', $request->class_id);
						})
                        ->when($request->section_id, function ($query) use ($request) {
                            $query->where('section_id', $request->section_id);
						})
                        ->where('school_id', auth()->user()->school_id)
                        ->get();
						
						foreach ($classes as $classe) {
							$homeworks = new SmHomework();
							$homeworks->class_id = $classe->class_id;
							$homeworks->section_id = $classe->section_id;
							$homeworks->subject_id = $request->subject_id;
							$homeworks->homework_date = date('Y-m-d', strtotime($request->homework_date));
							$homeworks->submission_date = date('Y-m-d', strtotime($request->submission_date));
							$homeworks->marks = $request->marks;
							$homeworks->description = $request->description;
							$homeworks->file = $upload_file;
							$homeworks->created_by = auth()->user()->id;
							$homeworks->school_id = auth()->user()->school_id;
							$homeworks->academic_id = getAcademicId();
							if ($request->status == 'lmsHomework') {
								$homeworks->course_id = $request->course_id;
								$homeworks->chapter_id = $request->chapter_id;
								$homeworks->lesson_id = $request->lesson_id;
								$homeworks->subject_id = $request->subject_id;
							}
							$homeworks->save();
						}
						} else {
						foreach ($request->section_id as $section) {
							$sections[] = $section;
							$homeworks = new SmHomework();
							$homeworks->class_id = $request->class_id;
							$homeworks->section_id = $section;
							$homeworks->subject_id = $request->subject_id;
							$homeworks->homework_date = date('Y-m-d', strtotime($request->homework_date));
							$homeworks->submission_date = date('Y-m-d', strtotime($request->submission_date));
							$homeworks->marks = $request->marks;
							$homeworks->description = $request->description;
							$homeworks->file = $upload_file;
							$homeworks->created_by = Auth()->user()->id;
							$homeworks->school_id = Auth::user()->school_id;
							$homeworks->academic_id = getAcademicId();
							$homeworks->save();
							
							$data['class_id'] = $homeworks->class_id;
							$data['section_id'] = $homeworks->section_id;
							$data['subject'] = $homeworks->subjects->subject_name;
							$records = $this->studentRecordInfo($data['class_id'], $data['section_id'])->pluck('studentDetail.user_id');
							$this->sent_notifications('Assign_homework', $records, $data, ['Student', 'Parent']);
						}
					}
					$student_ids = StudentRecord::when($request->class, function ($query) use ($request) {
						$query->where('class_id', $request->class_id);
					})
                    ->when($request->section_id, function ($query) use ($sections) {
                        $query->whereIn('section_id', $sections);
					})
                    ->when(!$request->academic_year, function ($query) use ($request) {
                        $query->where('academic_id', getAcademicId());
					})->where('school_id', auth()->user()->school_id)->pluck('student_id')->unique();
				}
				
				
				if ($request->status == 'lmsHomework') {
					return response()->json([
                    'status' => 200,
                    'message' => 'Operation successful',
					], 200);
					}else{
					return response()->json([
                    'status' => 200,
                    'message' => 'Operation successful',
					], 200);
				}
				
				} catch (\Exception $e) {
				return response()->json(['status' => 400,'error' => 'Something went wrong, please try again.'], 400);  
			}
		}
		
		
		public function homeworkList(Request $request)
		{
			
			$validator = Validator::make($request->all(), [
            'class_id' => 'required|integer',
            'subject_id' => 'required|integer',
            'section_id' => 'required|array',
            'section_id.*' => 'integer',
			]);
			
			// Check if validation fails
			if ($validator->fails()) {
				return response()->json([
                'success' => false,
                'errors' => $validator->errors()
				], 422);
			}
			
			
			try {
				$all_homeworks = SmHomework::query();
				$all_homeworks->with('classes','sections','subjects','users');
				$all_homeworks->when($request->class, function ($query) use ($request) {
					$query->where('class_id', $request->class);
				});
				$all_homeworks->when($request->subject, function ($query) use ($request) {
					$query->where('subject_id', $request->subject);
				});
				$all_homeworks->when($request->section, function ($query) use ($request) {
					$query->where('section_id', $request->section);
				});
				
				if(moduleStatusCheck('University')){
					$all_homeworks->with('semesterLabel','unSession','unSemester');
				}
				$all_homeworks->where('school_id',Auth::user()->school_id)->orderby('id','DESC')
                ->where('academic_id', getAcademicId());
				if (teacherAccess()) {
					$homeworkLists = $all_homeworks->where('created_by',Auth::user()->id)->get();
					} else {
					$homeworkLists = $all_homeworks->get();
				}
				
				if ($homeworkLists->isNotEmpty()) {
					return response()->json([
                    'status' => 200,
                    'message' => 'success',
                    'data' => $homeworkLists
					], 200);
					
					}else{
					return response()->json([
                    'status' => 404,
                    'message' => 'Data not found',
					], 200);
				}
				
				
				} catch (\Exception $e) {
				return response()->json(['status' => 400,'error' => 'Something went wrong, please try again.'], 400);  
			}
		}
		
		
		public function assignClasses()
		{
			
			try {
				$teacherId = auth()->id();
				$teacherStaffId = SmStaff::where('user_id',$teacherId)->pluck('id')->first();
				$classes = SmClass::get();
				// $teachers = SmStaff::status()->where(function ($q) {
				//     $q->where('role_id', 4)->orWhere('previous_role_id', 4);
				
				// })->get();
				$assign_class_teachers = SmAssignClassTeacher::with('class', 'section', 'classTeachers')
                ->where('academic_id', getAcademicId())
                ->status()
                ->orderBy('class_id', 'ASC')
                ->orderBy('section_id', 'ASC')
                ->whereHas('classTeachers', function ($q) use ($teacherStaffId) {
                    $q->where('teacher_id', $teacherStaffId);
				})
				->get();
				if ($assign_class_teachers->isNotEmpty()) {
					return response()->json([
                    'status' => 200,
                    'message' => 'success',
                    'data' => $assign_class_teachers
					], 200);
					
					}else{
					return response()->json([
                    'status' => 404,
                    'message' => 'Data not found',
					], 200);
				}
				
				} catch (\Exception $e) {
				return response()->json(['status' => 400,'error' => 'Something went wrong, please try again.'], 400);  
			}
			
		}
		
		
	}	