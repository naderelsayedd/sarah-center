@php
$setting = generalSetting();
if(isset($setting->copyright_text)){
$copyright_text = $setting->copyright_text;
}else{
$copyright_text = 'Copyright 2019 All rights reserved by Codethemes';
}
@endphp


@includeIf('backEnd.partials.hangoutchat')
@if(moduleStatusCheck('Lead')==true)
@foreach ($reminders as $item)
<div id="fullCalReminderModal_{{ $item->id }}" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 id="modalTitle" class="modal-title"></h4>
				<button type="button" class="close" data-dismiss="modal">
					<span aria-hidden="true">×</span> <span class="sr-only">@lang('common.close')</span>
				</button>
			</div>
			<div class="modal-body text-center">
                @include('lead::lead_calender', ['event' => $item])
			</div>
			<div class="modal-footer">
				<button type="button" class="primary-btn tr-bg" data-dismiss="modal">@lang('common.close')</button>
			</div>
		</div>
	</div>
</div>
@endforeach
@endif
@if(config('app.app_sync'))
<a target="_blank" href="https://aorasoft.com" class="float_button"> <i class="ti-shopping-cart-full"></i>
	<h3>Purchase InfixEdu</h3>
</a>
@endif
<div class="has-modal modal fade" id="showDetaildModal">
    <div class="modal-dialog modal-dialog-centered" id="modalSize">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title" id="showDetaildModalTile">@lang('system_settings.new_client_information')</h4>
                <button type="button" class="close icons" data-dismiss="modal">&times;</button>
			</div>
            <div class="modal-body" id="showDetaildModalBody">
				
			</div>
		</div>
	</div>
</div>
<!--  Start Modal Area -->
<div class="modal fade invoice-details" id="showDetaildModalInvoice">
    <div class="modal-dialog large-modal modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">@lang('common.add_invoice')</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
            <div class="modal-body" id="showDetaildModalBodyInvoice">
			</div>
		</div>
	</div>
</div>


<div class="modal fade invoice-details" id="modalPopAddCategory">
    <div class="modal-dialog large-modal modal-dialog-centered">
        <div class="modal-content"> 
            <div class="modal-header">
                <h4 class="modal-title">@lang('student.add_student_category')</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
            <div class="modal-body">
				{{ Form::open(['class' => 'form-horizontal add_new_category', 'files' => true, 'route' => 'student_category_store_popup', 'method' => 'POST']) }}
				<div class="row">
					<div class="col-lg-12"> 
						<div class="primary_input">
							<label class="primary_input_label" for="">@lang('common.type')<span class="text-danger"> *</span></label>
							<input class="primary_input_field form-control"	type="text" name="category" autocomplete="off">
						</div>
					</div>
				</div>
				
				<div class="row mt-40">
					<div class="col-lg-12 text-center">
						<button class="primary-btn fix-gr-bg submit" data-toggle="tooltip" title="Add New Category">
							<span class="ti-check"></span>
							@lang('student.save_category')
						</button>
					</div>
				</div>
				{{ Form::close() }}
			</div>
		</div>
	</div>
</div>

<div class="modal fade invoice-details" id="modalPopAddGroup">
    <div class="modal-dialog large-modal modal-dialog-centered">
        <div class="modal-content"> 
            <div class="modal-header">
                <h4 class="modal-title">@lang('student.add_student_group')</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
            <div class="modal-body">
				{{ Form::open(['class' => 'form-horizontal add_new_group', 'files' => true, 'route' => 'student_group_store_popup', 'method' => 'POST']) }}
				<div class="row">
					<div class="col-lg-12"> 
						<div class="primary_input">
							<label class="primary_input_label" for="">@lang('common.name') <span class="text-danger"> *</span></label>
							<input class="primary_input_field form-control" type="text" name="group" autocomplete="off">
						</div>
					</div>
				</div>
				
				<div class="row mt-40">
					<div class="col-lg-12 text-center">
						<button class="primary-btn fix-gr-bg submit" data-toggle="tooltip" title="Add New Group">
							<span class="ti-check"></span>
							@lang('student.save_group')
						</button>
					</div>
				</div>
				{{ Form::close() }}
			</div>
		</div>
	</div>
</div>

