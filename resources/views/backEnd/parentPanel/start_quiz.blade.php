@extends('backEnd.master')
@section('title')
    @lang('quiz.start_quiz')
@endsection
<style type="text/css">
    .timer{
        font-size: 20px !important;
        color: #212529 !important;
    }
</style>
@section('mainContent')
<div class="container mt-5">
    <div class="text-center mb-4">
        <h1>{{ $quiz->name }}</h1>
        <p>Total Time: {{ $quiz->total_question_time }} Min.</p>
    </div>

    <div id="quiz-container">
        <form action="{{ route('submit_quiz', $quiz->id) }}" method="POST" id="quiz-form">
            @csrf
            <input type="hidden" name="student_id" value="{{ $student_id }}">
            <input type="hidden" name="quiz_id" value="{{ Crypt::encrypt($id) }}">
            @foreach($quiz->questions as $index => $question)
                <div class="card question mb-4" data-question-id="{{ $index }}" data-question-time="{{ $question->question_time }}">
                    <div class="card-body">
                        <h3 class="card-title">Question: {{ $question->question_text }}</h3>
                        @if($question->image_url)
                            <img src="{{ asset('public/'.$question->image_url) }}" alt="Question Image" class="img-fluid mb-3">
                        @endif

                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="answers[{{ $question->id }}]" id="option1_{{ $index }}" value="1">
                            <label class="form-check-label" for="option1_{{ $index }}">
                                {{ $question->options[0]->first_option }}
                            </label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="answers[{{ $question->id }}]" id="option2_{{ $index }}" value="2">
                            <label class="form-check-label" for="option2_{{ $index }}">
                                {{ $question->options[0]->second_option }}
                            </label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="answers[{{ $question->id }}]" id="option3_{{ $index }}" value="3">
                            <label class="form-check-label" for="option3_{{ $index }}">
                                {{ $question->options[0]->third_option }}
                            </label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="answers[{{ $question->id }}]" id="option4_{{ $index }}" value="4">
                            <label class="form-check-label" for="option4_{{ $index }}">
                                {{ $question->options[0]->fourth_option }}
                            </label>
                        </div>


                        <div id="timer_next_button" class="mt-3 d-flex justify-content-between align-items-center">
                            <button type="button" class="btn btn-primary next-question">Next</button>
                            <div class="timer">Time left: <span class="time-left"></span></div>
                        </div>
                    </div>
                </div>
            @endforeach
            <button type="submit" class="btn btn-primary" id="submit-quiz" style="display: none;">Submit Quiz</button>
        </form>
    </div>
</div>



<script>
    document.addEventListener('DOMContentLoaded', function () {
        const questions = document.querySelectorAll('.question');
        let currentQuestionIndex = 0;
        let timer;

        function showQuestion(index) {
            questions.forEach((question, i) => {
                question.style.display = i === index ? 'block' : 'none';
            });
            startTimer(index);
        }

        function startTimer(index) {
            clearInterval(timer);
            let timeLeft = parseInt(questions[index].dataset.questionTime) * 60; // Convert minutes to seconds
            const timeLeftSpan = questions[index].querySelector('.time-left');

            timer = setInterval(() => {
                if (timeLeft <= 0) {
                    clearInterval(timer);
                    nextQuestion();
                } else {
                    const minutes = Math.floor(timeLeft / 60);
                    const seconds = timeLeft % 60;

                    timeLeftSpan.textContent = minutes.toString().padStart(2, '0') + ':' + seconds.toString().padStart(2, '0');
                    timeLeft--;
                }
            }, 1000);
        }

        function nextQuestion() {
            if (currentQuestionIndex < questions.length - 1) {
                currentQuestionIndex++;
                showQuestion(currentQuestionIndex);
            } else {
                document.getElementById('submit-quiz').style.display = 'block';
                document.getElementById('timer_next_button').style.display = 'none';
            }
        }

        document.querySelectorAll('.next-question').forEach(button => {
            button.addEventListener('click', () => {
                nextQuestion();
            });
        });

        showQuestion(currentQuestionIndex);
    });
</script>
@endsection
