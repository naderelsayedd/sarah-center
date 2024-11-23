@extends('backEnd.master')
@section('title')
@lang('nursery.child_medication_report')
@endsection
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style type="text/css">
	.report-section{
    	width: 100%;
	}
</style>
@section('mainContent')
<!-- page content goes here -->
<section class="sms-breadcrumb mb-40 white-box">
   <div class="container-fluid">
      <div class="row justify-content-between">
         <h1>@lang('nursery.child_medication_report')</h1>
         <div class="bc-pages">
            <a href="{{ route('dashboard') }}">@lang('common.dashboard')</a>
            <a href="#">@lang('nursery.nursery_section')</a>
            <a href="#">@lang('nursery.child_medication_report')</a>
         </div>
      </div>
   </div>
</section>
<section class="admin-visitor-area up_st_admin_visitor">
   <div class="container-fluid p-0">
      <div class="row">
         <div class="col-lg-12">
            <div class="new-forms">
               <div id="accordion">
                  <div class="card">
                     <div class="card-header" id="headingOne" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne" style="background-color: white;">
                        <h3 class="mb-0">
                           @lang('nursery.add_child_medication_report')
                        </h3>
                     </div>
                     <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                        <div class="card-body">
                           <form action="{{ route('post-child-medication-report') }}" method="post">
                              @csrf
                              <div class="row mt-15" id="exam_shedule">
                                 <div class="col-lg-12">
                                    <div class="container">
                                       <div class="row mt-15">
                                          <div class="col-lg-12">
                                             <h3 class="mb-30">@lang('nursery.child_medication_report')</h3>
                                             <div class="row">
                                                <div class="col-6">
                                                   <strong>@lang('nursery.child_name'):</strong>
                                                   <select id="student-select" name="student_id" class="nice-select primary_select form-control">
                                                      <option selected disabled>@lang('nursery.select_student')</option>
                                                      <?php foreach ($students as $key => $value): ?>
                                                      <option value="{{ $value->id }}">{{ $value->full_name }}</option>
                                                      <?php endforeach ?>
                                                   </select>
                                                </div>
                                                <div class="col-6">
                                                   <strong style="margin-left: 12%;">Report Date:</strong>
                                                   <?php $mytime = Carbon\Carbon::now(); ?>
                                                   {{$mytime->toDateString()}}
                                                   <input type="hidden" name="date" value="{{$mytime->toDateString()}}">
                                                </div>
                                             </div>
                                             <div class="row" id="form-container">
                                                <div class="col-sm-3">
                                                   <span>@lang('nursery.medication_name')</span>
                                                   <input type="text" name="medication_name[]" placeholder="@lang('nursery.medication_name')" class="form-control">
                                                </div>
                                                <div class="col-sm-3">
                                                   <span>@lang('nursery.dosage') (ML.)</span>
                                                   <input type="number" placeholder="@lang('nursery.dosage')" name="dosage[]" class="form-control">
                                                </div>
                                                <div class="col-sm-3">
                                                   <span>@lang('nursery.time')</span>
                                                   <input type="time" placeholder="@lang('nursery.time')" name="time[]" class="form-control">
                                                </div>
                                                <div class="col-sm-2">
                                                   <span>@lang('nursery.notes')</span>
                                                   <input type="text" placeholder="@lang('nursery.notes')" name="notes[]" class="form-control">
                                                </div>
                                                <div class="col-sm-1">
                                                   <span>@lang('nursery.add_more')</span>
                                                   <button type="button" class="primary-btn add-more">+</button>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="col-lg-12 text-center mt-3">
                                          <button class="primary-btn fix-gr-bg submit" data-toggle="tooltip" title="{{ @$tooltip }}">
                                          <span class="ti-check"></span>
                                          @lang('common.save')
                                          </button>
                                       </div>
                                    </div>  
                                 </div>
                              </div>
                           </form>
                        </div>
                     </div>
                  </div>
                  <div class="card">
                     <div class="card-header" id="headingTwo" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo"  style="background-color: white;">
                        <h3 class="mb-0">
                           @lang('nursery.child_medication_report')
                        </h3>
                     </div>
                     <div id="collapseTwo" class="collapse show" aria-labelledby="headingTwo" data-parent="#accordion">
                        <div class="card-body">
                           <!-- Add your table of reports here -->
                           <div class="report-table">
                              <table class="table table-bordered">
                                 <thead>
                                    <tr>
                                       <th>Sr.</th>
                                       <th>Report Date</th>
                                       <th>Child Name</th>
                                 </thead>
                                 <tbody>
                                 <?php foreach ($reports as $key => $value): ?>
                                       <tr>
                                          <td>{{$key+1}}</td>
                                          <td>{{$value->date}}</td>
                                          <td>{{getStudentName($value->student_id)->full_name}}</td>
                                       </tr>
                                 <?php endforeach ?>
                                 </tbody>
                              </table>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
<!-- page content ends here -->
@endsection
@include('backEnd.partials.date_picker_css_js')
@push('script')
<!-- script goes here
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('#student-select').select2({
            placeholder: "Select a student",
            allowClear: true
        });
    });
</script> -->
<script>
    $(document).ready(function() {
        // Function to add more fields
        $(document).on('click', '.add-more', function() {
            var newRow = `
                <div class="row form-group" style="margin-left: 0%;width: 100%;">
                    <div class="col-sm-3">
                        <span>@lang('nursery.medication_name')</span>
                        <input type="text" name="medication_name[]" placeholder="@lang('nursery.medication_name')" class="form-control">
                    </div>
                    <div class="col-sm-3">
                        <span>@lang('nursery.dosage') (ML.)</span>
                        <input type="number" placeholder="@lang('nursery.dosage')" name="dosage[]" class="form-control">
                    </div>
                    <div class="col-sm-3">
                        <span>@lang('nursery.time')</span>
                        <input type="time" placeholder="@lang('nursery.time')" name="time[]" class="form-control">
                    </div>
                    <div class="col-sm-2">
                        <span>@lang('nursery.notes')</span>
                        <input type="text" placeholder="@lang('nursery.notes')" name="notes[]" class="form-control">
                    </div>
                    <div class="col-sm-1">
                        <span>@lang('nursery.remove')</span>
                        <button type="button" class="primary-btn remove-field">-</button>
                    </div>
                </div>
            `;
            $('#form-container').append(newRow);
        });

        // Function to remove fields
        $(document).on('click', '.remove-field', function() {
            $(this).closest('.row').remove();
        });
    });
</script>

<!-- script ends here -->
@endpush
@include('backEnd.partials.data_table_js')