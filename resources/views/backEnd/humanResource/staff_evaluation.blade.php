@extends('backEnd.master')
@section('title')
@lang('hr.staff_list')
@endsection
@section('mainContent')
@push('css')
<style type="text/css">
	.switch {
	position: relative;
	display: inline-block;
	width: 60px;
	height: 34px;
	}
	
	.switch input {
	opacity: 0;
	width: 0;
	height: 0;
	}
	
	.slider {
	position: absolute;
	cursor: pointer;
	top: 0;
	left: 0;
	right: 0;
	bottom: 0;
	background-color: #ccc;
	-webkit-transition: .4s;
	transition: .4s;
	}
	
	.slider:before {
	position: absolute;
	content: "";
	height: 26px;
	width: 26px;
	left: 4px;
	bottom: 4px;
	background-color: white;
	-webkit-transition: .4s;
	transition: .4s;
	}
	
	input:checked+.slider {
	background: linear-gradient(90deg, var(--gradient_1) 0%, #c738d8 51%, var(--gradient_1) 100%);
	}
	
	input:focus+.slider {
	box-shadow: 0 0 1px linear-gradient(90deg, var(--gradient_1) 0%, #c738d8 51%, var(--gradient_1) 100%);
	}
	
	input:checked+.slider:before {
	-webkit-transform: translateX(26px);
	-ms-transform: translateX(26px);
	transform: translateX(26px);
	}
	
	/* Rounded sliders */
	.slider.round {
	border-radius: 34px;
	}
	
	.slider.round:before {
	border-radius: 50%;
	}

	/* My Own Styles */
	.primary_input_field{
		border-radius: 0 !important;
	}
	/* My Own Styles */
	
	/* th,td{
	font-size: 9px !important;
	padding: 5px !important
	
	} */
</style>
@endpush
<section class="sms-breadcrumb mb-40 white-box">
	<div class="container-fluid">
		<div class="row justify-content-between">
			<h1>@lang('hr.staff_evaluation')</h1>
			<div class="bc-pages">
				<a href="{{ route('dashboard') }}">@lang('common.dashboard')</a>
				<a href="#">@lang('hr.human_resource')</a>
				<a href="#">@lang('hr.staff_evaluation')</a>
			</div>
		</div>
	</div>
</section>
<section class="admin-visitor-area up_admin_visitor">
	<div class="container-fluid p-0">
		<div class="row">
			<div class="col-lg-8 col-md-6 col-6">
				<div class="main-title xs_mt_0 mt_0_sm">
					<h3 class="mb-30">@lang('hr.staff_evaluation')</h3>
				</div>
			</div>
		</div>
		<div class="row mt-40 full_wide_table">
			<div class="col-lg-12">
				<div class="white-box staff-evaluation-tabs">
					<div class="tab">
						<button class="tablinks active" onclick="openCity(event, 'London')">
							@lang('hr.evaluation_of_a_caregiver_on_the_day_of_the_trial')
						 </button>
						<button class="tablinks" onclick="openCity(event, 'Paris')"> 
							@lang('hr.staff_experience')
						</button>
						<button class="tablinks" onclick="openCity(event, 'Tokyo')">
							@lang('hr.evaluation_of_an_administrative_assistant_on_the_day_of_the_experiment')
						</button>
						@if(Auth::user()->role_id == 1 || Auth::user()->role_id == 5)
						<button class="tablinks" onclick="openCity(event, 'Japan')">
							@lang('common.teacher_evaluation')
						</button>
						@endif
					</div>
					
					<div id="London" class="tabcontent" style="display:block;">
						<h3 style="color: #828bb2;font-weight: bold;text-align: center;margin: 20px 0;">
							@lang('hr.evaluation_of_a_caregiver_on_the_day_of_the_trial')
						</h3>
						<div class="report-table">
							{{-- Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'evaluateStaff', 'method' => 'POST', 'enctype' => 'multipart/form-data']) --}}
							<form method="post" id="firstEvaluatinForm" class="form-horizontal" enctype="multipart/form-data">
								@csrf
								<input type="hidden" name="type" value="1">
								<div class="row">
									<div class="col-lg-12">
										<div class="white-box">
											<div class="row">
												<div class="col-lg-4">
													<label class="primary_input_label" for="">
														@lang('hr.staff_list')
														<span class="text-danger"> </span>
													</label>
													<select class="primary_select  form-control" name="role_id" id="role_id">
														<option data-display="@lang('hr.staff')" value=""> @lang('common.select') </option>
														@foreach ($all_staffs as $key => $value)
														<option value="{{ $value->id }}" >{{ $value->first_name }} {{ $value->last_name }}</option>
														@endforeach
													</select>
												</div>
												
											</div>
										</div>
									</div>
								</div>

								<table class="report-section" style="width:100%">
								    <thead>
								        <tr>
								            <th> 
								                @lang('hr.clause')
								            </th>
								            <th>
								                @lang('hr.class')
								            </th>
								            <th> 
								                @lang('hr.evaluation')
								            </th>
								        </tr>
								    </thead>
								    <tbody>
								        <tr>
								            <td>
								                @lang('hr.introduction')
								                <input type="hidden" name="question[]" value="introduction">
								            </td>
								            <td>
								                <select name="rating[]" required class="primary_input_field read-only-input form-control">
								                    <option value="0">@lang('hr.grade')</option>
								                    <option value="1">1</option>
								                    <option value="2">2</option>
								                    <option value="3">3</option>
								                    <option value="4">4</option>
								                    <option value="5">5</option>
								                </select>
								            </td>
								            <td><input class="primary_input_field read-only-input form-control" type="text" name="evaluation[]" placeholder="@lang('hr.notes')"></td>
								        </tr>
								        <tr>
								            <td>
								            	@lang('hr.concept')
								            	<input type="hidden" name="question[]" value="concept">
								            </td>
								            <td>
								                <select name="rating[]" required class="primary_input_field read-only-input form-control">
								                    <option value="0">@lang('hr.grade')</option>
								                    <option value="1">1</option>
								                    <option value="2">2</option>
								                    <option value="3">3</option>
								                    <option value="4">4</option>
								                    <option value="5">5</option>
								                </select>
								            </td>
								            <td><input class="primary_input_field read-only-input form-control" type="text" name="evaluation[]" placeholder="@lang('hr.notes')"></td>
								        </tr>
								        <tr>
								            <td>
								            	@lang('hr.tool')
								            	<input type="hidden" name="question[]" value=" tool ">
								            </td>
								            <td>
								                <select name="rating[]" required class="primary_input_field read-only-input form-control">
								                    <option value="0">@lang('hr.grade')</option>
								                    <option value="1">1</option>
								                    <option value="2">2</option>
								                    <option value="3">3</option>
								                    <option value="4">4</option>
								                    <option value="5">5</option>
								                </select>
								            </td>
								            <td><input class="primary_input_field read-only-input form-control" type="text" name="evaluation[]" placeholder="@lang('hr.notes')"></td>
								        </tr>
								        <tr>
								            <td>
								            	@lang('hr.feedback')
								            	<input type="hidden" name="question[]" value=" feedback ">
								            </td>
								            <td>
								                <select name="rating[]" required class="primary_input_field read-only-input form-control">
								                    <option value="0">@lang('hr.grade')</option>
								                    <option value="1">1</option>
								                    <option value="2">2</option>
								                    <option value="3">3</option>
								                    <option value="4">4</option>
								                    <option value="5">5</option>
								                </select>
								            </td>
								            <td><input class="primary_input_field read-only-input form-control" type="text" name="evaluation[]" placeholder="@lang('hr.notes')"></td>
								        </tr>
								        <tr>
								            <td>	
								            	@lang('hr.conclusion')
								            	<input type="hidden" name="question[]" value=" conclusion ">
								            </td>
								            <td>
								                <select name="rating[]" required class="primary_input_field read-only-input form-control">
								                    <option value="0">@lang('hr.grade')</option>
								                    <option value="1">1</option>
								                    <option value="2">2</option>
								                    <option value="3">3</option>
								                    <option value="4">4</option>
								                    <option value="5">5</option>
								                </select>
								            </td>
								            <td><input class="primary_input_field read-only-input form-control" type="text" name="evaluation[]" placeholder="@lang('hr.notes')"></td>
								        </tr>
								        <tr>
								            <td>
								            	@lang('hr.problem_solving')
								            	<input type="hidden" name="question[]" value=" problem_solving ">
								            </td>
								            <td>
								                <select name="rating[]" required class="primary_input_field read-only-input form-control">
								                    <option value="0">@lang('hr.grade')</option>
								                    <option value="1">1</option>
								                    <option value="2">2</option>
								                    <option value="3">3</option>
								                    <option value="4">4</option>
								                    <option value="5">5</option>
								                </select>
								            </td>
								            <td><input class="primary_input_field read-only-input form-control" type="text" name="evaluation[]" placeholder="@lang('hr.notes')"></td>
								        </tr>
								        <tr>
								            <td>
								            	@lang('hr.smile_and_voice')
								            	<input type="hidden" name="question[]" value=" smile_and_voice ">
								            </td>
								            <td>
								                <select name="rating[]" required class="primary_input_field read-only-input form-control">
								                    <option value="0">@lang('hr.grade')</option>
								                    <option value="1">1</option>
								                    <option value="2">2</option>
								                    <option value="3">3</option>
								                    <option value="4">4</option>
								                    <option value="5">5</option>
								                </select>
								            </td>
								            <td><input class="primary_input_field read-only-input form-control" type="text" name="evaluation[]" placeholder="@lang('hr.notes')"></td>
								        </tr>
								        <tr>
								            <td>
								            	@lang('hr.class_management')
								            	<input type="hidden" name="question[]" value=" class_management ">
								            </td>
								            <td>
								                <select name="rating[]" required class="primary_input_field read-only-input form-control">
								                    <option value="0">@lang('hr.grade')</option>
								                    <option value="1">1</option>
								                    <option value="2">2</option>
								                    <option value="3">3</option>
								                    <option value="4">4</option>
								                    <option value="5">5</option>
								                </select>
								            </td>
								            <td><input class="primary_input_field read-only-input form-control" type="text" name="evaluation[]" placeholder="@lang('hr.notes')"></td>
								        </tr>
								        <tr>
								            <td>
								            	@lang('hr.level_with_children')
								            	<input type="hidden" name="question[]" value=" level_with_children ">
								            </td>
								            <td>
								                <select name="rating[]" required class="primary_input_field read-only-input form-control">
								                    <option value="0">@lang('hr.grade')</option>
								                    <option value="1">1</option>
								                    <option value="2">2</option>
								                    <option value="3">3</option>
								                    <option value="4">4</option>
								                    <option value="5">5</option>
								                </select>
								            </td>
								            <td><input class="primary_input_field read-only-input form-control" type="text" name="evaluation[]" placeholder="@lang('hr.notes')"></td>
								        </tr>
								        <tr>
								            <td>
								            	@lang('hr.personal_appearance')
								            	<input type="hidden" name="question[]" value=" personal_appearance ">
								            </td>
								            <td>
								                <select name="rating[]" required class="primary_input_field read-only-input form-control">
								                    <option value="0">@lang('hr.grade')</option>
								                    <option value="1">1</option>
								                    <option value="2">2</option>
								                    <option value="3">3</option>
								                    <option value="4">4</option>
								                    <option value="5">5</option>
								                </select>
								            </td>
								            <td><input class="primary_input_field read-only-input form-control" type="text" name="evaluation[]" placeholder="@lang('hr.notes')"></td>
								        </tr>
								        <tr>
								            <td>
								            	@lang('hr.total_evaluation')
								            	<input type="hidden" name="question[]" value=" total_evaluation ">
								            </td>
								            <td>
								                <select name="rating[]" required class="primary_input_field read-only-input form-control">
								                    <option value="0">@lang('hr.grade')</option>
								                    <option value="1">1</option>
								                    <option value="2">2</option>
								                    <option value="3">3</option>
								                    <option value="4">4</option>
								                    <option value="5">5</option>
								                </select>
								            </td>
								            <td><input class="primary_input_field read-only-input form-control" type="text" name="evaluation[]" placeholder="@lang('hr.notes')"></td>
								        </tr>
								    </tbody>
								</table>


								<button id="save-evaluation-btn" style="width: 150px;height: 45px;border-radius: 6px !important;margin: 20px 0 0 0;" type="button" class="primary-btn small fix-gr-bg">@lang('common.save')</button>
							</form>
						</div>
					</div>
					<div id="Paris" class="tabcontent">
						<h3 style="color: #828bb2;font-weight: bold;text-align: center;margin: 20px 0;">@lang('hr.staff_experience')</h3>
						<div class="report-table">
							<form method="post" id="secondEvaluatinForm" class="form-horizontal" enctype="multipart/form-data">
								@csrf
								<input type="hidden" name="type" value="2">
								{{-- Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'evaluateStaff', 'method' => 'POST', 'enctype' => 'multipart/form-data']) --}}
								<div class="row">
									<div class="col-lg-12">
										<div class="white-box">
											<div class="row">
												<div class="col-lg-4">
													<label class="primary_input_label" for="">
														@lang('hr.staff_list')
														<span class="text-danger"> </span>
													</label>
													<select class="primary_select  form-control" name="role_id" id="role_id">
														<option data-display="@lang('hr.staff')" value=""> @lang('common.select') </option>
														@foreach ($all_staffs as $key => $value)
														<option value="{{ $value->id }}" >{{ $value->first_name }} {{ $value->last_name }}</option>
														@endforeach
													</select>
												</div>
												
											</div>
										</div>
									</div>
								</div>
								<table class="report-section" style="width:100%">
									<thead>
										<tr>
											<th>@lang('hr.criteria')</th>
							                <th>@lang('hr.excellent')</th>
							                <th>@lang('hr.very_good')</th>
							                <th>@lang('hr.acceptable')</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>

												@lang('hr.cheerful')
												<input type="hidden" name="question" value="lang('hr.cheerful')">
											</td>
											<td class="text-center"><input type="radio" name="cheerful" value="1" ></td>
											<td class="text-center"><input type="radio" name="cheerful" value="2" ></td>
											<td class="text-center"><input type="radio" name="cheerful" value="3" ></td>
										</tr>
										<tr>
											<td>@lang('hr.child_handling')<input type="hidden" name="question[]" value="lang('hr.child_handling')"></td>
											<td class="text-center"><input type="radio" name="child_handling" value="1" ></td>
											<td class="text-center"><input type="radio" name="child_handling" value="2" ></td>
											<td class="text-center"><input type="radio" name="child_handling" value="3" ></td>
										</tr>
										<tr>
											<td>@lang('hr.active')<input type="hidden" name="question[]" value="lang('hr.active')"></td>
											<td class="text-center"><input type="radio" name="active" value="1" ></td>
											<td class="text-center"><input type="radio" name="active" value="2" ></td>
											<td class="text-center"><input type="radio" name="active" value="3" ></td>
										</tr>
										<tr>
											<td>@lang('hr.helpful')<input type="hidden" name="question[]" value="lang('hr.helpful')"></td>
											<td class="text-center"><input type="radio" name="helpful" value="1" ></td>
											<td class="text-center"><input type="radio" name="helpful" value="2" ></td>
											<td class="text-center"><input type="radio" name="helpful" value="3" ></td>
										</tr>
										<tr>
											<td>@lang('hr.neat_appearance')
												<input type="hidden" name="question[]" value="lang('hr.neat_appearance')">
											</td>
											<td class="text-center"><input type="radio" name="neat_appearance" value="1" ></td>
											<td class="text-center"><input type="radio" name="neat_appearance" value="2" ></td>
											<td class="text-center"><input type="radio" name="neat_appearance" value="3" ></td>
										</tr>
										<tr>
											<td>@lang('hr.hygiene')
												<input type="hidden" name="question[]" value="lang('hr.hygiene')">
											</td>
											<td class="text-center"><input type="radio" name="hygiene" value="1" ></td>
											<td class="text-center"><input type="radio" name="hygiene" value="2" ></td>
											<td class="text-center"><input type="radio" name="hygiene" value="3" ></td>
										</tr>
										<tr>
											<td>@lang('hr.diaper_changing')
												<input type="hidden" name="question[]" value="lang('hr.diaper_changing')">
											</td>
											<td class="text-center"><input type="radio" name="diaper_changing" value="1" ></td>
											<td class="text-center"><input type="radio" name="diaper_changing" value="2" ></td>
											<td class="text-center"><input type="radio" name="diaper_changing" value="3" ></td>
										</tr>
										<tr>
											<td>@lang('hr.child_observation')
												<input type="hidden" name="question[]" value="lang('hr.child_observation')">
											</td>
											<td class="text-center"><input type="radio" name="child_observation" value="1" ></td>
											<td class="text-center"><input type="radio" name="child_observation" value="2" ></td>
											<td class="text-center"><input type="radio" name="child_observation" value="3" ></td>
										</tr>
										<tr>
											<td>@lang('hr.personality_traits')
												<input type="hidden" name="question[]" value="lang('hr.personality_traits')">
											</td>
											<td class="text-center"><input type="radio" name="personality_traits" value="1" ></td>
											<td class="text-center"><input type="radio" name="personality_traits" value="2" ></td>
											<td class="text-center"><input type="radio" name="personality_traits" value="3" ></td>
										</tr>
										<tr>
											<td>@lang('hr.guiding_children')
												<input type="hidden" name="question[]" value="lang('hr.guiding_children')">
											</td>
											<td class="text-center"><input type="radio" name="guiding_children" value="1" ></td>
											<td class="text-center"><input type="radio" name="guiding_children" value="2" ></td>
											<td class="text-center"><input type="radio" name="guiding_children" value="3" ></td>
										</tr>
										<tr>
											<td>@lang('hr.calm_voice')
												<input type="hidden" name="question[]" value="lang('hr.calm_voice')">
											</td>
											<td class="text-center"><input type="radio" name="calm_voice" value="1" ></td>
											<td class="text-center"><input type="radio" name="calm_voice" value="2" ></td>
											<td class="text-center"><input type="radio" name="calm_voice" value="3" ></td>
										</tr>
										<tr>
											<td>@lang('hr.safe_discipline')
												<input type="hidden" name="question[]" value="lang('hr.safe_discipline')">
											</td>
											<td class="text-center"><input type="radio" name="safe_discipline" value="1" ></td>
											<td class="text-center"><input type="radio" name="safe_discipline" value="2" ></td>
											<td class="text-center"><input type="radio" name="safe_discipline" value="3" ></td>
										</tr>
									</tbody>
								</table>
								<button id="second-evaluation-btn" style="width: 150px;height: 45px;border-radius: 6px !important;margin: 20px 0 0 0;" type="button" class="primary-btn small fix-gr-bg">@lang('common.save')</button>
								{{-- Form::close() --}}
							</form>
						</div>
					</div>
					<div id="Tokyo" class="tabcontent">
						<h3 style="color: #828bb2;font-weight: bold;text-align: center;margin: 20px 0;">@lang('hr.admin_assistant_evaluation')</h3>
						<div class="report-table">
							<form method="post" id="thirdEvaluatinForm" class="form-horizontal" enctype = 'multipart/form-data'>
								@csrf
								<input type="hidden" name="type" value="3">
								{{-- Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'evaluateStaff', 'method' => 'POST', 'enctype' => 'multipart/form-data']) --}}
								<div class="row">
									<div class="col-lg-12">
										<div class="white-box">
											<div class="row">
												<div class="col-lg-4">
													<label class="primary_input_label" for="">
														@lang('hr.staff_list')
														<span class="text-danger"> </span>
													</label>
													<select class="primary_select  form-control" name="role_id" id="role_id">
														<option data-display="@lang('hr.staff')" value=""> @lang('common.select') </option>
														@foreach ($all_staffs as $key => $value)
														<option value="{{ $value->id }}" >{{ $value->first_name }} {{ $value->last_name }}</option>
														@endforeach
													</select>
												</div>
												
											</div>
										</div>
									</div>
								</div>
								<table class="report-section" style="width:100%">
									<thead>
								        <tr>
								            <th> 
								                @lang('hr.clause')
								            </th>
								            <th>
								                @lang('hr.class')
								            </th>
								            <th> 
								                @lang('hr.notes')
								            </th>
								        </tr>
								    </thead>
									<tbody>
										<tr>
										    <td>
										        @lang('hr.uniform')
										        <input type="hidden" name="question[]" value="uniform">
										    </td>
										    <td>
										        <select name="rating[]" required class="primary_input_field read-only-input form-control">
										            <option value="0">@lang('hr.grade')</option>
										            <option value="1">1</option>
										            <option value="2">2</option>
										            <option value="3">3</option>
										            <option value="4">4</option>
										            <option value="5">5</option>
										        </select>
										    </td>
										    <td><input class="primary_input_field read-only-input form-control" type="text" name="evaluation[]" placeholder="@lang('hr.notes')"></td>
										</tr>

										<tr>
										    <td>
										        @lang('hr.photography')
										        <input type="hidden" name="question[]" value="photography">
										    </td>
										    <td>
										        <select name="rating[]" required class="primary_input_field read-only-input form-control">
										            <option value="0">@lang('hr.grade')</option>
										            <option value="1">1</option>
										            <option value="2">2</option>
										            <option value="3">3</option>
										            <option value="4">4</option>
										            <option value="5">5</option>
										        </select>
										    </td>
										    <td><input class="primary_input_field read-only-input form-control" type="text" name="evaluation[]" placeholder="@lang('hr.notes')"></td>
										</tr>

										<tr>
										    <td>
										        @lang('hr.whatsapp')
										        <input type="hidden" name="question[]" value="whatsapp">
										    </td>
										    <td>
										        <select name="rating[]" required class="primary_input_field read-only-input form-control">
										            <option value="0">@lang('hr.grade')</option>
										            <option value="1">1</option>
										            <option value="2">2</option>
										            <option value="3">3</option>
										            <option value="4">4</option>
										            <option value="5">5</option>
										        </select>
										    </td>
										    <td><input class="primary_input_field read-only-input form-control" type="text" name="evaluation[]" placeholder="@lang('hr.notes')"></td>
										</tr>

										<tr>
										    <td>
										        @lang('hr.discipline')
										        <input type="hidden" name="question[]" value="discipline">
										    </td>
										    <td>
										        <select name="rating[]" required class="primary_input_field read-only-input form-control">
										            <option value="0">@lang('hr.grade')</option>
										            <option value="1">1</option>
										            <option value="2">2</option>
										            <option value="3">3</option>
										            <option value="4">4</option>
										            <option value="5">5</option>
										        </select>
										    </td>
										    <td><input class="primary_input_field read-only-input form-control" type="text" name="evaluation[]" placeholder="@lang('hr.notes')"></td>
										</tr>

										<tr>
										    <td>
										        @lang('hr.best_clip')
										        <input type="hidden" name="question[]" value="best_clip">
										    </td>
										    <td>
										        <select name="rating[]" required class="primary_input_field read-only-input form-control">
										            <option value="0">@lang('hr.grade')</option>
										            <option value="1">1</option>
										            <option value="2">2</option>
										            <option value="3">3</option>
										            <option value="4">4</option>
										            <option value="5">5</option>
										        </select>
										    </td>
										    <td><input class="primary_input_field read-only-input form-control" type="text" name="evaluation[]" placeholder="@lang('hr.notes')"></td>
										</tr>

										<tr>
										    <td>
										        @lang('hr.help_children')
										        <input type="hidden" name="question[]" value="help_children">
										    </td>
										    <td>
										        <select name="rating[]" required class="primary_input_field read-only-input form-control">
										            <option value="0">@lang('hr.grade')</option>
										            <option value="1">1</option>
										            <option value="2">2</option>
										            <option value="3">3</option>
										            <option value="4">4</option>
										            <option value="5">5</option>
										        </select>
										    </td>
										    <td><input class="primary_input_field read-only-input form-control" type="text" name="evaluation[]" placeholder="@lang('hr.notes')"></td>
										</tr>

										<tr>
										    <td>
										        @lang('hr.help_parents')
										        <input type="hidden" name="question[]" value="help_parents">
										    </td>
										    <td>
										        <select name="rating[]" required class="primary_input_field read-only-input form-control">
										            <option value="0">@lang('hr.grade')</option>
										            <option value="1">1</option>
										            <option value="2">2</option>
										            <option value="3">3</option>
										            <option value="4">4</option>
										            <option value="5">5</option>
										        </select>
										    </td>
										    <td><input class="primary_input_field read-only-input form-control" type="text" name="evaluation[]" placeholder="@lang('hr.notes')"></td>
										</tr>

										<tr>
										    <td>
										        @lang('hr.respect_admin')
										        <input type="hidden" name="question[]" value="respect_admin">
										    </td>
										    <td>
										        <select name="rating[]" required class="primary_input_field read-only-input form-control">
										            <option value="0">@lang('hr.grade')</option>
										            <option value="1">1</option>
										            <option value="2">2</option>
										            <option value="3">3</option>
										            <option value="4">4</option>
										            <option value="5">5</option>
										        </select>
										    </td>
										    <td><input class="primary_input_field read-only-input form-control" type="text" name="evaluation[]" placeholder="@lang('hr.notes')"></td>
										</tr>

										<tr>
										    <td>
										        @lang('hr.work_pressure')
										        <input type="hidden" name="question[]" value="work_pressure">
										    </td>
										    <td>
										        <select name="rating[]" required class="primary_input_field read-only-input form-control">
										            <option value="0">@lang('hr.grade')</option>
										            <option value="1">1</option>
										            <option value="2">2</option>
										            <option value="3">3</option>
										            <option value="4">4</option>
										            <option value="5">5</option>
										        </select>
										    </td>
										    <td><input class="primary_input_field read-only-input form-control" type="text" name="evaluation[]" placeholder="@lang('hr.notes')"></td>
										</tr>

										<tr>
										    <td>
										        @lang('hr.assistant_help')
										        <input type="hidden" name="question[]" value="assistant_help">
										    </td>
										    <td>
										        <select name="rating[]" required class="primary_input_field read-only-input form-control">
										            <option value="0">@lang('hr.grade')</option>
										            <option value="1">1</option>
										            <option value="2">2</option>
										            <option value="3">3</option>
										            <option value="4">4</option>
										            <option value="5">5</option>
										        </select>
										    </td>
										    <td><input class="primary_input_field read-only-input form-control" type="text" name="evaluation[]" placeholder="@lang('hr.notes')"></td>
										</tr>

									</tbody>
								</table>
								<button id="third-evaluation-btn" style="width: 150px;height: 45px;border-radius: 6px !important;margin: 20px 0 0 0;" type="button" class="primary-btn small fix-gr-bg">@lang('common.save')</button>
							</form>
						</div>
					</div>
					@if(Auth::user()->role_id == 1 || Auth::user()->role_id == 5)
					<div id="Japan" class="tabcontent">
						<h3 style="color: #828bb2;font-weight: bold;text-align: center;margin: 20px 0;">
							@lang('common.teacher_evaluation')
						</h3>
						<div class="report-table">
							{{-- Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'fourthEvaluateStaff', 'method' => 'POST', 'enctype' => 'multipart/form-data']) --}}
							<form method="post" id="fourthEvaluatinForm" class="form-horizontal" enctype="multipart/form-data">
								@csrf
								<input type="hidden" name="type" value="1">
								<div class="row">
									<div class="col-lg-12">
										<div class="white-box">
											<div class="row">
												<div class="col-lg-4">
													<label class="primary_input_label" for="">
														@lang('hr.staff_list')
														<span class="text-danger"> </span>
													</label>
													<select class="primary_select  form-control" name="role_id" id="role_id">
														<option data-display="@lang('hr.staff')" value=""> @lang('common.select') </option>
														@foreach ($all_staffs as $key => $value)
														<option value="{{ $value->id }}" >{{ $value->first_name }} {{ $value->last_name }}</option>
														@endforeach
													</select>
												</div>
												
											</div>
										</div>
									</div>
								</div>

								<table class="report-section" style="width:100%">
								    <thead>
								        <tr>
								            <th> 
								                @lang('hr.clause')
								            </th>
								            <th>
								                @lang('hr.class')
								            </th>
								        </tr>
								    </thead>
								    <tbody>
								        <tr>
								            <td>
								            	@lang('common.uniform')
								            	<input type="hidden" name="question[]" value="uniform">
								            </td>
								            <td>
								                <select name="rating[]" required class="primary_input_field read-only-input form-control">
								                    <option value="0">@lang('hr.grade')</option>
								                    <option value="1">1</option>
								                    <option value="2">2</option>
								                    <option value="3">3</option>
								                    <option value="4">4</option>
								                    <option value="5">5</option>
								                </select>
								            </td>
								        </tr>
								        <tr>
								            <td>
								            	@lang('common.infection_mgmt')
								            	<input type="hidden" name="question[]" value=" infection_mgmt ">
								            </td>
								            <td>
								                <select name="rating[]" required class="primary_input_field read-only-input form-control">
								                    <option value="0">@lang('hr.grade')</option>
								                    <option value="1">1</option>
								                    <option value="2">2</option>
								                    <option value="3">3</option>
								                    <option value="4">4</option>
								                    <option value="5">5</option>
								                </select>
								            </td>
								        </tr>
								        <tr>
								            <td>
								            	@lang('common.entertainment')
								            	<input type="hidden" name="question[]" value=" entertainment ">
								            </td>
								            <td>
								                <select name="rating[]" required class="primary_input_field read-only-input form-control">
								                    <option value="0">@lang('hr.grade')</option>
								                    <option value="1">1</option>
								                    <option value="2">2</option>
								                    <option value="3">3</option>
								                    <option value="4">4</option>
								                    <option value="5">5</option>
								                </select>
								            </td>
								        </tr>
								        <tr>
								            <td>	
								            	@lang('common.weekly_clip')
								            	<input type="hidden" name="question[]" value=" weekly_clip ">
								            </td>
								            <td>
								                <select name="rating[]" required class="primary_input_field read-only-input form-control">
								                    <option value="0">@lang('hr.grade')</option>
								                    <option value="1">1</option>
								                    <option value="2">2</option>
								                    <option value="3">3</option>
								                    <option value="4">4</option>
								                    <option value="5">5</option>
								                </select>
								            </td>
								        </tr>
								        <tr>
								            <td>
								            	@lang('common.teacher_behavior')
								            	<input type="hidden" name="question[]" value=" teacher_behavior ">
								            </td>
								            <td>
								                <select name="rating[]" required class="primary_input_field read-only-input form-control">
								                    <option value="0">@lang('hr.grade')</option>
								                    <option value="1">1</option>
								                    <option value="2">2</option>
								                    <option value="3">3</option>
								                    <option value="4">4</option>
								                    <option value="5">5</option>
								                </select>
								            </td>
								        </tr>
								        <tr>
								            <td>
								            	@lang('common.welcoming')
								            	<input type="hidden" name="question[]" value=" welcoming ">
								            </td>
								            <td>
								                <select name="rating[]" required class="primary_input_field read-only-input form-control">
								                    <option value="0">@lang('hr.grade')</option>
								                    <option value="1">1</option>
								                    <option value="2">2</option>
								                    <option value="3">3</option>
								                    <option value="4">4</option>
								                    <option value="5">5</option>
								                </select>
								            </td>
								        </tr>
								        <tr>
								            <td>
								            	@lang('common.admin_respect')
								            	<input type="hidden" name="question[]" value=" admin_respect ">
								            </td>
								            <td>
								                <select name="rating[]" required class="primary_input_field read-only-input form-control">
								                    <option value="0">@lang('hr.grade')</option>
								                    <option value="1">1</option>
								                    <option value="2">2</option>
								                    <option value="3">3</option>
								                    <option value="4">4</option>
								                    <option value="5">5</option>
								                </select>
								            </td>
								        </tr>
								        <tr>
								            <td>
								            	@lang('common.teacher_effort')
								            	<input type="hidden" name="question[]" value=" teacher_effort ">
								            </td>
								            <td>
								                <select name="rating[]" required class="primary_input_field read-only-input form-control">
								                    <option value="0">@lang('hr.grade')</option>
								                    <option value="1">1</option>
								                    <option value="2">2</option>
								                    <option value="3">3</option>
								                    <option value="4">4</option>
								                    <option value="5">5</option>
								                </select>
								            </td>
								        </tr>
								        <tr>
								            <td>
								            	@lang('common.work_pressure')
								            	<input type="hidden" name="question[]" value=" work_pressure ">
								            </td>
								            <td>
								                <select name="rating[]" required class="primary_input_field read-only-input form-control">
								                    <option value="0">@lang('hr.grade')</option>
								                    <option value="1">1</option>
								                    <option value="2">2</option>
								                    <option value="3">3</option>
								                    <option value="4">4</option>
								                    <option value="5">5</option>
								                </select>
								            </td>
								        </tr>
								    </tbody>
								</table>
								<button id="fourth-evaluation-btn" style="width: 150px;height: 45px;border-radius: 6px !important;margin: 20px 0 0 0;" type="button" class="primary-btn small fix-gr-bg">@lang('common.save')</button>
							</form>
						</div>
					</div>
					@endif
				</div>
			</div>
		</div>
	</div>
