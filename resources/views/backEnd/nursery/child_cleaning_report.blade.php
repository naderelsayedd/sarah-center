@extends('backEnd.master')
@section('title')
@lang('nursery.child_cleaning_report')
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
         <h1>@lang('nursery.child_cleaning_report')</h1>
         <div class="bc-pages">
            <a href="{{ route('dashboard') }}">@lang('common.dashboard')</a>
            <a href="#">@lang('nursery.nursery_section')</a>
            <a href="#">@lang('nursery.child_cleaning_report')</a>
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
                     <div class="card-header" id="headingOne" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                        <h3 class="mb-0">
                           @lang('nursery.add_cleaning_report')
                        </h3>
                     </div>
                     <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                        <div class="card-body">
                           <form action="{{ route('post-child-cleaning-report') }}" method="post">
                              @csrf
                              <div class="row mt-15" id="exam_shedule">
                                 <div class="col-lg-12">
                                    <div class="container">
                                       <div class="row mt-15">
                                          <div class="col-lg-12">
                                             <h3 class="mb-30">@lang('nursery.child_cleaning_report')</h3>
                                             <div class="row py-3">
                                                <div class="col-6">
                                                   <strong>@lang('nursery.child_name'):</strong>
                                                   <select id="student-select" name="student_id" class="primary_select form-control" style="display:none;">
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
                                             <div class="report-table">
                                                <table class="report-section">
                                                   <thead>
                                                      <tr>
                                                         <th>@lang('nursery.general_cleanliness_status')</th>
                                                         <th>@lang('nursery.peronal_cleanliness_status')</th>
                                                      </tr>
                                                   </thead>
                                                   <tbody>
                                                      <tr>
                                                         <td>Description of the child's general cleanliness (Hair - Clothes - Body)
                                                            <div class="row">
                                                               <div class="col-sm-6">
                                                                  <span>@lang('nursery.hair') :</span>
                                                               </div>
                                                               <div class="col-sm-3">
                                                                  <input type="radio" name="hair" value="1">
                                                                  <label>@lang('nursery.yes')</label>
                                                               </div>
                                                               <div class="col-sm-3">
                                                                  <input type="radio" name="hair" value="0">
                                                                  <label>@lang('nursery.no')</label>
                                                               </div>
                                                            </div>
                                                            <div class="row">
                                                               <div class="col-sm-6">
                                                                  <span>@lang('nursery.cloth') :</span>
                                                               </div>
                                                               <div class="col-sm-3">
                                                                  <input type="radio" name="cloth" value="1">
                                                                  <label>@lang('nursery.yes')</label>
                                                               </div>
                                                               <div class="col-sm-3">
                                                                  <input type="radio" name="cloth" value="0">
                                                                  <label>@lang('nursery.no')</label>
                                                               </div>
                                                            </div>
                                                            <div class="row">
                                                               <div class="col-sm-6">
                                                                  <span>@lang('nursery.body') :</span>
                                                               </div>
                                                               <div class="col-sm-3">
                                                                  <input type="radio" name="body" value="1">
                                                                  <label>@lang('nursery.yes')</label>
                                                               </div>
                                                               <div class="col-sm-3">
                                                                  <input type="radio" name="body" value="0">
                                                                  <label>@lang('nursery.no')</label>
                                                               </div>
                                                            </div>
                                                            <div class="row">
                                                               <div class="col-sm-12">
                                                                  <span>@lang('nursery.description') :</span>
                                                                  <textarea class="form-control" name="general_cleanliness_description"></textarea>
                                                               </div>
                                                            </div>
                                                         </td>
                                                         <td>(showering - Use of bathing products and creams)
                                                            <div class="row">
                                                               <div class="col-sm-6">
                                                                  <span>@lang('nursery.showering') :</span>
                                                               </div>
                                                               <div class="col-sm-3">
                                                                  <input type="radio" name="showering" value="1">
                                                                  <label>@lang('nursery.yes')</label>
                                                               </div>
                                                               <div class="col-sm-3">
                                                                  <input type="radio" name="showering" value="0">
                                                                  <label>@lang('nursery.no')</label>
                                                               </div>
                                                            </div>
                                                            <div class="row">
                                                               <div class="col-sm-12">
                                                                  <span>@lang('nursery.description') :</span>
                                                                  <textarea class="form-control" name="general_cleanliness_description_second" rows="4"></textarea>
                                                               </div>
                                                            </div>
                                                         </td>
                                                      </tr>
                                                   </tbody>
                                                </table>
                                             </div>
                                             <div class="report-table mt-3 py-3">
                                                <strong>@lang('nursery.diaper_status')</strong>
                                                <table class="report-section">
                                                   <thead>
                                                      <tr>
                                                         <th>@lang('nursery.time')</th>
                                                         <th>@lang('nursery.notes')</th>
                                                      </tr>
                                                   </thead>
                                                   <tbody>
                                                      <tr>
                                                         <td>12:00 PM</td>
                                                         <td>
                                                            <textarea class="form-control" name="diaper_status_first"></textarea>
                                                         </td>
                                                      </tr>
                                                      <tr>
                                                         <td>2:00 PM</td>
                                                         <td>
                                                            <textarea class="form-control" name="diaper_status_second"></textarea>
                                                         </td>
                                                      </tr>
                                                      <tr>
                                                         <td>3:00 PM</td>
                                                         <td>
                                                            <textarea class="form-control" name="diaper_status_third"></textarea>
                                                         </td>
                                                      </tr>
                                                      <tr>
                                                         <td>4:00 PM</td>
                                                         <td>
                                                            <textarea class="form-control" name="diaper_status_fourth"></textarea>
                                                         </td>
                                                      </tr>
                                                   </tbody>
                                                </table>
                                             </div>
                                             <div class="report-table mt-3">
                                                <table class="report-section">
                                                   <thead>
                                                      <tr>
                                                         <th>Other Notes</th>
                                                      </tr>
                                                   </thead>
                                                   <tbody>
                                                      <tr>
                                                         <td>
                                                            <textarea class="form-control" name="other_notes" rows="5"></textarea>
                                                         </td>
                                                      </tr>
                                                   </tbody>
                                                </table>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="col-lg-12 text-center">
                                          <button class="primary-btn fix-gr-bg submit mt-30" data-toggle="tooltip" title="{{ @$tooltip }}">
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
                     <div class="card-header" id="headingTwo" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo" >
                        <h3 class="mb-0">
                           @lang('nursery.child_cleaning_report')
                        </h3>
                     </div>
                     <div id="collapseTwo" class="collapse show" aria-labelledby="headingTwo" data-parent="#accordion">
                        <div class="card-body">
                           <!-- Add your table of reports here -->
                           <div class="report-table">
                              <table class="table table-bordered">
                                 <thead>
                                    <tr>
                                       <th>Report Date</th>
                                       <th>Child Name</th>
                                       <th>Other Notes</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <?php foreach ($reports as $key => $value): ?>
                                       <tr>
                                          <td>{{$value->date}}</td>
                                          <td>{{getStudentName($value->student_id)->full_name}}</td>
                                          <td>{{$value->other_notes}}</td>
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