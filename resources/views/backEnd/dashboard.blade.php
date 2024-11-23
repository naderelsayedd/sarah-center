@extends('backEnd.master')
@section('title')
{{ @Auth::user()->roles->name }} @lang('common.dashboard')
@endsection
@push('css')
<link rel="stylesheet" href="{{ asset('public/backEnd/assets/vendors/css/fullcalendar.min.css') }}" />
<link rel="stylesheet" href="{{ asset('public/backEnd/assets/css/time_schedule.css') }}" />
<link rel="stylesheet" href="{{ asset('public/backEnd/assets/vendors/calender_js/core/main.css') }}" />
<link rel="stylesheet" href="{{ asset('public/backEnd/assets/vendors/calender_js/daygrid/main.css') }}" />
<link rel="stylesheet" href="{{ asset('public/backEnd/assets/vendors/calender_js/timegrid/main.css') }}" />
<link rel="stylesheet" href="{{ asset('public/backEnd/assets/vendors/calender_js/list/main.css') }}" />
<style>
	.ti-calendar:before {
	position: absolute;
	bottom: 17px !important;
	right: 18px !important;
	}
	
	.fc-button-group button {
	width: fit-content;
	}
	
	button.fc-today-button {
	width: fit-content;
	}
	
	.fc-icon-chevron-left::before {
	content: "" !important;
	}
	
	.fc-icon-chevron-right::before {
	content: "" !important;
	}
</style>
<style>
	.image-container {
	position: relative;
	display: inline-block;
	}
	.delete-icon {
	position: absolute;
	top: 5px;
	right: 5px;
	display: none;
	color: red;
	cursor: pointer;
	}
	.image-container:hover .delete-icon {
	display: block;
	}
	#carouselModal .modal-dialog.modal-lg {
	max-width: 800px; /* adjust to your desired width */
	height: 600px; /* adjust to your desired height */
	}
	
	#carouselModal .modal-content {
	height: 100%;
	display: flex;
	flex-direction: column;
	}
	
	#carouselModal .modal-body {
	flex: 1;
	overflow: hidden;
	}
	
	#carouselModal .carousel-inner {
	overflow: hidden;
	}
	
	#carouselModal .carousel-item {
	/*display: flex;*/  
	justify-content: center;
	align-items: center;
	}
	
	#carouselModal .carousel-item img {
	max-width: 100%;
	max-height: 100%;
	margin: 0 auto;
	display: block;
	}
	/* .fixed-size {
	width: 200px;
	height: 150px;
	overflow: hidden;
	} */
	
	.img-fit {
	width: 100%; /* make the image fit the container width */
	height: 100%; /* make the image fit the container height */
	object-fit: cover; /* scale the image to cover the container while maintaining aspect ratio */
	}
</style>
@endpush


