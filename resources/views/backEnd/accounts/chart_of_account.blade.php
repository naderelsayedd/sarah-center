@extends('backEnd.master')
@section('title') 
@lang('accounts.chart_of_account')
@endsection
<style type="text/css">
    .tagify{
	width: 100% !important;
    }
</style>
@section('mainContent')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css">
<section class="sms-breadcrumb mb-40 white-box">
    <div class="container-fluid">
        <div class="row justify-content-between">
            <h1>@lang('accounts.chart_of_account')</h1>
            <div class="bc-pages">
                <a href="{{route('dashboard')}}">@lang('common.dashboard')</a>
                <a href="#">@lang('accounts.accounts')</a>
                <a href="#">@lang('accounts.chart_of_account')</a>
			</div>
		</div>
	</div>
</section>
<section class="admin-visitor-area up_st_admin_visitor">
    <div class="container-fluid p-0">
        @if(isset($chart_of_account))
		@if(userPermission("chart-of-account-store"))
		
        <div class="row">
            <div class="offset-lg-10 col-lg-2 text-right col-md-12 mb-20">
                <a href="{{route('chart-of-account')}}" class="primary-btn small fix-gr-bg">
                    <span class="ti-plus pr-2"></span>
                    @lang('common.add')
				</a>
			</div>
		</div>
        @endif
        @endif
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="main-title">
                            <h3 class="mb-30">@if(isset($chart_of_account))
								@lang('accounts.edit_chart_of_account')
                                @else
								@lang('accounts.add_chart_of_account')
                                @endif
								
							</h3>
						</div>
                        @if(isset($chart_of_account))
                        {{ Form::open(['class' => 'form-horizontal', 'files' => true,  'route' => array('chart-of-account-update',@$chart_of_account->id), 'method' => 'PUT', 'enctype' => 'multipart/form-data']) }}
                        @else
						@if(userPermission("chart-of-account-store"))
                        {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'chart-of-account-store',
                        'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
                        @endif
                        @endif
                        <div class="white-box">
                            <div class="add-visitor">
                                <div class="row">
                                    <div class="col-lg-12">
										<input type="hidden" name="id" value="{{isset($chart_of_account)? $chart_of_account->id: ''}}">
                                        <div class="primary_input">
											<div class="row">
												<div class="col-lg-6">
													<label class="primary_input_label" for="">@lang('accounts.head_name') <span class="text-danger"> *</span></label>
													<input class="primary_input_field form-control{{ @$errors->has('head') ? ' is-invalid' : '' }}"	type="text" name="head" autocomplete="off" value="{{isset($chart_of_account)? $chart_of_account->head: old('head')}}">
													@if ($errors->has('head'))
													<span class="text-danger" >
														<strong>{{ @$errors->first('head') }}</strong>
													</span>
													@endif
												</div>
												
												<div class="col-lg-6">
													<label class="primary_input_label" for="">@lang('accounts.head_code') <span class="text-danger"> *</span></label>
													<input class="primary_input_field form-control{{ @$errors->has('head_code') ? ' is-invalid' : '' }}"	type="number" name="head_code" autocomplete="off" value="{{isset($chart_of_account)? $chart_of_account->head_code: old('head_code')}}">
													@if ($errors->has('head_code'))
													<span class="text-danger" >
														<strong>{{ @$errors->first('head_code') }}</strong>
													</span>
													@endif
												</div>
											</div>
											<?php $count = 1; ?>
											
											<?php if(isset($chart_of_account) && count($sub_head_chart_of_accounts) > 0) { ?>
											<input type="hidden" name="subheadcount" id="subheadcount" value="<?php echo count($sub_head_chart_of_accounts);?>">
											<?php } else { ?>
											<input type="hidden" name="subheadcount" id="subheadcount" value="1">
											
											<?php } ?>
											<button type="button" class="add_field_button" style="border-radius: 10%; background: green; color: white; border: none; float:right;">+ More Sub Heads</button>
											<div class="sub_head_panel_wrapper">
												@if(isset($chart_of_account) && count($sub_head_chart_of_accounts) > 0)
												
												@foreach($sub_head_chart_of_accounts as $sub_head_chart_of_account)
												
												<div class="sub_head_panel" style="background: blanchedalmond;margin: 30px;padding: 10px;">
													<div class="row">
														<div class="col-lg-1"></div>
														<div class="col-lg-5">
															<label class="primary_input_label" for="">@lang('accounts.sub_head_name')</label>
															<input class="primary_input_field form-control" type="text" name="sub_head[]" autocomplete="off" value="{{isset($sub_head_chart_of_account)? $sub_head_chart_of_account->head_sub: ''}}">
														</div>
														
														<div class="col-lg-5">
															<label class="primary_input_label" for="">@lang('accounts.sub_head_code')</label>
															<input class="primary_input_field form-control"	type="number" name="sub_head_code[]" autocomplete="off" value="{{isset($sub_head_chart_of_account)? $sub_head_chart_of_account->head_sub_code: ''}}">
														</div>
														<?php if($count == 1) { ?>
															<div class="col-lg-1"><label class="primary_input_label" for="">&nbsp;</label></div>
															<?php } else { ?>
															<div class="col-lg-1"><label class="primary_input_label" for="">&nbsp;</label><button type="button" class="remove_field" style="border-radius: 50%; background: red; color: white; border: none;">-</button></div>
															
														<?php } ?>
													</div>
													<div class="sub_sub_head_panel_wrapper_<?php echo $count;?>">
													<?php $subcount = 1; ?>
														@foreach($sub_head_chart_of_account->head_sub_sub as $key => $sub_sub_head_chart_of_account)
														<div class="sub_sub_head_panel">
															<div class="row">
																<div class="col-lg-3"></div>
																<div class="col-lg-4">
																	<label class="primary_input_label" for="">@lang('accounts.sub_sub_head_name')</label>
																	<input class="primary_input_field form-control "	type="text" name="sub_sub_head[<?php echo $count;?>][]" autocomplete="off" value="{{isset($sub_head_chart_of_account->head_sub_sub[$key])? $sub_head_chart_of_account->head_sub_sub[$key] : ''}}">
																</div>
																
																<div class="col-lg-4">
																	<label class="primary_input_label" for="">@lang('accounts.sub_sub_head_code')</label>
																	<input class="primary_input_field form-control " type="number" name="sub_sub_head_code[<?php echo $count;?>][]" autocomplete="off" value="{{isset($sub_head_chart_of_account->head_sub_sub_code[$key])? $sub_head_chart_of_account->head_sub_sub_code[$key] : ''}}">
																</div>
																<?php if($subcount == 1) { ?>
																<div class="col-lg-1"><label class="primary_input_label" for="">&nbsp;</label><button type="button" class="add_field_button_sub" onclick="addSubSubHead(this,<?php echo $count;?>)" style="border-radius: 50%; background: lightgreen; color: white; border: none;">+</button></div>
																<?php } else { ?>
																<div class="col-lg-1"><label class="primary_input_label" for="">&nbsp;</label><button type="button" class="remove_field_button_sub" onclick="removeSubSubHead(this,<?php echo $subcount;?>)" style="border-radius: 50%; background: orange; color: white; border: none;">-</button></div>
																<?php } ?>
															</div>
														</div>
														<?php $subcount ++; ?>
														@endforeach
													</div>
												</div>
												
												<?php
													$count++;
												?>
												@endforeach
												@else
												
												<div class="sub_head_panel" style="background: blanchedalmond;margin: 30px;padding: 10px;">
													<div class="row">
														<div class="col-lg-1"></div>
														<div class="col-lg-5">
															<label class="primary_input_label" for="">@lang('accounts.sub_head_name')</label>
															<input class="primary_input_field form-control" type="text" name="sub_head[]" autocomplete="off" value="{{isset($sub_head_chart_of_account)? $sub_head_chart_of_account->head_sub: ''}}">
														</div>
														
														<div class="col-lg-5">
															<label class="primary_input_label" for="">@lang('accounts.sub_head_code')</label>
															<input class="primary_input_field form-control"	type="number" name="sub_head_code[]" autocomplete="off" value="{{isset($sub_head_chart_of_account)? $sub_head_chart_of_account->head_sub_code: ''}}">
														</div>
														<div class="col-lg-1"><label class="primary_input_label" for="">&nbsp;</label></div>
													</div>
													<div class="sub_sub_head_panel_wrapper_1">
														<div class="sub_sub_head_panel">
															<div class="row">
																<div class="col-lg-3"></div>
																<div class="col-lg-4">
																	<label class="primary_input_label" for="">@lang('accounts.sub_sub_head_name')</label>
																	<input class="primary_input_field form-control "	type="text" name="sub_sub_head[1][]" autocomplete="off" value="">
																</div>
																
																<div class="col-lg-4">
																	<label class="primary_input_label" for="">@lang('accounts.sub_sub_head_code')</label>
																	<input class="primary_input_field form-control " type="number" name="sub_sub_head_code[1][]" autocomplete="off" value="">
																</div>
																<div class="col-lg-1"><label class="primary_input_label" for="">&nbsp;</label><button type="button" class="add_field_button_sub" onclick="addSubSubHead(this,1)" style="border-radius: 50%; background: lightgreen; color: white; border: none;">+</button></div>
															</div>
														</div>
													</div>
												</div>
												@endif
											</div>
										</div>
									</div>
								</div>
                                <div class="row  mt-15">
                                    <div class="col-lg-12">
										<label class="primary_input_label" for="">@lang('common.type') <span class="text-danger"> *</span></label>
										<select class="primary_select  form-control{{ @$errors->has('type') ? ' is-invalid' : '' }}" name="type">
											<option data-display="@lang('common.type') *" value="">@lang('common.type') *</option>
											
										<option value="A" {{@$chart_of_account->type == 'A'? 'selected':old('type') == ('A'? 'selected':'') }}>@lang('accounts.assets')</option>
										<option value="L" {{@$chart_of_account->type == 'L'? 'selected':old('type') == ('L'? 'selected':'' )}}>@lang('accounts.liabilities')</option>
										<option value="ET" {{@$chart_of_account->type == 'ET'? 'selected':old('type') == ('ET'? 'selected':'') }}>@lang('accounts.equity')</option>
										<option value="I" {{@$chart_of_account->type == 'I'? 'selected':old('type') == ('I'? 'selected':'' )}}>@lang('accounts.revenues')</option>
										<option value="E" {{@$chart_of_account->type == 'E'? 'selected':old('type') == ('E'? 'selected':'' )}}>@lang('accounts.expenses')</option>
										
										</select>
										
										
										@if ($errors->has('type'))
										<span class="text-danger invalid-select" role="alert">
											<strong>{{ @$errors->first('type') }}</strong>
										</span>
										@endif
									</div>
								</div>
                            	@php
								$tooltip = "";
								if(userPermission("chart-of-account-store") || userPermission('chart-of-account-edit')){
								$tooltip = "";
								}else{
								$tooltip = "You have no permission to add";
								}
                                @endphp
                                <div class="row mt-40">
                                    <div class="col-lg-12 text-center">
										<button class="primary-btn fix-gr-bg submit" data-toggle="tooltip" title="{{$tooltip}}">
                                            <span class="ti-check"></span>
                                            @if(isset($chart_of_account))
											@lang('accounts.update_head')
                                            @else
											@lang('accounts.save_head')
											@endif
											
										</button>
									</div>
								</div>
							</div>
						</div>
						{{ Form::close() }}
					</div>
				</div>
			</div>
			
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-4 no-gutters">
					<a class="primary-btn fix-gr-bg submit" href="/export_excel">
						<span class="ti-check"></span>
						@lang('accounts.export_to_csv')
					</a>
						<div class="main-title">
							<h3 class="mb-0">@lang('accounts.chart_of_account_list')</h3>
							
						</div>
					</div>
				</div>
				
				<div class="row">
					<div class="col-lg-12">
						<x-table>
							<table id="table_id" class="table" cellspacing="0" width="100%">
								
								<thead>
									
									<tr>
										<th>@lang('accounts.head_name')</th>
										<th>@lang('accounts.head_code')</th>
										<th>@lang('common.type')</th>
										<th>@lang('common.action')</th>
									</tr>
								</thead>
								
								<tbody>
									@foreach($chart_of_accounts as $chart_of_account)
									<tr>
										<td>{{@$chart_of_account->head}}</td>
										<td>{{@$chart_of_account->head_code}}</td>
										
										<td>
											@if($chart_of_account->type=="A")@lang('accounts.asset') @endif
											@if($chart_of_account->type=="E")@lang('accounts.expense') @endif
											@if($chart_of_account->type=="I")@lang('accounts.income') @endif
											@if($chart_of_account->type=="L")@lang('accounts.liability') @endif
											
											{{-- {{@$chart_of_account->type == "I"? 'Income':'Expense'}} --}}
										</td>
										<td>
											<a onclick="getChartofAccounts({{$chart_of_account->id}})" href="javascript:;" class="primary-btn small fix-gr-bg" title="View"><i class="ti-view-grid" style="font-size: 20px;"></i></a>
												<a class="primary-btn small fix-gr-bg" target="_blank" href="{{route('chart-of-account-edit', [@$chart_of_account->id])}}" title="Edit"><i class="ti-pencil" style="font-size: 20px;"></i></a>
												<a data-toggle="modal" data-target="#deleteChartOfAccountModal{{@$chart_of_account->id}}" class="primary-btn small fix-gr-bg" href="#"  title="Disable"><i class="ti-trash" style="font-size: 20px;"></i></a>
											
										</td>
									</tr>
									<div class="modal fade admin-query" id="deleteChartOfAccountModal{{@$chart_of_account->id}}" >
										<div class="modal-dialog modal-dialog-centered">
											<div class="modal-content">
												<div class="modal-header">
													<h4 class="modal-title">@lang('accounts.delete_chart_of_account')</h4>
													<button type="button" class="close" data-dismiss="modal">&times;</button>
												</div>
												
												<div class="modal-body">
													<div class="text-center">
														<h4>@lang('common.are_you_sure_to_delete')</h4>
													</div>
													
													<div class="mt-40 d-flex justify-content-between">
														<button type="button" class="primary-btn tr-bg" data-dismiss="modal">@lang('common.cancel')</button>
														{{ Form::open(['route' => array('chart-of-account-delete',@$chart_of_account->id), 'method' => 'DELETE', 'enctype' => 'multipart/form-data']) }}
														<button class="primary-btn fix-gr-bg" type="submit">@lang('common.delete')</button>
														{{ Form::close() }}
														
														
													</div>
												</div>
												
											</div>
										</div>
									</div>
									@endforeach
								</tbody>
							</table>
						</x-table>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
@endsection
@include('backEnd.partials.data_table_js')																																													