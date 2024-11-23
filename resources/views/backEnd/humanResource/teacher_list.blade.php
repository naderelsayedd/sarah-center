@extends('backEnd.master')
@section('mainContent')
@push('css')
<style>
	table.dataTable tbody th,
	table.dataTable tbody td {
	padding-left: 20px !important;
	}
	
	table.dataTable thead th {
	padding-left: 34px !important;
	}
	
	table.dataTable thead .sorting_asc:after,
	table.dataTable thead .sorting:after,
	table.dataTable thead .sorting_desc:after {
	left: 16px;
	top: 10px;
	}
	
	.star-rating {
	display: flex;
	flex-direction: row-reverse;
	font-size: 1.5em;
	justify-content: space-around;
	text-align: center;
	width: 5em;
	}
	
	.star-rating input {
	display: none;
	}
	
	.star-rating label {
	color: #ccc;
	cursor: pointer;
	}
	
	.star-rating :checked~label {
	color: #f90;
	}
	
	article {
	background-color: #ffe;
	box-shadow: 0 0 1em 1px rgba(0, 0, 0, .25);
	color: #006;
	font-family: cursive;
	font-style: italic;
	margin: 4em;
	max-width: 30em;
	padding: 2em;
	}
</style>
@endpush
<section class="sms-breadcrumb mb-40 white-box">
	<div class="container-fluid">
		<div class="row justify-content-between">
			<h1>@lang('student.teacher_list')</h1>
			<div class="bc-pages">
				<a href="{{ route('dashboard') }}">@lang('common.dashboard')</a>
				<a href="">@lang('student.teacher_list')</a>
			</div>
		</div>
	</div>
</section>
<br><br>
<section class="admin-visitor-area up_admin_visitor">
	<div class="container-fluid p-0">
		
		<div class="row">
			<div class="col-lg-12 ">
				<div class="row mt-10">
					<div class="col-lg-12">
						<table id="table_id" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th>@lang('hr.teacher_name')</th>
									<th>@lang('common.email')</th>
									<th>@lang('common.phone')</th>
									@if ($teacherEvaluationSetting->is_enable == 0)
									@if (in_array('3', $teacherEvaluationSetting->submitted_by))
									@if (date('m/d/Y') >= date('m/d/Y', strtotime($teacherEvaluationSetting->from_date)) &&
									date('m/d/Y') <= date('m/d/Y', strtotime($teacherEvaluationSetting->to_date)))
										<th width="15%">@lang('teacherEvaluation.rate')</th>
										<th width="50%">@lang('teacherEvaluation.comment')</th>
										<th width="10%">@lang('common.action')</th>
										@endif
										@endif
										@endif
										<th>@lang('common.action')</th>
									</tr>
								</thead>
								<tbody>
									@foreach ($teacherList as $value)
									<tr>
										<td>
											<img src="{{ file_exists(@$value->staff_photo) ? asset(@$value->staff_photo) : asset('public/uploads/staff/demo/staff.jpg') }}"
											class="img img-thumbnail"
											style="width: 60px; height: auto;">
											{{ @$value->teacher != '' ? @$value->full_name : '' }}
										</td>
										<td>{{ @$value->email != '' ? @$value->email : '' }}</td>
										<td>{{ @$value->phone_number != '' ? @$value->phone_number : '' }}	</td>
										<td>
											@if (in_array($value->id, $teacherIds))
											<label class="primary-btn small fix-gr-bg">Teacher Evaluations Already Submitted.</label>
											@else
											<a href="javascript:void();" onclick="showPop('modalPopTeacherEvaluations_{{ $value->id }}','add_teacher_evaluations','select_teacher_evaluations','select');" class="primary-btn small fix-gr-bg" data-toggle="tooltip" title="" data-original-title="Add Teacher Evaluations">@lang('common.teacher_evaluations')</a>
											@endif
										</td>
										
										</tr>
										@endforeach
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
				
				@foreach ($teacherList as $value)
				<!-- Modal Example Start-->
				<div class="modal fade" id="modalPopTeacherEvaluations_{{ $value->id }}" tabindex="-1" role="dialog" aria- labelledby="demoModalLabel" aria-hidden="true">
					<div class="modal-dialog large-modal modal-dialog-centered">
						<div class="modal-content"> 
							<div class="modal-header">
								<h4 class="modal-title">@lang('common.teacher_questionnaire_evaluation')
								<br>  ({{ @$value->full_name != '' ? @$value->full_name : '' }})</h4>
								<button type="button" class="close" data-dismiss="modal">&times;</button>
							</div>
							<div class="modal-body">
								{{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'teacher-evaluation-question-admin', 'method' => 'POST', 'enctype' => 'multipart/form-data', 'id' => 'infix_form']) }}
								<div class="col-md-12">
									<input type="hidden" name="teacher_id" value="{{ $value->id }}">
									<table class="report-section" dir="rtl" style="width: 100%">
										<thead>
											<tr>
										<th>المؤشرات التطبيقية</th>
										<th>الدرجة</th>
										<th>التقييم</th>
										<th>ملاحظات</th>
									</tr>
								</thead>
								<tbody>
									@foreach ($getQuestion as $getData)
									
									<tr>
										<td>{{ $getData->question }} <input type="hidden" name="question_id[]" value="{{ $getData->id }}"></td>
										<td>
											<select name="rating[]" required class="primary_input_field read-only-input form-control">
												<option value="">الدرجة</option>
												<option value="1">1</option>
												<option value="2">2</option>
												<option value="3">3</option>
												<option value="4">4</option>
												<option value="5">5</option>
											</select>
										</td>
										<td><input class="primary_input_field read-only-input form-control" type="text" name="comment[]" placeholder="التقييم"></td>
										<td><input class="primary_input_field read-only-input form-control" type="text" name="evaluation[]" placeholder="ملاحظات"></td>
									</tr>
									
									@endforeach
								</tbody>
							</table>
						</div>
						<div class="modal-footer">
							<button type="submit" class="primary-btn small fix-gr-bg">@lang('common.save')</button>
							{{ Form::close() }}
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- Modal Example End-->
		@endforeach
	</section>
	@endsection
	@include('backEnd.partials.data_table_js')