@section('mainContent')
<section class="mb-40">
	<div class="container-fluid p-0">
		<div class="row">
			<div class="col-lg-12">
				<div class="main-title">
					@if (isSubscriptionEnabled() && auth()->user()->role_id == 1 && saasDomain() != 'school')
					<h3 class="mb-0">@lang('dashboard.welcome') - {{ @Auth::user()->school->school_name }} |
						{{ @Auth::user()->roles->name }} |
						@lang('dashboard.active_package') : {{ @$package_info['package_name'] }} |
						@lang('dashboard.remain_days') : {{ @$package_info['remaining_days'] }} |
						@lang('dashboard.student') : {{ @$totalStudents }} out {{ @$package_info['student_quantity'] }} |
						@lang('common.staff') : {{ @$totalStaffs }} out {{ @$package_info['staff_quantity'] }}
					</h3>
					@else
					<h3 class="mb-0">@lang('dashboard.welcome') - {{ @Auth::user()->school->school_name }} |
					{{ @Auth::user()->roles->name }}</h3>
					@endif
				</div>
			</div>
		</div>
		@if (Auth::user()->role_id == 1 || Auth::user()->role_id == 5 || Auth::user()->role_id == 10)
		
		@endif
		@if (Auth::user()->is_saas == 0)
		<div class="row">
			<div class="col-lg-6 col-md-6 col-sm-6">
				<div class="white-box single-summery">
					<div class="d-flex justify-content-between">
						@php
						$attendance = App\SmAttendance::where('user_id', Auth::user()->id)->where('school_id', Auth::user()->school_id)->where('academic_id',getAcademicId())->orderBy('id', 'desc')->first();
						$clockIN = $attendance ? date('h:i A', strtotime($attendance->in_time)) : '';
						@endphp
						<div>
							<h3>@lang('dashboard.clock_in_clock_out')</h3>
							@if($attendance && $attendance->out_time)
							<p class="mb-0" id="currentMessage" title="You are currently clocked out">@lang('dashboard.you_currently_clocked_out')</p>
							@elseif(!$attendance)
							<p class="mb-0" id="currentMessage" title="You are currently clocked out">@lang('dashboard.you_currently_clocked_out')</p>
							@else
							<p class="mb-0" id="currentMessage" title="You are currently clocked out" style="color: green !important">@lang('dashboard.clock_started_at') : {{$clockIN}}</p>
							
							@endif
						</div>
						
						
						@if($attendance && $attendance->out_time)
						<h1>
							<a href="javascript:;" class="primary-btn small fix-gr-bg" id="clockin" onclick="addUserAttendance();">@lang('dashboard.clock_in') </a>
							<a href="javascript:;" class="primary-btn small fix-gr-bg" id="clockout" data-toggle="modal" data-target="#modalPopAttendance" style="display:none; background: red !important">@lang('dashboard.clock_out') </a>
						</h1>
						@elseif(!$attendance)
						<h1>
							<a href="javascript:;" class="primary-btn small fix-gr-bg" id="clockin" onclick="addUserAttendance();">@lang('dashboard.clock_in') </a>
							<a href="javascript:;" class="primary-btn small fix-gr-bg" id="clockout" data-toggle="modal" data-target="#modalPopAttendance" style="display:none; background: red !important">@lang('dashboard.clock_out')</a>
						</h1>
						@else
						<h1>
							<a href="javascript:;" class="primary-btn small fix-gr-bg" id="clockin" onclick="addUserAttendance();" style="display:none;">@lang('dashboard.clock_in') </a>
							<a href="javascript:;" class="primary-btn small fix-gr-bg" id="clockout" data-toggle="modal" data-target="#modalPopAttendance" style=" background: red !important">@lang('dashboard.clock_out') </a>
						</h1>
						@endif
					</div>
				</div>
			</div>
		</div>
		@endif
		@if (Auth::user()->is_saas == 0)
			@include('backEnd.modules.category_details')
		@endif
		@if (Auth::user()->is_saas == 0)
		<div class="row">
			@if (userPermission('number-of-student'))
			<div class="col-lg-3 col-md-6 col-sm-6">
				<a href="{{ route('student_list') }}" class="d-block">
					<div class="white-box single-summery">
						<div class="d-flex justify-content-between">
							<div>
								<h3>@lang('dashboard.student')</h3>
								<p class="mb-0">@lang('dashboard.total_students')</p>
							</div>
							<h1 class="gradient-color2">
								@if (isset($totalStudents))
								{{ $totalStudents }}
								@endif
							</h1>
						</div>
					</div>
				</a>
			</div>
			@endif
			@if (userPermission('number-of-teacher'))
			<div class="col-lg-3 col-md-6 col-sm-6">
				<a href="{{ route('staff_directory') }}" class="d-block">
					<div class="white-box single-summery">
						<div class="d-flex justify-content-between">
							<div>
								<h3>@lang('common.teachers')</h3>
								<p class="mb-0">@lang('dashboard.total_teachers')</p>
							</div>
							<h1 class="gradient-color2">
								@if (isset($totalTeachers))
								{{ $totalTeachers }}
								@endif
							</h1>
						</div>
					</div>
				</a>
			</div>
			@endif
			@if (userPermission('number-of-parent'))
			{{-- mt-30-md --}}
			<div class="col-lg-3 col-md-6 col-sm-6">
				<a href="#" class="d-block">
					<div class="white-box single-summery">
						<div class="d-flex justify-content-between">
							<div>
								<h3>@lang('dashboard.parents')</h3>
								<p class="mb-0">@lang('dashboard.total_parents')</p>
							</div>
							<h1 class="gradient-color2">
								@if (isset($totalParents))
								{{ $totalParents }}
								@endif
							</h1>
						</div>
					</div>
				</a>
			</div>
			@endif
			@if (userPermission('number-of-staff'))
			<div class="col-lg-3 col-md-6 col-sm-6">
				<a href="{{ route('staff_directory') }}" class="d-block">
					<div class="white-box single-summery">
						<div class="d-flex justify-content-between">
							<div>
								<h3>@lang('dashboard.staffs')</h3>
								<p class="mb-0">@lang('dashboard.total_staffs')</p>
							</div>
							<h1 class="gradient-color2">
								@if (isset($totalStaffs))
								{{ $totalStaffs }}
								@endif
							</h1>
						</div>
					</div>
				</a>
			</div>
			@endif
		</div>
		@endif
		
		@if (Auth::user()->is_saas == 1)
		
		<div class="row">
			@if (userPermission('number-of-student'))
			<div class="col-lg-3 col-md-6 col-sm-6">
				
				<a href="#" class="d-block">
					<div class="white-box single-summery">
						<div class="d-flex justify-content-between">
							<div>
								<h3>@lang('dashboard.student')</h3>
								<p class="mb-0">@lang('dashboard.total_students')</p>
							</div>
							<h1 class="gradient-color2">
								
								@if (isset($totalStudents))
								{{ $totalStudents }}
								@endif
							</h1>
						</div>
					</div>
				</a>
			</div>
			@endif
			@if (userPermission('number-of-teacher'))
			<div class="col-lg-3 col-md-6 col-sm-6">
				<a href="#" class="d-block">
					<div class="white-box single-summery">
						<div class="d-flex justify-content-between">
							<div>
								<h3>@lang('common.teachers')</h3>
								<p class="mb-0">@lang('dashboard.total_teachers')</p>
							</div>
							<h1 class="gradient-color2">
								@if (isset($totalTeachers))
								{{ $totalTeachers }}
								@endif
							</h1>
						</div>
					</div>
				</a>
			</div>
			@endif
			@if (userPermission('number-of-parent'))
			{{-- mt-30-md --}}
			<div class="col-lg-3 col-md-6 col-sm-6">
				<a href="#" class="d-block">
					<div class="white-box single-summery">
						<div class="d-flex justify-content-between">
							<div>
								<h3>@lang('dashboard.parents')</h3>
								<p class="mb-0">@lang('dashboard.total_parents')</p>
							</div>
							<h1 class="gradient-color2">
								@if (isset($totalParents))
								{{ $totalParents }}
								@endif
							</h1>
						</div>
					</div>
				</a>
			</div>
			@endif
			@if (userPermission('number-of-staff'))
			<div class="col-lg-3 col-md-6 col-sm-6">
				<a href="#" class="d-block">
					<div class="white-box single-summery">
						<div class="d-flex justify-content-between">
							<div>
								<h3>@lang('dashboard.staffs')</h3>
								<p class="mb-0">@lang('dashboard.total_staffs')</p>
							</div>
							<h1 class="gradient-color2">
								@if (isset($totalStaffs))
								{{ $totalStaffs }}
								@endif
							</h1>
						</div>
					</div>
				</a>
			</div>
			@endif
		</div>
		@endif
	</div>
