<!DOCTYPE html>
<html>
<head>
    <title>@lang('nursery.child_cleaning_report')</title>
    <style type="text/css">
        * { font-family: DejaVu Sans, sans-serif; }
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
</head>
<body>
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
                            <span class="subtitle">@lang('nursery.description'):</span>
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
    </div>    
</body>
</html>