</div>
</div>
</section>
{{-- deleteStaffModal --}}
</div>
<div id="loader" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(255, 255, 255, 0.8); z-index: 1000;">
  <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); text-align: center;">
    <p style="font-size: 24px; font-weight: bold; color: #333;">Please wait...</p>
  </div>
</div>
@endsection

@include('backEnd.partials.data_table_js')
@include('backEnd.partials.server_side_datatable')
@push('script')  

<script>
$(document).ready(function() {
	$('#save-evaluation-btn').on('click', saveEvaluation);
	$('#second-evaluation-btn').on('click', secondEvaluation);
	$('#third-evaluation-btn').on('click', thirdEvaluation);
	$('#fourth-evaluation-btn').on('click', fourthEvaluation);
    function saveEvaluation() {
    	var formData = $('#firstEvaluatinForm').serialize();
	    $.ajax({
	        type: 'POST',
	        url: "{{route('evaluateStaff')}}",
	        data: formData,
	        beforeSend: function() {
		        $('#loader').show(); // Show loader on form screen
		    },
	        success: function(data) {
	            toastr.success(data.message, 'Success');
	            $('#firstEvaluatinForm')[0].reset();
	        },
	        error: function(xhr, status, error) {
	            toastr.error(xhr.responseJSON.message, 'Error');
	        },
	        complete: function() {
		        $('#loader').hide(); // Hide loader on form screen
		    }
	    });
	}
	function secondEvaluation() {
    	var formData = $('#secondEvaluatinForm').serialize();
	    $.ajax({
	        type: 'POST',
	        url: "{{route('secondEvaluateStaff')}}",
	        data: formData,
	        beforeSend: function() {
		        $('#loader').show(); // Show loader on form screen
		    },
	        success: function(data) {
	            toastr.success(data.message, 'Success');
	            $('#secondEvaluatinForm')[0].reset();
	        },
	        error: function(xhr, status, error) {
	            toastr.error(xhr.responseJSON.message, 'Error');
	        },
	        complete: function() {
		        $('#loader').hide(); // Hide loader on form screen
		    }
	    });
	}
	function thirdEvaluation() {
    	var formData = $('#thirdEvaluatinForm').serialize();
	    $.ajax({
	        type: 'POST',
	        url: "{{route('thirdEvaluateStaff')}}",
	        data: formData,
	        beforeSend: function() {
		        $('#loader').show(); // Show loader on form screen
		    },
	        success: function(data) {
	            toastr.success(data.message, 'Success');
	            $('#thirdEvaluatinForm')[0].reset();
	        },
	        error: function(xhr, status, error) {
	            toastr.error(xhr.responseJSON.message, 'Error');
	        },
	        complete: function() {
		        $('#loader').hide(); // Hide loader on form screen
		    }
	    });
	}
	function fourthEvaluation() {
    	var formData = $('#fourthEvaluatinForm').serialize();
	    $.ajax({
	        type: 'POST',
	        url: "{{route('fourthEvaluateStaff')}}",
	        data: formData,
	        beforeSend: function() {
		        $('#loader').show(); // Show loader on form screen
		    },
	        success: function(data) {
	            toastr.success(data.message, 'Success');
	            $('#fourthEvaluatinForm')[0].reset();
	        },
	        error: function(xhr, status, error) {
	            toastr.error(xhr.responseJSON.message, 'Error');
	        },
	        complete: function() {
		        $('#loader').hide(); // Hide loader on form screen
		    }
	    });
	}
});
</script>


