@extends('backEnd.master')
@section('title')
@lang('hr.staff_list')
@endsection
@section('mainContent')
@push('css')

<style>
	#searchForm{
		display: flex;
	}
	#label_percent{
		font-weight: 700;
	}
</style>
@endpush


<section class="sms-breadcrumb mb-40 white-box">
	<div class="container-fluid">
		<div class="row justify-content-between">
			<h1>@lang('hr.search_staff_evaluation')</h1>
			<div class="bc-pages">
				<a href="{{ route('dashboard') }}">@lang('common.dashboard')</a>
				<a href="#">@lang('hr.human_resource')</a>
				<a href="#">@lang('hr.search_staff_evaluation')</a>
			</div>
		</div>
	</div>
</section>
<section class="admin-visitor-area up_admin_visitor">
	<div class="container-fluid p-0">
		<div class="row">
			<div class="col-lg-8 col-md-6 col-6">
				<div class="main-title xs_mt_0 mt_0_sm">
					<h3 class="mb-30">@lang('hr.search_staff_evaluation')</h3>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-12">
				<div class="white-box">
					<form action="{{ route('searchEvaluateStaffMonthly') }}" method="POST" id="searchForm" >
						@csrf
						<div class="col-sm-3">
							<label>@lang('hr.teacher')</label>
							<select class="primary_select  form-control" name="role_id" id="role_id">
								<option data-display="@lang('hr.staff')" value=""> @lang('common.select') </option>
								@foreach ($all_staffs as $key => $value)
								<option value="{{ $value->id }}" >{{ $value->first_name }} {{ $value->last_name }}</option>
								@endforeach
							</select>
						</div>
						<div class="col-sm-3">
							<label>@lang('hr.from_date')</label>
							<input class="form-control primary_input" type="date" name="from_date">
						</div>
						<div class="col-sm-3">
							<label>@lang('hr.to_date')</label>
							<input class="form-control primary_input" type="date" name="to_date">
						</div>
						<div class="col-sm-3" class="text-righ" style="padding-top: 10px;">
							<button id="search-evaluation-btn" style="width: 150px;height: 45px;border-radius: 6px !important;margin: 20px 0 0 0;" type="submit" class="primary-btn small fix-gr-bg">Search</button>
						</div>
					</form>
				</div>
			</div>
		</div>

		<?php 
			if (isset($data) && !empty($data['first_evaluation'])) {
				$labels = [];
				$firstEvaluationData = [];
				$firstEvaluationRatioData = [];
				$secondEvaluationData = [];
				$secondEvaluationRatioData = [];
				$thirdEvaluationData = [];
				$thirdEvaluationRatioData = [];
				$fourthEvaluationData = [];
				$fourthEvaluationRatioData = [];

				foreach ($data['first_evaluation'] as $date => $evaluation) {
				    $labels[] = $date;
				    $firstEvaluationData[] = $evaluation['rating'];
				}

				foreach ($data['first_evaluation_ratio'] as $date => $evaluation) {
				    $firstEvaluationRatioData[] = $evaluation['ratio'];
				}

				foreach ($data['second_evaluation'] as $date => $evaluation) {
				    $secondEvaluationData[] = $evaluation['rating'];
				}

				foreach ($data['second_evaluation_ratio'] as $date => $evaluation) {
				    $secondEvaluationRatioData[] = $evaluation['ratio'];
				}

				foreach ($data['third_evaluation'] as $date => $evaluation) {
				    $thirdEvaluationData[] = $evaluation['rating'];
				}

				foreach ($data['third_evaluation_ratio'] as $date => $evaluation) {
				    $thirdEvaluationRatioData[] = $evaluation['ratio'];
				}

				foreach ($data['fourth_evaluation'] as $date => $evaluation) {
				    $fourthEvaluationData[] = $evaluation['rating'];
				}

				foreach ($data['fourth_evaluation_ratio'] as $date => $evaluation) {
				    $fourthEvaluationRatioData[] = $evaluation['ratio'];
				}
			}


		 ?>


		@if(isset($data) &&!empty($data))
		<div class="container" style="margin-top: 20px;">
			<div class="row">
				<div class="col-sm-12 white-box">
					@if(isset($data) &&!empty($data))
						<div class="row">
							<div class="col-sm-6">
								<div class="chart">
								    <canvas id="evaluation-chart" width="450" height="450" style="display: block;box-sizing: border-box;height: 450px;width: 450px;"></canvas>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="details">
									<label id="label_percent">@lang('common.name'): </label>
									<span>
										@foreach ($all_staffs as $key => $value)
										<?php if ($value->id == $data['role_id']): ?>
											{{ $value->first_name }} {{ $value->last_name }}
										<?php endif ?>
										@endforeach
									</span>
								</div>
								<div class="table-responsive">
								  <table class="table table-striped">
								    <thead>
								      <tr>
								        <th>@lang('hr.evaluation_type')</th>
								        <th>@lang('hr.evaluation_result')</th>
								      </tr>
								    </thead>
								    <tbody>
								      <tr>
								        <td>@lang('hr.evaluation_of_a_caregiver_on_the_day_of_the_trial')</td>
								        <td>
										    @if(isset($firstEvaluationData[0]))
										        {{ number_format($firstEvaluationData[0] / 5 * 100, 2) }}%
										    @else
										        N/A
										    @endif
										</td>
								      </tr>
								      <tr>
								        <td>@lang('hr.staff_experience')</td>
								        <td>
											@if(isset($secondEvaluationData[0]))
											    {{ number_format($secondEvaluationData[0] / 5 * 100, 2) }}%
											@else
											    N/A
											@endif
										</td>
								      </tr>
								      <tr>
								        <td>@lang('hr.evaluation_of_an_administrative_assistant_on_the_day_of_the_experiment')</td>
								        <td>
										    @if(isset($thirdEvaluationData[0]))
										        {{ number_format($thirdEvaluationData[0] / 5 * 100, 2) }}%
										    @else
										        N/A
										    @endif
										</td>
								      </tr>
								      <tr>
								        <td>@lang('common.teacher_evaluation')</td>
								        <td>
										    @if(isset($fourthEvaluationData[0]))
										        {{ number_format($fourthEvaluationData[0] / 5 * 100, 2) }}%
										    @else
										        N/A
										    @endif
										</td>
								      </tr>
								    </tbody>
								  </table>
								</div>
							</div>
						</div>
					@endif
				</div>
			</div>
		</div>
		@endif
	</div>
</div>
</div>
</section>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@if(isset($data) &&!empty($data))
<script>
    var ctx = document.getElementById('evaluation-chart').getContext('2d');
    var chart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: [
                "@lang('hr.evaluation_of_a_caregiver_on_the_day_of_the_trial')",
                "@lang('hr.staff_experience')",
                "@lang('hr.evaluation_of_an_administrative_assistant_on_the_day_of_the_experiment')",
                "@lang('common.teacher_evaluation')"
            ],
            datasets: [{
                label: 'Evaluations',
                data: [
                    {{ $firstEvaluationData[0] ?? 0 }},
				    {{ $secondEvaluationData[0] ?? 0 }},
				    {{ $thirdEvaluationData[0] ?? 0 }},
				    {{ $fourthEvaluationData[0] ?? 0 }}
                ],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            title: {
                display: true,
                text: 'Evaluations'
            }
        }
    });
</script>
@endif
</div>
@endsection

@include('backEnd.partials.data_table_js')
@include('backEnd.partials.server_side_datatable')
@push('script')  


	
@endpush
	
		