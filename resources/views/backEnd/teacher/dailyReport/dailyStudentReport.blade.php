@extends('backEnd.master')
@section('title')
@lang('reports.daily_report')
@endsection

@section('mainContent')

@php  $setting = generalSetting();  if(!empty($setting->currency_symbol)){ $currency = $setting->currency_symbol; }else{ $currency = '$'; }   @endphp 
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/css/bootstrap-select.min.css">

<style type="text/css">
    table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    table td {
      position: relative;
    }

    table td input {
      position: relative;
      display: block;
      top:0;
      left:0;
      margin: 0;
/*      height: 100%;*/
      width: 100%;
      border: none;
      padding: 10px;
      box-sizing: border-box;
    }
</style>


<section class="sms-breadcrumb mb-40 white-box">
    <div class="container-fluid">
        <div class="row justify-content-between">
            <h1>@lang('reports.daily_report') </h1>
            <div class="bc-pages">
                <a href="{{route('dashboard')}}">@lang('common.dashboard')</a>
                <a href="#">@lang('reports.reports')</a>
                <a href="#">@lang('reports.daily_report')</a>
            </div>
        </div>
    </div>
</section>
<section class="admin-visitor-area up_st_admin_visitor">
    <div class="container-fluid p-0">
        <div class="row">
            <div class="col-lg-4 col-md-6">
                <div class="main-title">
                    <h3 class="mb-30">@lang('common.select_criteria') </h3>
                </div>
            </div>
        </div>

    </div>
