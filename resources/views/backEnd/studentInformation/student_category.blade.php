@extends('backEnd.master')
@section('title') 
@lang('student.student_category')
@endsection
@section('mainContent')

@php
$breadCrumbs = 
[
'h1'=> __('student.student_category'),
'bcPages'=> [               
'<a href="#">'.__('student.student_information').'</a>',
],
];
@endphp
<x-bread-crumb-component :breadCrumbs="$breadCrumbs" />
<section class="admin-visitor-area up_st_admin_visitor">
    <div class="container-fluid p-0">
        @if(isset($student_type))
		@if(userPermission('student_category_store'))
		
        <div class="row">
            <div class="offset-lg-10 col-lg-2 text-right col-md-12 mb-20">
                <a href="{{route('student_category')}}" class="primary-btn small fix-gr-bg">
                    <span class="ti-plus pr-2"></span>
                    @lang('common.add')
				</a>
			</div>
		</div>
        @endif
        @endif
        <div class="row">
			
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="main-title">
                            <h3 class="mb-30">@if(isset($student_type))
								@lang('student.edit_student_category')
                                @else
								@lang('student.add_student_category')
                                @endif
								
							</h3>
						</div>
                        @if(isset($student_type))
						{{ Form::open(['class' => 'form-horizontal', 'route' => 'student_category_update', 'method' => 'POST', 'files' => true]) }}
                        @else
						@if(userPermission('student_category_store'))
						{{ Form::open(['class' => 'form-horizontal', 'route' => 'student_category_store', 'method' => 'POST','files'=> true]) }}
						@endif
                        @endif
                        <div class="white-box">
                            <div class="add-visitor">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="primary_input">
                                            <label class="primary_input_label" for="">@lang('common.name') <span class="text-danger"> *</span></label>
                                            <input class="primary_input_field form-control{{ $errors->has('category') ? ' is-invalid' : '' }}"
											type="text" name="category" autocomplete="off" value="{{isset($student_type)? $student_type->category_name:''}}">
                                            <input type="hidden" name="id" value="{{isset($student_type)? $student_type->id: ''}}">                                          
                                            @if ($errors->has('category'))
                                            <span class="text-danger" >
                                                {{ $errors->first('category') }}
											</span>
                                            @endif
										</div>
									</div>
									
									@php
                                    $courseCategories = DB::table('sm_course_categories')->get();
									@endphp
									
									<div class="col-lg-12 mt-30">
										<div class="primary_input ">
											<label class="primary_input_label" for="">@lang('common.main_category') <span
											class="text-danger"> *</span> </label>
											<select class="primary_select" name="main_category" id="main_category">
												<option data-display="@lang('common.main_category') *" value="">@lang('common.main_category') * </option>
												@foreach ($courseCategories as $category)
                                                <option value="{{ $category->id }}"	{{ isset($student_type) && $student_type->main_category == $category->id ? 'selected' : '' }}>{{ $category->category_name }}</option>
												@endforeach
											</select>
											@if ($errors->has('main_category'))
											<span class="text-danger">
												{{ $errors->first('main_category') }}
											</span>
											@endif
										</div>
									</div>
									
									
                                    <div class="col-lg-12  mt-30">
                                        <div class="primary_input">
                                            <label class="primary_input_label" for="">@lang('common.description') <span class="text-danger"> *</span></label>
                                            <textarea class="primary_input_field form-control{{ $errors->has('description') ? ' is-invalid' : '' }}"
											type="text" name="description" autocomplete="off" rows="5">
                                                {{isset($student_type)? $student_type->description:''}}
											</textarea>
                                            <input type="hidden" name="id" value="{{isset($student_type)? $student_type->id: ''}}">                                          
                                            
                                            @if ($errors->has('description'))
                                            <span class="text-danger" >
                                                {{ $errors->first('description') }}
											</span>
                                            @endif
										</div>
									</div>
									
									<div class="col-lg-12  mt-30">
                                        <div class="primary_input">
											<label for="details">@lang('subscription.details')</label>
											<script src="https://cdn.ckeditor.com/4.12.1/standard/ckeditor.js"></script>
											<textarea id="details" class="generated-text primary_input_field form-control }}" cols="0" rows="4" name="details" maxlength="500">{{  isset($student_type)? $student_type->details:'' }}</textarea>
											<script>
												CKEDITOR.replace("details");
											</script>
										</div>
									</div>
									
                                    <div class="col-lg-12  mt-30">
                                        <div class="primary_input">
                                            <label class="primary_input_label" for="">@lang('common.image') <span class="text-danger"> *</span></label>
                                            <input class="primary_input_field form-control{{ $errors->has('image') ? ' is-invalid' : '' }}"
											type="file" name="image" autocomplete="off" rows="5" />
                                            <input type="hidden" name="id" value="{{isset($student_type)? $student_type->id: ''}}">
                                            @if(isset($student_type->image))
											<img src="{{  asset($student_type->image)  }}" width="100%">
                                            @endif
                                            
											@if ($errors->has('image'))
											<span class="text-danger" >
												{{ $errors->first('image') }}
											</span>
											@endif
										</div>   
									</div>
									<div class="col-lg-12  mt-30">
                                        <div class="primary_input">
											<label class="primary_input_label" for="">@lang('common.duration') <span class="text-danger"> *</span></label>
											<?php if (!isset($student_type)): ?>
											<input type="text" name="duration[]" class="primary_input_field form-control" value="{{ isset($student_type) ? $student_type->duration : '' }}">
											<?php endif ?>
											<div id="duration-list">
												@if(isset($student_type) && strpos($student_type->duration, ',') !== false)
												@php $durationArray = explode(', ', $student_type->duration); @endphp
												@foreach($durationArray as $duration)
												<div class="input-group">
													<input type="text" name="duration[]" class="primary_input_field form-control" value="{{ $duration }}">
													<div class="input-group-append">
														<button type="button" class="btn remove-duration">X</button>
													</div>
												</div>
												@endforeach
												@endif
											</div>
											<button type="button" class="btn btn-primary" id="add-more-duration" style="margin: 15px 45px;">@lang('common.add_more')</button>
											@if ($errors->has('duration'))
											<span class="text-danger" >
												{{ $errors->first('duration') }}
											</span>
											@endif
										</div>
									</div>
									
								</div>
								@php 
								$tooltip = "";
								if(userPermission('student_category_store')){
								$tooltip = "";
								}else{
								$tooltip = "You have no permission to add";
								}
								@endphp
								<div class="row mt-40">
									<div class="col-lg-12 text-center">
										<button class="primary-btn fix-gr-bg submit" data-toggle="tooltip" title="{{$tooltip}}">
											<span class="ti-check"></span>
											@if(isset($student_type))
											@lang('student.update_category')
											@else
											@lang('student.save_category')
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
			
			<div class="col-lg-12 mt-30">
				<div class="row">
					<div class="col-lg-4 no-gutters">
						<div class="main-title">
							<h3 class="mb-0">@lang('student.student_category_list')</h3>
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
										<th>@lang('common.main_category')</th>
										<th>@lang('student.category')</th>
										<th>@lang('common.description')</th>
										<th>@lang('common.image') </th>
										<th>@lang('common.duration') </th>
										<th>@lang('common.actions')</th>
									</tr>
								</thead>
								<tbody>
									@foreach($student_types as $key => $student_type)
									<tr>
										<td>{{$key+1}}</td>
										<td>{{$student_type->mainCategory->category_name}}</td>
										<td>{{$student_type->category_name}}</td>
										<td>{{Illuminate\Support\Str::words($student_type->description, 10, '...')}}</td>
										<td>
											@if(isset($student_type->image))
											<img src="{{  asset($student_type->image)  }}" width="100%">
											@endif
										</td>
										<td>{{$student_type->duration}}</td>
										<td>
											@php
											echo $btn =  (userPermission('student_category_edit') ?
											'<a class="primary-btn small fix-gr-bg"  href="' . route('student_category_edit', [$student_type->id]) . '" title="'.__('common.edit').'"><i class="ti-pencil" style="font-size: 20px;"></i></a><br>':'').
											(userPermission('student_category_delete') ?
											'<a  class="primary-btn small fix-gr-bg"  data-toggle="modal"  data-target="#deleteStudentTypeModal'.$student_type->id.'"  title="'. __('common.delete') .'" ><i class="ti-trash" style="font-size: 20px;"></i></a>' : '');
											/*$routeList =[
											(userPermission('student_category_edit')) ?
											'<a class="dropdown-item" href="'.route('student_category_edit', [$student_type->id]).'">'.__('common.edit').'</a>' : null,
											(userPermission('student_category_delete')) ?
											'<a class="dropdown-item" data-toggle="modal" data-target="#deleteStudentTypeModal'.$student_type->id.'"
											href="#">'.__('common.delete').'</a>' : null,
											];*/
											@endphp
											<?php /*<x-drop-down-action-component :routeList="$routeList"/> */?>
										</td>
									</tr>
									<div class="modal fade admin-query" id="deleteStudentTypeModal{{$student_type->id}}" >
										<div class="modal-dialog modal-dialog-centered">
											<div class="modal-content">
												<div class="modal-header">
													<h4 class="modal-title">@lang('student.delete_category')</h4>
													<button type="button" class="close" data-dismiss="modal">&times;</button>
												</div>
												<div class="modal-body">
													<div class="text-center">
														<h4>@lang('common.are_you_sure_to_delete')</h4>
													</div>
													<div class="mt-40 d-flex justify-content-between">
														<button type="button" class="primary-btn tr-bg" data-dismiss="modal">@lang('common.cancel')</button>
														<a href="{{route('student_category_delete', [$student_type->id])}}"><button class="primary-btn fix-gr-bg" type="submit">@lang('common.delete')</button></a>
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
	$(document).ready(function() {
		$(document).on('click', '.remove-duration', function() {
			$(this).closest('.input-group').remove();
		});
		
		$('#add-more-duration').click(function() {
			$('#duration-list').append('<div class="input-group"><input type="text" name="duration[]" class="primary_input_field form-control"><div class="input-group-append"><button type="button" class="btn remove-duration">X</button></div></div>');
		});
	});
</script>
@endsection
@include('backEnd.partials.data_table_js')												