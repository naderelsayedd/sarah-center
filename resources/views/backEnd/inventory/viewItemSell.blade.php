@extends('backEnd.master')
@section('title')
@lang('inventory.sells_details')
@endsection

@section('mainContent')

<style>
	.white-box {
    background: #fff;
    padding: 40px 30px;
    border-radius: 10px;
    box-shadow: 0px 10px 15px rgba(236, 208, 244, 0.3);
    color: #000;
	}
</style>
<section class="sms-breadcrumb mb-40 white-box">
    <div class="container-fluid">
        <div class="row justify-content-between">
            <h1>@lang('inventory.sells_details')</h1>
            <div class="bc-pages">
                <a href="{{route('dashboard')}}">@lang('common.dashboard')</a>
                <a href="#">@lang('inventory.inventory')</a>
                <a href="{{route('item-sell-list')}}">@lang('inventory.item_sell_list')</a>
                <a href="#"> @lang('inventory.sells_details')</a>
			</div>
		</div>
	</div>
</section>
<section class="admin-visitor-area">
	<div class="container-fluid p-0">
		<div class="row">
            <div class="col-lg-12">
                
                <div class="white-box">
					<div class="row mt-40">
						<div class="col-lg-12">
							<!-- <div class="row">
								<div class="col-lg-4 no-gutters">
								<div class="main-title">
								<h3 class="mb-0">Item Receive List</h3>
								</div>
								</div>
							</div> -->
							
							<div class="row">
								<div class="container-fluid">
									<div id="purchaseInvoice">
										<div class="row mb-20">
											<div class="col-lg-12">
												<div class="invoice-details-left">
													<div class="mb-20">
														@if(@$general_setting->logo)
														<label>
															<img src="{{ asset('/')}}{{ $general_setting->logo}}" alt="" width="200px">
														</label>
														@else
														<label for="companyLogo" class="company-logo">
															<i class="ti-image"></i> 
															<img src="{{ asset('public/uploads/settings/logo.png')}}" alt="" width="200px">
														</label>
														<input id="companyLogo" type="file"/>
														@endif
													</div>
													
													<div class="business-info" style="text-align: center;">
														<h3>{{ $general_setting->site_title}}</h3>
														<p>{{ $general_setting->address}}</p>
														<p>{{ $general_setting->email}}</p>
													</div>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-lg-6"> 
												<div class="invoice-details-right" style="float: left;">
													<h1 class="text-uppercase">@lang('inventory.bill_to')</h1>
													@php
													$buyerDetails = '';
													if($viewData->role_id == 2){
													$buyerDetails = $viewData->studentDetails;
													}elseif($viewData->role_id == 3){
													$buyerDetails = $viewData->parentsDetails;
													}else{
													$buyerDetails = $viewData->staffDetails;
													}
													@endphp
													<div class="client-info">
														
														<h3>{{$viewData->role_id == 3? $buyerDetails->fathers_name:$buyerDetails->full_name }}</h3>
														<p>
															
															@if($viewData->role_id == "3")
															{{$buyerDetails->guardians_address}}
															@else
															
															@endif
														</p>
													</div>
												</div>
											</div>
											
											<div class="col-lg-6"> 
												<div class="invoice-details-right" style="float: right;">
													<h1 class="text-uppercase">@lang('inventory.sell_receipt')</h1>
													<div class="d-flex justify-content-between">                                      
														<p>@lang('inventory.sell_date'): {{(isset($viewData)) ?  dateConvert($viewData->sell_date) : ''}}</p>
													</div>
													<div class="d-flex justify-content-between">
														<p>@lang('inventory.reference_no'): #{{(isset($viewData)) ? $viewData->reference_no : ''}}</p>
													</div>
													<div class="d-flex justify-content-between">
														<p>@lang('inventory.payment_status'): 
															@if($viewData->paid_status == 'P')
															<strong>@lang('inventory.paid')</strong>
															@elseif($viewData->paid_status == 'PP')
															<strong>@lang('inventory.partial_paid')</strong>
															
															@elseif($viewData->paid_status == 'R')
															<strong>@lang('inventory.refund')</strong>
															@else
															<strong>@lang('inventory.unpaid')</strong>
															@endif
														</p>
													</div>
													<!--<span class="primary-btn fix-gr-bg large mt-30">
														{{(isset($viewData)) ? currency_format((float) $viewData->grand_total) : ''}}
													</span>-->
												</div>
											</div>
											
										</div>
										
										<hr>
										<div class="row mt-30 mb-50">
											<div class="col-lg-12">
												<table class="d-table table-responsive custom-table" cellspacing="0" width="100%">
													<thead style="background: #c1c1c1">
														<tr>
															<th width="15%">@lang('inventory.item_name')</th>
															<th width="20%">@lang('common.description')</th>
															<th width="20%">@lang('inventory.price')</th>
															<th width="15%">@lang('inventory.quantity')</th>
															<th width="15%">@lang('common.discount')</th>
															<th width="15%">@lang('common.vat') {{$general_setting->vat}} %</th>
															<th width="20%">@lang('accounts.amount')</th>
														</tr>
													</thead>
													
													<tbody>
														
														@php $sub_totals = 0; @endphp
														@php $discount = 0; @endphp
														@php $vat = 0; @endphp
														@if(isset($editDataChildren))
														@foreach($editDataChildren as $value)
														<tr>
															<td>{{$value->items !=""?$value->items->item_name:""}}</td>
															<td>{{$value->items !=""?$value->descriptionItem:""}}</td>
															<td>{{number_format( (float) $value->sell_price, 2, '.', '')}}</td>
															<td>{{$value->quantity}}</td>
															<td>{{$value->items !=""?number_format( (float) $value->discount, 2, '.', ''):""}}</td>
															<td>{{$value->items !=""? number_format( (float) $value->sub_total, 2, '.', '') - (number_format( (float) $value->sell_price, 2, '.', '') - $value->discount):""}}</td>
															<td>{{number_format( (float) $value->sub_total, 2, '.', '')}}</td>
														</tr>
														@php $sub_totals += $value->sub_total; @endphp
														@php $discount += $value->discount; @endphp
														@php $vat += number_format( (float) $value->sub_total, 2, '.', '') - (number_format( (float) $value->sell_price, 2, '.', '') - $value->discount); @endphp
														@endforeach
														@endif
														
													</tbody>
												</table>
												<br>
												<table style="float: right" class="d-table custom-table" width="40%">
													<thead >
														<tr>
															<td width="20%"><span><b>@lang('inventory.sub_total')</b></span></td>
															<td width="30%">{{currency_format(number_format( (float) $sub_totals, 2, '.', ''))}}</td>
														</tr>
														<tr>
															<td width="20%"><span><b>@lang('common.discount')</b></span></td>
															<td width="30%">{{currency_format(number_format( (float) $discount, 2, '.', ''))}}</td>
														</tr>
														<tr>
															<td width="20%"><span><b>@lang('common.vat') {{$general_setting->vat}} %</b></span></td>
															<td width="30%">{{currency_format($vat)}}</td>
														</tr>
														<tr>
															<td width="20%"><span><b>@lang('inventory.paid_amount')</b></span></td>
															<td width="30%">
																{{(isset($viewData)) ? currency_format(number_format( (float) $viewData->total_paid, 2, '.', '')) : ''}}
															</td>
														</tr>
														<tr>
															<td width="20%"><span><b>@lang('inventory.due_amount')</b></span></td>
															<td width="30%">
																{{(isset($viewData)) ? currency_format(number_format( (float) $viewData->total_due, 2, '.', '')) : ''}}
															</td>
														</tr>
														<tr>
															<td width="20%"><span><b>@lang('common.the_total_amount_subject_to_tax')</b></span></td>
															<td width="30%">
																{{(isset($viewData)) ? currency_format(number_format( (float) $viewData->grand_total, 2, '.', '')) : ''}}
															</td>
														</tr>
													</thead>
												</table>
												
												<table class="table">
													<thead>
														
														<td class="virtical_middle" style="text-align: center;">
															<p style="text-align: center;"><span><img src="data:image/png;base64,{{$qrCode}}" /></span></p>
															</td>
														</thead>
														</table>
												</div>
											</div> 
										</div>   
										
										<div class="row mt-40">
											<div class="col-lg-12 text-center">
												<button class="primary-btn fix-gr-bg" onclick="javascript:printDiv('purchaseInvoice')">@lang('common.print')</button>
											</div>
										</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
@endsection