</section>
@if (userPermission('month-income-expense'))
<section class="" id="incomeExpenseDiv">
	<div class="container-fluid p-0">
		<div class="row">
			<div class="col-lg-8 col-md-9 col-8">
				<div class="main-title">
					<h3 class="mb-30"> @lang('dashboard.income_and_expenses_for') {{ date('M') }} {{ $year }} </h3>
				</div>
			</div>
			<div class="offset-lg-2 col-lg-2 text-right col-md-3 col-4">
				<button type="button" class="primary-btn small tr-bg icon-only" id="barChartBtn">
					<span class="pr ti-move"></span>
				</button>
				
				<button type="button" class="primary-btn small fix-gr-bg icon-only ml-10" id="barChartBtnRemovetn">
					<span class="pr ti-close"></span>
				</button>
			</div>
			<div class="col-lg-12">
				<div class="white-box" id="barChartDiv">
					<div class="row">
						<div class="col-lg-2 col-md-6 col-6">
							<div class="text-center">
								
								<h1>({{ generalSetting()->currency_symbol }}) {{ number_format($m_total_income) }}
								</h1>
								<p>@lang('dashboard.total_income')</p>
							</div>
						</div>
						<div class="col-lg-2 col-md-6 col-6">
							<div class="text-center">
								<h1>({{ generalSetting()->currency_symbol }})
								{{ number_format($m_total_expense) }}</h1>
								<p>@lang('dashboard.total_expenses')</p>
							</div>
						</div>
						<div class="col-lg-3 col-md-6 col-6">
							<div class="text-center">
								<h1>({{ generalSetting()->currency_symbol }})
								{{ number_format($m_total_income - $m_total_expense) }}</h1>
								<p>@lang('dashboard.total_profit')</p>
							</div>
						</div>
						<div class="col-lg-3 col-md-6 col-6">
							<div class="text-center">
								<h1>({{ generalSetting()->currency_symbol }}) {{ number_format($m_total_income) }}
								</h1>
								<p>@lang('dashboard.total_revenue')</p>
							</div>
						</div>
						@if (moduleStatusCheck('Wallet'))
						<div class="col-lg-2 col-md-6 col-6">
							<div class="text-center">
								<h1>{{ currency_format($monthlyWalletBalance) }}</h1>
								<p>@lang('dashboard.wallet_balance')</p>
							</div>
						</div>
						@endif
						<div class="col-lg-12">
							<div id="commonBarChart" style="height: 350px; padding-right: 20px;"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
