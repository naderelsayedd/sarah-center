@extends('backEnd.master')
@section('title')
@lang('nursery.child_cleaning_report')
@endsection
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style type="text/css">
    .report-section{
        width: 100%;
        border-collapse: collapse;
    }
    .report-section, .report-section th, .report-section td {
        border: 1px solid black;
    }
    .report-section th, .report-section td {
        padding: 8px;
        text-align: left;
    }
    .report-section .title {
        font-weight: bold;
    }
    .report-section .subtitle {
        margin-left: 20px;
    }
    .container {
        width: 100%;
        margin: 0 auto;
    }
    .text-center {
        text-align: center;
    }
</style>
@section('mainContent')
<!-- page content goes here -->
<section class="sms-breadcrumb mb-40 white-box">
   <div class="container">
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
   <div class="container">
      <div class="row">
         <div class="col-lg-12">
            <div class="row mt-15" id="exam_shedule">
               <div class="col-lg-12">
                  <div class="white-box mt-10">
                     <div class="container">
                        <h3 class="mb-30 text-center">@lang('nursery.child_cleaning_report')</h3>
                        <table class="report-section">
                            <tr>
                                <td class="title">@lang('nursery.child_name'):</td>
                                <td>{{getStudentName($data->student_id)->full_name}}</td>
                                <td class="title">Report Date:</td>
                                <td>{{$data->date}}</td>
                            </tr>
                        </table>
                        <table class="report-section mt-3">
                            <thead>
                                <tr>
                                    <th>@lang('nursery.general_cleanliness_status')</th>
                                    <th>@lang('nursery.peronal_cleanliness_status')</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div>
                                            <span class="subtitle">@lang('nursery.hair'):</span>
                                            <span>{{ ($data->hair == 1) ? __('nursery.yes') : __('nursery.no') }}</span>
                                        </div>
                                        <div>
                                            <span class="subtitle">@lang('nursery.cloth'):</span>
                                            <span>{{ ($data->cloth == 1) ? __('nursery.yes') : __('nursery.no') }}</span>
                                        </div>
                                        <div>
                                            <span class="subtitle">@lang('nursery.body'):</span>
                                            <span>{{ ($data->body == 1) ? __('nursery.yes') : __('nursery.no') }}</span>
                                        </div>
                                        <div>
                                            <span class="subtitle">@lang('nursery.description'):</span>
                                            <span>{{ ($data->general_cleanliness_description) ? $data->general_cleanliness_description : '' }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <span class="subtitle">@lang('nursery.showering'):</span>
                                            <span>{{ ($data->showering == 1) ? __('nursery.yes') : __('nursery.no') }}</span>
                                        </div>
                                        <div>
                                            <span class="subtitle">
                                            @lang('nursery.description'):</span>
                                            <span>{{ ($data->general_cleanliness_description_second) ? $data->general_cleanliness_description_second : '' }}</span>
                                        </div>

                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table class="report-section mt-3">
                            <thead>
                                <tr>
                                    <th colspan="2">@lang('nursery.diaper_status')</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div>
                                            <span class="subtitle">@lang('nursery.time'): </span>
                                            <span>12:00 PM</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <span class="subtitle">@lang('nursery.notes'): </span>
                                            <span>{{ ($data->diaper_status_first) ? $data->diaper_status_first : '' }}</span>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div>
                                            <span class="subtitle">@lang('nursery.time'): </span>
                                            <span>2:00 PM</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <span class="subtitle">@lang('nursery.notes'): </span>
                                            <span>{{ ($data->diaper_status_second) ? $data->diaper_status_second : '' }}</span>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div>
                                            <span class="subtitle">@lang('nursery.time'): </span>
                                            <span>3:00 PM</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <span class="subtitle">@lang('nursery.notes'): </span>
                                            <span>{{ ($data->diaper_status_third) ? $data->diaper_status_third : '' }}</span>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div>
                                            <span class="subtitle">@lang('nursery.time'): </span>
                                            <span>4:00 PM</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <span class="subtitle">@lang('nursery.notes'): </span>
                                            <span>{{ ($data->diaper_status_fourth) ? $data->diaper_status_fourth : '' }}</span>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table class="report-section mt-3">
                            <thead>
                                <tr>
                                    <th>Other Notes</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div>{{ ($data->other_notes) ? $data->other_notes : '' }}</div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="text-center mt-15">
                            <a class="primary-btn fix-gr-bg" href="{{ route('download-child-cleaning-report', $data->id) }}" data-toggle="tooltip"
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
<!-- script ends here -->
@endpush
@include('backEnd.partials.data_table_js')
