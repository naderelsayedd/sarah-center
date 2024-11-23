@extends('backEnd.master')
@section('title') 
@lang('quiz.quiz_category')
@endsection
@section('mainContent')
<style type="text/css">
    /*for action pencil and delete button*/
    .ti-view-grid:before, .ti-pencil:before, .ti-trash:before {
        font-size: 15px;
        color: #000;
    }
</style>
@php
    $breadCrumbs = 
    [
        'h1'=> __('quiz.quiz_category'),
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
                                @if(isset($quiz_categories))
                                    @lang('quiz.add_quiz_category')
                                @else
                                    @lang('quiz.edit_quiz_category')
                                @endif
                            </h3>
                        </div>
                        @if(isset($category))
                            {{ Form::open(['class' => 'form-horizontal', 'route' => 'quiz_category_update', 'method' => 'POST']) }}
                        @else
                            @if(userPermission('quiz_category_store'))
                                {{Form::open(['class' => 'form-horizontal', 'route' => 'quiz_category_store', 'method' => 'POST'])}}
                            @endif
                        @endif
                        <div class="white-box">
                            <div class="add-visitor">
                                <div class="row">
                                    <div class="col-lg-12">
                                      
                                        <div class="primary_input">
                                            <label class="primary_input_label" for="">@lang('quiz.add_quiz_category') <span class="text-danger"> *</span></label>
                                            <input class="primary_input_field form-control{{ $errors->has('category') ? ' is-invalid' : '' }}"
                                                type="text" name="category" autocomplete="off" value="{{isset($category)? $category->name:''}}">
                                            <input type="hidden" name="id" value="{{isset($category)? $category->id: ''}}">
                                            @if ($errors->first())
                                            <span class="text-danger" >
                                                {{ $errors->first() }}
                                            </span>
                                            @endif
                                        </div>
                                        
                                    </div>
                                </div>
                                 @php 
                                  $tooltip = "";
                                  if(userPermission('quiz_category_store')){
                                        $tooltip = "";
                                    }else{
                                        $tooltip = "You have no permission to add";
                                    }
                                @endphp
                                <div class="row mt-40">
                                    <div class="col-lg-12 text-center">
                                       <button class="primary-btn fix-gr-bg submit" data-toggle="tooltip" title="{{$tooltip}}">
                                            <span class="ti-check"></span>
                                            @if(isset($category))
                                                @lang('quiz.update_category')
                                            @else
                                                @lang('quiz.save_category')
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
                            <h3 class="mb-0">@lang('quiz.quiz_category_list')</h3>
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
                                        <th>@lang('quiz.category')</th>
                                        <th>@lang('common.actions')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($quiz_categories as $key => $quiz_category)
                                        <tr>
                                            <td>{{$key+1}}</td>
                                            <td>{{$quiz_category->name}}</td>
                                            <td>
                                                @php
													echo $btn =  (userPermission('quiz_category_edit') ?
                                                    '<a class="primary-btn small fix-gr-bg"  href="' . route('quiz_category_edit', [$quiz_category->id]) . '" title="'.__('common.edit').'"><i class="ti-pencil" style="font-size: 20px;"></i></a><br>':'').
                                                    (userPermission('quiz_category_delete') ?
                                                    '<a  class="primary-btn small fix-gr-bg"  data-toggle="modal"  data-target="#deleteStudentTypeModal'.$quiz_category->id.'"  title="'. __('common.delete') .'" ><i class="ti-trash" style="font-size: 20px;"></i></a>' : '');
                                                    /*$routeList =[
                                                        (userPermission('quiz_category_edit')) ?
                                                        '<a class="dropdown-item" href="'.route('quiz_category_edit', [$quiz_category->id]).'">'.__('common.edit').'</a>' : null,
                                                        (userPermission('quiz_category_delete')) ?
                                                        '<a class="dropdown-item" data-toggle="modal" data-target="#deleteStudentTypeModal'.$quiz_category->id.'"
                                                            href="#">'.__('common.delete').'</a>' : null,
                                                    ];*/
                                                @endphp
                                                <?php /*<x-drop-down-action-component :routeList="$routeList"/> */?>
                                            </td>
                                        </tr>
                                        <div class="modal fade admin-query" id="deleteStudentTypeModal{{$quiz_category->id}}" >
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">@lang('quiz.delete_category')</h4>
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="text-center">
                                                            <h4>@lang('common.are_you_sure_to_delete')</h4>
                                                        </div>
                                                        <div class="mt-40 d-flex justify-content-between">
                                                            <button type="button" class="primary-btn tr-bg" data-dismiss="modal">@lang('common.cancel')</button>
                                                            <a href="{{route('quiz_category_delete', [$quiz_category->id])}}"><button class="primary-btn fix-gr-bg" type="submit">@lang('common.delete')</button></a>
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
@endsection
@include('backEnd.partials.data_table_js')