@endif


@if (userPermission('year-income-expense'))
<section class="mt-50" id="incomeExpenseSessionDiv">
	<div class="container-fluid p-0">
		<div class="row">
			<div class="col-lg-8 col-md-9 col-8">
				<div class="main-title">
					<h3 class="mb-30">@lang('dashboard.income_and_expenses_for') {{ $year }}</h3>
				</div>
			</div>
			<div class="offset-lg-2 col-lg-2 text-right col-md-3 col-4">
				<button type="button" class="primary-btn small tr-bg icon-only" id="areaChartBtn">
					<span class="pr ti-move"></span>
				</button>
				
				<button type="button" class="primary-btn small fix-gr-bg icon-only ml-10"
				id="areaChartBtnRemovetn">
					<span class="pr ti-close"></span>
				</button>
			</div>
			<div class="col-lg-12">
				<div class="white-box" id="areaChartDiv">
					<div class="row">
						<div class="col-lg-3 col-md-6 col-6">
							<div class="text-center">
								<h1>({{ generalSetting()->currency_symbol }}) {{ number_format($y_total_income) }}
								</h1>
								<p>@lang('dashboard.total_income')</p>
							</div>
						</div>
						<div class="col-lg-3 col-md-6 col-6">
							<div class="text-center">
								
								<h1>({{ generalSetting()->currency_symbol }})
								{{ number_format($y_total_expense) }}</h1>
								<p>@lang('dashboard.total_expenses')</p>
							</div>
						</div>
						<div class="col-lg-2 col-md-6 col-6">
							<div class="text-center">
								<h1>({{ generalSetting()->currency_symbol }})
								{{ number_format($y_total_income - $y_total_expense) }}</h1>
								<p>@lang('dashboard.total_profit')</p>
							</div>
						</div>
						<div class="col-lg-2 col-md-6 col-6">
							<div class="text-center">
								<h1>({{ generalSetting()->currency_symbol }}) {{ number_format($y_total_income) }}
								</h1>
								<p>@lang('dashboard.total_revenue')</p>
							</div>
						</div>
						@if (moduleStatusCheck('Wallet'))
						<div class="col-lg-2 col-md-6 col-6">
							<div class="text-center">
								<h1>{{ currency_format($yearlyWalletBalance) }}</h1>
								<p>@lang('dashboard.wallet_balance')</p>
							</div>
						</div>
						@endif
						
						<div class="col-lg-12">
							<div id="commonAreaChart" style="height: 350px;"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
@endif


@if (userPermission('notice-board'))
<section class="mt-50">
	<div class="container-fluid p-0">
		<div class="row">
			<div class="col-lg-6 col-7">
				<div class="main-title">
					<h3 class="mb-30">@lang('communicate.notice_board')</h3>
				</div>
			</div>
			@if (userPermission('add-notice'))
			<div class="col-lg-6 col-5 ml-auto pull-right text-right">
				<a href="{{ route('add-notice') }}" class="primary-btn small fix-gr-bg"> <span
				class="ti-plus pr-2"></span> @lang('common.add') </a>
			</div>
			@endif
			
			<div class="col-lg-12">
				<table class="school-table-style w-100">
					<thead>
						<tr>
							<th>@lang('common.date')</th>
							<th>@lang('dashboard.title')</th>
							<th class="d-flex justify-content-around">@lang('common.actions')</th>
						</tr>
					</thead>
					
					<tbody>
						<?php $role_id = Auth()->user()->role_id; ?>
						
						<?php if (isset($notices)) {
							
                            foreach ($notices as $notice) {
								// $inform_to = explode(',', @$notice->inform_to);
								// if (in_array($role_id, $inform_to)) {
							?>
							<tr>
								<td>
									
									{{ @$notice->publish_on != '' ? dateConvert(@$notice->publish_on) : '' }}
									
								</td>
								<td>{{ @$notice->notice_title }}</td>
								<td class="d-flex justify-content-around">
									<a href="{{ route('view-notice', @$notice->id) }}" title="@lang('common.view_notice')"
									class="primary-btn small tr-bg modalLink"
									data-modal-size="modal-lg">@lang('common.view')</a>
								</td>
							</tr>
							<?php
								// }
							}
						}
						
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</section>
@endif

