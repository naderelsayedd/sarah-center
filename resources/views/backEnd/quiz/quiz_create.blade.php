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
    #select_box_padding{
        margin-bottom: 20% !important;
    }
</style>
@php
    $breadCrumbs = 
    [
        'h1'=> __('quiz.quiz_list'),
        'bcPages'=> [               
                '<a href="#">'.__('quiz.quiz').'</a>',
                ],
    ];
@endphp
<x-bread-crumb-component :breadCrumbs="$breadCrumbs" />
<section class="admin-visitor-area up_st_admin_visitor">
    <div class="container-fluid p-0">
        <div class="row">
            <div class="col-lg-3">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="main-title">
                            <h3 class="mb-30">
                                @if(isset($quizzes))
                                    @lang('quiz.add_quiz')
                                @else
                                    @lang('quiz.edit_quiz')
                                @endif
                            </h3>
                        </div>
                        @if(isset($quiz))
                            {{ Form::open(['class' => 'form-horizontal', 'route' => 'quiz_update', 'method' => 'POST']) }}
                        @else
                            @if(userPermission('quiz_store'))
                                {{Form::open(['class' => 'form-horizontal', 'route' => 'quiz_store', 'method' => 'POST'])}}
                            @endif
                        @endif
                        <div class="white-box">
                            <div class="add-visitor">
                                <div class="row">
                                    <div class="col-lg-12">
                                      
                                        <div class="primary_input">
                                            <label class="primary_input_label" for="">@lang('quiz.add_quiz') <span class="text-danger"> *</span></label>
                                            <input class="primary_input_field form-control {{ $errors->has('name') ? ' is-invalid' : '' }}"
                                                type="text" name="name" autocomplete="off" value="{{isset($quiz)? $quiz->name:''}}" placeholder="Quiz Name">
                                                @if($errors->has('name'))
                                                    <span class="text-danger" >
                                                        {{ $errors->first('name') }}
                                                    </span>
                                                @endif

                                                <div id="select_box_padding">
                                                    <select class="primary_select" id="class_select" name="class">
                                                            <option selected disabled>Select Class</option>
                                                        @foreach($classes as $key => $class)
                                                            <option value="{{$class->id}}"
                                                                <?php if(isset($quiz)){?>
                                                                    {{($quiz->class ==$class->id)?'selected':''}}
                                                                <?php } ?>
                                                                >{{$class->class_name}}</option>
                                                                }
                                                        @endforeach
                                                    </select>
                                                    @if($errors->has('class'))
                                                        <span class="text-danger" >
                                                            {{ $errors->first('class') }}
                                                        </span>
                                                    @endif <br>
                                                </div>

                                                <div id="select_box_padding">
                                                    <select class="primary_select" name="course" id="course_select">
                                                        <option selected disabled>Select Course</option> 
                                                    </select> <br>
                                                </div>
    
                                                <div id="select_box_padding">
                                                    <select class="primary_select" name="quiz_category">
                                                            <option selected disabled>Select Option</option>
                                                        @foreach($quiz_category as $key => $category)
                                                            <option value="{{$category->id}}"
                                                                <?php if(isset($quiz)){?>
                                                                    {{($quiz->category_id ==$category->id)?'selected':''}}
                                                                <?php } ?>

                                                            
                                                                >{{$category->name}}</option>
                                                                }
                                                        @endforeach
                                                    </select>
                                                    @if($errors->has('quiz_category'))
                                                        <span class="text-danger" >
                                                            {{ $errors->first('quiz_category') }}
                                                        </span>
                                                    @endif <br>
                                                </div>
                                                <input type="hidden" name="id" value="{{isset($quiz)? $quiz->id: ''}}">
                                            
                                        </div>
                                        
                                    </div>
                                </div>
                                 @php 
                                  $tooltip = "";
                                  if(userPermission('quiz_store')){
                                        $tooltip = "";
                                    }else{
                                        $tooltip = "You have no permission to add";
                                    }
                                @endphp
                                <div class="row mt-40">
                                    <div class="col-lg-12 text-center">
                                       <button class="primary-btn fix-gr-bg submit" data-toggle="tooltip" title="{{$tooltip}}">
                                            <span class="ti-check"></span>
                                            @if(isset($quiz))
                                                @lang('quiz.update_quiz')
                                            @else
                                                @lang('quiz.save_quiz')
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
            
            <div class="col-lg-9">
                <div class="row">
                    <div class="col-lg-4 no-gutters">
                        <div class="main-title">
                            <h3 class="mb-0">@lang('quiz.quiz_list')</h3>
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
                                        <th>@lang('quiz.name')</th>
                                        <th>@lang('quiz.category')</th>
                                        <th>@lang('common.actions')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($quizzes as $key => $quiz)
                                        <tr>
                                            <td>{{$key+1}}</td>
                                            <td>{{$quiz->name}}</td>
                                            <td>{{isset($quiz->category->name)?$quiz->category->name:''}}</td>
                                            <td>
                                                <a href="{{route('add_question', [$quiz->id])}}"><button class="primary-btn fix-gr-bg submit" type="submit">@lang('quiz.add_question')</button></a>
                                                @php
													echo $btn =  (userPermission('quiz_edit') ?
                                                    '<a class="primary-btn small fix-gr-bg"  href="' . route('quiz_edit', [$quiz->id]) . '" title="'.__('common.edit').'"><i class="ti-pencil" style="font-size: 20px;"></i></a><br>':'').
                                                    (userPermission('quiz_delete') ?
                                                    '<a  class="primary-btn small fix-gr-bg"  data-toggle="modal"  data-target="#deleteStudentTypeModal'.$quiz->id.'"  title="'. __('common.delete') .'" ><i class="ti-trash" style="font-size: 20px;"></i></a>' : '');
                                                    /*$routeList =[
                                                        (userPermission('quiz_edit')) ?
                                                        '<a class="dropdown-item" href="'.route('quiz_edit', [$quiz->id]).'">'.__('common.edit').'</a>' : null,
                                                        (userPermission('quiz_delete')) ?
                                                        '<a class="dropdown-item" data-toggle="modal" data-target="#deleteStudentTypeModal'.$quiz->id.'"
                                                            href="#">'.__('common.delete').'</a>' : null,
                                                    ];*/
                                                @endphp
                                                <?php /*<x-drop-down-action-component :routeList="$routeList"/> */?>
                                            </td>
                                        </tr>
                                        <div class="modal fade admin-query" id="deleteStudentTypeModal{{$quiz->id}}" >
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">@lang('quiz.delete_quiz')</h4>
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="text-center">
                                                            <h4>@lang('common.are_you_sure_to_delete')</h4>
                                                        </div>
                                                        <div class="mt-40 d-flex justify-content-between">
                                                            <button type="button" class="primary-btn tr-bg" data-dismiss="modal">@lang('common.cancel')</button>
                                                            <a href="{{route('quiz_delete', [$quiz->id])}}"><button class="primary-btn fix-gr-bg" type="submit">@lang('common.delete')</button></a>
                                                            
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
<script>
    $(document).ready(function(){
        $('#class_select').change(function(){
            var class_id = $(this).val();
            if(class_id){
                $.ajax({
                    type:"GET",
                    url:"{{url('get-courses')}}?class_id="+class_id,
                    success:function(res){
                        if(res){
                            $("#course_select").empty();
                            $("#course_select").append('<option selected disabled>Select Course</option>');
                            $.each(res,function(key,value){
                                $("#course_select").append('<option value="'+key+'">'+value+'</option>');
                            });

                            // Refresh the nice-select plugin for course select after dynamically updating options
                            $('#course_select').niceSelect('update');
                            
                            // Enable the course select dropdown
                            $('#course_select').prop('disabled', false);
                        }else{
                            $("#course_select").empty();
                        }
                    }
                });
            }else{
                $("#course_select").empty();
                $('#course_select').prop('disabled', true);
            }
        });
    });
</script>


@endsection
@include('backEnd.partials.data_table_js')