<div class="modal fade invoice-details" id="modalPopAddDepartment">
    <div class="modal-dialog large-modal modal-dialog-centered">
        <div class="modal-content"> 
            <div class="modal-header">
                <h4 class="modal-title">@lang('hr.add_department')</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
            <div class="modal-body">
				{{ Form::open(['class' => 'form-horizontal add_new_department', 'files' => true, 'route' => 'department-store-popup',
				'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
				<div class="row">
					<div class="col-lg-12"> 
						<div class="primary_input">
							<label class="primary_input_label" for="">@lang('hr.department_name') <span class="text-danger"> *</span></label>
                            <input class="primary_input_field form-control"	type="text" name="name" autocomplete="off" value="" required="" >
						</div>
					</div>
				</div>
				
				<div class="row mt-40">
					<div class="col-lg-12 text-center">
						<button class="primary-btn fix-gr-bg submit" data-toggle="tooltip" title="Add New Department">
							<span class="ti-check"></span>
							@lang('hr.save_department')
						</button>
					</div>
				</div>
				{{ Form::close() }}
			</div>
		</div>
	</div>
</div>



<div class="modal fade invoice-details" id="modalPopCheckMathematics">
    <div class="modal-dialog large-modal modal-dialog-centered">
        <div class="modal-content"> 
            <div class="modal-header">
                <h4 class="modal-title">Mathematics Shortcodes and Symbols</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
            <div class="modal-body" id="tableMathematics">
				
			</div>
		</div>
	</div>
</div>

<div class="modal fade invoice-details" id="modalPopAddDesignation">
    <div class="modal-dialog large-modal modal-dialog-centered">
        <div class="modal-content"> 
            <div class="modal-header">
                <h4 class="modal-title">@lang('hr.add_designation')</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
            <div class="modal-body">
				{{ Form::open(['class' => 'form-horizontal add_new_designation','files' => true,'route' => 'designation-store-pop','method' => 'POST','enctype' => 'multipart/form-data', ]) }}
				<div class="row">
					<div class="col-lg-12"> 
						<div class="primary_input">
							<input class="primary_input_field form-control"	type="text" name="title" autocomplete="off"	value="" required="" placeholder="Please Enter Designation">
						</div>
					</div>
				</div>
				<div class="row mt-40">
					<div class="col-lg-12 text-center">
						<button class="primary-btn fix-gr-bg submit" data-toggle="tooltip" title="Add New Designation">
							<span class="ti-check"></span>
							@lang('hr.save_designation')
						</button>
					</div>
				</div>
				{{ Form::close() }}
			</div>
		</div>
	</div>
</div>

<div class="modal fade invoice-details" id="modalPopAddClass">
    <div class="modal-dialog large-modal modal-dialog-centered">
        <div class="modal-content"> 
            <div class="modal-header">
                <h4 class="modal-title">@lang('academics.add_class')</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
            <div class="modal-body">
				{{ Form::open(['class' => 'form-horizontal add_new_class', 'files' => true, 'route' => 'class_store_popup', 'method' => 'POST']) }}
				<div class="row">
					<div class="col-lg-12"> 
						<div class="primary_input">
							<label class="primary_input_label" for="">@lang('common.name') <span class="text-danger"> *</span></label>
							<input class="primary_input_field form-control" type="text" name="name" autocomplete="off" value="">
							<input type="hidden" name="id" value="">
						</div>
					</div>
				</div>
				
				<div class="row mt-25">
					<div class="col-lg-12">
						@php
						$generalSetting = generalSetting();
						$sections = App\SmSection::where('school_id', $generalSetting->school_id)->where('academic_id',getAcademicId())->get();
						@endphp
						<label class="primary_input_label" for="">@lang('common.section')<span class="text-danger"> *</span></label>
						@foreach($sections as $section)
						<div class="">
							<input type="checkbox" id="section{{@$section->id}}" class="common-checkbox form-control" name="section[]" value="{{@$section->id}}">
							<label for="section{{@$section->id}}"> {{@$section->section_name}}</label>
						</div>
						@endforeach
					</div>
				</div>
				
				<div class="row mt-40">
					<div class="col-lg-12 text-center">
						<button class="primary-btn fix-gr-bg submit" data-toggle="tooltip" title="Add New Class">
							<span class="ti-check"></span>
							@lang('academics.save_class')
						</button>
					</div>
				</div>
				{{ Form::close() }}
			</div>
		</div>
	</div>
</div>

<div class="modal fade invoice-details" id="modalPopAddSection">
    <div class="modal-dialog large-modal modal-dialog-centered">
        <div class="modal-content"> 
            <div class="modal-header">
                <h4 class="modal-title">@lang('academics.add_section')</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
            <div class="modal-body">
				{{ Form::open(['class' => 'form-horizontal add_new_section', 'files' => true, 'route' => 'section_store_popup', 'method' => 'POST']) }}
				<div class="row">
					<div class="col-lg-12"> 
						<div class="primary_input">
							<label class="primary_input_label" for="">@lang('common.name') <span class="text-danger"> *</span></label>
							<input class="primary_input_field form-control" type="text" name="name" autocomplete="off" value="">
							<input type="hidden" name="id" value="">
						</div>
					</div>
				</div>
				
				
				<div class="row mt-40">
					<div class="col-lg-12 text-center">
						<button class="primary-btn fix-gr-bg submit" data-toggle="tooltip" title="Add New Section">
							<span class="ti-check"></span>
							@lang('academics.save_section')
						</button>
					</div>
				</div>
				{{ Form::close() }}
			</div>
		</div>
	</div>
</div>

<div class="modal fade invoice-details" id="modalPopParentConfirmation">
    <div class="modal-dialog large-modal modal-dialog-centered">
        <div class="modal-content"> 
            <div class="modal-header">
                <h4 class="modal-title">@lang('auth.parent_confirmation_for_child')</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
            <div class="modal-body">
				{{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'parent_comfirmation', 'method' => 'POST']) }}
				<div class="row">
					<div class="col-lg-12"> 
						<div class="primary_input">
							<label class="primary_input_label" for="">@lang('auth.is_confirmation') </label>
							<input type="radio" id="is_confirmation" name="is_confirmation" value="1"> @lang('common.yes') 
							<input type="radio" id="is_confirmation" name="is_confirmation" value="2"> @lang('common.no') 
						</div>
					</div>
				</div>
				
				<div class="row">
					<div class="col-lg-12"> 
						<div class="primary_input">
							<label class="primary_input_label" for="">@lang('auth.is_photo_confirmation') </label>
							<input type="radio" id="is_photo_confirmation" name="is_photo_confirmation" value="1"> @lang('common.yes') 
							<input type="radio" id="is_photo_confirmation" name="is_photo_confirmation" value="2"> @lang('common.no') 
						</div>
					</div>
				</div>
				
				<div class="row" id="snapchat_url_div" style="display:none">
					<div class="col-lg-12"> 
						<div class="primary_input">
							<label class="primary_input_label" for="">@lang('auth.snapchat_url') </label>
							<input class="primary_input_field form-control" type="text" id="snapchat_url" name="snapchat_url" autocomplete="off" value="">
						</div>
					</div>
				</div>
				
				
				<div class="row mt-40">
					<div class="col-lg-12 text-center">
						<button class="primary-btn fix-gr-bg submit" data-toggle="tooltip">
							<span class="ti-check"></span>
							@lang('common.submit')
						</button>
					</div>
				</div>
				{{ Form::close() }}
			</div>
		</div>
	</div>
</div>

<div class="modal fade invoice-details" id="modalPopAddSubject">
    <div class="modal-dialog large-modal modal-dialog-centered">
        <div class="modal-content"> 
            <div class="modal-header">
                <h4 class="modal-title">@lang('academics.add_subject')</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
            <div class="modal-body">
				{{ Form::open(['class' => 'form-horizontal add_new_subject', 'files' => true, 'route' => 'subject_store_popup', 'method' => 'POST']) }}
				<div class="row">
					<div class="col-lg-12">
						<div class="primary_input">
							<label class="primary_input_label" for="">@lang('academics.subject_name') <span class="text-danger"> *</span></label>
							<input class="primary_input_field form-control" 
							type="text" name="subject_name" autocomplete="off">
							<input type="hidden" name="id" value="">
						</div>
					</div>
				</div>
				<div class="row  mt-15">
					<div class="col-lg-12">
						<div class="d-flex radio-btn-flex">
							<div class="mr-30">
								<input type="radio" name="subject_type" id="relationFather" value="T" class="common-radio relationButton" checked>
								<label for="relationFather">@lang('academics.theory')</label>
							</div>
							<div class="mr-30">
								<input type="radio" name="subject_type" id="relationMother" value="P" class="common-radio relationButton">
								<label for="relationMother">@lang('academics.practical')</label>
							</div>
						</div>
					</div>
				</div>
				
				<div class="row  mt-15">
					<div class="col-lg-12">
						<div class="primary_input">
							<label class="primary_input_label" for="">@lang('academics.subject_code') <span class="text-danger"> *</span></label>
							<input class="primary_input_field form-control" type="text" name="subject_code" autocomplete="off" value="">
						</div>
					</div>
				</div>
				
				
				<div class="row mt-40">
					<div class="col-lg-12 text-center">
						<button class="primary-btn fix-gr-bg submit" data-toggle="tooltip" title="Add New Subject">
							<span class="ti-check"></span>
							@lang('academics.save_subject')
						</button>
					</div>
				</div>
				{{ Form::close() }}
			</div>
		</div>
	</div>
</div>

<div class="modal fade invoice-details" id="modalPopAddLesson">
    <div class="modal-dialog large-modal modal-dialog-centered">
        <div class="modal-content"> 
            <div class="modal-header">
                <h4 class="modal-title">@lang('lesson::lesson.add_lesson')</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
            <div class="modal-body">
				{{ Form::open(['class' => 'form-horizontal add_new_lesson', 'files' => true, 'route' => 'lesson_store_popup', 'method' => 'POST']) }}
				<div class="row">
					<div class="col-lg-12">
						@php
						$classes = App\SmClass::where('school_id', $generalSetting->school_id)->where('academic_id',getAcademicId())->get();
						@endphp
						<label class="primary_input_label" for="">{{ __('common.class') }}<span class="text-danger"> *</span></label>
						<select class="primary_select form-control" name="class">
							<option data-display="@lang('common.select_class') *" value="">
								@lang('common.select_class')*
							</option>
							@foreach ($classes as $class)
							<option value="{{ @$class->id }}">
								{{ @$class->class_name }}
							</option>
							@endforeach
						</select>
					</div>
				</div>
				<div class="row mt-15">
					<div class="col-lg-12">
						<label class="primary_input_label" for="">{{ __('common.section') }}<span class="text-danger"> *</span></label>
						@php
						$sections = App\SmSection::where('school_id', $generalSetting->school_id)->where('academic_id',getAcademicId())->get();
						@endphp
						<select	class="primary_select form-control" name="section">
							<option data-display="@lang('common.select_section') *" value="">
								@lang('common.select_section')*
							</option>
							@foreach ($sections as $section)
							<option value="{{ @$section->id }}">
								{{ @$section->section_name }}
							</option>
							@endforeach
						</select>
					</div>
				</div>
				
				<div class="row mt-15" id="">
					<div class="col-lg-12">
						<label class="primary_input_label" for="">{{ __('common.subject') }} <span class="text-danger"> *</span></label>
						@php
						$subjects = App\SmSubject::where('school_id', $generalSetting->school_id)->where('academic_id',getAcademicId())->get();
						@endphp
						<select	class="primary_select form-control" name="subject">
							<option data-display="@lang('common.select_subjects') *" value="">
							@lang('common.select_subjects')*</option>
							@foreach ($subjects as $subject)
							<option value="{{ @$subject->id }}">
								{{ @$subject->subject_name }}
								({{ $subject->subject_type == 'T' ? 'Theory' : 'Practical' }})
							</option>
							@endforeach
						</select>
					</div>
				</div>
				
				<div class="row">
					<div class="col-lg-12">
						<div class="white-box mt-10">
							<div class="row mb-3 align-items-center">
								<div class="col-xl-9 col-lg-8 col-md-10 col-9">
									<div class="main-title my-0 md:mt-auto">
										<h5 class="mb-0">@lang('lesson::lesson.add_lesson_name')</h5>
									</div>
								</div>
								<div class="col-xl-3 col-lg-4 col-md-2 col-3 text-right">
									<button type="button" class="primary-btn icon-only fix-gr-bg" onclick="addRowLessonPop();" id="addRowBtnPop"><span class="ti-plus pr-2"></span></button>
								</div>
							</div>
							<table class="" id="productTablePopup">
								<thead>
                                    <tr>
										
										
									</tr>
								</thead>
								<tbody>
                                    <tr id="row1" class="mt-40">
										<td class="">
											<input type="hidden" name="url" id="url" value="{{ URL::to('/') }}">
											<div class="primary_input">
												<input class="primary_input_field form-control"	type="text" id="lesson" placeholder="{{ __('common.title') }}" name="lesson[]" autocomplete="off">
											</div>
										</td>
										<td>
											<button class="primary-btn icon-only fix-gr-bg" type="button">
												<span class="ti-trash"></span>
											</button>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				
				<div class="row mt-40">
					<div class="col-lg-12 text-center">
						<button class="primary-btn fix-gr-bg submit" data-toggle="tooltip" title="Add New Lesson">
							<span class="ti-check"></span>
							@lang('lesson::lesson.save_lesson')
						</button>
					</div>
				</div>
				{{ Form::close() }}
			</div>
		</div>
	</div>
</div>


<div class="modal fade invoice-details" id="modalPopParentPickDrop">
    <div class="modal-dialog large-modal modal-dialog-centered">
        <div class="modal-content"> 
            <div class="modal-header">
                <h4 class="modal-title">@lang('common.pickup_arrieved_student_notification')</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
            <div class="modal-body">
				<div class="row">
					<div class="col-lg-6" style="text-align:center"> 
						<h2 style="text-align:center">@lang('common.call_student')</h2> <br>
						<img src="{{asset('public/uploads/staff/demo/staff.jpg')}}" /><br>
						<button class="primary-btn fix-gr-bg submit" data-toggle="tooltip" title="Call Student" onclick="actionPickUpArrieved({{Auth::user()->id}},'pick')()">
							<span class="ti-check"></span>
							@lang('common.click') @lang('common.call_student')
						</button>
					</div>
					<div class="col-lg-6" style="text-align:center"> 
						<h2 style="text-align:center">@lang('common.call_arrieved')</h2> <br>
						<img src="{{asset('public/uploads/staff/demo/staff.jpg')}}" /> <br>
						<button class="primary-btn fix-gr-bg submit" data-toggle="tooltip" title="Student Arrived" onclick="actionPickUpArrieved({{Auth::user()->id}},'drop')()">
							<span class="ti-check"></span>
							@lang('common.click') @lang('common.call_arrieved')
						</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


<div class="modal fade invoice-details" id="modalPopAttendance">
    <div class="modal-dialog large-modal modal-dialog-centered">
        <div class="modal-content"> 
            <div class="modal-header">
                <h4 class="modal-title">Check Out</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
            <div class="modal-body">
				<div class="row">
					<div class="col-lg-12"> 
						@php
						$attendance = App\SmAttendance::where('user_id', Auth::user()->id)->where('school_id', Auth::user()->school_id)->where('academic_id',getAcademicId())->orderBy('id', 'desc')->first();
						
						@endphp
						<div class="primary_input">
							<label class="primary_input_label" for="">Note<span class="text-danger"> *</span></label>
							<input class="primary_input_field form-control" type="text" id="checkout_note" name="checkout_note" autocomplete="off" value="">
							@if($attendance)
							<input type="hidden" name="checkin_id" id="checkin_id" value="{{$attendance->id}}">
							@else
							<input type="hidden" name="checkin_id" id="checkin_id" value="">
							@endif
							
						</div>
					</div>
				</div>
				<div class="row mt-40">
					<div class="col-lg-12 text-center">
						<button class="primary-btn fix-gr-bg submit" data-toggle="tooltip" title="Check Out" onclick="checkoutAttendance()">
							<span class="ti-check"></span>
							Check Out
						</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!--================Footer Area ================= -->
<footer class="footer-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                @if(Auth::check())
				<p>{!! $copyright_text !!} </p>
                @else
				<p>{!! $copyright_text !!} </p>
                @endif
			</div>
		</div>
	</div>
</footer>

<!-- ================End Footer Area ================= -->

<script>
    window.jsLang = function(key, replace) {
        let translation = true
		
        let json_file = $.parseJSON(window._translations[window._locale]['json'])
        translation = json_file[key]
		? json_file[key]
		: key
		
		
        $.each(replace, (value, key) => {
            translation = translation.replace(':' + key, value)
		})
		
        return translation
	}
    window.trans = function(key, replace) {
        let translation = true
		
        let json_file = $.parseJSON(window._translations[window._locale]['json'])
        translation = json_file[key]
		? json_file[key]
		: key
		
        
        $.each(replace, (value, key) => {
            translation = translation.replace(':' + key, value)
		})
        return translation
	}
</script>

<script src="{{asset('public/backEnd/')}}/vendors/js/jquery-ui.js"></script>
<script src="{{asset('public/backEnd/')}}/vendors/js/popper.js"></script>

<script src="{{asset('public/backEnd/assets/js/metisMenu.js')}}"></script>

@if(userRtlLtl() ==1)
<script src="{{asset('public/backEnd/assets/js/bootstrap.rtl.min.js') }}"></script>
@else
<script src="{{asset('public/backEnd/assets/js/bootstrap.min.js') }}"></script>
@endif
<script src="{{asset('public/backEnd/')}}/vendors/js/nice-select.min.js"></script>

<script src="{{asset('public/backEnd/')}}/vendors/js/jquery.magnific-popup.min.js"></script>

<script src="{{asset('public/backEnd/')}}/vendors/js/raphael-min.js"></script>
<script src="{{asset('public/backEnd/')}}/vendors/js/morris.min.js"></script>
<script type="text/javascript" src="{{asset('public/backEnd/')}}/vendors/js/toastr.min.js"></script>
<script type="text/javascript" src="{{asset('public/backEnd/')}}/vendors/js/moment.min.js"></script>




<script type="text/javascript" src="{{asset('public/backEnd/')}}/js/jquery.validate.min.js"></script>


<script src="{{asset('public/backEnd/')}}/js/main.js"></script>

<script src="{{asset('public/backEnd/')}}/js/custom.js"></script>
<script src="{{asset('public/')}}/js/registration_custom.js"></script>
<script src="{{asset('public/backEnd/')}}/js/developer.js"></script>
<script src="{{url('Modules\Wallet\Resources\assets\js\wallet.js')}}"></script>
<script src="{{ asset('public/backEnd/') }}/vendors/editor/summernote-bs4.js"></script>
<script src="{{ asset('public/whatsapp-support/scripts.js') }}"></script>
<script>
    $('.close_modal').on('click', function() {
        $('.custom_notification').removeClass('open_notification');
	});
    $('.notification_icon').on('click', function() {
        $('.custom_notification').addClass('open_notification');
	});
    $(document).click(function(event) {
        if (!$(event.target).closest(".custom_notification").length) {
            $("body").find(".custom_notification").removeClass("open_notification");
		}
	});
	
    function isNumberKey(evt) {
        var charCode = (evt.which) ? evt.which : (event.keyCode);
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
		}
        return true;
	}
	
	function showPop(modalId,updateSection,updateSectionId,type){
		$("#"+modalId).modal("show");
		$("."+updateSection).append('<input type="hidden" name="section_update" value="'+updateSectionId+'" />');
		$("."+updateSection).append('<input type="hidden" name="type" value="'+type+'" />');
		$("."+updateSection).append('<input type="hidden" name="modelId" value="'+modalId+'" />');
	}
	
	var frmdepartment = $('.add_new_department');
    frmdepartment.submit(function (e) {
        e.preventDefault();
		console.log(e);
		var section_update = $(".add_new_department input[name=section_update]").val();
		var type = $(".add_new_department input[name=type]").val();
        $.ajax({
            type: frmdepartment.attr('method'),
            url: frmdepartment.attr('action'),
            data: frmdepartment.serialize(),
            success: function (data) {
				$("#"+$(".add_new_department input[name=modelId]").val()).modal("hide");
				var json = $.parseJSON(data);
				$("#"+section_update).append(
				$("<option>", {
					value: json.id,
					text: json.class_name,
				})
				);
				
				$("#"+section_update+"_div ul").append(
				"<li data-value='" +
				json.id +
				"' class='option'>" +
				json.class_name +
				"</li>"
				);
				$(".add_new_department input[name=name]").val('');
				setTimeout(function() {
					toastr.success(
					"Department Added Suucesfully!",
					"Success Alert", { iconClass: "customer-info" }, { timeOut: 2000 }
					);
				}, 500);
			},
            error: function (data) {
                console.log('An error occurred.');
                console.log(data);
				setTimeout(function() {
					toastr.error("Somethning went wrong!", "Error Alert", {
						timeOut: 5000,
					});
				}, 500);
			},
		});
	});
	
	var frmdesignation = $('.add_new_designation');
    frmdesignation.submit(function (e) {
        e.preventDefault();
		var section_update = $(".add_new_designation input[name=section_update]").val();
		var type = $(".add_new_designation input[name=type]").val();
        $.ajax({
            type: frmdesignation.attr('method'),
            url: frmdesignation.attr('action'),
            data: frmdesignation.serialize(),
            success: function (data) {
				$("#"+$(".add_new_designation input[name=modelId]").val()).modal("hide");
				var json = $.parseJSON(data);
				$("#"+section_update).append(
				$("<option>", {
					value: json.id,
					text: json.class_name,
				})
				);
				
				$("#"+section_update+"_div ul").append(
				"<li data-value='" +
				json.id +
				"' class='option'>" +
				json.class_name +
				"</li>"
				);
				$(".add_new_designation input[name=name]").val('');
				setTimeout(function() {
					toastr.success(
					"Designation Added Suucesfully!",
					"Success Alert", { iconClass: "customer-info" }, { timeOut: 2000 }
					);
				}, 500);
			},
            error: function (data) {
				setTimeout(function() {
					toastr.error("Somethning went wrong!", "Error Alert", {
						timeOut: 5000,
					});
				}, 500);
			},
		});
	});
	
	var frmgroup = $('.add_new_group');
    frmgroup.submit(function (e) {
        e.preventDefault();
		var section_update = $(".add_new_group input[name=section_update]").val();
		var type = $(".add_new_group input[name=type]").val();
        $.ajax({
            type: frmgroup.attr('method'),
            url: frmgroup.attr('action'),
            data: frmgroup.serialize(),
            success: function (data) {
				$("#"+$(".add_new_group input[name=modelId]").val()).modal("hide");
				var json = $.parseJSON(data);
				$("#"+section_update).append(
				$("<option>", {
					value: json.id,
					text: json.class_name,
				})
				);
				
				$("#"+section_update+"_div ul").append(
				"<li data-value='" +
				json.id +
				"' class='option'>" +
				json.class_name +
				"</li>"
				);
				$(".add_new_group input[name=name]").val('');
				setTimeout(function() {
					toastr.success(
					"Group Added Suucesfully!",
					"Success Alert", { iconClass: "customer-info" }, { timeOut: 2000 }
					);
				}, 500);
			},
            error: function (data) {
				setTimeout(function() {
					toastr.error("Somethning went wrong!", "Error Alert", {
						timeOut: 5000,
					});
				}, 500);
			},
		});
	});
	
	var frmcategory = $('.add_new_category');
    frmcategory.submit(function (e) {
        e.preventDefault();
		var section_update = $(".add_new_category input[name=section_update]").val();
		var type = $(".add_new_category input[name=type]").val();
        $.ajax({
            type: frmcategory.attr('method'),
            url: frmcategory.attr('action'),
            data: frmcategory.serialize(),
            success: function (data) {
				$("#"+$(".add_new_category input[name=modelId]").val()).modal("hide");
				var json = $.parseJSON(data);
				$("#"+section_update).append(
				$("<option>", {
					value: json.id,
					text: json.class_name,
				})
				);
				
				$("#"+section_update+"_div ul").append(
				"<li data-value='" +
				json.id +
				"' class='option'>" +
				json.class_name +
				"</li>"
				);
				$(".add_new_category input[name=name]").val('');
				setTimeout(function() {
					toastr.success(
					"Category Added Suucesfully!",
					"Success Alert", { iconClass: "customer-info" }, { timeOut: 2000 }
					);
				}, 500);
			},
            error: function (data) {
				setTimeout(function() {
					toastr.error("Somethning went wrong!", "Error Alert", {
						timeOut: 5000,
					});
				}, 500);
			},
		});
	});
	
	
	var frmlession = $('.add_new_lesson');
    frmlession.submit(function (e) {
        e.preventDefault();
		var section_update = $(".add_new_lesson input[name=section_update]").val();
		var type = $(".add_new_lesson input[name=type]").val();
        $.ajax({
            type: frmlession.attr('method'),
            url: frmlession.attr('action'),
            data: frmlession.serialize(),
            success: function (data) {
				$("#"+$(".add_new_lesson input[name=modelId]").val()).modal("hide");
				var json = $.parseJSON(data);
				$("#"+section_update).append(
				$("<option>", {
					value: json.id,
					text: json.class_name,
				})
				);
				
				$("#"+section_update+"_div ul").append(
				"<li data-value='" +
				json.id +
				"' class='option'>" +
				json.class_name +
				"</li>"
				);
				$(".add_new_lesson input[name=name]").val('');
				setTimeout(function() {
					toastr.success(
					"Lesson Added Suucesfully!",
					"Success Alert", { iconClass: "customer-info" }, { timeOut: 2000 }
					);
				}, 500);
			},
            error: function (data) {
				setTimeout(function() {
					toastr.error("Somethning went wrong!", "Error Alert", {
						timeOut: 5000,
					});
				}, 500);
			},
		});
	});
	
	var frmsubject = $('.add_new_subject');
    frmsubject.submit(function (e) {
        e.preventDefault();
		var section_update = $(".add_new_subject input[name=section_update]").val();
		var type = $(".add_new_subject input[name=type]").val();
        $.ajax({
            type: frmsubject.attr('method'),
            url: frmsubject.attr('action'),
            data: frmsubject.serialize(),
            success: function (data) {
				$("#"+$(".add_new_subject input[name=modelId]").val()).modal("hide");
				var json = $.parseJSON(data);
				$("#"+section_update).append(
				$("<option>", {
					value: json.id,
					text: json.class_name,
				})
				);
				
				$("#"+section_update+"_div ul").append(
				"<li data-value='" +
				json.id +
				"' class='option'>" +
				json.class_name +
				"</li>"
				);
				$(".add_new_subject input[name=name]").val('');
				setTimeout(function() {
					toastr.success(
					"Subject Added Suucesfully!",
					"Success Alert", { iconClass: "customer-info" }, { timeOut: 2000 }
					);
				}, 500);
			},
            error: function (data) {
				setTimeout(function() {
					toastr.error("Somethning went wrong!", "Error Alert", {
						timeOut: 5000,
					});
				}, 500);
			},
		});
	});
	
	var frmsection = $('.add_new_section');
    frmsection.submit(function (e) {
        e.preventDefault();
		var section_update = $(".add_new_section input[name=section_update]").val();
		var type = $(".add_new_section input[name=type]").val();
        $.ajax({
            type: frmsection.attr('method'),
            url: frmsection.attr('action'),
            data: frmsection.serialize(),
            success: function (data) {
				$("#"+$(".add_new_section input[name=modelId]").val()).modal("hide");
				var json = $.parseJSON(data);
				$("#"+section_update).append(
				$("<option>", {
					value: json.id,
					text: json.class_name,
				})
				);
				
				$("#"+section_update+"_div ul").append(
				"<li data-value='" +
				json.id +
				"' class='option'>" +
				json.class_name +
				"</li>"
				);
				$(".add_new_section input[name=name]").val('');
				setTimeout(function() {
					toastr.success(
					"Section Added Suucesfully!",
					"Success Alert", { iconClass: "customer-info" }, { timeOut: 2000 }
					);
				}, 500);
			},
            error: function (data) {
				setTimeout(function() {
					toastr.error("Somethning went wrong!", "Error Alert", {
						timeOut: 5000,
					});
				}, 500);
			},
		});
	});
	
	var frm = $('.add_new_class');
    frm.submit(function (e) {
        e.preventDefault();
		var section_update = $(".add_new_class input[name=section_update]").val();
		var type = $(".add_new_class input[name=type]").val();
        $.ajax({
            type: frm.attr('method'),
            url: frm.attr('action'),
            data: frm.serialize(),
            success: function (data) {
				$("#"+$(".add_new_class input[name=modelId]").val()).modal("hide");
				var json = $.parseJSON(data);
				$("#"+section_update).append(
				$("<option>", {
					value: json.id,
					text: json.class_name,
				})
				);
				
				$("#"+section_update+"_div ul").append(
				"<li data-value='" +
				json.id +
				"' class='option'>" +
				json.class_name +
				"</li>"
				);
				$(".add_new_class input[name=name]").val('');
				setTimeout(function() {
					toastr.success(
					"Class Added Suucesfully!",
					"Success Alert", { iconClass: "customer-info" }, { timeOut: 2000 }
					);
				}, 500);
			},
            error: function (data) {
				setTimeout(function() {
					toastr.error("Somethning went wrong!", "Error Alert", {
						timeOut: 5000,
					});
				}, 500);
			},
		});
	});
	
</script>
<script src="{{asset('public/backEnd/')}}/js/search.js"></script>

{!! Toastr::message() !!}
<script src="{{ asset('public/js/app.js') }}"></script>
<script src="{{ asset('public/chat/js/custom.js') }}"></script>
@yield('script')
@stack('script')
@stack('scripts')
@if(moduleStatusCheck('Lead')==true)

@foreach ($reminders as $item)
@php
$reminder_date_time=Carbon::parse($item->date_time)->format('Y-m-d').' '.$item->time;
@endphp
<script>
	setInterval(() => {
		let id = {{ $item->id }};
		let reminder_date = '{{ $reminder_date_time }}';
		let current_time = moment().format('YYYY-MM-DD HH:mm:ss');
		
		let current_time_integer = Date.parse(current_time);
		let reminder_integer = Date.parse(reminder_date);
		if(current_time_integer==reminder_integer) {
			$('#fullCalReminderModal_'+id).modal('show');
		}
	}, 1000);
</script>
@endforeach
@endif
<!--<script src="https://maps.google.com/maps/api/js?key=AIzaSyAllExNZLFYm3WUM88675fFfVlhyZNWa5M&libraries=places" type="text/javascript"></script>-->
<script src="https://maps.google.com/maps/api/js?key=AIzaSyAllExNZLFYm3WUM88675fFfVlhyZNWa5M&libraries=places" type="text/javascript"></script>
<script>
	var Currentlatitude;
	var Currentlongitude;
	var Currentaddress;
	$(document).ready(function(){
		if(navigator.geolocation){
			navigator.geolocation.getCurrentPosition(showLocation);
			}else{ 
			alert('Geolocation is not supported by this browser.');
		}
	});
	
	function showLocation(position){
		Currentlatitude = position.coords.latitude;
		Currentlongitude = position.coords.longitude;
	}
	
	function addUserAttendance() {
		$.ajax({
			type: 'post',
			url: '/set-user-attendance',
			data: {checkin_lat: Currentlatitude, checkin_long: Currentlongitude},
			success: function (data) {
				if(data.attendance) {
					$('#clockin').hide();
					$('#clockout').show();
					$('#checkin_id').val(data.attendance.id);
					$('#currentMessage').html('@lang("dashboard.clock_started_at") : '+ data.time);
					$('#currentMessage').attr('title', '@lang("dashboard.clock_started_at") : '+ data.attendance.in_time);
					setTimeout(function() {
						toastr.success('Clock started at : '+ data.time+" set now!", "Success", {
							timeOut: 3000,
						});
					}, 500);
				} else {
					setTimeout(function() {
						toastr.error(data.error, "Error", {
							timeOut: 3000,
						});
					}, 500);
				}
			},
			error: function (data) {
				setTimeout(function() {
					toastr.error("Somethning went wrong!", "Error Alert", {
						timeOut: 5000,
					});
				}, 500);
			},
		});
	}
	
	function checkoutAttendance() {
		$.ajax({
			type: 'post',
			url: '/set-user-attendance-checkout',
			data: {checkin_lat: Currentlatitude, checkin_long: Currentlongitude,'note': $('#checkout_note').val(),'id': $('#checkin_id').val()},
			success: function (data) {
				if(data.attendance) {
					$("#modalPopAttendance").modal("hide");
					$('#clockin').show();
					$('#clockout').hide();
					$('#checkin_id').val('');
					$('#currentMessage').html("@lang('dashboard.you_currently_clocked_out')");
					$('#currentMessage').attr('title', '@lang("dashboard.you_currently_clocked_out")');
					setTimeout(function() {
						toastr.success('@lang("dashboard.clock_out_at") : '+ data.time+" @lang('dashbaord.set_now')!", "Success", {
							timeOut: 3000,
						});
					}, 500);
				}
			},
			error: function (data) {
				$("#modalPopAttendance").modal("hide");
				setTimeout(function() {
					toastr.error("Somethning went wrong!", "Error Alert", {
						timeOut: 5000,
					});
				}, 500);
			},
		});
	}
</script>
<script type="text/javascript">
	var map;
	function InitializeMap(mapID,latlng,address) {
		locate()
		var myOptions =
		{
			center: latlng,
			zoom: 13,
			mapTypeId: google.maps.MapTypeId.ROADMAP,
			disableDefaultUI: true
		};
		map = new google.maps.Map(document.getElementById(mapID), myOptions);
		
		var marker = new google.maps.Marker({
			map: map,
			position: latlng,
			draggable: false,
			anchorPoint: new google.maps.Point(0, -29)
		});
		var infowindow = new google.maps.InfoWindow();   
		
		google.maps.event.addListener(marker, 'click', function() {
			var iwContent = '<div id="iw_container">' +
			'<div class="iw_title"><b>Location</b> : '+address+'</div></div>';
			// including content to the infowindow
			infowindow.setContent(iwContent);
			// opening the infowindow in the current map and at the current marker location
			infowindow.open(map, marker);
		});
	}
	
	function ShowMap(mapID,lat,lng, address) {
		document.getElementById(mapID).style.height = '400px';
		var latlng = new google.maps.LatLng(lat, lat);
		var myOptions =
		{
			center: latlng,
			zoom: 8,
			mapTypeId: google.maps.MapTypeId.ROADMAP,
			disableDefaultUI: true
		};
		map = new google.maps.Map(document.getElementById(mapID), myOptions);
		
		var marker = new google.maps.Marker({
			map: map,
			position: latlng,
			draggable: false,
			anchorPoint: new google.maps.Point(0, -29)
		});
		var infowindow = new google.maps.InfoWindow();   
		
		google.maps.event.addListener(marker, 'click', function() {
			var iwContent = '<div id="iw_container">' +
			'<div class="iw_title"><b>Location</b> : '+address+'</div></div>';
			// including content to the infowindow
			infowindow.setContent(iwContent);
			// opening the infowindow in the current map and at the current marker location
			infowindow.open(map, marker);
		});
	}
	
	function getLatLong() {		
		var geocoder = new google.maps.Geocoder();
		var address = document.getElementById('school_address').value;
		
		geocoder.geocode( { 'address': address}, function(results, status) {
			if (status == google.maps.GeocoderStatus.OK) {
				var latitude = results[0].geometry.location.lat();
				var longitude = results[0].geometry.location.lng();
				document.getElementById('lat').value = latitude;
				document.getElementById('long').value = longitude;
			} 
		}); 
	}
	
	google.maps.event.addDomListener(window, 'load', function () {
		
		var options = {
			types: ['(cities)'],
			componentRestrictions: {country: "sa"},
			strictBounds: true
		};
		var places;
		var guardians_address;
		var current_address;
		var permanent_address;
		/*if($('#autocomplete').length > 0) {
			places = new google.maps.places.Autocomplete(document.getElementById('autocomplete'), options);
			google.maps.event.addListener(places, 'place_changed', function () {
			});
			}
			if($('#guardians_address').length > 0) {
			guardians_address = new google.maps.places.Autocomplete(document.getElementById('guardians_address'), options);
			google.maps.event.addListener(guardians_address, 'place_changed', function () {
			var place = guardians_address.getPlace();
			var latitude = place.geometry.location.lat();
			var longitude = place.geometry.location.lng();
			var latlng = new google.maps.LatLng(latitude, longitude);
			InitializeMap('guardians_address_map',latlng);
			});
		}*/
		
		if($('#guardians_address').length > 0) {
			guardians_address = new google.maps.places.Autocomplete(document.getElementById('guardians_address'), options);
			google.maps.event.addListener(guardians_address, 'place_changed', function () {
				var place_guardians_address = guardians_address.getPlace();
				var address_guardians_address = place_guardians_address.adr_address;
				var latitude_guardians_address = place_guardians_address.geometry.location.lat();
				var longitude_guardians_address = place_guardians_address.geometry.location.lng();
				var latlng_guardians_address = new google.maps.LatLng(latitude_guardians_address, longitude_guardians_address);
				InitializeMap('guardians_address_map',latlng_guardians_address,address_guardians_address);
				document.getElementById('guardians_address_map').style.height = '400px';
				document.getElementById('guardians_address_lat').value = latitude_guardians_address;
				document.getElementById('guardians_address_long').value = longitude_guardians_address;
			});
		}
		
		if($('#current_address').length > 0) {
			current_address = new google.maps.places.Autocomplete(document.getElementById('current_address'), options);
			google.maps.event.addListener(current_address, 'place_changed', function () {
				var place_current_address = current_address.getPlace();
				var address_current_address = place_current_address.adr_address;
				var latitude_current_address = place_current_address.geometry.location.lat();
				var longitude_current_address = place_current_address.geometry.location.lng();
				var latlng_current_address = new google.maps.LatLng(latitude_current_address, longitude_current_address);
				InitializeMap('current_address_map',latlng_current_address,address_current_address);
				document.getElementById('current_address_map').style.height = '400px';
				document.getElementById('current_address_lat').value = latitude_current_address;
				document.getElementById('current_address_long').value = longitude_current_address;
			});
		}
		
		if($('#permanent_address').length > 0) {
			permanent_address = new google.maps.places.Autocomplete(document.getElementById('permanent_address'), options);
			google.maps.event.addListener(permanent_address, 'place_changed', function () {
				var place_permanent_address = permanent_address.getPlace();
				var address_permanent_address = place_permanent_address.adr_address;
				var latitude_permanent_address = place_permanent_address.geometry.location.lat();
				var longitude_permanent_address = place_permanent_address.geometry.location.lng();
				var latlng_permanent_address = new google.maps.LatLng(latitude_permanent_address, longitude_permanent_address);
				InitializeMap('permanent_address_map',latlng_permanent_address,address_permanent_address);
				document.getElementById('permanent_address_map').style.height = '400px';
				document.getElementById('permanent_address_lat').value = latitude_permanent_address;
				document.getElementById('permanent_address_long').value = longitude_permanent_address;
			});
		}
		
		/*if($('#permanent_address').length > 0) {
			permanent_address = new google.maps.places.Autocomplete(document.getElementById('permanent_address'), options);
			google.maps.event.addListener(permanent_address, 'place_changed', function () {
			var place = permanent_address.getPlace();
			var latitude = place.geometry.location.lat();
			var longitude = place.geometry.location.lng();
			var latlng = new google.maps.LatLng(latitude, longitude);
			InitializeMap('permanent_address_map',latlng);
			});
		}*/
	});
	
	function updateUserTheme(id) {
		$.ajax({
			type: 'post',
			url: '/set-user-theme',
			data: {theme_name: id},
			success: function (data) {
				setTimeout(function() {
					toastr.success(id+" theme set now!", "Success", {
						timeOut: 3000,
					});
				}, 500);
			},
			error: function (data) {
				setTimeout(function() {
					toastr.error("Somethning went wrong!", "Error Alert", {
						timeOut: 5000,
					});
				}, 500);
			},
		});
	}
	
	
	/* Color Themes Script */
	$('#white-theme').click(white);
	$('#blueblack-theme').click(blueblack);
	$('#darkblueblack-theme').click(darkblueblack);
	$('#dark-orange-theme').click(darkorange);
	$('#light-orange-theme').click(lightorange);
	$('#dark-blue-theme').click(darkblue);
	$('#light-blue-theme').click(lightblue);
	$('#cyan-theme').click(cyan);
	$('#green-theme').click(green);
	$('#brightblue-theme').click(brightblue);
	$('#purple-theme').click(purple);
	$('#darkred-theme').click(darkred);
	$('#turkishaqua-theme').click(turkishaqua);
	$('#barared-theme').click(barared);
	$('#magentapurple-theme').click(magentapurple);
	$('#greycyan-theme').click(greycyan);
	$('#greyorange-theme').click(greyorange);
	$('#midnightblue-theme').click(midnightblue);
	$('#green-beige-theme').click(greenBeige);
	$('#navy-teal-theme').click(navyTeal);
	
	function white() {$('body').attr('id', 'white'); updateUserTheme('white');}
	function blueblack() {$('body').attr('id', 'blueblack'); updateUserTheme('blueblack');}
	function darkblueblack() {$('body').attr('id', 'darkblueblack'); updateUserTheme('darkblueblack');}
	function darkorange() {$('body').attr('id', 'dark-orange'); updateUserTheme('dark-orange');}
	function lightorange() {$('body').attr('id', 'light-orange'); updateUserTheme('light-orange');}
	function darkblue() {$('body').attr('id', 'dark-blue'); updateUserTheme('dark-blue');}
	function lightblue() {$('body').attr('id', 'light-blue'); updateUserTheme('light-blue');}
	function cyan() {$('body').attr('id', 'cyan'); updateUserTheme('cyan');}
	function green() {$('body').attr('id', 'green'); updateUserTheme('green');}
	function brightblue() {$('body').attr('id', 'brightblue'); updateUserTheme('brightblue');}
	function purple() {$('body').attr('id', 'purple'); updateUserTheme('purple');}
	function darkred() {$('body').attr('id', 'darkred'); updateUserTheme('darkred');}
	function turkishaqua() {$('body').attr('id', 'turkishaqua'); updateUserTheme('turkishaqua');}
	function barared() {$('body').attr('id', 'barared'); updateUserTheme('barared');}
	function magentapurple() {$('body').attr('id', 'magentapurple'); updateUserTheme('magentapurple');}
	function greycyan() {$('body').attr('id', 'greycyan'); updateUserTheme('greycyan');}
	function greyorange() {$('body').attr('id', 'greyorange'); updateUserTheme('greyorange');}
	function midnightblue() {$('body').attr('id', 'midnightblue'); updateUserTheme('midnightblue');}
	function greenBeige() {$('body').attr('id', 'green-beige'); updateUserTheme('green-beige');}
	function navyTeal() {$('body').attr('id', 'navy-teal'); updateUserTheme('navy-teal');}
	
	/* Start Medical Report */
	$('.input-field').on('focus', function() {
		if ($('.new-input').length == 0) {
			$('.parent').append('<input type="text" class="primary_input_field form-control new-input" />');
			$('.new-input').last().fadeIn();
		}
	});
	
	$('.parent').on('focus', '.new-input', function() {
		if ($(this).val() == '') {
			$(this).parent().append('<input type="text" class="primary_input_field form-control new-input" />');
			$('.new-input').last().fadeIn();
		}
	});
	
	$('.parent').on('blur', '.new-input', function() {
		if ($(this).val() == '') {
			$(this).remove();
		}
	});
	$('.parent').on('blur', '.input-field', function() {
		if ($(this).val() == '') {
			$(this).remove();
		}
	});
	
	
	$('.input-field2').on('focus', function() {
		if ($('.new-input2').length == 0) {
			$('.parent2').append('<input type="text" class="primary_input_field form-control new-input2" />');
			$('.new-input2').last().fadeIn();
		}
	});
	
	$('.parent2').on('focus', '.new-input2', function() {
		if ($(this).val() == '') {
			$(this).parent().append('<input type="text" class="primary_input_field form-control new-input2" />');
			$('.new-input2').last().fadeIn();
		}
	});
	
	$('.parent2').on('blur', '.new-input2', function() {
		if ($(this).val() == '') {
			$(this).remove();
		}
	});
	$('.parent2').on('blur', '.input-field2', function() {
		if ($(this).val() == '') {
			$(this).remove();
		}
	});
	/* End Medical Report */
	
	function showPickUpArrieved(){
		$('#modalPopParentPickDrop').modal('show');
	}
	
	
	function actionPickUpArrieved(id,type) {
		$.ajax({
			type: 'post',
			url: '/send-notification-when-parent-reached-web',
			data: {type: type,id: id},
			success: function (data) {
				setTimeout(function() {
					toastr.success(data, "Success", {
						timeOut: 3000,
					});
				}, 500);
			},
			error: function (data) {
				setTimeout(function() {
					toastr.error("Somethning went wrong!", "Error Alert", {
						timeOut: 5000,
					});
				}, 500);
			},
		});
	}
	
	
	function addMathSymboles(id,value) {
		var text = $('.'+id).val();
		text = text + ' ' + value;
		$('.'+id).val(text);
		$('#modalPopCheckMathematics').modal('hide');
	}
	
	function showMethameticsSymboles() {
		$.ajax({
			type: "GET",
			url: "math_symbol.txt",
			dataType: "text",
			success: function(data) {
				var allTextLines = data.split(/\r\n/);
				var headers = allTextLines[0].split(',');
				var lines = [];
				var html = '<table style="display: math;">';
				var is_break = 1;
				for (var i=0; i<allTextLines.length; i++) {
					var dataArray = allTextLines[i].split(',');
					if(is_break == 1) {
						html += '<tr>';
					}
					if(is_break != 8) {
						html += '<td style="cursor:pointer;" onclick=addMathSymboles("mathematicsSymbol","'+dataArray[1]+'")>'+dataArray[0]+'</td><td>'+dataArray[1]+'</td>';
					}
					if(is_break == 8) {
						html += '</tr>';
					}
					is_break++;
					if(is_break == 8){
						is_break = 1;
					}
				}
				html += '<table>';
				$('#tableMathematics').html(html);
			}
		});
	}
	
	$(document).ready(function() {
		<?php if(Auth()->user()->is_confirmation == 0 && Auth()->user()->is_photo_confirmation == 0 && Auth()->user()->role_id == 3) { ?>
			$("#modalPopParentConfirmation").modal("show");
		<?php } ?>
		
		$('.mathematicsSymbol').bind('keypress', function(e) {
			var text = $(this).val();
            if (e.which == 32 || e.which == 8){//space bar
				$.ajax({
					type: "GET",
					url: "math_symbol.txt",
					dataType: "text",
					success: function(data) {
						var allTextLines = data.split(/\r\n/);
						var headers = allTextLines[0].split(',');
						var lines = [];
						for (var i=0; i<allTextLines.length; i++) {
							var dataArray = allTextLines[i].split(',');
							
							if(text.indexOf(dataArray[0]) != -1){
								text = text.replace(dataArray[0], dataArray[1]); 
								$('.mathematicsSymbol').val(text);
							}
						}
					}
				});
				
				
			}
		});
	});
	
	$(document).on("change",".is_photo_confirmation", function(){
		var is_photo_confirmation = $(this).val();
		if(is_photo_confirmation == 2){
			$("#snapchat_url_div").show();
			$("#snapchat_url").attr("required", true);
		}else{
			$("#snapchat_url_div").hide();
			$("#snapchat_url").removeAttr("required");
		}
	});
</script>
</body>

</html>						