<script>
	function openCity(evt, cityName) {
		var i, tabcontent, tablinks;
		tabcontent = document.getElementsByClassName("tabcontent");
		for (i = 0; i < tabcontent.length; i++) {
			tabcontent[i].style.display = "none";
		}
		tablinks = document.getElementsByClassName("tablinks");
		for (i = 0; i < tablinks.length; i++) {
			tablinks[i].className = tablinks[i].className.replace(" active", "");
		}
		document.getElementById(cityName).style.display = "block";
		evt.currentTarget.className += " active";
	}
	</script>
	
	@endpush
	
	<style>
		#loader {
		  display: none; /* Hide the loader by default */
		  position: fixed;
		  top: 0;
		  left: 0;
		  width: 100%;
		  height: 100%;
		  background-color: rgba(255, 255, 255, 0.8); /* White background with 80% opacity */
		  z-index: 1000; /* Ensure the loader is on top of all other elements */
		}

		#loader p {
		  font-size: 24px;
		  font-weight: bold;
		  color: #333; /* Dark gray text color */
		}
		/* Style the tab */
		.tab {
		overflow: hidden;
		border: 1px solid #ccc;
		background-color: #f1f1f1;
		}
		
		/* Style the buttons inside the tab */
		.tab button {
		background-color: inherit;
		float: left;
		border: none;
		outline: none;
		cursor: pointer;
		padding: 14px 16px;
		transition: 0.3s;
		font-size: 17px;
		}
		
		/* Change background color of buttons on hover */
		.tab button:hover {
		background-color: #ddd;
		}
		
		/* Create an active/current tablink class */
		.tab button.active {
		background-color: #ccc;
		}
		
		/* Style the tab content */
		.tabcontent {
		display: none;
		padding: 6px 12px;
		border: 1px solid #ccc;
		border-top: none;
		}
	</style>
		