</section>

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
                              <form action="{{ route('dailyReportSubmit') }}" method="post">
                                    @csrf
                              <div class="teacher-info mb-3">
                                <div class="info-field col-sm-6">
                                    <strong>@lang('reports.child_name'):</strong>
                                    <select class="selectpicker form-control" data-live-search="true" name="student_id">
                                        <option selected disabled>@lang('reports.search_students')</option>
                                        <?php foreach ($students as $key => $value): ?>
                                            <option value="{{$value->id}}" data-tokens="{{$value->id}}">{{$value->fullname}}</option>
                                        <?php endforeach ?>
                                    </select> 
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
                                              {{--<td style="border: 1px solid gray;padding-left: 15px;">@lang('reports.Moody')</td>--}}
                                              <td style="border: 1px solid gray;padding-left: 15px;">@lang('reports.Notes')</td>
                                            </tr>
                                            <tr class="text-center">
                                              <td style="border: 1px solid gray;padding: 15px;">
                                                <div class="form-check">
                                                  <input class="form-check-input" type="radio" name="mood" id="mood" value="1">
                                                </div>
                                              </td>
                                              <td style="border: 1px solid gray;padding: 15px;">
                                                <div class="form-check">
                                                  <input class="form-check-input" type="radio" name="mood" id="mood" value="2">
                                                </div>
                                              </td>
                                              <td style="border: 1px solid gray;padding: 15px;">
                                                <div class="form-check">
                                                  <input class="form-check-input" type="radio" name="mood" id="mood" value="3">
                                                </div>
                                              </td>
                                              {{--<td style="border: 1px solid gray;padding: 15px;">
                                                <div class="form-check">
                                                  <input class="form-check-input" type="radio" name="mood" id="mood" value="4">
                                                </div>
                                              </td>--}}
                                              <td style="border: 1px solid gray;padding: 15px;">
                                                <div class="form-check">
                                                  <input class="form-check-input" type="radio" name="mood" id="mood" value="5">
                                                </div>
                                              </td>
                                              <td>
                                                <div class="form-check">
                                                  <div class="form-check">
                                                  <input class="form-control" type="text" name="mood_notes" id="mood_notes" value="">
                                                </div>
                                                </div>
                                              </td>
                                            </tr>
                                          </tbody>
                                        </table>
                                        <table class="report-section">
                                          <thead>
                                            <tr>
                                              <th colspan="5">@lang('reports.Nappy Change')</th>
                                            </tr>
                                          </thead>
                                          <tbody>
                                            <tr>
                                              <td>@lang('reports.Nappy changed')</td>
                                              <td>@lang('reports.Nappy is in a good condition')</td>
                                              <td>@lang('reports.The infant has an allergy')</td>
                                              <td>@lang('reports.The infant has no allergies')</td>
                                              <td>@lang('reports.Notes')</td>

                                            </tr>
                                            <tr class="text-center">
                                              <td>
                                                <div class="form-check">
                                                  <input class="form-check-input" type="radio" name="nappy_changed" id="nappy_good" value="1">
                                                </div>
                                              </td>
                                              <td>
                                                <div class="form-check">
                                                  <input class="form-check-input" type="radio" name="nappy_condition" id="nappy_good" value="1">
                                                </div>
                                              </td>
                                              <td>
                                                <div class="form-check">
                                                  <input class="form-check-input" type="radio" name="allergy" id="allergy_yes" value="1">
                                                  
                                                </div>
                                              </td>
                                              <td>
                                                <div class="form-check">
                                                  <input class="form-check-input" type="radio" name="allergy" id="allergy_no" value="2">
                                                  
                                                </div>
                                              </td>
                                              <td>
                                                <input type="text" name="notes" placeholder="@lang('reports.Notes')">
                                              </td>
                                            </tr>
                                          </tbody>
                                        </table>

                                        <table class="report-section">
                                          <thead>
                                            <tr>
                                              <th colspan="4">@lang('reports.Clothing Case')</th>
                                            </tr>
                                          </thead>
                                          <tbody>
                                            <tr>
                                              <td>@lang('reports.The baby\'s clothes were changed')</td>
                                              <td>@lang('reports.The clothes are good')</td>
                                              <td>@lang('reports.Notes')</td>
                                            </tr>
                                            <tr class="text-center">
                                              <td>
                                                <div class="form-check">
                                                  <input class="form-check-input" type="radio" name="clothes_changed" id="clothes_changed" value="1">
                                                </div>
                                              </td>
                                              <td>
                                                <div class="form-check">
                                                  <input class="form-check-input" type="radio" name="clothes_condition" id="clothes_good" value="1">
                                                </div>
                                              </td>
                                              <td colspan="2">
                                                <input type="text" name="notes" placeholder="@lang('reports.Notes')">
                                              </td>
                                            </tr>
                                          </tbody>
                                        </table>

                                        <table class="report-section">
                                          <thead>
                                            <tr>
                                              <th colspan="5">@lang('reports.Eating Cerelac')</th>
                                            </tr>
                                          </thead>
                                          <tbody>
                                            <tr>
                                              <td>@lang('reports.Cyrylac was eaten')</td>
                                            </tr>
                                            <tr class="text-center">
                                              <td>
                                                <input class="form-check-input" type="radio" name="meal_eaten" id="meal_eaten_yes" value="1">
                                              </td>
                                              <td>
                                                <div class="form-check">
                                                  <input class="form-check-input" type="radio" name="meal_eaten" id="meal_eaten_yes" value="1">
                                                  @lang('reports.baby_refusal')
                                                </div>
                                              
                                                <div class="form-check">
                                                  <input class="form-check-input" type="radio" name="meal_eaten" id="meal_eaten_no" value="2">
                                                  @lang('reports.The meal was not eaten')
                                                </div>
                                              </td>
                                              <td>
                                                <input type="number" name="spoons" placeholder="@lang('reports.Number of spoons of 1_6')">
                                              
                                                <div class="form-check">
                                                  <input class="form-check-input" type="radio" name="refusal" id="refusal_yes" value="1">
                                                  @lang('reports.Baby’s refusal')
                                                </div>
                                                
                                              </td>
                                              <td>
                                                <input type="text" name="notes" placeholder="@lang('reports.Notes')">
                                              </td>
                                            </tr>
                                          </tbody>
                                        </table>

                                        <table class="report-section">
                                          <thead>
                                            <tr>
                                              <th colspan="5">@lang('reports.additional_meals')</th>
                                            </tr>
                                          </thead>
                                          <tbody>
                                            <tr class="text-center">
                                              <td>@lang('reports.refuse_to_eat')</td>
                                              <td>
                                                <div class="form-check">
                                                  <input class="form-check-input" type="radio" name="meal_eaten" id="meal_eaten_yes" value="1">
                                                  @lang('reports.meal_was_eaten')
                                                </div>
                                              
                                                <div class="form-check">
                                                  <input class="form-check-input" type="radio" name="refusal" id="refusal_yes" value="1">
                                                  @lang('reports.Baby’s refusal')
                                                </div>
                                              </td>
                                              <td>
                                                <div class="form-check">
                                                  <input class="form-check-input" type="radio" name="meal_quantity" id="meal_quantity_full" value="1">
                                                  @lang('reports.ate_full_meal')
                                                </div>
                                              
                                                <div class="form-check">
                                                  <input class="form-check-input" type="radio" name="meal_quantity" id="meal_quantity_quarter" value="2">
                                                  @lang('reports.ate_quarter_meal')
                                                </div>
                                              </td>
                                              <td>
                                                <div class="form-check">
                                                  <input class="form-check-input" type="radio" name="meal_quantity" id="meal_quantity_half" value="3">
                                                  @lang('reports.ate_half_meal')
                                                </div>
                                              </td>
                                              <td>
                                                <input type="text" name="notes" placeholder="@lang('reports.Notes')">
                                              </td>
                                            </tr>
                                          </tbody>
                                        </table>
                                        <div class="row text-center mt-20">
                                            <div class="col">
                                                <button type="submit" class="btn btn-primary align-center">@lang('reports.Submit')</button>
                                            </div>
                                        </div>
                                        
                                      </div>

                              </form>
                            </div>
                          </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/js/bootstrap-select.min.js"></script>
<script>
    $(document).ready(function() {
        $('.selectpicker').selectpicker();
    });
</script>
@endsection
