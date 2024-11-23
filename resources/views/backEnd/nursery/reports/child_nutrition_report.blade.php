@extends('backEnd.master')
@section('title')
@lang('nursery.child_nutrition_report')
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
         <h1>@lang('nursery.child_nutrition_report')</h1>
         <div class="bc-pages">
            <a href="{{ route('dashboard') }}">@lang('common.dashboard')</a>
            <a href="#">@lang('nursery.nursery_section')</a>
            <a href="#">@lang('nursery.child_nutrition_report')</a>
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
                        <table class="report-section" style="border-collapse: collapse;">
                           <tr>
                              <td colspan="4">
                                 <h3>@lang('nursery.child_nutrition_report')</h3>
                                 <table style="width: 100%;">
                                    <tr>
                                       <td style="border: 1px solid #000;"><strong>@lang('nursery.child_name'):</strong></td>
                                       <td style="border: 1px solid #000;">{{ getStudentName($data[0]->student_id)->full_name }}</td>
                                       <td style="border: 1px solid #000;"><strong style="margin-left: 12%;">@lang('nursery.report_date'):</strong></td>
                                       <td style="border: 1px solid #000;">{{ $data[0]->date }}</td>
                                    </tr>
                                 </table>
                              </td>
                           </tr>
                           <tr>
                              <td colspan="4">
                                 <table class="report-section" style="border: 1px solid #000; width: 100%;">
                                    <tr>
                                       <th style="border: 1px solid #000;">@lang('nursery.meal')</th>
                                       <th style="border: 1px solid #000;">@lang('nursery.quantity') (ML.)</th>
                                       <th style="border: 1px solid #000;">@lang('nursery.time')</th>
                                       <th style="border: 1px solid #000;">@lang('nursery.notes')</th>
                                    </tr>
                                    @foreach ($data as $key => $value)
                                    <tr>
                                       <td style="border: 1px solid #000;">{{ $value->meal }}</td>
                                       <td style="border: 1px solid #000;">{{ $value->quantity }}</td>
                                       <td style="border: 1px solid #000;">{{ $value->time }}</td>
                                       <td style="border: 1px solid #000;">{{ $value->note }}</td>
                                    </tr>
                                    @endforeach
                                 </table>
                              </td>
                           </tr>
                        </table>
                        <div class="row mt-15">
                           <div class="col-lg-12 text-center">
                              <a class="primary-btn fix-gr-bg" href="{{ route('download-child-nutrition-report', [$data[0]->student_id,$data[0]->date]) }}" data-toggle="tooltip"
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