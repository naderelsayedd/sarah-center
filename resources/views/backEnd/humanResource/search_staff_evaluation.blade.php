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
					<form action="{{ route('searchEvaluateStaff') }}" method="POST" id="searchForm" >
						@csrf
						<div class="col-sm-3">
							<label>@lang('hr.date')</label>
							<input class="form-control primary_input" type="date" name="date">
						</div>
						<div class="col-sm-3">
							<label>@lang('hr.teacher')</label>
							<select class="primary_select  form-control" name="role_id" id="role_id">
								<option data-display="@lang('hr.staff')" value=""> @lang('common.select') </option>
								@foreach ($all_staffs as $key => $value)
								<option value="{{ $value->id }}" >{{ $value->first_name }} {{ $value->last_name }}</option>
								@endforeach
							</select>
						</div>
						<div class="col-sm-4">
							<label>@lang('hr.type')</label>
							<select class="primary_select form-control" name="type">
								<option data-display="@lang('hr.type')" value=""> @lang('hr.type') </option>
								<option value="1">
									@lang('hr.evaluation_of_a_caregiver_on_the_day_of_the_trial')
								</option>
								<option value="2">
									@lang('hr.staff_experience')
								</option>
								<option value="3">
									@lang('hr.evaluation_of_an_administrative_assistant_on_the_day_of_the_experiment')
								</option>
								<option value="4">
									@lang('common.teacher_evaluation')
								</option>
							</select>
						</div>
						<div class="col-sm-2" class="text-righ" style="padding-top: 10px;">
							<button id="search-evaluation-btn" style="width: 150px;height: 45px;border-radius: 6px !important;margin: 20px 0 0 0;" type="submit" class="primary-btn small fix-gr-bg">Search</button>

							<button id="download-evaluation-btn" style="width: 150px;height: 45px;border-radius: 6px !important;margin: 20px 0 0 0;" type="submit" class="primary-btn small fix-gr-bg" name="pdf" value="pdf">Download</button>
						</div>
					</form>
				</div>
			</div>
		</div>


		@if(isset($data) &&!empty($data))
			<!-- for pdf content starts here -->
			<?php if (isset($data['pdf']) && $data['pdf'] == 'pdf'): ?>
				@if($data['type'] == 1)
		            <table class="table table-striped">
		                <thead>
		                    <tr>
		                        <th><strong>@lang('hr.clause')</strong></th>
		                        <th><strong>@lang('hr.class')</strong></th>
		                        <th><strong>@lang('hr.evaluation')</strong></th>
		                    </tr>
		                </thead>
		                <tbody>
		                    @foreach($data['evaluation'] as $evaluation)
		                        <tr>
		                            <td>@lang('hr.'.$evaluation['question'])</td>
		                            <td class="text-center"> {{$evaluation['rating']}}</td>
		                            <td>{{$evaluation['note']}}</td>
		                        </tr>
		                    @endforeach
		                </tbody>
		            </table>
		        @elseif($data['type'] == 2)
		            <table class="table table-striped">
		                <thead>
		                    <tr>
		                        <th>@lang('hr.criteria')</th>
		                        <th class="text-center">@lang('hr.rating')</th>
		                    </tr>
		                </thead>
		                <tbody>
		                    @foreach($data['evaluation'] as $evaluation)
		                        <tr>
		                            <td>@lang('hr.'.$evaluation['question'])</td>
		                            <td class="text-center">
		                                @if($evaluation['rating'] == 1)
		                                    @lang('hr.excellent')
		                                @elseif($evaluation['rating'] == 2)
		                                    @lang('hr.very_good')
		                                @elseif($evaluation['rating'] == 3)
		                                    @lang('hr.acceptable')
		                                @endif
		                            </td>
		                        </tr>
		                    @endforeach
		                </tbody>
		            </table>
		        @elseif($data['type'] == 3)
		            <table class="table table-striped" style="width:100%">
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
		                    @foreach($data['evaluation'] as $evaluation)
		                        <tr>
		                            <td>@lang('hr.'.$evaluation['question'])</td>
		                            <td class="text-center">
		                                {{$evaluation['rating']}}
		                            </td>
		                            <td>{{$evaluation['notes']}}</td>
		                        </tr>
		                    @endforeach
		                </tbody>
					</table>
		        @endif
		    @else
		    	<!-- for show the data in table format -->
			    @if($data['type'] == 1)
			        <div id="London" class="tabcontent">
						<h3 style="color: #645a5a;font-weight: bold;text-align: center;margin: 20px 0;">
							@lang('hr.evaluation_of_a_caregiver_on_the_day_of_the_trial')
						</h3>
						<div class="white-box">
							<table class="table table-striped">
							    <thead>
							        <tr>
							            <th><strong>@lang('hr.clause')</strong></th>
							            <th><strong>@lang('hr.class')</strong></th>
							            <th><strong>@lang('hr.evaluation')</strong></th>
							        </tr>
							    </thead>
							    <tbody>
							    	@foreach($data['evaluation'] as $evaluation)
									    <tr>
									        <td>@lang('hr.'.$evaluation['question'])</td>
									        <td class="text-center"> {{$evaluation['rating']}}
									        </td>
									        <td>{{$evaluation['note']}}</td>
									    </tr>
									@endforeach
							    </tbody>
							</table>
						</div>
					</div>
			    @elseif($data['type'] == 2)
			        <div id="Paris" class="tabcontent">
						<h3 style="color: #645a5a;font-weight: bold;text-align: center;margin: 20px 0;">@lang('hr.staff_experience')</h3>
						<div class="report-table white-box">
							<table class="table table-striped" style="width:100%">
								<thead>
									<tr>
										<th>@lang('hr.criteria')</th>
						                <th class="text-center">@lang('hr.rating')</th>
									</tr>
								</thead>
								<tbody>
									@foreach($data['evaluation'] as $evaluation)
									    <tr>
									        <td>@lang('hr.'.$evaluation['question'])</td>
									        <td class="text-center">
									            @if($evaluation['rating'] == 1)
									                @lang('hr.excellent')
									            @elseif($evaluation['rating'] == 2)
									                @lang('hr.very_good')
									            @elseif($evaluation['rating'] == 3)
									                @lang('hr.acceptable')
									            @endif
									        </td>
									    </tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
			    @elseif($data['type'] == 3)
			        <div id="Tokyo" class="tabcontent">
						<h3 style="color: #645a5a;font-weight: bold;text-align: center;margin: 20px 0;">@lang('hr.admin_assistant_evaluation')</h3>
						<div class="report-table white-box">
								<table class="table table-striped" style="width:100%">
									<thead>
								        <tr>
								            <th style="color:white;"> 
								                @lang('hr.clause')
								            </th>
								            <th style="color:white;">
								                @lang('hr.class')
								            </th>
								            <th style="color:white;"> 
								                @lang('hr.notes')
								            </th>
								        </tr>
								    </thead>
					                <tbody>
					                    @foreach($data['evaluation'] as $evaluation)
					                        <tr>
					                            <td>@lang('hr.'.$evaluation['question'])</td>
					                            <td class="text-center">
					                                {{$evaluation['rating']}}
					                            </td>
					                            <td>{{$evaluation['notes']}}</td>
					                        </tr>
					                    @endforeach
					                </tbody>
								</table>
							</form>
						</div>
					</div>
			    @endif

			    @if($data['type'] == 4)
			    <div id="Japan" class="tabcontent">
						<h3 style="color: #645a5a;font-weight: bold;text-align: center;margin: 20px 0;">@lang('common.teacher_evaluation')</h3>
						<div class="report-table white-box">
								<table class="table table-striped" style="width:100%">
									<thead>
										<tr>
											<th style="color:white;">@lang('common.question')</th>
								            <th style="color:white;">@lang('common.rating')</th>
								            <th style="color:white;">@lang('common.date')</th>
										</tr>
									</thead>
									<tbody>
										@foreach($data['evaluation'] as $evaluation)
								            <tr>
								                <td>@lang('common.'.$evaluation['question'])</td>
								                <td>{{ $evaluation['rating'] }}</td>
								                <td>{{ $evaluation['submitted_date'] }}</td>
								            </tr>
								        @endforeach
									</tbody>
								</table>
							</form>
						</div>
					</div>
			    @endif
			<?php endif ?>
		@endif
	</div>
</div>
</div>
</section>

</div>
@endsection

@include('backEnd.partials.data_table_js')
@include('backEnd.partials.server_side_datatable')
@push('script')  


	
@endpush
	
		