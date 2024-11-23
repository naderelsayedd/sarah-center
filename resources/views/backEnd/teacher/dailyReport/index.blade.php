@extends('backEnd.master')
@section('title')
    @lang('reports.daily_report')
@endsection
@section('mainContent')

@if (isset($studentDailyReport))
    <div class="row mt-30 mb-20">
        <div class="col-lg-4 no-gutters">
            <div class="main-title">
                <h3 class="mb-0">@lang('reports.daily_report_list')</h3>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
			<div class="row">
					<div class="col-lg-12 no-gutters">
					<a class="primary-btn fix-gr-bg submit" href="/daily_report_create">
						<span class="ti-plus"></span>
						@lang('reports.daily_report_create')					
					</a>
					</div>
				</div>
            <x-table>
                <table id="table_id" class="table data-table Crm_table_active3" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>@lang('common.sl')</th>
                            <th>@lang('reports.student')</th>
                            <th>@lang('reports.date')</th>
                            <th>@lang('reports.action')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach (@$studentDailyReport as $key => $report)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>
                                    <?php 
                                        $name = getStudentName($report->student_id);
                                        echo $name->full_name;
                                    ?>
                                </td>
                                <td>{{ date('d-m-Y', strtotime($report->created_at)) }}</td>
                                <td>
                                    <button class="btn btn-secondary" onclick="window.location.href='{{ route('download.pdf',$report->id) }}'">Download PDF</button>
                                    <a href="{{ route('dailyChildReport.delete',$report->id) }}">
                                        <button type="button" class="btn btn-secondary">
                                            Delete
                                        </button>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </x-table>
        </div>
    </div>
@endif


@endsection