<section class="mt-50">
	<div class="container-fluid p-0">
		<div class="row">
			@if (userPermission('calender-section'))
			<div class="col-lg-7 col-xl-8">
				<div class="row">
					<div class="col-lg-12">
						@include('backEnd.communicate.commonAcademicCalendar')
					</div>
				</div>
			</div>
			@endif
			<div class="col-lg-5 col-xl-4 mt-50-md md_infix_50">
				@if (userPermission('to-do-list'))
				<div class="row">
					<div class="col-lg-6 col-md-6 col-6">
						<div class="main-title">
							<h3 class="mb-30">@lang('dashboard.to_do_list')</h3>
						</div>
					</div>
					<div class="col-lg-6 text-right col-md-6 col-6">
						<a href="#" data-toggle="modal" class="primary-btn small fix-gr-bg"
						data-target="#add_to_do" title="Add To Do" data-modal-size="modal-md">
							<span class="ti-plus pr-2"></span>
							@lang('common.add')
						</a>
					</div>
				</div>
				@endif
				
				<div class="modal fade admin-query" id="add_to_do">
					<div class="modal-dialog modal-dialog-centered">
						<div class="modal-content">
							<div class="modal-header">
								<h4 class="modal-title">@lang('dashboard.add_to_do')</h4>
								<button type="button" class="close" data-dismiss="modal">&times;</button>
							</div>
							
							<div class="modal-body">
								<div class="container-fluid">
									{{ Form::open([
									'class' => 'form-horizontal',
									'files' => true,
									'route' => 'saveToDoData',
									'method' => 'POST',
									'enctype' => 'multipart/form-data',
									'onsubmit' => 'return validateToDoForm()',
									]) }}
									
									<div class="row">
										<div class="col-lg-12">
											<div class="row mt-25">
												<div class="col-lg-12" id="sibling_class_div">
													<div class="primary_input">
														<label class="primary_input_label"
														for="">@lang('dashboard.to_do_title') *<span></span>
														</label>
														<input class="primary_input_field form-control" type="text"
														name="todo_title" id="todo_title">
														
														<span class="modal_input_validation red_alert"></span>
													</div>
												</div>
											</div>
											<div class="row mt-30">
												<div class="col-lg-12" id="">
													<div class="no-gutters input-right-icon">
														<div class="col">
															<div class="primary_input">
																<label class="primary_input_label"
																for="">@lang('common.date') <span></span>
																</label>
																<input
																class="read-only-input primary_input_field  primary_input_field date form-control form-control{{ $errors->has('date') ? ' is-invalid' : '' }}"
																id="startDate" type="text" autocomplete="off"
																readonly="true" name="date"
																value="{{ date('m/d/Y') }}"><i
																class="ti-calendar" id="start-date-icon"></i>
																@if ($errors->has('date'))
																<span class="text-danger">
																	{{ $errors->first('date') }}
																</span>
																@endif
															</div>
														</div>
													</div>
												</div>
											</div>
											
											<div class="col-lg-12 text-center">
												<div class="mt-40 d-flex justify-content-between">
													<button type="button" class="primary-btn tr-bg"
													data-dismiss="modal">@lang('common.cancel')</button>
													<input class="primary-btn fix-gr-bg submit" type="submit"
													value="@lang('common.save')">
												</div>
											</div>
										</div>
										{{ Form::close() }}
									</div>
								</div>
								
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="white-box school-table">
							<div class="row to-do-list mb-20">
								<div class="col-md-12 d-flex align-items-center justify-content-between ">
									<button class="primary-btn small fix-gr-bg"
									id="toDoList">@lang('dashboard.incomplete')</button>
									<button class="primary-btn small tr-bg"
									id="toDoListsCompleted">@lang('dashboard.completed')</button>
								</div>
							</div>
							<input type="hidden" id="url" value="{{ url('/') }}">
							<div class="toDoList">
								@if (count(@$toDos->where('complete_status', 'P')) > 0)
								@foreach ($toDos->where('complete_status', 'P') as $toDoList)
								<div class="single-to-do d-flex justify-content-between toDoList"
								id="to_do_list_div{{ @$toDoList->id }}">
									<div>
										<input type="checkbox" id="midterm{{ @$toDoList->id }}"
										class="common-checkbox complete_task" name="complete_task"
										value="{{ @$toDoList->id }}">
										
										<label for="midterm{{ @$toDoList->id }}">
											<input type="hidden" id="id"
											value="{{ @$toDoList->id }}">
											<input type="hidden" id="url"
											value="{{ url('/') }}">
											<h5 class="d-inline">{{ @$toDoList->todo_title }}</h5>
											<p>
												{{ $toDoList->date != '' ? dateConvert(@$toDoList->date) : '' }}
												
											</p>
										</label>
									</div>
								</div>
								@endforeach
								@else
								<div class="single-to-do d-flex justify-content-between">
									@lang('dashboard.no_do_lists_assigned_yet')
								</div>
								@endif
							</div>
							
							
							<div class="toDoListsCompleted">
								@if (count(@$toDos->where('complete_status', 'C')) > 0)
								@foreach ($toDos->where('complete_status', 'C') as $toDoListsCompleted)
								<div class="single-to-do d-flex justify-content-between"
								id="to_do_list_div{{ @$toDoListsCompleted->id }}">
									<div>
										<h5 class="d-inline">{{ @$toDoListsCompleted->todo_title }}</h5>
										<p class="">
											
											{{ @$toDoListsCompleted->date != '' ? dateConvert(@$toDoListsCompleted->date) : '' }}
											
										</p>
									</div>
								</div>
								@endforeach
								@else
								<div class="single-to-do d-flex justify-content-between">
									@lang('dashboard.no_do_lists_assigned_yet')
								</div>
								@endif
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- check if the logged in user is teacher -->
		<!-- for storing the gallery data -->
		<!-- Modal box -->
		<div class="modal fade" id="galleryModal" tabindex="-1" role="dialog" aria-labelledby="galleryModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
                <div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="galleryModalLabel">@lang('dashboard.add_gallery')</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<!-- Form content goes here -->
						<form action="{{ route('uploadGallery') }}" method="post" enctype="multipart/form-data">
							@csrf
							<div class="form-group">
								<label for="gallery_name">@lang('dashboard.gallery_name'):</label>
								<input type="text" class="form-control" id="gallery_name" name="gallery_name" required>
							</div>
							<div class="form-group">
								<label for="images">@lang('dashboard.class'):</label>
								<select class="form-control" name="class">
									<option selected disabled>@lang('dashboard.select_class')</option>
									<?php foreach ($allClasses as $key => $value): ?>
									<option value="{{$value->id}}">{{$value->class_name}}</option>
									<?php endforeach ?>
								</select>
							</div>
							<div class="form-group">
								<label for="location">@lang('dashboard.location'):</label>
								<input type="text" class="form-control" id="location" name="location" required>
							</div>
							<div class="form-group">
								<label for="location">@lang('dashboard.date'):</label>
								<input type="date" class="form-control" id="date" name="date" required>
							</div>
							<!-- Add other required fields for gallery here -->
							<div class="form-group">
								<label for="images">@lang('dashboard.images'):</label>
								<input type="file" class="form-control" id="images" name="images[]" multiple required>
							</div>
							<button type="submit" class="btn btn-primary">@lang('dashboard.submit_gallery')</button>
						</form>
					</div>
				</div>
			</div>
		</div>
		<!-- for showing the gallery data -->
		<section class="mt-50">
			<div class="row">
				<div class="col-lg-12">
					<div class="white-box">
						<div class="row">
							<div class="col-lg-6">
								<div class="main-title">
									<h3 class="mb-30">@lang('dashboard.gallery')</h3>
								</div>
							</div>
							<div class="col-lg-6 text-right"><a href="#" class="primary-btn small fix-gr-bg" data-toggle="modal" data-target="#galleryModal"><span class="ti-plus pr-2"></span>@lang('dashboard.add_new_gallery')</a></div>
							<div class="col-lg-6 mb-4">
								<?php if (Auth::user()->role_id == 1 || Auth::user()->role_id == 5): ?>
								<form action="{{ route('dashboard') }}" method="get" id="class-filter-form">
									<select class="nice-select primary_select form-control" name="class_filter" onchange="document.getElementById('class-filter-form').submit()">
										<option selected disabled>@lang('dashboard.filter_by_class')</option>
										<?php foreach ($allClasses as $key => $value): ?>
										<option value="{{$value->id}}" {{ request()->get('class_filter') == $value->id? 'selected' : '' }}>{{$value->class_name}}</option>
										<?php endforeach ?>
									</select>
								</form>
							</div>
							<div class="col-lg-6 mb-4">
								<form action="{{ route('dashboard') }}" method="get" id="gallery-teacher-filter-form">
									<select class="nice-select primary_select form-control" name="filter_gallery_teacher_id" onchange="document.getElementById('gallery-teacher-filter-form').submit()">
										<option selected disabled>@lang('dashboard.filter_by_user')</option>
										<?php foreach ($staff_list as $key => $value):?>
										<option value="{{$value->user_id}}" {{ request()->get('filter_teacher_id') == $value->user_id? 'selected' : '' }}>{{$value->full_name}}</option>
										<?php endforeach?>
									</select>
								</form>
								<?php endif;?>
							</div>
							<!-- <div class="col-lg-12 col-12 ml-auto pull-right text-right">
								
							</div> -->
						</div>
						<div class="row">
							@foreach($gallery as $gallery_image)
							<div class="col-md-3">
								<div class="image-gallery-box position-relative">
									<img src="{{ $gallery_image->images[0]->images }}" class="img-thumbnail img-fit" data-toggle="modal" data-target="#carouselModal" data-slide-to="{{ $loop->index }}" data-gallery-id="{{ $gallery_image->id }}">
									<div class="comment-count-badge position-absolute" style="top:10px;left: 10px;background-color: #fff;border-radius: 50%;padding: 1px 10px;font-size: 12px;font-weight: bold;color: #333;">
										{{ $gallery_image->comments->count() }}
									</div>
									<div class="dashboard-gallery-text">
										<label>{{ $gallery_image->title }}</label>
										<label class="text-right">{{ $gallery_image->date }}</label>
									</div>
									
									<div class="image-overlay">
										<?php if (Auth::user()->role_id == 5  || Auth::user()->role_id == 1 || Auth::user()->id == $gallery_image->teacher_id):?>
										<form action="{{ route('deleteGallery', $gallery_image->id) }}" method="POST" class="delete-form">
											@csrf
											@method('DELETE')
											<button type="submit" class="delete-btn">
												<i class="fas fa-trash"></i>
											</button>
										</form>
										<?php endif?>
										<a href="{{ route('downloadGallery', $gallery_image->id) }}" class="download-icon">
											<i class="fas fa-download"></i>
										</a>
										<a href="{{ route('galleryDetailsPage', $gallery_image->id) }}" class="view-icon">
											<i class="fas fa-eye"></i>
										</a>
									</div>
								</div>
							</div>
							@endforeach
						</div>
						<!-- Modal -->
						<div class="modal fade" id="carouselModal" tabindex="-1" role="dialog" aria-labelledby="carouselModalLabel" aria-hidden="true">
							<div class="modal-dialog modal-lg" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title " id="carouselModalLabel">@lang('dashboard.gallery_images')</h5>
										<a href="javascript::void(0);" class="primary-btn small fix-gr-bg view-all" data-gallery-id="">@lang('dashboard.view_all')</a>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="modal-body">
										<div id="carouselExample" class="carousel slide" data-ride="carousel">
											<div class="carousel-inner">
												<div class="text-center">@lang('dashboard.loading_images')...</div>
												<!-- Carousel items will be loaded here via AJAX -->
											</div>
											<a class="carousel-control-prev" href="#carouselExample" role="button" data-slide="prev">
												<span class="carousel-control-prev-icon" aria-hidden="true"></span>
												<span class="sr-only">Previous</span>
											</a>
											<a class="carousel-control-next" href="#carouselExample" role="button" data-slide="next">
												<span class="carousel-control-next-icon" aria-hidden="true"></span>
												<span class="sr-only">Next</span>
											</a>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- Gallery Modal -->
		</section>
		<br>
		<br>
		@include('backEnd.modules.weeklyPlan')
	</div>
