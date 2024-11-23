@extends('backEnd.master')
@section('title')
{{ $student_detail->first_name . ' ' . $student_detail->last_name }} @lang('student.teacher_list')
@endsection
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
<section class="admin-visitor-area up_admin_visitor">
	<div class="container-fluid p-0" style="width: 275% !important;">
		
		<div class="row">
			<div class="col-lg-12 student-details up_admin_visitor">
				<ul class="nav nav-tabs tabs_scroll_nav ml-0" role="tablist">
					
					@foreach ($records as $key => $record)
					<li class="nav-item mb-0">
						<a class="nav-link mb-0 @if ($key == 0) active @endif "
						href="#tab{{ $key }}" role="tab"
						data-toggle="tab">{{ $record->class->class_name }}
							({{ $record->section->section_name }})
						</a>
					</li>
					@endforeach
					
				</ul>
				<!-- Tab panes -->
				<div class="tab-content">
					@foreach ($records as $key => $record)
					<div role="tabpanel" class="tab-pane fade  @if ($key == 0) active show @endif"
					id="tab{{ $key }}">
						<div class="row mt-10">
							<div class="col-lg-12">
								<table id="table_id" class="table" cellspacing="0" width="100%">
									<thead>
										<tr>
											<th width="15%">@lang('hr.teacher_name')</th>
											<th width="10%">@lang('common.subject')</th>
											@if (generalSetting()->teacher_email_view)
											<th>@lang('common.email')</th>
											@endif
											@if (generalSetting()->teacher_phone_view)
											<th>@lang('common.phone')</th>
											@endif
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
											</tr>
										</thead>
										<tbody>
											@foreach ($setFinalArr as $value)
											<tr>
												<td>
													<img src="{{ file_exists(@$value->teacher->staff_photo) ? asset(@$value->teacher->staff_photo) : asset('public/uploads/staff/demo/staff.jpg') }}"
													class="img img-thumbnail"
													style="width: 60px; height: auto;">
													{{ @$value->teacher != '' ? @$value->teacher->full_name : '' }}
												</td>
												<th>{{ $value->subject->subject_name }}</th>
												@if (generalSetting()->teacher_email_view)
												<td>{{ @$value->teacher != '' ? @$value->teacher->email : '' }}
												</td>
												@endif
												@if (generalSetting()->teacher_phone_view)
												<td>{{ @$value->teacher != '' ? @$value->teacher->mobile : '' }}
												</td>
												@endif
												<th>
													@if (in_array($value->teacher_id, $teacherIds))
													<label class="primary-btn small fix-gr-bg">Teacher Evaluations Already Submitted.</label>
													@else
													<a href="javascript:void();" onclick="showPop('modalPopTeacherEvaluations_{{ $value->teacher_id }}','add_teacher_evaluations','select_teacher_evaluations','select');" class="primary-btn small fix-gr-bg" data-toggle="tooltip" title="" data-original-title="Add Teacher Evaluations">@lang('common.teacher_evaluations')</a>
													@endif
												</th>
												
											</tr>
											@endforeach
										</tbody>
									</table>
								</div>
							</div>
						</div>
                        @endforeach
					</div>
				</div>
			</div>
		</div>
		
		@foreach ($records as $key => $record)
		@foreach ($setFinalArr as $value)
		<!-- Modal Example Start-->
		<div class="modal fade" id="modalPopTeacherEvaluations_{{ $value->teacher_id }}" tabindex="-1" role="dialog" aria- labelledby="demoModalLabel" aria-hidden="true">
			<div class="modal-dialog large-modal modal-dialog-centered">
				<div class="modal-content"> 
					<div class="modal-header">
						<h4 class="modal-title">@lang('common.teacher_questionnaire_evaluation')
						<br>  ({{ @$value->teacher != '' ? @$value->teacher->full_name : '' }}  {{ $value->subject->subject_name }})</h4>
						<button type="button" class="close" data-dismiss="modal">&times;</button>
					</div>
					<div class="modal-body">
						{{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'teacher-evaluation-question', 'method' => 'POST', 'enctype' => 'multipart/form-data', 'id' => 'infix_form']) }}
						<div class="col-md-12">
							<input type="hidden" name="teacher_id" value="{{ $value->teacher_id }}">
							<input type="hidden" name="record_id" value="{{ $record->id }}">
							<input type="hidden" name="student_id" value="{{ $record->studentDetail->id }}">
							<input type="hidden" name="parent_id" value="{{ $record->studentDetail->parents->id }}">
							<input type="hidden" name="subject_id" value="{{ $value->subject->id }}">
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
		@endforeach
	</section>
	@endsection
	@include('backEnd.partials.data_table_js')
