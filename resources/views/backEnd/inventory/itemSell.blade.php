@extends('backEnd.master')
@section('title')
@lang('inventory.item_sell')
@endsection
@section('mainContent')
@push('css')
<style type="text/css">
    #productTable tbody tr{
	border-bottom: 1px solid #FFFFFF !important;
    }
    .forStudentWrapper, #selectStaffsDiv{
	display: none;
    }
</style>
@endpush
<section class="sms-breadcrumb mb-40 white-box">
    <div class="container-fluid">
        <div class="row justify-content-between">
            <h1>@lang('inventory.item_sell')</h1>
            <div class="bc-pages">
                <a href="{{route('dashboard')}}">@lang('common.dashboard')</a>
                <a href="{{route('item-sell')}}">@lang('inventory.item_sell')</a>
			</div>
		</div>
	</div>
</section>
<section class="admin-visitor-area">
    <div class="container-fluid p-0">
		
		{{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'save-item-sell-data',
		'method' => 'POST', 'enctype' => 'multipart/form-data', 'id' => 'item-sell-form']) }}
		<input type="hidden" name="income_head_id" value="3">
		<input type="hidden" name="bank_id">
		<input type="hidden" name="staff_id">
		<input type="hidden" name="role_id" value="2">
		<div class="row">		
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-4 no-gutters">
						<div class="main-title">
							<h3 class="mb-20">@lang('inventory.item_sell')</h3>
						</div>
					</div>
				</div>
				
				<div class="row">
					<div class="col-lg-12">
						<div class="white-box">
							<div class="col-lg-12">
								<div class="main-title">
									<h3 class="mb-30">
										@if(isset($editData))
										@lang('common.edit_sell')
										@else
										@lang('inventory.sells_details')    
										@endif
									</h3>
								</div>
							</div>
							<div class="alert alert-danger" id="errorMessage2">
								<div id="itemError"></div>
								<div id="priceError"></div>
								<div id="quantityError"></div>                     
							</div>
							
							<div class="col-lg-6 mb-30" id="select_student_div" style="float:left;">
								<label class="primary_input_label" for="">@lang('common.student') <span class="text-danger"> *</span> </label>
								<select class="primary_select form-control{{ $errors->has('student') ? ' is-invalid' : '' }}" id="select_student" name="student">
									<option data-display="@lang('common.select_student') *" value="">@lang('common.select_student') *</option>
									@foreach($students as $key=>$value)
									<option  value="{{$value->id}}">{{$value->first_name}} {{$value->last_name}}</option>
									@endforeach
								</select>
								<div class="text-danger" id="studentError"></div>
								@if ($errors->has('student'))
								<span class="text-danger invalid-select" role="alert">
									{{ $errors->first('student') }}
								</span>
								@endif
							</div>
							
							<div class="col-lg-6 mb-30" style="float:left;">
								<label class="primary_input_label" for="">@lang('inventory.payment_method') <span class="text-danger"> *</span> </label>
								<select class="primary_select  form-control" name="payment_method" id="item_sell_payment_method_id">
									<option data-display="@lang('inventory.payment_method')*" value="">@lang('inventory.payment_method')*</option>
									@foreach($paymentMethhods as $key=>$value)
									<option data-string="{{$value->method}}" value="{{$value->id}}">{{$value->method}}</option>
									@endforeach
								</select>
								<div class="text-danger" id="paymentError"></div>
							</div>
							
							<div class="col-lg-6 mb-30" style="float:left;" style="float:left;">
								<div class="primary_input">
									<label class="primary_input_label" for="">@lang('inventory.reference_no')</label>
									<input class="primary_input_field form-control"	type="text" name="reference_no" autocomplete="off" value="{{isset($editData)? $editData->reference_no : '' }}">
								</div>
							</div>
							
							
							<div class="col-lg-6 mb-30" style="float:left;">
								<div class="primary_input ">
									<label class="primary_input_label" for="">@lang('inventory.sell_date') <span></span> </label>
									<div class="primary_datepicker_input">
										<div class="no-gutters input-right-icon">
											<div class="col">
												<div class="">
													<input class="primary_input_field  primary_input_field date form-control form-control{{ $errors->has('sell_date') ? ' is-invalid' : '' }}"  id="sell_date" type="text" name="sell_date" value="{{isset($editData)? date('m/d/Y', strtotime($editData->sell_date)): date('m/d/Y')}}" autocomplete="off">
												</div>
											</div>
											<button class="btn-date" data-id="#sell_date" type="button">
												<label for="sell_date" class="m-0 p-0">
													<i class="ti-calendar" id="start-date-icon"></i>
												</label>
											</button>
										</div>
									</div>
									<span class="text-danger">{{$errors->first('sell_date')}}</span>
								</div>
							</div>
							<div class="col-lg-12 mb-20" style="float:left;">
								<div class="primary_input">
									<label class="primary_input_label" for="">@lang('common.description') <span></span> </label>
									<textarea class="primary_input_field form-control" cols="0" rows="4" name="description" id="description">{{isset($editData) ? $editData->description : ''}}</textarea>
								</div>
							</div>
							
							<hr />
							
							<div class="offset-lg-12 col-lg-12 text-right col-md-12 mb-20" style="float:left;">
								<button type="button" class="primary-btn small fix-gr-bg" onclick="addRowInSell();" id="addRowBtn">
									<span class="ti-plus pr-2"></span>
									@lang('common.add') 
								</button>
							</div>
							<table class="table" id="productTable">
								<thead>
									<tr>
										<th> @lang('inventory.product_name') </th>
										<th> @lang('common.description') </th>
										<th> @lang('inventory.sell_price') </th>
										<th> @lang('common.discount') </th>
										<th> @lang('inventory.quantity') </th>
										<th> @lang('common.vat') (%) </th>
										<th>@lang('inventory.sub_total')</th>
										<th>@lang('common.action')</th>
									</tr>
								</thead>
								<tbody>
									<tr id="row1" class="0">
										<td class="border-top-0">
											<input type="hidden" name="url" id="url" value="{{URL::to('/')}}"> 
											<div class="primary_input">
												<select class="primary_select  form-control{{ $errors->has('category_name') ? ' is-invalid' : '' }}" name="item_id[]" id="productName1">
													<option data-display="@lang('common.select_item') " value="">@lang('common.select')</option>
													@foreach($items as $key=>$value)
													<option value="{{$value->id}}"
													@if(isset($editData))
													@if($editData->category_name == $value->id)
														selected
														@endif
														@endif
													>{{$value->item_name}}</option>
													@endforeach
												</select>
												
												@if ($errors->has('item_id'))
												<span class="text-danger invalid-select" role="alert">
													{{ $errors->first('item_id') }}
												</span>
												@endif
											</div>
										</td>
										<td class="border-top-0">
											<div class="primary_input">
												<input class="primary_input_field form-control{{ $errors->has('discount') ? ' is-invalid' : '' }}"
												type="text" id="descriptionItem1" name="descriptionItem[]" autocomplete="off" value="{{isset($editData)? $editData->descriptionItem : '' }}">
												
												
												@if ($errors->has('descriptionItem'))
												<span class="text-danger" >
													{{ $errors->first('descriptionItem') }}
												</span>
												@endif
											</div>
										</td>
										<td class="border-top-0">
											<div class="primary_input">
												<input class="primary_input_field form-control{{ $errors->has('unit_price') ? ' is-invalid' : '' }}"
												type="number" step="0.1" id="unit_price1" name="unit_price[]" onkeypress="return isNumberKey(event)" autocomplete="off" value="{{isset($editData)? $editData->unit_price : '' }}" onkeyup="getTotalByPrice(1)">
												
												
												@if ($errors->has('unit_price'))
												<span class="text-danger" >
													{{ $errors->first('unit_price') }}
												</span>
												@endif
											</div>
										</td>
										<td class="border-top-0">
											<div class="primary_input">
												<input class="primary_input_field form-control{{ $errors->has('discount') ? ' is-invalid' : '' }}"
												type="number" step="0.1" id="discount1" name="discount[]" onkeypress="return isNumberKey(event)" autocomplete="off" value="{{isset($editData)? $editData->discount : '' }}" onkeyup="getTotalByPrice(1)">
												
												
												@if ($errors->has('discount'))
												<span class="text-danger" >
													{{ $errors->first('discount') }}
												</span>
												@endif
											</div>
										</td>
										<td class="border-top-0">
											<div class="primary_input">
												<input class="primary_input_field form-control{{ $errors->has('quantity') ? ' is-invalid' : '' }}"
												type="number" id="quantity1" name="quantity[]" onkeypress="return isNumberKey(event)" autocomplete="off" onkeyup="getTotalInSell(1);" value="{{isset($editData)? $editData->quantity : '' }}">
												
												
												@if ($errors->has('quantity'))
												<span class="text-danger" >
													{{ $errors->first('quantity') }}
												</span>
												@endif
											</div>
										</td>
										<td class="border-top-0">
											<div class="primary_input">
												<input class="primary_input_field form-control{{ $errors->has('vat') ? ' is-invalid' : '' }}"
												type="number" id="vat1" name="vat[]"  value="{{isset($editData)? $editData->vat : '15' }}"  readonly>
												
												
												@if ($errors->has('vat'))
												<span class="text-danger" >
													{{ $errors->first('vat') }}
												</span>
												@endif
											</div>
										</td>
										<td class="border-top-0">
											<div class="primary_input">
												<input class="primary_input_field form-control{{ $errors->has('sub_total') ? ' is-invalid' : '' }}"
												type="text" name="total[]" id="total1" onkeypress="return isNumberKey(event)" autocomplete="off" value="{{isset($editData)? $editData->sub_total : '0.00' }}">
												
												
												@if ($errors->has('sub_total'))
												<span class="text-danger" >
													{{ $errors->first('sub_total') }}
												</span>
												@endif
											</div>
											<input type="hidden" name="totalValue[]" id="totalValue1" autocomplete="off" class="form-control" />
										</td>
										<td>
											<button class="primary-btn icon-only fix-gr-bg" type="button">
												<span class="ti-trash" id="removeSubject" onclick="deleteSubject(4)"></span>
											</button>
										</td>
									</tr>
									<tfoot>
										
										<tr>
											<th colspan="5"><hr /></th>
											<th class="border-top-0" colspan="2">@lang('inventory.total')</th>
											<th class="border-top-0">
												<input type="text" class="primary_input_field form-control" id="subTotalQuantity" onkeypress="return isNumberKey(event)" name="subTotalQuantity" placeholder="0.00" readonly="" />
												<input type="hidden" class="form-control" id="subTotalQuantityValue" name="subTotalQuantityValue" />
											</th>
											<th class="border-top-0">
												<input type="text" class="primary_input_field form-control" id="subTotal" name="subTotal" placeholder="0.00" readonly="" />
												<input type="hidden" class="form-control" id="subTotalValue" name="subTotalValue" />
											</th>
											<th class="border-top-0"></th>
										</tr>
									</tfoot>
									
								</tbody>
							</table>
							
							<div class="col-lg-12 mt-20 text-center">
								<button class="primary-btn fix-gr-bg">
									<span class="ti-check"></span>
									@lang('inventory.sells')
								</button>
							</div>
						</div>
					</div>
				</div>
				
				<div class="row mt-30" style="display:none;">
					<div class="col-lg-12">
						<div class="white-box">
							<div class="row">
								
								<div class="col-lg-4 mt-30-md">
									<div class="col-lg-12">
										<div class="primary_input">
											<input type="checkbox" id="full_paid"  class="common-checkbox form-control{{ $errors->has('full_paid') ? ' is-invalid' : '' }}" name="full_paid" value="1">
											<label for="full_paid">@lang('inventory.full_paid')</label>
										</div>
									</div>
								</div>  
								
								<div class="col-lg-4 mt-30-md">
									<div class="col-lg-12">
										<div class="primary_input">
											<label class="primary_input_label" for="">@lang('inventory.total_paid')</label>
											<input class="primary_input_field" type="number" step="0.1" value="0" name="totalPaid" id="totalPaid" onkeyup="paidAmount();">
											<input type="hidden" id="totalPaidValue" name="totalPaidValue">
											
											
										</div>
									</div>
								</div>
								<div class="col-lg-4 mt-30-md">
									<div class="col-lg-12">
										<div class="primary_input">
											<label class="primary_input_label" for="">@lang('inventory.total_due')</label>
											<input class="primary_input_field" type="text" value="0.00" id="totalDue" readonly>
											<input type="hidden" id="totalDueValue" name="totalDueValue">
											
											
										</div>
									</div>
								</div>
							</div>
							
							
						</div>
					</div>
				</div>
			</div>
		</div>
		{{ Form::close() }}
	</div>
</section>
@endsection
@include('backEnd.partials.date_picker_css_js')															