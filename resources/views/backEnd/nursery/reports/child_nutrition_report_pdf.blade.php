<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>@lang('nursery.child_nutrition_report')</title>
	<style type="text/css">
	   .report-section{
	   width: 100%;
	   }
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
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
</body>
</html>