<!doctype html>
<html lang="ar" dir="rtl">
   <head>
      <meta charset="utf-8">
      <title>التقرير اليومي للطفل</title>
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <link rel="stylesheet" href="include/css/bootstrap/bootstrap.min.css" type="text/css">
      <link rel="stylesheet" href="include/call-styles.css" type="text/css">
      <link rel="stylesheet" href="include/css/all.min.css">
      <link rel="stylesheet" href="include/css/fontawesome.min.css">
      <link rel="stylesheet" href="include/css/animate.css">
      <script src="include/js/wow.min.js"></script>
      <script>new WOW().init();</script>
   </head>
   <body id="light-blue">
      <div class="container">
         <div class="row">
            <div class="col-12">
               <div class="h3 text-center mb-3">التقرير اليومي للطفل</div>
               <div class="teacher-info mb-3">
                  <div class="info-field"><strong>اسم الطفل:</strong> </div>
                  <div class="info-field"><strong>اليوم:</strong> </div>
                  <div class="info-field"><strong>التاريخ:</strong> </div>
               </div>
               <div class="report-table">
                  <section class="student-details">
                     <div class="container-fluid p-0">
                        <div class="row">
                           <div class="col-lg-4 no-gutters">
                              <div class="main-title">
                                 <h3 class="mb-30 mt-30">@lang('reports.daily_report_for_class') </h3>
                              </div>
                           </div>
                        </div>
                        <div class="row">
                           <div class="col-lg-12">
                              <div class="white-box">
                                 <div class="container">
                                    <div class="row">
                                       <div class="col-12">
                                          <div class="h3 text-center mb-3">@lang('reports.daily_report_for_child')</div>
                                             @csrf
                                             <div class="teacher-info mb-3">
                                                <div class="info-field col-sm-6">
                                                   <strong>@lang('reports.child_name'):</strong>
                                                   {{$student_data->full_name}}
                                                </div>
                                             </div>
                                             <div class="report-table col-sm-12">
                                               <table class="report-section">
                                          <thead>
                                            <tr>
                                              <th colspan="6">@lang('reports.my_mood')</th>
                                            </tr>
                                          </thead>
                                          <tbody>
                                            <tr>
                                              <td style="border: 1px solid gray;padding-left: 15px;">@lang('reports.Happy')</td>
                                              <td style="border: 1px solid gray;padding-left: 15px;">@lang('reports.Energetic')</td>
                                              <td style="border: 1px solid gray;padding-left: 15px;">@lang('reports.Grumpy')</td>
                                              <td style="border: 1px solid gray;padding-left: 15px;">@lang('reports.Tired')</td>
                                              <td style="border: 1px solid gray;padding-left: 15px;">@lang('reports.Moody')</td>
                                              <td style="border: 1px solid gray;padding-left: 15px;">@lang('reports.Notes')</td>
                                            </tr>
                                                      <tr class="text-center">
                                                         <td style="border: 1px solid gray;padding: 15px;">
                                                            <div class="form-check">
                                                               <input class="form-check-input" type="radio" name="mood" id="mood" value="1" {{ ($report_data->mood == 1) ? 'checked':'' }}>
                                                            </div>
                                                         </td>
                                                         <td style="border: 1px solid gray;padding: 15px;">
                                                            <div class="form-check">
                                                               <input class="form-check-input" type="radio" name="mood" id="mood" value="2" {{ ($report_data->mood == 2) ? 'checked':'' }}>
                                                            </div>
                                                         </td>
                                                         <td style="border: 1px solid gray;padding: 15px;">
                                                            <div class="form-check">
                                                               <input class="form-check-input" type="radio" name="mood" id="mood" value="3" {{ ($report_data->mood == 3) ? 'checked':'' }}>
                                                            </div>
                                                         </td>
                                                         <td style="border: 1px solid gray;padding: 15px;">
                                                            <div class="form-check">
                                                               <input class="form-check-input" type="radio" name="mood" id="mood" value="4" {{ ($report_data->mood == 4) ? 'checked':'' }}>
                                                            </div>
                                                         </td>
                                                         <td style="border: 1px solid gray;padding: 15px;">
                                                            <div class="form-check">
                                                               <input class="form-check-input" type="radio" name="mood" id="mood" value="5" {{ ($report_data->mood == 5) ? 'checked':'' }}>
                                                            </div>
                                                         </td>
                                                         <td>
                                                            <div class="form-check">
                                                               <div class="form-check">
                                                                  <input class="form-control" type="text" name="mood_notes" id="mood_notes" value="{{ ($report_data->mood_notes) ? $report_data->mood_notes:'' }}">
                                                               </div>
                                                            </div>
                                                         </td>
                                                      </tr>
                                                   </tbody>
                                                </table>
                                                <table class="report-section">
                                          <thead>
                                            <tr>
                                              <th colspan="4">@lang('reports.number_of_time_using_bathroom')</th>
                                              <th colspan="2">@lang('reports.Sleep')</th>
                                              <th>@lang('reports.Other')</th>
                                            </tr>
                                          </thead>
                                          <tbody>
                                            <tr class="text-center">
                                              <td rowspan="2">@lang('reports.number_of_time')</td>
                                              <td>@lang('reports.Once')</td>
                                              <td>@lang('reports.Twice')</td>
                                              <td>@lang('reports.More')</td>
                                              <td>@lang('reports.From')</td>
                                              <td>@lang('reports.To')</td>
                                              <td rowspan="2"></td>
                                            </tr>
                                                      <tr class="text-center">
                                                         <td style="border: 1px solid gray;padding: 15px;">
                                                            <div class="form-check">
                                                               <input class="form-check-input" type="radio" name="bathroom" id="flexRadioDefault1" {{ ($report_data->bathroom == 1) ? 'checked':'' }}>
                                                            </div>
                                                         </td>
                                                         <td style="border: 1px solid gray;padding: 15px;">
                                                            <div class="form-check">
                                                               <input class="form-check-input" type="radio" name="bathroom" id="flexRadioDefault1" {{ ($report_data->bathroom == 2) ? 'checked':'' }}>
                                                            </div>
                                                         </td>
                                                         <td style="border: 1px solid gray;padding: 15px;">
                                                            <div class="form-check">
                                                               <input class="form-check-input" type="radio" name="bathroom" id="flexRadioDefault1" {{ ($report_data->bathroom == 3) ? 'checked':'' }}>
                                                            </div>
                                                         </td>
                                                         <td style="border: 1px solid gray;padding: 15px;">
                                                            <div class="form-check">
                                                               {{ ($report_data->sleep_from) ? $report_data->sleep_from:'' }}
                                                            </div>
                                                         </td>
                                                         <td style="border: 1px solid gray;padding: 15px;">
                                                            <div class="form-check">
                                                               {{ ($report_data->sleep_to) ? $report_data->sleep_to:'' }}
                                                            </div>
                                                         </td>
                                                      </tr>
                                                      <!--  <tr>
                                                         <td>Type</td>
                                                         <td></td>
                                                         <td></td>
                                                         <td></td>
                                                         <td></td>
                                                         <td></td>
                                                         <td></td>
                                                         </tr> -->
                                                   </tbody>
                                                </table>
                                                <table class="report-section">
                                                   <thead>
                                                      <tr>
                                                         <th>@lang('reports.Meal')</th>
                                              <th>@lang('reports.Time')</th>
                                              <th>@lang('reports.Type')</th>
                                              <th>@lang('reports.ate_it_all')</th>
                                              <th>@lang('reports.ate_half')</th>
                                              <th>@lang('reports.Refused')</th>
                                            </tr>
                                                      </tr>
                                                   </thead>
                                                   <tbody>
                                                      <tr>
                                                          <td>@lang('reports.Feeding')</td>
                                                         <td style="border: 1px solid gray;padding: 15px;">
                                                            <div class="form-check">
                                                               {{ ($report_data->feeding_time == 1) ? $report_data->feeding_time:'' }}
                                                            </div>
                                                         </td>
                                                         <td style="border: 1px solid gray;padding: 15px;">
                                                            <div class="form-check">
                                                               {{ ($report_data->feeding_time == 1) ? $report_data->feeding_time:'' }}
                                                            </div>
                                                         </td>
                                                         <td style="border: 1px solid gray;padding: 15px;">
                                                            <div class="form-check">
                                                               <input class="form-check-input" type="radio" name="feeding_quantity" id="flexRadioDefault1" {{ ($report_data->feeding_quantity == 1) ? 'checked':'' }}>
                                                            </div>
                                                         </td>
                                                         <td style="border: 1px solid gray;padding: 15px;">
                                                            <div class="form-check">
                                                               <input class="form-check-input" type="radio" name="feeding_quantity" id="flexRadioDefault1" {{ ($report_data->feeding_quantity == 2) ? 'checked':'' }}>
															   </div>
                                                         </td>
                                                         <td style="border: 1px solid gray;padding: 15px;">
                                                            <div class="form-check">
                                                               <input class="form-check-input" type="radio" name="feeding_quantity" id="flexRadioDefault1" {{ ($report_data->feeding_quantity == 3) ? 'checked':'' }}>
                                                            </div>
                                                         </td>
                                                      </tr>
                                                      <tr>
                                                         <td>@lang('reports.Breakfast')</td>
                                                         <td style="border: 1px solid gray;padding: 15px;">
                                                            <div class="form-check">
                                                               {{ ($report_data->breakfast_time) ? $report_data->breakfast_time:'' }}
                                                            </div>
                                                         </td>
                                                         <td style="border: 1px solid gray;padding: 15px;">
                                                            <div class="form-check">
                                                               {{ ($report_data->breakfast_type) ? $report_data->breakfast_type:'' }}
                                                            </div>
                                                         </td>
                                                         <td style="border: 1px solid gray;padding: 15px;">
                                                            <div class="form-check">
                                                               <input class="form-check-input" type="radio" name="breakfast_quantity" id="flexRadioDefault1" value="1" {{ ($report_data->breakfast_quantity == 1) ? 'checked':'' }}>
                                                            </div>
                                                         </td>
                                                         <td style="border: 1px solid gray;padding: 15px;">
                                                            <div class="form-check">
                                                               <input class="form-check-input" type="radio" name="breakfast_quantity" id="flexRadioDefault1" value="2" {{ ($report_data->breakfast_quantity == 2) ? 'checked':'' }}>
                                                            </div>
                                                         </td>
                                                         <td style="border: 1px solid gray;padding: 15px;">
                                                            <div class="form-check">
                                                               <input class="form-check-input" type="radio" name="breakfast_quantity" id="flexRadioDefault1" value="3" {{ ($report_data->breakfast_quantity == 3) ? 'checked':'' }}>
                                                            </div>
                                                         </td>
                                                      </tr>
                                                      <tr>
                                                        <td>@lang('reports.Snack')</td>
                                                         <td style="border: 1px solid gray;padding: 15px;">
                                                            <div class="form-check">
                                                               {{ ($report_data->snack_time) ? $report_data->snack_time:'' }}
                                                            </div>
                                                         </td>
                                                         <td style="border: 1px solid gray;padding: 15px;">
                                                            <div class="form-check">
                                                               {{ ($report_data->snack_type) ? $report_data->snack_type:'' }}
                                                            </div>
                                                         </td>
                                                         <td style="border: 1px solid gray;padding: 15px;">
                                                            <div class="form-check">
                                                               <input class="form-check-input" type="radio" name="snack_quantity" id="flexRadioDefault1" value="1" {{ ($report_data->snack_quantity == 1) ? 'checked':'' }}>
                                                            </div>
                                                         </td>
                                                         <td style="border: 1px solid gray;padding: 15px;">
                                                            <div class="form-check">
                                                               <input class="form-check-input" type="radio" name="snack_quantity" id="flexRadioDefault1" value="2" {{ ($report_data->snack_quantity == 2) ? 'checked':'' }}>
                                                            </div>
                                                         </td>
                                                         <td style="border: 1px solid gray;padding: 15px;">
                                                            <div class="form-check">
                                                               <input class="form-check-input" type="radio" name="snack_quantity" id="flexRadioDefault1" value="3" {{ ($report_data->snack_quantity == 3) ? 'checked':'' }}>
                                                            </div>
                                                         </td>
                                                      </tr>
                                                      <tr>
                                                         <td>@lang('reports.Lunch')</td>
                                                         <td style="border: 1px solid gray;padding: 15px;">
                                                            <div class="form-check">
                                                               {{ ($report_data->lunch_time) ? $report_data->lunch_time:'' }}
                                                            </div>
                                                         </td>
                                                         <td style="border: 1px solid gray;padding: 15px;">
                                                            <div class="form-check">
                                                               {{ ($report_data->lunch_type) ? $report_data->lunch_type:'' }}
                                                            </div>
                                                         </td>
                                                         <td style="border: 1px solid gray;padding: 15px;">
                                                            <div class="form-check">
                                                               <input class="form-check-input" type="radio" name="lunch_quantity" id="flexRadioDefault1" value="1" {{ ($report_data->lunch_quantity == 1) ? 'checked':'' }} >
                                                            </div>
                                                         </td>
                                                         <td style="border: 1px solid gray;padding: 15px;">
                                                            <div class="form-check">
                                                               <input class="form-check-input" type="radio" name="lunch_quantity" id="flexRadioDefault1" value="2" {{ ($report_data->lunch_quantity == 2) ? 'checked':'' }}>
                                                            </div>
                                                         </td>
                                                         <td style="border: 1px solid gray;padding: 15px;">
                                                            <div class="form-check">
                                                               <input class="form-check-input" type="radio" name="lunch_quantity" id="flexRadioDefault1" value="3"
                                                               {{ ($report_data->lunch_quantity == 3) ? 'checked':'' }}>
                                                            </div>
                                                         </td>
                                                      </tr>
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
               </div>
            </div>
         </div>
      </div>
   </body>
</html>