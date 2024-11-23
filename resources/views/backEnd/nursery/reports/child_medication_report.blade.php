@extends('backEnd.master')
@section('title')
@lang('nursery.child_medication_report')
@endsection
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
            <div class="row mt-15" id="exam_shedule">
               <div class="col-lg-12">
                  <div class="white-box mt-10">
                     <div class="container">
                        <h3 class="mb-30">@lang('nursery.child_medication_report')</h3>
                        <div class="row">
                           <div class="col-6">
                                <strong>@lang('nursery.child_name'):</strong>
                                <span>{{getStudentName($data[0]->student_id)->full_name}}</span>
                           </div>
                           <div class="col-6">
                                <strong style="margin-left: 12%;">Report Date:</strong> 
                                <span>{{$data[0]->date}}</span>
                           </div>
                        </div>
                        <div class="report-table mt-3">
                           <table class="report-section">
                              <thead>
                                 <tr>
                                    <th>@lang('nursery.medication_name')</th>
                                    <th>@lang('nursery.dosage') (ML.)</th>
                                    <th>@lang('nursery.time')</th>
                                    <th>@lang('nursery.notes')</th>
                                 </tr>
                              </thead>
                              <tbody id="form-container">
                                  <?php foreach ($data as $key => $value): ?>
                                    <tr>
                                        <td>{{ $value->medication_name }}</td>
                                        <td>{{ $value->dosage }}</td>
                                        <td>{{ $value->time }}</td>
                                        <td>{{ $value->notes }}</td>
                                    </tr>
                                  <?php endforeach ?>
                              </tbody>
                           </table>
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
                           <a class="primary-btn fix-gr-bg" href="{{ route('download-child-medication-report', [$data[0]->student_id,$data[0]->date]) }}" data-toggle="tooltip"
                              title="{{ @$tooltip }}">
                            <span class="ti-check"></span>
                                @lang('common.print')
                           </a>
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


<!-- script ends here -->
@endpush
@include('backEnd.partials.data_table_js')
