<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>@lang('nursery.child_sleep_report')</title>
	<style type="text/css">
	   .report-section{
	   		width: 100%;
	   }
	   * { font-family: DejaVu Sans, sans-serif; }
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
                        <table class="report-section" style="border-collapse: collapse; width: 100%;">
                           <tr>
                              <td colspan="4">
                                 <h3>@lang('nursery.child_sleep_report')</h3>
                                 <table style="width: 100%;">
                                    <tr>
                                       <td><strong>@lang('nursery.child_name'):</strong></td>
                                       <td>{{ getStudentName($data[0]->student_id)->full_name }}</td>
                                       <td><strong style="margin-left: 12%;">@lang('nursery.report_date'):</strong></td>
                                       <td><?php $mytime = Carbon\Carbon::now(); ?>
                                          {{ $mytime->toDateString() }}
                                          <input type="hidden" name="date" value="{{ $mytime->toDateString() }}">
                                       </td>
                                    </tr>
                                 </table>
                              </td>
                           </tr>
                           <tr>
                              <th style="border: 1px solid black;">@lang('nursery.sleep_from')</th>
                              <th style="border: 1px solid black;">@lang('nursery.sleep_till')</th>
                              <th style="border: 1px solid black;">@lang('nursery.quality_of_sleep')</th>
                              <th style="border: 1px solid black;">@lang('nursery.notes')</th>
                           </tr>
                           <?php foreach ($data as $key => $value): ?>
                           <tr>
                              <td style="border: 1px solid black;">{{ $value->sleep_from }}</td>
                              <td style="border: 1px solid black;">{{ $value->sleep_till }}</td>
                              <td style="border: 1px solid black;">{{ $value->quality_of_sleep }}</td>
                              <td style="border: 1px solid black;">{{ $value->notes }}</td>
                           </tr>
                           <?php endforeach ?>
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