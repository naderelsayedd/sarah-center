@extends('backEnd.master')
@section('title')
    @lang('parent.parent_dashboard')
@endsection
@push('css')
    <style>
        .QA_section .QA_table thead th {
            padding-left: 30px !important;
        }

        .check_box_table .QA_table .table tbody th:first-child {
            padding-left: 20px !important;
        }

        .check_box_table .QA_table .table thead th:nth-child(2) {
            padding-left: 0px !important;
        }

        .customeDashboard tr td,
        #default_table tr td {
            min-width: 150px;
        }

        .table .routine-table td,
        .table th {
            padding: 20px 18px !important;
        }

        .QA_table {
            margin-top: 5px !important;
        }

        .fc th {
            padding: 0 !important;
        }
    </style>
@endpush
@section('mainContent')
<?php if ($interview == 0): ?>    
@include('backEnd.parentPanel.interview');
<?php endif ?>
    <section class="student-details">
        <div class="container-fluid p-0">
            <div class="row">
                <div class="col-lg-3">
                    <div class="main-title">
                        <h3 class="mb-20">@lang('parent.my_children')</h3>
                    </div>
                </div>
            </div>
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
		
		<a href="javascript:void(0)" class="primary-btn fix-gr-bg submit pull-right" onclick="showPickUpArrieved()">@lang('common.pickup_arrieved_student_notification')</a>

            {{-- <div class="row"> --}}
            @foreach ($my_childrens as $children)
                <div class="row">
                    <div class="col-lg-12">
                        <!-- Start Student Meta Information -->
                        <div class="main-title">
                            <h3 class="mb-20"><strong> {{ $children->full_name }}</strong>  <a href="{{ route('update-my-children', $children->id) }}" class="primary-btn fix-gr-bg submit pull-right">Edit {{ $children->full_name }} Profile</a></h3>
                        </div>

                        @php
                            $student_detail = $children;

                            $issueBooks = $student_detail->bookIssue;

                            $homeworkLists = 0;
                            $totalSubjects = 0;
                            $totalOnlineExams = 0;
                            $totalTeachers = 0;
                            $totalExams = 0;
                            $feesDue = 0;
                            $totalPoint = 0;
                            $balance_fees = 0;
                            $pendingHomework = 0;

                            foreach ($student_detail->studentRecords as $record) {
                                $homework = $record->getHomeWorkAttribute();
                                $pendingHomework += $homework->where('homework_completed_count', 0)->count();
                                $totalSubjects += $record->getAssignSubjectAttribute()->count();
                                $totalTeachers += $record->getStudentTeacherAttribute()->count();
                                $totalOnlineExams += $record->getOnlineExamAttribute()->count();
                                $totalExams += $record->examSchedule()->count();

                                foreach ($record->feesInvoice as $key => $studentInvoice) {
                                    $amount = $studentInvoice->Tamount;
                                    $weaver = $studentInvoice->Tweaver;
                                    $fine = $studentInvoice->Tfine;
                                    $paid_amount = $studentInvoice->Tpaidamount;
                                    $sub_total = $studentInvoice->Tsubtotal;
                                    $feesDue = $amount + $fine - ($paid_amount + $weaver);
                                }
                                foreach ($record->directFeesInstallments as $feesInstallment) {
                                    $balance_fees += discount_fees($feesInstallment->amount, $feesInstallment->discount_amount) - $feesInstallment->paid_amount;
                                }
                                foreach ($record->incidents as $incident) {
                                    $totalPoint += $incident->point;
                                }
                            }

                            $attendances = $student_detail->studentAttendances->where('academic_id', generalSetting()->session_id);
                        @endphp
                    </div>
                </div>
                <div class="row">
                    @if (userPermission('parent-dashboard-subject'))
                        <div class="col-lg-3 col-md-6">
                            <a href="{{ route('parent_subjects', $children->id) }}" class="d-block">
                                <div class="white-box single-summery">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h3>@lang('common.subject')</h3>
                                            <p class="mb-0">@lang('parent.total_subject')</p>
                                        </div>
                                        <h1 class="gradient-color2">

                                            {{ $totalSubjects }}

                                        </h1>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endif
                    @if (userPermission('parent-dashboard-notice'))
                        <div class="col-lg-3 col-md-6">
                            <a href="{{ route('parent_noticeboard') }}" class="d-block">
                                <div class="white-box single-summery">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h3>@lang('parent.notice')</h3>
                                            <p class="mb-0">@lang('parent.total_notice')</p>
                                        </div>
                                        <h1 class="gradient-color2">
                                            @if (isset($totalNotices))
                                                {{ count($totalNotices) }}
                                            @endif
                                        </h1>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endif
                    @if (userPermission('parent-dashboard-exam'))
                        <div class="col-lg-3 col-md-6">
                            <a href="{{ route('parent_exam_schedule', $children->id) }}" class="d-block">
                                <div class="white-box single-summery">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h3>@lang('parent.exam')</h3>
                                            <p class="mb-0">@lang('parent.total_exam')</p>
                                        </div>
                                        <h1 class="gradient-color2">

                                            {{ $totalExams }}
                                        </h1>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endif
                    @if (userPermission('parent-dashboard-exam'))
                        <div class="col-lg-3 col-md-6">
                            <a href="{{ route('parent_online_examination', $children->id) }}" class="d-block">
                                <div class="white-box single-summery">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h3>@lang('parent.online_exam')</h3>
                                            <p class="mb-0">@lang('parent.total_online_exam')</p>
											</div>
                                        <h1 class="gradient-color2">

                                            {{ $totalOnlineExams }}
                                        </h1>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endif
                    @if (userPermission('parent-dashboard-teacher'))
                        <div class="col-lg-3 col-md-6">
                            <a href="{{ route('parent_teacher_list', $children->id) }}" class="d-block">
                                <div class="white-box single-summery">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h3>@lang('parent.teachers')</h3>
                                            <p class="mb-0">@lang('parent.total_teachers')</p>
                                        </div>
                                        <h1 class="gradient-color2">
                                            {{ $totalTeachers }}
                                        </h1>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endif
                    @if (userPermission('parent-dashboard-issued-books'))
                        <div class="col-lg-3 col-md-6">
                            <a href="{{ route('parent_library') }}" class="d-block">
                                <div class="white-box single-summery">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h3>@lang('parent.issued_book')</h3>
                                            <p class="mb-0">@lang('parent.total_issued_book')</p>
                                        </div>
                                        <h1 class="gradient-color2">
                                            @if (isset($issueBooks))
                                                {{ count($issueBooks) }}
                                            @endif
                                        </h1>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endif
                    @if (userPermission('parent-dashboard-pending-homeworks'))
                        <div class="col-lg-3 col-md-6">
                            <a href="{{ route('parent_homework', $children->id) }}" class="d-block">
                                <div class="white-box single-summery">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h3>@lang('parent.pending_home_work')</h3>
                                            <p class="mb-0">@lang('parent.total_pending_home_work')</p>
                                        </div>
                                        <h1 class="gradient-color2">
                                            @if (isset($pendingHomework))
                                                {{ $pendingHomework }}
                                            @endif
                                        </h1>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endif
                    @if (userPermission('parent-dashboard-attendance-in-current-month'))
                        <div class="col-lg-3 col-md-6">
                            <a href="{{ route('parent_attendance', $children->id) }}" class="d-block">
                                <div class="white-box single-summery">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h3>@lang('parent.attendance_in_current_month')</h3>
                                            <p class="mb-0">@lang('parent.total_attendance_in_current_month')</p>
                                        </div>
                                        <h1 class="gradient-color2">
                                            @if (isset($attendances))
                                                {{ count($attendances) }}
                                            @endif
                                        </h1>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endif
                    <div class="col-lg-3 col-md-6">
                        <a href="{{ generalSetting()->fees_status == 0 ? route('parent_fees', $children->id) : route('fees.student-fees-list-parent', $children->id) }}"
                            class="d-block">
                            <div class="white-box single-summery">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h3>@lang('parent.fees')</h3>
                                        <p class="mb-0">@lang('parent.total_due_fees')</p>
                                    </div>
                                    <h1 class="gradient-color2">
                                        @if (generalSetting()->fees_status == 0)
                                            {{ $currency->currency_symbol }}{{ $balance_fees }}
                                        @elseif (isset($feesDue))
                                            {{ $currency->currency_symbol }}{{ $feesDue }}
                                        @endif
                                    </h1>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <a href="{{ route('my_children', $children->id) }}" class="d-block">
                            <div class="white-box single-summery">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h3>@lang('parent.behaviour_point')</h3>
                                        <p class="mb-0">@lang('parent.student_behaviour_point')</p>
                                    </div>
                                    <h1 class="gradient-color2">
                                        @if (isset($totalPoint))
                                            {{ $totalPoint }}
                                        @endif
                                    </h1>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <br>
                @if (userPermission('parent_class_routine'))
                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                            <div class="main-title">
                                <h3 class="mb-30">@lang('academics.class_routine')</h3>
                            </div>
                        </div>
                        <div class="col-lg-12 student-details up_admin_visitor mb-20">
                            <ul class="nav nav-tabs tabs_scroll_nav ml-0" role="tablist">
                                @foreach ($children->studentRecords as $key => $record)
                                    <li class="nav-item">
                                        <a class="nav-link @if ($key == 0) active @endif"
                                            href="#routineTab{{ $key }}" role="tab" data-toggle="tab">
                                            @if (moduleStatusCheck('University'))
                                                {{ $record->semesterLabel->name }}
                                                ({{ $record->unSection->section_name }})
                                                -
                                                {{ @$record->unAcademic->name }}
                                            @else
                                                {{ $record->class->class_name }} ({{ $record->section->section_name }})
                                            @endif
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                            <div class="tab-content">
                                @foreach ($children->studentRecords as $key => $record)
                                    <div role="tabpanel"
                                        class="tab-pane fade  @if ($key == 0) active show @endif"
                                        id="routineTab{{ $key }}">
                                        <div class="container-fluid p-0">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="table-responsive">
                                                        <x-table>
                                                            <table id="default_table"
                                                                class="table customeDashboard routine-table"
                                                                cellspacing="0"
                                                                width="100%">
                                                                <tr>
                                                                    @php
                                                                        $height = 0;
                                                                        $tr = [];
                                                                    @endphp
                                                                    @foreach ($sm_weekends as $sm_weekend)
                                                                        @php
                                                                            if (moduleStatusCheck('University')) {
                                                                                $studentClassRoutine = App\SmWeekend::universityStudentClassRoutine($record->un_semester_label_id, $record->un_section_id, $sm_weekend->id);
                                                                            } else {
                                                                                $studentClassRoutine = App\SmWeekend::studentClassRoutineFromRecord($record->class_id, $record->section_id, $sm_weekend->id);
                                                                            }
                                                                        @endphp
                                                                        @if ($studentClassRoutine->count() > $height)
                                                                            @php
                                                                                $height = $studentClassRoutine->count();
                                                                            @endphp
                                                                        @endif

                                                                        <th
                                                                            class="{{ \Carbon\Carbon::now()->format('l') == $sm_weekend->name ? 'main-border-color' : '' }}">
                                                                            {{ @$sm_weekend->name }}</th>
                                                                    @endforeach
                                                                </tr>

                                                                @php
                                                                    $used = [];
                                                                    $tr = [];
                                                                @endphp
                                                                @foreach ($sm_weekends as $sm_weekend)
                                                                    @php
                                                                        $i = 0;
                                                                        if (moduleStatusCheck('University')) {
                                                                            $studentClassRoutine = App\SmWeekend::universityStudentClassRoutine($record->un_semester_label_id, $record->un_section_id, $sm_weekend->id);
                                                                        } else {
                                                                            $studentClassRoutine = App\SmWeekend::studentClassRoutineFromRecord($record->class_id, $record->section_id, $sm_weekend->id);
                                                                        }
                                                                    @endphp
                                                                    @foreach ($studentClassRoutine as $routine)
                                                                        @php
                                                                            if (!in_array($routine->id, $used)) {
                                                                                if (moduleStatusCheck('University')) {
                                                                                    $tr[$i][$sm_weekend->name][$loop->index]['subject'] = $routine->unSubject ? $routine->unSubject->subject_name : '';
                                                                                    $tr[$i][$sm_weekend->name][$loop->index]['subject_code'] = $routine->unSubject ? $routine->unSubject->subject_code : '';
                                                                                } else {
                                                                                    $tr[$i][$sm_weekend->name][$loop->index]['subject'] = $routine->subject ? $routine->subject->subject_name : '';
                                                                                    $tr[$i][$sm_weekend->name][$loop->index]['subject_code'] = $routine->subject ? $routine->subject->subject_code : '';
                                                                                }
                                                                                $tr[$i][$sm_weekend->name][$loop->index]['class_room'] = $routine->classRoom ? $routine->classRoom->room_no : '';
                                                                                $tr[$i][$sm_weekend->name][$loop->index]['teacher'] = $routine->teacherDetail ? $routine->teacherDetail->full_name : '';
                                                                                $tr[$i][$sm_weekend->name][$loop->index]['start_time'] = $routine->start_time;
                                                                                $tr[$i][$sm_weekend->name][$loop->index]['end_time'] = $routine->end_time;
                                                                                $tr[$i][$sm_weekend->name][$loop->index]['is_break'] = $routine->is_break;
                                                                                $used[] = $routine->id;
                                                                            }
                                                                        @endphp
                                                                    @endforeach

                                                                    @php
                                                                        $i++;
                                                                    @endphp
                                                                @endforeach

                                                                @for ($i = 0; $i < $height; $i++)
                                                                    <tr>
                                                                        @foreach ($tr as $days)
                                                                            @foreach ($sm_weekends as $sm_weekend)
                                                                                <td
                                                                                    class="{{ \Carbon\Carbon::now()->format('l') == $sm_weekend->name ? 'main-border-color' : '' }}">
                                                                                    @php
                                                                                        $classes = gv($days, $sm_weekend->name);
                                                                                    @endphp
                                                                                    @if ($classes && gv($classes, $i))
                                                                                        @if ($classes[$i]['is_break'])
                                                                                            <strong> @lang('academics.break')
                                                                                            </strong>

                                                                                            <span class="">
                                                                                                ({{ date('h:i A', strtotime(@$classes[$i]['start_time'])) }}
                                                                                                -
                                                                                                {{ date('h:i A', strtotime(@$classes[$i]['end_time'])) }})
                                                                                                <br> </span>
                                                                                        @else
                                                                                            <span class="">
                                                                                                <strong>@lang('common.time')
                                                                                                    :</strong>
                                                                                                {{ date('h:i A', strtotime(@$classes[$i]['start_time'])) }}
                                                                                                -
                                                                                                {{ date('h:i A', strtotime(@$classes[$i]['end_time'])) }}
                                                                                                <br> </span>
                                                                                            <span class=""> <strong>
                                                                                                    {{ $classes[$i]['subject'] }}
                                                                                                </strong>
                                                                                                ({{ $classes[$i]['subject_code'] }})
                                                                                                <br> </span>
                                                                                            @if ($classes[$i]['class_room'])
                                                                                                <span class="">
                                                                                                    <strong>@lang('academics.room')
                                                                                                        :</strong>
                                                                                                    {{ $classes[$i]['class_room'] }}
                                                                                                    <br> </span>
                                                                                            @endif
                                                                                            @if ($classes[$i]['teacher'])
                                                                                                <span class="">
                                                                                                    {{ $classes[$i]['teacher'] }}
                                                                                                    <br>
                                                                                                </span>
                                                                                            @endif
                                                                                        @endif
                                                                                    @endif

                                                                                </td>
                                                                            @endforeach
                                                                        @endforeach
                                                                    </tr>
                                                                @endfor
                                                            </table>
                                                        </x-table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                @if (userPermission('parent_attendance'))
                    <div class="row">
                        @php
                            $now = Carbon::now();
                            $year = $now->year;
                            $month = $now->month;
                            $days = cal_days_in_month(CAL_GREGORIAN, $now->month, $now->year);
                            $attendance = $children->attendances;
                        @endphp
                        @include('backEnd.parentPanel.inc._parent_dashboard_attendance_statistics')
                        @include('backEnd.parentPanel.inc._dashboard_subject_attendance_tab')
                    </div>
                @endif
                @if (userPermission('fees.student-fees-list-parent'))
                    <div class="row mt-30">
                        @include('backEnd.parentPanel.inc._fees_info')
                    </div>
                @endif
                @if (userPermission('parent_exam_schedule'))
                    <div class="row mt-30">
                        <div class="col-lg-6 col-md-6">
                            <div class="main-title">
                                <h3 class="mb-30">@lang('exam.exam_routine')</h3>
                            </div>
                        </div>
                        <div class="col-lg-12 student-details up_admin_visitor mb-20">
                            <ul class="nav nav-tabs tabs_scroll_nav ml-0" id="myTab" role="tablist">
                                @foreach ($children->studentRecords as $key => $record)
                                    @if ($record->Exam)
                                        @foreach ($record->Exam->unique(function ($item) {
                                            return $item->exam_type_id . $item->class_id . $item->section_id;
                                        }) as $exam)
                                            <li class="nav-item">
                                                <a class="nav-link" id="home-tab{{ $children->id . $exam->id }}"
                                                    data-toggle="tab" href="#home{{ $children->id . $exam->id }}"
                                                    role="tab" aria-controls="home" aria-selected="true">
                                                    {{ $exam->examType->title }} - {{ $record->class->class_name }}
                                                    ({{ $record->section->section_name }})
                                                </a>
                                            </li>
                                        @endforeach
                                    @endif
                                @endforeach
                            </ul>
                            <div class="tab-content">
                                @foreach ($children->studentRecords as $record)
                                    @if ($record->Exam)
                                        @foreach ($record->Exam->unique(function ($item) {
                                            return $item->exam_type_id . $item->class_id . $item->section_id;
                                        }) as $key => $exam)
                                            @php
                                                $exam_routines = App\SmExamSchedule::getAllExams($exam->class_id, $exam->section_id, $exam->exam_type_id);
                                            @endphp
                                            <div class="tab-pane fade @if ($loop->parent->first) active show @endif"
                                                id="home{{ $children->id . $exam->id }}" role="tabpanel"
                                                aria-labelledby="home-tab{{ $children->id . $exam->id }}">
                                                <div class="container-fluid p-0">
                                                    <x-table>
                                                        <div class="table-responsive">
                                                            <table id="default_table" class="table" cellspacing="0"
                                                                width="100%">
                                                                <thead>
                                                                    <tr>
                                                                        <th style="width:10%;">
                                                                            @lang('exam.date_&_day')
                                                                        </th>
                                                                        <th>@lang('exam.subject')</th>
                                                                        <th>@lang('common.class_Sec')</th>
                                                                        <th>@lang('exam.teacher')</th>
                                                                        <th>@lang('exam.time')</th>
                                                                        <th>@lang('exam.duration')</th>
                                                                        <th>@lang('exam.room')</th>

                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach ($exam_routines as $date => $exam_routine)
                                                                        <tr
                                                                            class="{{ Carbon::parse($exam_routine->date)->format('Y-m-d') == Carbon::now()->format('Y-m-d') ? 'main-border-color' : '' }}">
                                                                            <td>{{ dateConvert($exam_routine->date) }}
                                                                                <br>{{ Carbon::createFromFormat('Y-m-d', $exam_routine->date)->format('l') }}
                                                                            </td>
                                                                            <td>
                                                                                <strong>
                                                                                    {{ $exam_routine->subject ? $exam_routine->subject->subject_name : '' }}
                                                                                </strong>
                                                                                {{ $exam_routine->subject ? '(' . $exam_routine->subject->subject_code . ')' : '' }}
                                                                            </td>
                                                                            <td>{{ $exam_routine->class ? $exam_routine->class->class_name : '' }}
                                                                                {{ $exam_routine->section ? '(' . $exam_routine->section->section_name . ')' : '' }}
                                                                            </td>
                                                                            <td>{{ $exam_routine->teacher ? $exam_routine->teacher->full_name : '' }}
                                                                            </td>

                                                                            <td> {{ date('h:i A', strtotime(@$exam_routine->start_time)) }}
                                                                                -
                                                                                {{ date('h:i A', strtotime(@$exam_routine->end_time)) }}
                                                                            </td>
                                                                            <td>
                                                                                @php
                                                                                    $duration = strtotime($exam_routine->end_time) - strtotime($exam_routine->start_time);
                                                                                @endphp

                                                                                {{ timeCalculation($duration) }}
                                                                            </td>

                                                                            <td>{{ $exam_routine->classRoom ? $exam_routine->classRoom->room_no : '' }}
                                                                            </td>

                                                                        </tr>
                                                                    @endforeach

                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </x-table>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
            <div class="row">
                <div class="col-lg-12">
                    @include('backEnd.parentPanel.inc._complaint_list_tab')
                </div>
            </div>

            @if (userPermission('parent-dashboard-calendar'))
                <div class="row mt-30">
                    <div class="col-lg-12">
                        @include('backEnd.communicate.commonAcademicCalendar')
                    </div>
                </div>
            @endif
        </div>
    </section>

    <div id="fullCalModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span> <span
                            class="sr-only">close</span></button>
                    <h4 id="modalTitle" class="modal-title"></h4>
                </div>
                <div class="modal-body text-center">
                    <img src="" alt="There are no image" id="image" height="150" width="auto">
                    <div id="modalBody"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="primary-btn tr-bg" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@include('backEnd.communicate.academic_calendar_css_js')
