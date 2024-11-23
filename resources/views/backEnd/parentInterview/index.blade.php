@extends('backEnd.master')
@section('title')
@lang('reports.class_report')
@endsection

@section('mainContent')
<style>
	.content{
		margin: 5px;
	}
</style>
<section class="sms-breadcrumb mb-40 white-box">
    <div class="container-fluid">
        <div class="row justify-content-between">
            <h1>@lang('common.interview') </h1>
            <div class="bc-pages">
                <a href="{{route('dashboard')}}">@lang('common.dashboard')</a>
                <a href="#">@lang('common.hr')</a>
                <a href="#">@lang('common.interview')</a>
            </div>
        </div>
    </div>
</section>
<section class="admin-visitor-area up_st_admin_visitor">
    <div class="container-fluid p-0">
    	<div class="col-lg-12">
    		<div>
		        <div class="col-sm-12 white-box">
		            <h2>@lang('common.interview')</h2>
		            <table class="table table-striped">
		                <thead>
		                    <tr>
		                        <th>@lang('common.user')</th>
		                        <th>@lang('common.interview') @lang('common.time')</th>
		                        <th>@lang('common.comment')</th>
		                        <th>@lang('common.admin_comment')</th>
		                        <th>@lang('common.action')</th>
		                    </tr>
		                </thead>
		                <tbody>
		                    @foreach($interviews as $interview)
		                    <tr>
		                        <td>{{ $interview->user->full_name}}</td>
		                        <td>{{ $interview->interview_date }} {{ $interview->interview_time }}</td>
		                        <td>{{ $interview->comment }}</td>
		                        <td>{{ $interview->admin_comment }}</td>
		                        <?php if ($interview->status == Null): ?>
			                        <td>
			                        	<form action="{{ route('interviews.parent.update', $interview->id) }}" method="post" id="interview-status-form">
			                        		@csrf
			                        		<input type="text" name="admin_comment" class="form-control" placeholder="@lang('common.admin_comment')">
										    <select class="form-control" name="status" onchange="document.getElementById('interview-status-form').submit()">
										    	<option disabled selected>@lang('common.option')</option>
										        <option value="1">@lang('common.attend')</option>
										        <option value="0">@lang('common.not_attend')</option> 
										    </select>
										</form>
			                        </td>
		                        <?php endif ?>
		                        <?php if ($interview->status != Null): ?>
		                        	<td>{{ $interview->status ? trans('common.attend') : trans('common.not_attend') }}</td>
		                        <?php endif ?>
		                    </tr>
		                    @endforeach
		                </tbody>
		            </table>
		        </div>
    		</div>
    	</div>
    </div>
</section>
@endsection