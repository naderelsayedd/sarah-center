<?php

namespace App\Http\Controllers\Admin\Quiz;

use App\User;
use App\SmExam;
use App\Quiz;
use App\QuizCategory;
use App\QuizQuestionOptions;
use App\QuizQuestionAnswer;
use App\SmClass;
use App\SmCourse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Scopes\GlobalAcademicScope;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Validator;


class QuizController extends Controller
{
    public function __construct()
	{
        $this->middleware('PM');
        // User::checkAuth();
	}
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
               	$quiz_categories = QuizCategory::orderBy('id', 'DESC')->get();
            	return view('backEnd.quiz.quiz_category', compact('quiz_categories'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function quizCategoryUpdate(Request $request)
    {
    	try {
            $student_type = QuizCategory::find($request->id);
            $student_type->name = $request->category;
            $student_type->save();

            Toastr::success('Operation Successful', 'Success');
            return redirect('quiz_category');
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function quizCategoryStore(Request $request)
    {
    	try {
			$validator = Validator::make($request->all(), [
				'category' => 'required|unique:quiz_categories,name',
			]);

			if ($validator->fails()) {
				return back()->withErrors($validator->errors()->first())->withInput();
			}else{
				$quiz_category = new QuizCategory();
				$quiz_category->name = $request->category;
				$quiz_category->description = null;
				if ($quiz_category->save()) {
					Toastr::success('Operation Successful', 'Success');
            		return redirect()->back();
				}else{
					Toastr::error('Operation Failed', 'Failed');
            		return redirect()->back();
				}
			}
    	} catch (Exception $e) {
    		Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();	
    	}
    }

    public function quizCategoryEdit(Request $request, $id)
    {
        try {
            $category = QuizCategory::find($id);
            $quiz_categories = QuizCategory::get();
            return view('backEnd.quiz.quiz_category', compact('quiz_categories', 'category'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }


    public function quizCategoryDelete($id)
    {
        try {
            $data = Quiz::where('category_id',$id)->count();
            try {
                if ($data==0) {
                    QuizCategory::find($id)->delete();
                } else {
                    $msg = 'This data already used in use. Please remove those data first';
                    Toastr::error($msg, 'Failed');
                    return redirect()->back();
                }
                Toastr::success('Operation successful', 'Success');
                return redirect()->back();
            } catch (\Illuminate\Database\QueryException $e) {
                $msg = 'This data already used in use. Please remove those data first';
                Toastr::error($msg, 'Failed');
                return redirect()->back();
            } catch (\Exception $e) {
                Toastr::error('Operation Failed', 'Failed');
                return redirect()->back();
            }
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function createQuiz($value='')
    {
    	try {
               	$quizzes = Quiz::orderBy('id','DESC')->get();
               	$quiz_category = QuizCategory::get();
                $classes = SmClass::where('active_status',1)->get();
            	return view('backEnd.quiz.quiz_create', compact('quizzes','quiz_category','classes'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function getCourses(Request $request)
    {
        $class_id = $request->class_id;
        $courses = SmCourse::where('class_id', $class_id)->where('active_status',1)->pluck('title', 'id');
        return response()->json($courses);
    }

    public function quizStore(Request $request)
    {
    	try {
			$validator = Validator::make($request->all(), [
				'name' => 'required|unique:quizzes,name',
				'quiz_category' => 'required|exists:quiz_categories,id',
                'class' => 'required',
                'course' => 'required'
			]);

			if ($validator->fails()) {
				return back()->withErrors($validator->errors()->first())->withInput();
			}else{
				$quiz = new Quiz();
				$quiz->name = $request->name;
				$quiz->category_id = $request->quiz_category;
                $quiz->class = $request->class;
                $quiz->course = $request->course;
				$quiz->description = null;
				if ($quiz->save()) {
					Toastr::success('Operation Successful', 'Success');
            		return redirect()->back();
				}else{
					Toastr::error('Operation Failed', 'Failed');
            		return redirect()->back();
				}
			}
    	} catch (Exception $e) {
    		Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();	
    	}
    }

    public function quizEdit(Request $request, $id)
    {
        try {
            $quiz = Quiz::find($id);
            $quizzes = Quiz::get();
            $quiz_category = QuizCategory::get();
            return view('backEnd.quiz.quiz_create', compact('quizzes', 'quiz','quiz_category'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function quizUpdate(Request $request)
    {
    	try {
    		$validator = Validator::make($request->all(), [
				'name' => 'required',
				'quiz_category' => 'required|exists:quiz_categories,id',
			]);

			if ($validator->fails()) {
				return back()->withErrors($validator->errors()->first())->withInput();
			}else{
	            $quiz = Quiz::find($request->id);
	            $quiz->name = $request->name;
	            $quiz->category_id = $request->quiz_category;
	            $quiz->save();

	            Toastr::success('Operation Successful', 'Success');
	            return redirect('quiz');
			}


        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function quizDelete($id)
    {
        try {
            $quiz = Quiz::find($id)->delete();
        	//$quiz_questions = QuizQuestionAnswer::where('quiz_id',$id)->delete();
            Toastr::success('Operation successful', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function addQuestion($id)
    {
        try {
               	$questions = QuizQuestionAnswer::where('quiz_id',$id)->orderBy('id','DESC')->get();
            	return view('backEnd.quiz.add_question', compact('questions','id'));
        } catch (\Exception $e) {        	
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function questionStore(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'question'      => 'required',
                'option_first'  => 'required',
                'option_second' => 'required',
                'option_third'  => 'required',
                'option_fourth' => 'required',
                'question_time' => 'required',
                'answer'        => 'required',
                'quiz_id'       => 'required|exists:quizzes,id',
                'image'         => 'sometimes|required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            if ($validator->fails()) {
                return back()->withErrors($validator->errors()->first())->withInput();
            }else{
                /*store question first*/
                $question = new QuizQuestionAnswer();
                $question->question_text = $request->question;
                $question->is_correct = $request->answer;
                $question->question_time = $request->question_time;
                $question->quiz_id = $request->quiz_id;
                if (isset($request->image)) {
                    // Store the uploaded image
                    $imageName = time().'.'.$request->image->extension();  
                    $request->image->move(public_path('question_image'), $imageName);
                    $question->image_url = 'question_image/'.$imageName;
                }


                $qes = $question->save();
                /*get last inserted id of the question*/
                $question_id = $question->id;
                /*store options of the question*/
                $options = new QuizQuestionOptions();
                $options->quiz_id = $request->quiz_id;
                $options->question_id = $question_id;
                $options->first_option = $request->option_first;
                $options->second_option = $request->option_second;
                $options->third_option = $request->option_third;
                $options->fourth_option = $request->option_fourth;
                $opt = $options->save();
                if ($qes && $opt) {
                    Toastr::success('Operation Successful', 'Success');
                    return redirect()->back();
                }else{
                    Toastr::error('Operation Failed', 'Failed');
                    return redirect()->back();
                }
            }
        } catch (Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();  
        }
    }

    public function questionEdit(Request $request, $id)
    {
        //echo $id."<pre>";print_r($request->all());die;
        try {
            $question = QuizQuestionAnswer::find($id)->with('options')->first();
            $questions = QuizQuestionAnswer::get();
            return view('backEnd.quiz.add_question', compact('question', 'questions'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function questionUpdate (Request $request){
        try {
            $validator = Validator::make($request->all(), [
                'question'      => 'required',
                'option_first'  => 'required',
                'option_second' => 'required',
                'option_third'  => 'required',
                'option_fourth' => 'required',
                'question_time' => 'required',
                'answer'        => 'required',
                'image'         => 'sometimes|required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            if ($validator->fails()) {
                return back()->withErrors($validator->errors()->first())->withInput();
            }else{
                /*store question first*/
                $question                   = QuizQuestionAnswer::where('id',$request->id)->first();
                $question->question_text    = $request->question;
                $question->is_correct       = $request->answer;
                $question->question_time    = $request->question_time;
                
                
                if (isset($request->image)) {
                    // Store the uploaded image
                    $imageName = time().'.'.$request->image->extension();  
                    $request->image->move(public_path('question_image'), $imageName);
                    $question->image_url = 'question_image/'.$imageName;
                }
                $qes = $question->save();
                /*get last inserted id of the question*/
                $question_id = $question->id;
                /*store options of the question*/
                $options  = QuizQuestionOptions::where('question_id',$request->id)->first();
                $options->first_option  = $request->option_first;
                $options->second_option = $request->option_second;
                $options->third_option  = $request->option_third;
                $options->fourth_option = $request->option_fourth;
                $opt                    = $options->save();
                if ($qes && $opt) {
                    Toastr::success('Operation Successful', 'Success');
                    return redirect()->route('add_question',['id' => $request->quiz_id]);
                }else{
                    Toastr::error('Operation Failed', 'Failed');
                    return redirect()->back();
                }
            }

        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function questionDelete($id){
        try {
                QuizQuestionAnswer::find($id)->delete();
                QuizQuestionOptions::where('question_id',$id)->delete();  
            Toastr::success('Operation successful', 'Success');
            return redirect()->route('quiz');
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }
}