</section>


<div id="fullCalModal" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 id="modalTitle" class="modal-title"></h4>
				<button type="button" class="close" data-dismiss="modal">
					<span aria-hidden="true">×</span> <span class="sr-only">@lang('common.close')</span>
				</button>
			</div>
			<div class="modal-body text-center">
				<img src="" alt="There are no image" id="image" class="" height="150"
				width="auto">
				<div id="modalBody"></div>
			</div>
			<div class="modal-footer">
				<button type="button" class="primary-btn tr-bg" data-dismiss="modal">@lang('common.close')</button>
			</div>
		</div>
	</div>
</div>



{{-- Dashboard Secound Graph Start  --}}

{{-- @php
@$chart_data = "";

for($i = 1; $i <= date('d'); $i++){

$i = $i < 10? '0'.$i:$i;
@$income = App\SmAddIncome::monthlyIncome($i);
@$expense = App\SmAddIncome::monthlyExpense($i);

@$chart_data .= "{ day: '" . $i . "', income: " . @$income . ", expense:" . @$expense . " },";
}
@endphp

@php
@$chart_data_yearly = "";

for($i = 1; $i <= date('m'); $i++){

$i = $i < 10? '0'.$i:$i;

@$yearlyIncome = App\SmAddIncome::yearlyIncome($i);

@$yearlyExpense = App\SmAddIncome::yearlyExpense($i);

@$chart_data_yearly .= "{ y: '" . $i . "', income: " . @$yearlyIncome . ", expense:" . @$yearlyExpense . " },";

}
@endphp --}}

