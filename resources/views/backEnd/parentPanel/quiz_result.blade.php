@extends('backEnd.master')
@section('title')
    @lang('quiz.quiz_result')
@endsection

@section('mainContent')
<div class="row">    
    <div class="col-lg-3 col-md-6">
        <div class="white-box single-summery">
            <div class="d-flex justify-content-between">
                <div>
                    <h3>@lang('quiz.result')</h3>
                </div>
                <div>
                    <h3>@lang('quiz.quiz_name'): {{$quiz_data->name}}</h3>
                </div>
                <h1 class="gradient-color2">
                    Score: {{ $result->score }}%
                </h1>
                <div>
                    <p>Quiz taken on: {{ $result->created_at->diffForHumans() }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection