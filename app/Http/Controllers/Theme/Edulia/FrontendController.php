<?php

namespace App\Http\Controllers\Theme\Edulia;

use App\SmExam;
use App\SmNews;
use App\SmClass;
use App\SmCourse;
use App\SmEvent;
use App\SmSection;
use App\SmStudent;
use App\YearCheck;
use App\SmStudentCategory;
use App\SmCourseCategory;
use App\SmExamType;
use App\SmNewsPage;
use App\SmMarksGrade;
use App\SmExamSetting;
use App\SmNoticeBoard;
use App\SmResultStore;
use App\SmAssignSubject;
use App\SmMarksRegister;
use Illuminate\Http\Request;
use App\Models\SmNewsComment;
use App\Models\StudentRecord;
use App\Models\SmPhotoGallery;
use App\SmClassOptionalSubject;
use App\SmOptionalSubjectAssign;
use App\Models\FrontendExamResult;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use App\Models\SubscriptionPlan;
use App\Http\Requests\Admin\FrontSettings\ExamResultSearch;

class FrontendController extends Controller
{
    public function singleCourseDetails($course_id)
    {
        try {
            $data['course'] = SmCourse::where('school_id', app('school')->id)->find($course_id);
            return view('frontEnd.theme.' . activeTheme() . '.course.single_course_details_page', $data);
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function singleNewsDetails($news_id)
    {
        try {
            $data['news'] = SmNews::with(['newsComments.onlyChildrenFrontend'])->where('school_id', app('school')->id)->findOrFail($news_id);
            return view('frontEnd.theme.' . activeTheme() . '.news.single_news_details_page', $data);
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function storeNewsComment(Request $request)
    {
        try {
            $newsDeyails = SmNews::find($request->news_id);
            $store = new SmNewsComment();
            $store->message = $request->message;
            $store->news_id = $request->news_id;
            $store->user_id = $request->user_id;
            $store->parent_id = $request->parent_id ?? NULL;
            if ($newsDeyails->is_global == 1 && generalSetting()->auto_approve == 1) {
                $store->status = 1;
            } elseif ($newsDeyails->is_global == 0 && $newsDeyails->auto_approve == 1) {
                $store->status = 1;
            } else {
                $store->status = 0;
            }
            $store->save();
            if (request()->ajax()) {
                return response()->json(['success' => true]);
            } else {
                Toastr::success('Comment Store Successfully', 'Success');
                return redirect()->route('frontend.news-details', $request->news_id);
            }
        } catch (\Exception $e) {
            if (request()->ajax()) {
                return response()->json(['error' => $e]);
            } else {
                Toastr::error('Operation Failed', 'Failed');
                return redirect()->back();
            }
        }
    }

    public function singleGalleryDetails($gallery_id)
    {
        try {
            $data['gallery_feature'] = SmPhotoGallery::where('school_id', app('school')->id)->where('parent_id', '=', null)->findOrFail($gallery_id);
            $data['galleries'] = SmPhotoGallery::where('school_id', app('school')->id)->where('parent_id', '!=', null)->where('parent_id', $gallery_id)->get();
            return view('frontEnd.theme.' . activeTheme() . '.photoGallery.single_photo_gallery', $data);
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }
    public function singleNoticeDetails($notice_id)
    {
        try {
            $data['notice_detail'] = SmNoticeBoard::where('is_published', 1)->where('school_id', app('school')->id)->findOrFail($notice_id);
            $data['notices'] = SmNoticeBoard::where('is_published', 1)->where('school_id', app('school')->id)->get();
            return view('frontEnd.theme.' . activeTheme() . '.notice.single_notice', $data);
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }
    public function indiviualResult(ExamResultSearch $request)
    {
        try {
            $exam_types = SmExamType::where('school_id', app('school')->id)->get();
            $page = FrontendExamResult::where('school_id', app('school')->id)->first();
            $school_id = app('school')->id;
            $student = SmStudent::where('admission_no', $request->admission_number)->where('school_id', $school_id)->with('parents', 'group')->first();
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

                return view('frontEnd.theme.' . activeTheme() . '.indivisualResult.indivisual_result', compact(
                    'student',
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

    public function allBlogList()
    {
        try {
            $data['news'] = SmNews::where('school_id', app('school')->id)->paginate(8);
            $data['newsPage'] = SmNewsPage::where('school_id', app('school')->id)->first();
            return view('frontEnd.theme.' . activeTheme() . '.news.all_news_list', $data);
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function loadMoreBlogs(Request $request)
    {
        try {
            $data['count'] = SmNews::count();
            $data['skip'] = $request->skip;
            $data['limit'] = $data['count'] - $data['skip'];
            $data['news'] = SmNews::skip($data['skip'])->where('school_id', app('school')->id)->take(4)->get();
            return view('frontEnd.theme.' . activeTheme() . '.news.load_more_news', $data);
        } catch (\Exception $e) {
            return response('error');
        }
    }

    public function singleEventDetails($id)
    {
        try {
            $data['event'] = SmEvent::with('user')->find($id);
            return view('frontEnd.theme.' . activeTheme() . '.single_event', $data);
        } catch (\Exception $e) {
            return response('error');
        }
    }

    public function blogList()
    {
        try {
            $data['blogs'] = SmNews::with('category')->where('school_id', app('school')->id);
            return view('frontEnd.theme.' . activeTheme() . '.blog_list', $data);
        } catch (\Exception $e) {
            return response('error');
        }
    }

    public function loadMoreBlogList(Request $request)
    {
        try {
            $data['count'] = SmNews::count();
            $data['skip'] = $request->skip;
            $data['limit'] = $data['count'] - $data['skip'];
            $data['blogs'] = SmNews::skip($data['skip'])->where('school_id', app('school')->id)->take(5)->get();
            $html = view('frontEnd.theme.' . activeTheme() . '.read_more_blog_list', $data)->render();
            return response()->json(['success' => true, 'html' => $html, 'total_data' => $data['count']]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e]);
        }
    }
	
	public function sections()
	{
		try {
			
			$sections = SmStudentCategory::where('school_id', app('school')->id)->get();
			return view('frontEnd.theme.' . activeTheme() . '.sections', compact('sections'));
			} catch (\Exception $e) {
			Toastr::error($e->getMessage(), 'Failed');
			return redirect()->back();
		}
	}
	
	public function aboutus()
	{
		try {
			return view('frontEnd.theme.' . activeTheme() . '.aboutus');
			} catch (\Exception $e) {
			Toastr::error($e->getMessage(), 'Failed');
			return redirect()->back();
		}
	}
	
	public function photoGallery()
	{
		try {
			return view('frontEnd.theme.' . activeTheme() . '.photoGallery');
			} catch (\Exception $e) {
			Toastr::error($e->getMessage(), 'Failed');
			return redirect()->back();
		}
	}
	
	public function videoGallery()
	{
		try {
			return view('frontEnd.theme.' . activeTheme() . '.videoGallery');
			} catch (\Exception $e) {
			Toastr::error($e->getMessage(), 'Failed');
			return redirect()->back();
		}
	}
	
	public function onsiteNursery()
	{

        try {
    			$name = "حضانه";
    			$subscriptionWithOutOffer = SubscriptionPlan::where('category_id',2)->where('course_section',1)->where('type',2)->where('offer',2)->where('other_offers',0)->get();
    			$subscriptionType1 = SubscriptionPlan::where('category_id',2)->where('course_section',1)->where('type',2)->where('offer',2)->where('other_offers',1)->get();
    			$subscriptionType2 = SubscriptionPlan::where('category_id',2)->where('course_section',1)->where('type',2)->where('offer',2)->where('other_offers',2)->get();
    			$subscriptionWithOffer = SubscriptionPlan::where('category_id',2)->where('course_section',1)->where('type',2)->where('offer',1)->get();
    			$courses = SmCourse::where('category_id',2)->where('course_section',1)->first();
    			$category = SmStudentCategory::where('id',1)->first();
				$name = $category->category_name;
				$courseCategory = SmCourseCategory::where('id',2)->first();
    			return view('frontEnd.theme.' . activeTheme() . '.onlineSubscription',compact('courseCategory','subscriptionWithOutOffer','subscriptionWithOffer','courses','category','name','subscriptionType1','subscriptionType2'));
			} catch (\Exception $e) {
    			Toastr::error($e->getMessage(), 'Failed');
    			return redirect()->back();
		}
	}
	
	public function onsiteKg()
	{
		try {
			$name = "روضه";
			$subscriptionWithOutOffer = SubscriptionPlan::where('category_id',2)->where('course_section',2)->where('type',2)->where('offer',2)->where('other_offers',0)->get();
			$subscriptionType1 = SubscriptionPlan::where('category_id',2)->where('course_section',2)->where('type',2)->where('offer',2)->where('other_offers',1)->get();
    		$subscriptionType2 = SubscriptionPlan::where('category_id',2)->where('course_section',2)->where('type',2)->where('offer',2)->where('other_offers',2)->get();
    			
			$subscriptionWithOffer = SubscriptionPlan::where('category_id',2)->where('course_section',2)->where('type',2)->where('offer',1)->get();
			$courses = SmCourse::where('category_id',2)->where('course_section',2)->first();
			$category = SmStudentCategory::where('id',2)->first();
			$name = $category->category_name;
			$courseCategory = SmCourseCategory::where('id',2)->first();
			return view('frontEnd.theme.' . activeTheme() . '.onlineSubscription',compact('courseCategory','subscriptionWithOutOffer','subscriptionWithOffer','courses','category','name','subscriptionType1','subscriptionType2'));
			} catch (\Exception $e) {
			Toastr::error($e->getMessage(), 'Failed');
			return redirect()->back();
		}
	}
	
	public function intensiveEducationRemedial()
	{
		try {
			$name = "تربيه خاصه";
			$subscriptionWithOutOffer = SubscriptionPlan::where('category_id',2)->where('course_section',3)->where('type',2)->where('offer',2)->where('other_offers',0)->get();
			$subscriptionType1 = SubscriptionPlan::where('category_id',2)->where('course_section',3)->where('type',2)->where('offer',2)->where('other_offers',1)->get();
    		$subscriptionType2 = SubscriptionPlan::where('category_id',2)->where('course_section',3)->where('type',2)->where('offer',2)->where('other_offers',2)->get();
    			
			$subscriptionWithOffer = SubscriptionPlan::where('category_id',2)->where('course_section',3)->where('type',2)->where('offer',1)->get();
			$courses = SmCourse::where('category_id',2)->where('course_section',3)->first();
			$category = SmStudentCategory::where('id',3)->first();
			$name = $category->category_name;
			$courseCategory = SmCourseCategory::where('id',2)->first();
			return view('frontEnd.theme.' . activeTheme() . '.onlineSubscription',compact('courseCategory','subscriptionWithOutOffer','subscriptionWithOffer','courses','category','name','subscriptionType1','subscriptionType2'));
			} catch (\Exception $e) {
			Toastr::error($e->getMessage(), 'Failed');
			return redirect()->back();
		}
	}
	
	public function specialEducation()
	{
		try {
			$name = "التقويه";
			$subscriptionWithOutOffer = SubscriptionPlan::where('category_id',2)->where('course_section',4)->where('type',2)->where('offer',2)->where('other_offers',0)->get();
			$subscriptionType1 = SubscriptionPlan::where('category_id',2)->where('course_section',4)->where('type',2)->where('offer',2)->where('other_offers',1)->get();
    		$subscriptionType2 = SubscriptionPlan::where('category_id',2)->where('course_section',4)->where('type',2)->where('offer',2)->where('other_offers',2)->get();
			$subscriptionWithOffer = SubscriptionPlan::where('category_id',2)->where('course_section',4)->where('type',2)->where('offer',1)->get();
    			
			$courses = SmCourse::where('category_id',2)->where('course_section',4)->first();
			$category = SmStudentCategory::where('id',4)->first();
			$name = $category->category_name;
			$courseCategory = SmCourseCategory::where('id',2)->first();
			return view('frontEnd.theme.' . activeTheme() . '.onlineSubscription',compact('courseCategory','subscriptionWithOutOffer','subscriptionWithOffer','courses','category','name','subscriptionType1','subscriptionType2'));
			} catch (\Exception $e) {
			Toastr::error($e->getMessage(), 'Failed');
			return redirect()->back();
		}
	}
	
	public function onlineNursery()
	{
		try {
			$name = "الروضة والتمهيدي";
			$subscriptionWithOutOffer = SubscriptionPlan::where('category_id',1)->where('course_section',5)->where('type',2)->where('offer',2)->where('other_offers',0)->get();
			$subscriptionType1 = SubscriptionPlan::where('category_id',1)->where('course_section',5)->where('type',2)->where('offer',2)->where('other_offers',1)->get();
    		$subscriptionType2 = SubscriptionPlan::where('category_id',1)->where('course_section',5)->where('type',2)->where('offer',2)->where('other_offers',2)->get();
    			
			$subscriptionWithOffer = SubscriptionPlan::where('category_id',1)->where('course_section',5)->where('type',2)->where('offer',1)->get();
			$courses = SmCourse::where('category_id',1)->where('course_section',5)->first();
			$category = SmStudentCategory::where('id',5)->first();
			$name = $category->category_name;
			$courseCategory = SmCourseCategory::where('id',1)->first();
			return view('frontEnd.theme.' . activeTheme() . '.onlineSubscription',compact('courseCategory','subscriptionWithOutOffer','subscriptionWithOffer','courses','category','name','subscriptionType1','subscriptionType2'));
			} catch (\Exception $e) {
			Toastr::error($e->getMessage(), 'Failed');
			return redirect()->back();
		}
	}
	
	public function primaryStage()
	{
		try {
			$name = "تقوية مكثفة للمرحلة الابتدائية";
			$subscriptionWithOutOffer = SubscriptionPlan::where('category_id',1)->where('course_section',6)->where('type',2)->where('offer',2)->where('other_offers',0)->get();
			$subscriptionType1 = SubscriptionPlan::where('category_id',1)->where('course_section',6)->where('type',2)->where('offer',2)->where('other_offers',1)->get();
    		$subscriptionType2 = SubscriptionPlan::where('category_id',1)->where('course_section',6)->where('type',2)->where('offer',2)->where('other_offers',2)->get();
    			
			$subscriptionWithOffer = SubscriptionPlan::where('category_id',1)->where('course_section',6)->where('type',2)->where('offer',1)->get();
			$courses = SmCourse::where('category_id',1)->where('course_section',6)->first();
			$category = SmStudentCategory::where('id',6)->first();
			$name = $category->category_name;
			$courseCategory = SmCourseCategory::where('id',1)->first();
			return view('frontEnd.theme.' . activeTheme() . '.onlineSubscription',compact('courseCategory','subscriptionWithOutOffer','subscriptionWithOffer','courses','category','name','subscriptionType1','subscriptionType2'));
			} catch (\Exception $e) {
			Toastr::error($e->getMessage(), 'Failed');
			return redirect()->back();
		}
	}
	
	public function intermediateStage()
	{
		try {
			$name = "تقوية مكثفة للمرحلة المتوسطة";
			$subscriptionWithOutOffer = SubscriptionPlan::where('category_id',1)->where('course_section',7)->where('type',2)->where('offer',2)->where('other_offers',0)->get();
			$subscriptionType1 = SubscriptionPlan::where('category_id',1)->where('course_section',7)->where('type',2)->where('offer',2)->where('other_offers',1)->get();
    		$subscriptionType2 = SubscriptionPlan::where('category_id',1)->where('course_section',7)->where('type',2)->where('offer',2)->where('other_offers',2)->get();
    			
			$subscriptionWithOffer = SubscriptionPlan::where('category_id',1)->where('course_section',7)->where('type',2)->where('offer',1)->get();
			$courses = SmCourse::where('category_id',1)->where('course_section',7)->first();
			$category = SmStudentCategory::where('id',7)->first();
			$name = $category->category_name;
			$courseCategory = SmCourseCategory::where('id',1)->first();
			return view('frontEnd.theme.' . activeTheme() . '.onlineSubscription',compact('courseCategory','subscriptionWithOutOffer','subscriptionWithOffer','courses','category','name','subscriptionType1','subscriptionType2'));
			} catch (\Exception $e) {
			Toastr::error($e->getMessage(), 'Failed');
			return redirect()->back();
		}
	}
	
	public function secondaryStage()
	{
		try {
			$name = "تقوية مكثفة للمرحلة الثانوية";
			$subscriptionWithOutOffer = SubscriptionPlan::where('category_id',1)->where('course_section',8)->where('type',2)->where('offer',2)->where('other_offers',0)->get();
			$subscriptionType1 = SubscriptionPlan::where('category_id',1)->where('course_section',8)->where('type',2)->where('offer',2)->where('other_offers',1)->get();
    		$subscriptionType2 = SubscriptionPlan::where('category_id',1)->where('course_section',8)->where('type',2)->where('offer',2)->where('other_offers',2)->get();
    			
			$subscriptionWithOffer = SubscriptionPlan::where('category_id',1)->where('course_section',8)->where('type',2)->where('offer',1)->get();
			$courses = SmCourse::where('category_id',1)->where('course_section',8)->first();
			$category = SmStudentCategory::where('id',8)->first();
			$name = $category->category_name;
			$courseCategory = SmCourseCategory::where('id',1)->first();
			return view('frontEnd.theme.' . activeTheme() . '.onlineSubscription',compact('courseCategory','subscriptionWithOutOffer','subscriptionWithOffer','courses','category','name','subscriptionType1','subscriptionType2'));
			} catch (\Exception $e) {
			Toastr::error($e->getMessage(), 'Failed');
			return redirect()->back();
		}
	}
	
	public function undergraduateStage()
	{
		try {
			$name = "تقوية مكثفة للمرحلة الجامعية";
			$subscriptionWithOutOffer = SubscriptionPlan::where('category_id',1)->where('course_section',9)->where('type',2)->where('offer',2)->where('other_offers',0)->get();
			$subscriptionType1 = SubscriptionPlan::where('category_id',1)->where('course_section',9)->where('type',2)->where('offer',2)->where('other_offers',1)->get();
    		$subscriptionType2 = SubscriptionPlan::where('category_id',1)->where('course_section',9)->where('type',2)->where('offer',2)->where('other_offers',2)->get();
			$subscriptionWithOffer = SubscriptionPlan::where('category_id',1)->where('course_section',9)->where('type',2)->where('offer',1)->get();
			$courses = SmCourse::where('category_id',1)->where('course_section',9)->first();
			$category = SmStudentCategory::where('id',9)->first();
			$name = $category->category_name;
			$courseCategory = SmCourseCategory::where('id',1)->first();
			return view('frontEnd.theme.' . activeTheme() . '.onlineSubscription',compact('courseCategory','subscriptionWithOutOffer','subscriptionWithOffer','courses','category','name','subscriptionType1','subscriptionType2'));
			} catch (\Exception $e) {
			Toastr::error($e->getMessage(), 'Failed');
			return redirect()->back();
		}
	}
	
	public function contactus()
	{
		try {
			return view('frontEnd.theme.' . activeTheme() . '.contactus');
			} catch (\Exception $e) {
			Toastr::error($e->getMessage(), 'Failed');
			return redirect()->back();
		}
	}
	
	public function sectionDetails(Request $request)
	{
		try {
			$courses = SmCourse::where('course_section', $request->id)->where('school_id', app('school')->id)->get();
			if($courses->isEmpty()) {
				Toastr::error('Sorry! Course are not available for this section', 'Failed');
				return redirect()->back();
			}
			return view('frontEnd.theme.' . activeTheme() . '.sectiondetails', compact('courses'));
			} catch (\Exception $e) {
			Toastr::error('Operation Failed', 'Failed');
			return redirect()->back();
		}
	}
}