{{-- Dashboard Secound Graph End  --}}


@endsection
@include('backEnd.partials.date_picker_css_js')
@include('backEnd.communicate.academic_calendar_css_js')
@section('script')
<script type="text/javascript" src="{{ asset('public/backEnd/') }}/vendors/js/fullcalendar.min.js"></script>
<script src="{{ asset('public/backEnd/vendors/js/fullcalendar-locale-all.js') }}"></script>
<script>
	$('#carouselModal').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget);
		var slideTo = button.data('slide-to');
		$('#carouselExampleIndicators').carousel(slideTo);
	});
</script>
<script type="text/javascript">
	function barChart(idName) {
		window.barChart = Morris.Bar({
			element: 'commonBarChart',
			data: [<?php echo $chart_data; ?>],
			xkey: 'day',
			ykeys: ['income', 'expense'],
			labels: [jsLang('income'), jsLang('expense')],
			barColors: ['#8a33f8', '#f25278'],
			resize: true,
			redraw: true,
			gridTextColor: 'var(--base_color)',
			gridTextSize: 12,
			gridTextFamily: '"Poppins", sans-serif',
			barGap: 4,
			barSizeRatio: 0.3
		});
	}
	
	const monthNames = ["", "Jan", "Feb", "Mar", "Apr", "May", "Jun",
	"Jul", "Aug", "Sep", "Oct", "Nov", "Dec"
	];
	
	function areaChart() {
		window.areaChart = Morris.Area({
			element: 'commonAreaChart',
			data: [<?php echo $chart_data_yearly; ?>],
			xkey: 'y',
			parseTime: false,
			ykeys: ['income', 'expense'],
			labels: [jsLang('income'), jsLang('expense')],
			xLabelFormat: function(x) {
				var index = parseInt(x.src.y);
				return monthNames[index];
			},
			xLabels: "month",
			labels: [jsLang('income'), jsLang('expense')],
			hideHover: 'auto',
			lineColors: ['rgba(124, 50, 255, 0.5)', 'rgba(242, 82, 120, 0.5)'],
		});
	}
