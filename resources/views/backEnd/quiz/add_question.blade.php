@extends('backEnd.master')
@section('title') 
@lang('quiz.create_quiz')
@endsection
@section('mainContent')

<style type="text/css">
    /*for action pencil and delete button*/
    .ti-view-grid:before, .ti-pencil:before, .ti-trash:before {
        font-size: 15px;
        color: #000;
    }
    .primary_input_field{
        margin-bottom: 14px;
    }
</style>
@php
    $breadCrumbs = 
    [
        'h1'=> __('quiz.question_list'),
        'bcPages'=> [               
                '<a href="#">'.__('quiz.quiz').'</a>',
                ],
    ];
@endphp
<x-bread-crumb-component :breadCrumbs="$breadCrumbs" />
<section class="admin-visitor-area up_st_admin_visitor">
    <div class="container-fluid p-0">
        <div class="row">
            <div class="col-lg-12" style="margin-bottom: 30px;">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="main-title">
                            <h3 class="mb-30">
                                @if(isset($questions))
                                    @lang('quiz.add_question')
                                @else
                                    @lang('quiz.edit_question')
                                @endif
                            </h3>
                        </div>
                        @if(isset($question))
                            {{ Form::open(['class' => 'form-horizontal', 'route' => 'question_update', 'method' => 'POST', 'enctype' => "multipart/form-data"]) }}
                        @else
                            @if(userPermission('question_store'))
                                {{Form::open(['class' => 'form-horizontal', 'route' => 'question_store', 'method' => 'POST', 'enctype' => "multipart/form-data"])}}
                            @endif
                        @endif
                        <div class="white-box">
                            <div class="add-visitor">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="primary_input">
                                            <label class="primary_input_label" for="">@lang('quiz.add_question') <span class="text-danger"> *</span></label>
                                            <textarea class="form-control {{ $errors->has('question_text') ? ' is-invalid' : '' }}" name="question" rows="4">{{isset($question)? $question->question_text:''}}</textarea>
                                            @if ($errors->has('question_text'))
                                                <span class="text-danger" >
                                                    {{ $errors->first('question_text') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <!-- option first -->
                                            <label class="primary_input_label" for="">@lang('quiz.option_first') <span
                                                class="text-danger"> *</span> </label>


                                            <input class="primary_input_field form-control {{ $errors->has('option_first') ? ' is-invalid' : '' }}"
                                                type="text" name="option_first" autocomplete="off" value="{{isset($question)? $question->options[0]->first_option:''}}">
                                            @if ($errors->has('option_first'))
                                                <span class="text-danger" >
                                                    {{ $errors->first('option_first') }}
                                                </span>
                                            @endif
                                    </div>
                                    <div class="col-lg-3">

                                            <!-- option second -->
                                            <label class="primary_input_label" for="">@lang('quiz.option_second') <span
                                                class="text-danger"> *</span> </label>
                                            <input class="primary_input_field form-control {{ $errors->has('option_second') ? ' is-invalid' : '' }}"
                                                type="text" name="option_second" autocomplete="off" value="{{isset($question)? $question->options[0]->second_option:''}}">
                                            @if ($errors->has('option_second'))
                                                <span class="text-danger" >
                                                    {{ $errors->first('option_second') }}
                                                </span>
                                            @endif
                                    </div>
                                    <div class="col-lg-3">
                                             <!-- option third -->
                                            <label class="primary_input_label" for="">@lang('quiz.option_third') <span
                                                class="text-danger"> *</span> </label>
                                            <input class="primary_input_field form-control {{ $errors->has('option_third') ? ' is-invalid' : '' }}"
                                                type="text" name="option_third" autocomplete="off" value="{{isset($question)? $question->options[0]->third_option:''}}">
                                            @if ($errors->has('option_third'))
                                                <span class="text-danger" >
                                                    {{ $errors->first('option_third') }}
                                                </span>
                                            @endif
                                    </div>
                                    <div class="col-lg-3">
                                            <!-- option fourth -->
                                            <label class="primary_input_label" for="">@lang('quiz.option_fourth') <span
                                                class="text-danger"> *</span> </label>
                                            <input class="primary_input_field form-control {{ $errors->has('option_fourth') ? ' is-invalid' : '' }}"
                                                type="text" name="option_fourth" autocomplete="off" value="{{isset($question)? $question->options[0]->fourth_option:''}}">
                                            @if ($errors->has('option_fourth'))
                                                <span class="text-danger" >
                                                    {{ $errors->first('option_fourth') }}
                                                </span>
                                            @endif
                                    </div>
                                    <div class="col-lg-4">
                                        <!-- option fourth -->
                                            <label class="primary_input_label" for="">@lang('quiz.question_time') (@lang('quiz.in_minutes'))<span
                                                class="text-danger"> *</span> </label>
                                            <input class="primary_input_field form-control {{ $errors->has('question_time') ? ' is-invalid' : '' }}"
                                                type="text" name="question_time" autocomplete="off" value="{{isset($question)? $question->question_time:''}}">
                                            @if ($errors->has('question_time'))
                                                <span class="text-danger" >
                                                    {{ $errors->first('question_time') }}
                                                </span>
                                            @endif
                                    </div>
                                    <div class="col-lg-4">
                                         <!-- question image -->
                                            <label class="primary_input_label" for="">@lang('quiz.image') <span
                                                class="text-danger"> *</span>@if(isset($question))
                                            <a href="javascript:void(0);" data-toggle="modal" data-target="#imageModal">
                                                Show Image
                                            </a>
                                            @endif </label>
                                            <input class="primary_input_field form-control {{ $errors->has('image') ? ' is-invalid' : '' }}"
                                                type="file" name="image" autocomplete="off" value="{{isset($question)? $question->image:''}}">
                                            @if ($errors->has('image'))
                                                <span class="text-danger" >
                                                    {{ $errors->first('image') }}
                                                </span>
                                            @endif
                                    </div>
                                    <div class="col-lg-4">
                                            <label class="primary_input_label" for="">@lang('quiz.answer') <span
                                                class="text-danger"> *</span> </label>
                                                <?php $opt_val = 0; 
                                                    if(isset($question->is_correct)){
                                                        $opt_val = $question->is_correct;
                                                    }
                                                ?>
                                            <select class="primary_select" name="answer">
                                                <option selected disabled>Choose Option</option>
                                                <option {{($opt_val == 1)? 'selected': ''}} value="1">First</option>
                                                <option {{($opt_val == 2)? 'selected': ''}} value="2">Second</option>
                                                <option {{($opt_val == 3)? 'selected': ''}} value="3">Third</option>
                                                <option {{($opt_val == 4)? 'selected': ''}} value="4">Fourth</option>
                                            </select> 
                                            <input type="hidden" name="quiz_id" value="{{isset($id)? $id: $question->quiz_id}}">

                                            <input type="hidden" name="id" value="{{isset($question)? $question->id: ''}}">
                                    </div>      
                                </div>
                                 @php 
                                  $tooltip = "";
                                  if(userPermission('question_store')){
                                        $tooltip = "";
                                    }else{
                                        $tooltip = "You have no permission to add";
                                    }
                                @endphp
                                <div class="row mt-40">
                                    <div class="col-lg-12 text-center">
                                       <button class="primary-btn fix-gr-bg submit" data-toggle="tooltip" title="{{$tooltip}}">
                                            <span class="ti-check"></span>
                                            @if(isset($question))
                                                @lang('quiz.update_question')
                                            @else
                                                @lang('quiz.save_question')
                                            @endif
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-4 no-gutters">
                        <div class="main-title">
                            <h3 class="mb-0">@lang('quiz.question_list')</h3>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <x-table>
                            <table id="table_id" class="table" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>@lang('common.sl')</th>
                                        <th>@lang('quiz.question_text')</th>
                                        <th>@lang('common.actions')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($questions as $key => $question)
                                        <tr>
                                            <td>{{$key+1}}</td>
                                            <td>{{$question->question_text}}</td>
                                            <td>
                                                @php
													echo $btn =  (userPermission('question_edit') ?
                                                    '<a class="primary-btn small fix-gr-bg"  href="' . route('question_edit', [$question->id]) . '" title="'.__('common.edit').'"><i class="ti-pencil" style="font-size: 20px;"></i></a><br>':'').
                                                    (userPermission('quiz_delete') ?
                                                    '<a  class="primary-btn small fix-gr-bg"  data-toggle="modal"  data-target="#deleteStudentTypeModal'.$question->id.'"  title="'. __('common.delete') .'" ><i class="ti-trash" style="font-size: 20px;"></i></a>' : '');
                                                    /*$routeList =[
                                                        (userPermission('question_edit')) ?
                                                        '<a class="dropdown-item" href="'.route('question_edit', [$question->id]).'">'.__('common.edit').'</a>' : null,
                                                        (userPermission('quiz_delete')) ?
                                                        '<a class="dropdown-item" data-toggle="modal" data-target="#deleteStudentTypeModal'.$question->id.'"
                                                            href="#">'.__('common.delete').'</a>' : null,
                                                    ];*/
                                                @endphp
                                                <?php /*<x-drop-down-action-component :routeList="$routeList"/> */?>
                                            </td>
                                        </tr>
                                        <div class="modal fade admin-query" id="deleteStudentTypeModal{{$question->id}}" >
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">@lang('quiz.delete_question')</h4>
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="text-center">
                                                            <h4>@lang('common.are_you_sure_to_delete')</h4>
                                                        </div>
                                                        <div class="mt-40 d-flex justify-content-between">
                                                            <button type="button" class="primary-btn tr-bg" data-dismiss="modal">@lang('common.cancel')</button>
                                                            <a href="{{route('question_delete', [$question->id])}}"><button class="primary-btn fix-gr-bg" type="submit">@lang('common.delete')</button></a>
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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
@if(isset($question))
<!-- Modal for displaying the image -->
<!-- Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Image</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <img id="modalImage" src="{{isset($question)? asset('public/'.$question->image_url): ''}}" class="img-fluid">
            </div>
        </div>
    </div>
</div>
<!-- JavaScript to handle modal functionality -->
<script>
    function showImage(imagePath) {
        $('#modalImage').attr('src', imagePath);
        $('#imageModal').modal('show');
    }
</script>
@endif
@endsection
@include('backEnd.partials.data_table_js')