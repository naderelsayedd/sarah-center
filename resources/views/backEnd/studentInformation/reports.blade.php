@extends('backEnd.master')
@section('title') 
@lang('reports.student_report')
@endsection
@section('mainContent')
<input type="text" hidden value="{{ @$clas->class_name }}" id="cls">
<input type="text" hidden value="{{ @$clas->section_name->sectionName->section_name }}" id="sec">
<section class="sms-breadcrumb mb-40 up_breadcrumb white-box">
    <div class="container-fluid">
        <div class="row justify-content-between">
            <h1>@lang('reports.reports') </h1>
            <div class="bc-pages">
                <a href="{{route('dashboard')}}">@lang('common.dashboard')</a>
                <a href="#">@lang('reports.reports')</a>
            </div>
        </div>
    </div>
</section>
<section class="admin-visitor-area up_admin_visitor">
    <div class="container-fluid p-0">
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="main-title">
                        <h3 class="mb-30" >@lang('reports.reports')</h3>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="white-box">
                        @if (Auth::user()->role_id == 1 || Auth::user()->role_id == 5 || Auth::user()->role_id == 10)
			<div class="row">
				<div class="col-lg-4 col-md-6 col-sm-6">
						<div class="white-box single-summery">
							<div class="d-flex justify-content-between">
								<div>
									<h3>@lang('common.student_report')</h3>
									<p class="mb-0">
									<select name="student_report" onchange="this.value ? window.location.href=this.value : ''" class="form-control">
										<option value="">Select Report</option>
										<option value="/student-attendance-report">@lang('student.student_attendance_report')</option>
										<option value="/subject-attendance-report">@lang('student.subject_attendance_report')</option>
										<option value="/evaluation-report">@lang('homework.evaluation_report')</option>
										<option value="/student-transport-report">@lang('transport.student_transport_report')</option>
										<option value="/student-dormitory-report">@lang('dormitory.student_dormitory_report')</option>
										<option value="/guardian-report">@lang('reports.guardian_report')</option>
										<option value="/student-history">@lang('reports.student_history')</option>
										<option value="/student-login-report">@lang('reports.student_login_report')</option>
										<option value="/class-report">@lang('common.class_report')</option>
										<option value="/class-routine-report">@lang('academics.class_routine')</option>
										<option value="/user-log">@lang('reports.user_log')</option>
										<option value="/student-report">@lang('common.student_report')</option>
										<option value="/previous-record">@lang('reports.previous_record')</option>
									</select>
									</p>
								</div>
							</div>
						</div>
				</div>
				
				<div class="col-lg-4 col-md-6 col-sm-6">
						<div class="white-box single-summery">
							<div class="d-flex justify-content-between">
								<div>
									<h3>@lang('common.exam_report')</h3>
									<p class="mb-0">
									<select name="exam_report" onchange="this.value ? window.location.href=this.value : ''" class="form-control">
										<option value="">Select Report</option>
										<option value="/exam-routine-report">@lang('edulia.exam_routine')</option>
										<option value="/merit-list-report">@lang('exam.merit_list_report')</option>
										<option value="/online-exam-report">@lang('reports.online_exam_report')</option>
										<option value="/mark-sheet-report-student">@lang('exam.mark_sheet_report')</option>
										<option value="/tabulation-sheet-report">@lang('reports.tabulation_sheet_report')</option>
										<option value="/progress-card-report">@lang('reports.progress_card_report')</option>
										<option value="/custom-progress-card-report-percent">@lang('reports.progress_card_report_100_percent')</option>
										<option value="/previous-class-results">@lang('exam.previous_result')</option>
									</select>
									</p>
								</div>
							</div>
						</div>
				</div>
				
				<div class="col-lg-4 col-md-6 col-sm-6">
						<div class="white-box single-summery">
							<div class="d-flex justify-content-between">
								<div>
									<h3>@lang('common.staff_report')</h3>
									<p class="mb-0">
									<select name="ztaff_report" onchange="this.value ? window.location.href=this.value : ''" class="form-control">
										<option value="">Select Report</option>
										<option value="/staff-attendance-report">@lang('hr.staff_attendance_report')</option>
										<option value="/payroll-report">@lang('hr.payroll_report')</option>
									</select>
									</p>
								</div>
							</div>
						</div>
				</div>
				
				<div class="col-lg-4 col-md-6 col-sm-6">
						<div class="white-box single-summery">
							<div class="d-flex justify-content-between">
								<div>
									<h3>@lang('common.fees_report')</h3>
									<p class="mb-0">
									<select name="ztaff_report" onchange="this.value ? window.location.href=this.value : ''" class="form-control">
										<option value="">Select Report</option>
										<option value="/fees/due-fees">@lang('fees::feesModule.fees_due_report')</option>
										<option value="/fees/fine-report">@lang('fees::feesModule.fine_report')</option>
										<option value="/fees/payment-report">@lang('fees::feesModule.payment_report')</option>
										<option value="/fees/balance-report">@lang('fees::feesModule.balance_report')</option>
										<option value="/fees/waiver-report">@lang('fees::feesModule.waiver_report')</option>
										<option value="/wallet/wallet-report">@lang('wallet::wallet.wallet_report')</option>
									</select>
									</p>
								</div>
							</div>
						</div>
				</div>
				
				<div class="col-lg-4 col-md-6 col-sm-6">
						<div class="white-box single-summery">
							<div class="d-flex justify-content-between">
								<div>
									<h3>@lang('common.accounts_report')</h3>
									<p class="mb-0">
									<select name="ztaff_report" onchange="this.value ? window.location.href=this.value : ''" class="form-control">
										<option value="">Select Report</option>
										<option value="/accounts-payroll-report">@lang('accounts.payroll_report')</option>
										<option value="/transaction">@lang('accounts.transaction')</option>
									</select>
									</p>
								</div>
							</div>
						</div>
				</div>
			</div>
			@endif
                    </div>
                </div>
            </div>
            
