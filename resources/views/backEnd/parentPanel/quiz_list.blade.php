@extends('backEnd.master')
@section('title')
    @lang('quiz.quiz_list')
@endsection

@section('mainContent')
    <section class="sms-breadcrumb mb-40 white-box">
        <div class="container-fluid">
            <div class="row justify-content-between">
                <h1>@lang('quiz.quiz_list')</h1>
                <div class="bc-pages">
                    <a href="{{ route('parent-dashboard') }}">@lang('common.dashboard')</a>
                    <a href="#">@lang('quiz.quiz')</a>
                    <a href="#">@lang('quiz.quiz_list')</a>
                </div>
            </div>
        </div>
    </section>
    <section class="admin-visitor-area">
        <div class="container-fluid p-0">
            <div class="row">
                <div class="col-lg-12 mt-40">
                    <div class="row">
                        <div class="col-lg-12">
                            <x-table>
                                <table id="table_id" class="table" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>@lang('common.sl')</th>
                                            <th>@lang('quiz.quiz_name')</th>
                                            <th>@lang('quiz.time')</th>
                                            <th>@lang('common.action')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($quiz_data as $key=> $value)
                                            <tr>
                                                <td>{{ $key+1 }}</td>
                                                <td>{{ $value->name}}</td>
                                                <td>{{ $value->total_question_time }} Min.</td>
                                                <td>
                                                @if($value->is_taken)

                                                    <a href="{{ route('show_quiz_result', ['quiz_id' => Crypt::encrypt($value->id), 'student_id' => Crypt::encrypt($student_records->student_id)]) }}" class="btn btn-primary">
                                                    <button class="btn btn-primary" type="submit">Show Result</button></a>
                                                @else
                                                    <a href="{{ route('start_quiz', ['id' => Crypt::encrypt($value->id), 'student_id' => Crypt::encrypt($student_records->student_id)]) }}" class="btn btn-primary"><button class="btn btn-primary" type="submit">Take Quiz</button></a>
                                                @endif
                                            </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </x-table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- content goes here -->


@endsection