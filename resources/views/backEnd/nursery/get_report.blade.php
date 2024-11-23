@extends('backEnd.master')
@section('title')
@lang('nursery.nursery_report')
@endsection
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style type="text/css">
	.report-section{
    	width: 100%;
	}
   .datepicker.dropdown-menu{display: none !important;}
</style>
@section('mainContent')
<!-- page content goes here -->
<section class="sms-breadcrumb mb-40 white-box">
   <div class="container-fluid">
      <div class="row justify-content-between">
         <h1>@lang('nursery.nursery_report')</h1>
         <div class="bc-pages">
            <a href="{{ route('dashboard') }}">@lang('common.dashboard')</a>
            <a href="#">@lang('nursery.nursery_section')</a>
            <a href="#">@lang('nursery.nursery_report')</a>
         </div>
      </div>
   </div>
</section>
<section class="admin-visitor-area up_st_admin_visitor">
   <div class="container-fluid p-0">
      <div class="row">
         <div class="col-lg-12">
         <form action="{{ route('post-nursery-report') }}" method="post">
         	@csrf
            <div class="row mt-15" id="exam_shedule">
               <div class="col-lg-12">
                  <div class="white-box mt-10">
                     <div class="container">
                     	<div class="row mt-15">
                        	<div class="col-lg-12">
                        		<h3 class="mb-30">@lang('nursery.nursery_report')</h3>
		                        <div class="row">
		                           <div class="col-4">
                                    <strong>@lang('nursery.child_name'):</strong>
                                    <select id="student-select" name="student_id" class="nice-select primary_select form-control">
                                       <option selected disabled>@lang('nursery.select_student')</option>
                                       <?php foreach ($students as $key => $value): ?>
                                          <option value="{{ $value->id }}">{{ $value->full_name }}</option>
                                       <?php endforeach ?>
                                    </select>
		                           </div>
		                           <div class="col-4">
		                           		<strong>@lang('nursery.report_date'):</strong> 
                                        <input type="date" name="date" class="primary_input_field  primary_input_field date form-control">
		                           </div>
                                   <div class="col-4">
                                        <strong>@lang('nursery.report_type'):</strong>
                                        <select class="nice-select primary_select form-control" name="report_type">
                                            <option selected disabled>@lang('nursery.select_report_type')</option>
                                            <option value="1">@lang('nursery.child_medication_report')</option>
                                            <option value="2">@lang('nursery.child_nutrition_report')</option>
                                            <option value="3">@lang('nursery.child_cleaning_report')</option>
                                            <option value="4">@lang('nursery.child_sleep_report')</option>
                                        </select>
                                   </div>
		                        </div>
                        	</div>
                        </div>
                     </div>	
                  </div>
               </div>
            </div>
            <div class="row mt-15">
               <div class="col-lg-12">
                  <div class="white-box">
                     <div class="row mt-15">
                        <div class="col-lg-12 text-center">
                           <button class="primary-btn fix-gr-bg submit" data-toggle="tooltip"
                              title="{{ @$tooltip }}">
                           <span class="ti-check"></span>
                           		@lang('common.save')
                           </button>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
        </form>
         </div>
      </div>
   </div>
</section>
<!-- page content ends here -->
@endsection
@include('backEnd.partials.date_picker_css_js')
@push('script')
<!-- script goes here --> 
<!-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('#student-select').select2({
            placeholder: "Select a student",
            allowClear: true
        });
    });
</script> -->
<!-- script ends here -->
@endpush
@include('backEnd.partials.data_table_js')