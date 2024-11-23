<?php

namespace App\Http\Controllers\Parent;


use App\User;
use App\SmExam;
use App\Quiz;
use App\QuizCategory;
use App\QuizQuestionOptions;
use App\QuizQuestionAnswer;
use App\SmClass;
use App\SmCourse;
use App\SmParent;
use App\QuizResult;
use App\Models\StudentRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Scopes\GlobalAcademicScope;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Validator;
use Auth;
use Illuminate\Support\Facades\Crypt;

class QuizController extends Controller
{
    public function __construct()
    {
        $this->middleware('PM');
        // User::checkAuth();
    }   

    public function quizList()
    {
        try {
            $user = Auth::user();
            $data = SmParent::where('user_id',$user->id)->first();
            $student_records = StudentRecord::where('student_id',$data->id)->first();
            /*fetching quiz */
            $quiz_data = Quiz::where(['class' => $student_records->class_id, 'course' => $student_records->course_id])
                ->has('questions') //check if there any questions added to this
                ->with('questions')
                ->orderBy('id','DESC')
                ->get();

            foreach ($quiz_data as $quiz) {
                $quiz->is_taken = QuizResult::where('student_id', $data->id)
                                             ->where('quiz_id', $quiz->id)
                                             ->exists();
            }


            return view('backEnd.parentPanel.quiz_list', compact('user','student_records','quiz_data'));
        } catch (Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
        
    }

    public function startQuiz($quiz_id,$student_id)
    {
        try {

            $id = Crypt::decrypt($quiz_id);
            $quiz = Quiz::with('questions.options')->findOrFail($id);
            return view('backEnd.parentPanel.start_quiz', compact('quiz','student_id','id'));   
        } catch (Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function submitQuiz(Request $request, $id)
    {
        try {
            $studentId = Crypt::decrypt($request->input('student_id'));
            $quizId = Crypt::decrypt($request->input('quiz_id'));
            $answers = $request->input('answers', []);

            // Retrieve the quiz questions and correct answers
            $questions = QuizQuestionAnswer::where('quiz_id', $quizId)->get();
            $correctAnswersCount = 0;

            foreach ($questions as $question) {
                if (isset($answers[$question->id]) && $question->is_correct == $answers[$question->id]) {
                    $correctAnswersCount++;
                }
            }

            $totalQuestions = count($questions);
            $score = ($totalQuestions > 0) ? ($correctAnswersCount / $totalQuestions) * 100 : 0;

            // Store the result
            QuizResult::create([
                'student_id' => $studentId,
                'quiz_id' => $quizId,
                'score' => $score,
            ]);

            Toastr::success('Operation Successful', 'Success');
            return redirect('quiz_list');
        } catch (Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }


    public function showQuizResult($quiz_id, $student_id)
    {
        try {
            $quizId = Crypt::decrypt($quiz_id);
            $studentId = Crypt::decrypt($student_id);


            $quiz_data = Quiz::where('id',$quizId)->first();

            $result = QuizResult::where('student_id', $studentId)->where('quiz_id', $quizId)->first();

            if (!$result) {
                return redirect()->route('quiz_list')->with('error', 'Quiz result not found.');
            }

            return view('backEnd.parentPanel.quiz_result', compact('result','quiz_data'));   
        } catch (Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
        
    }





}