</script>

<script type="text/javascript">
	if ($('.common-calendar').length) {
		$('.common-calendar').fullCalendar({
			locale: _locale,
			rtl: _rtl,
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,agendaWeek,agendaDay'
			},
			eventClick: function(event, jsEvent, view) {
				$('#modalTitle').html(event.title);
				let url = event.url;
				let description = event.description;
				if (!url) {
					$('#image').addClass('d-none');
				}
				if (url.includes('lead')) {
					$('#image').addClass('d-none');
					$('#modalBody').html(event.description);
					} else {
					$('#image').attr('src', event.url);
				}
				$('#fullCalModal').modal();
				return false;
			},
			height: 650,
			events: <?php echo json_encode($calendar_events); ?>,
		});
	}
</script>
<script>
	$(document).ready(function() {
		var galleryId = '';
		$('#carouselModal').on('show.bs.modal', function(event) {
			var button = $(event.relatedTarget);
			galleryId = button.data('gallery-id');
			var modal = $(this);
			
			
			
			$.ajax({
				type: 'GET',
				url: '{{ route('getGalleryImages') }}',
				data: { gallery_id: galleryId },
				success: function(data) {
					var carouselInner = modal.find('.carousel-inner');
					carouselInner.empty();
					
					$.each(data, function(index, image) {
						var carouselItem = $('<div class="carousel-item">');
						var img = $('<img src="' + image.images + '">');
						
						carouselItem.append(img);
						carouselInner.append(carouselItem);
						
						if (index === 0) {
							carouselItem.addClass('active');
						}
					});
				}
			});
		});
		
		$('.view-all').on('click', function() {
			window.location.href = '{{ route("galleryDetailsPage", "ID") }}'.replace('ID', galleryId);
		});
		
	});
</script>
@endsection