@if(isset($student_records))

 {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'method' => 'POST', 'enctype' => 'multipart/form-data'])}}

            <div class="row mt-40">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-6 no-gutters">
                            <div class="main-title">
                                <h3 class="mb-0">@lang('reports.student_report')</h3>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-lg-12 ">
                            <x-table>
                                <table id="table_id" class="table Crm_table_active3" cellspacing="0" width="100%">
                                    <thead>
                                        @if(session()->has('message-danger') != "")
                                        <tr>
                                            <td colspan="9">
                                            </td>
                                        </tr>
                                        @endif
                                        <tr>
                                            @if(moduleStatusCheck('University'))
                                            <th>@lang('university::un.semester_label')</th>
                                            <th>@lang('university::un.department')</th>
                                            @else 
                                            <th>@lang('common.class')</th>
                                            <th>@lang('common.section')</th>
                                            @endif 
                                            <th>@lang('student.admission_no')</th>
                                            <th>@lang('common.name')</th>
                                            <th>@lang('student.father_name')</th>
                                            <th>@lang('common.date_of_birth')</th>
                                            <th>@lang('common.gender')</th>
                                            <th>@lang('common.type')</th>
                                            <th>@lang('common.phone')</th>
                                            
                                        </tr>
                                    </thead>
    
                                    <tbody>
                                        @foreach($student_records as $record)
                                        <tr>
                                            @if(moduleStatusCheck('University'))
                                            <td>{{@$record->UnSemesterLabel->name}}</td>
                                            <td> {{@$record->unDepartment->name}}</td>
                                            @else
                                            <td>{{@$record->class->class_name}}</td>
                                            <td> {{@$record->section->section_name}}</td>
                                            @endif
                                            <td>{{@$record->student->admission_no}}</td>
                                            <td>{{@$record->student->first_name.' '.@$record->student->last_name}}</td>
                                            <td>{{@$record->student->parents !=""?@$record->student->parents->fathers_name:""}}</td>
                                            <td>{{@$record->student->date_of_birth != ""? dateConvert(@$record->student->date_of_birth):''}}</td>
                                            <td>{{@$record->student->gender != ""? @$record->student->gender->base_setup_name:""}}</td>
                                            <td>{{@$record->student->category != ""? @$record->student->category->category_name:""}}</td>
                                            <td>{{@$record->student->mobile}}</td>
                                            
                                            
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </x-table>
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>

@endif

    </div>
</section>


@endsection
@include('backEnd.partials.data_table_js')