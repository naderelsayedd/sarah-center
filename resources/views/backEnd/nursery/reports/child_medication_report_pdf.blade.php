<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@lang('nursery.child_medication_report')</title>
    <style type="text/css">
        * { font-family: DejaVu Sans, sans-serif; }
        .report-section{
            width: 100%;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        .container-fluid {
            margin-right: auto;
            margin-left: auto;
            padding-right: 15px;
            padding-left: 15px;
        }
        .row {
            width: 100%;
            display: flex;
            flex-wrap: wrap;
        }
        .col-lg-12 {
            width: 100%;
            flex: 0 0 100%;
            max-width: 100%;
            padding-right: 15px;
            padding-left: 15px;
        }
        .white-box {
            background-color: #fff;
            border-radius: 6px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 0.46875rem 2.1875rem rgba(90,97,105,.1), 0 0.9375rem 1.40625rem rgba(90,97,105,.1), 0 0.25rem 0.53125rem rgba(90,97,105,.12), 0 0.125rem 0.1875rem rgba(90,97,105,.1);
        }
        .mb-30 {
            margin-bottom: 30px;
        }
    </style>
</head>
<body>
    <table class="report-section">
        <tr>
            <td>
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
                                                        <table class="report-section">
                                                            <tr>
                                                                <th>@lang('nursery.child_name'):</th>
                                                                <td>{{getStudentName($data[0]->student_id)->full_name}}</td>
                                                            </tr>
                                                            <tr>
                                                                <th style="margin-left: 12%;">Report Date:</th>
                                                                <td>{{$data[0]->date}}</td>
                                                            </tr>
                                                        </table>
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
                            </div>
                        </div>
                    </div>
                </section>
            </td>
        </tr>
    </table>
</body>
</html>
