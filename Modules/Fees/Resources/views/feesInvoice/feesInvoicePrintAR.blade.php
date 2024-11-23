<?php $setting =generalSetting(); ?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>@lang('fees::feesModule.view_fees_invoice')</title>
		<style>
			<link rel="stylesheet" href="{{url('Modules\Fees\Resources\assets\css\feesStyle.css')}}"/>
			@import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');
			body{
			font-family: 'Poppins', sans-serif;
			font-size: 14px;
			margin: 0;
			padding: 0;
			counter-reset: Serial;
			}
			
			html[dir="rtl"] body{
			font-family: 'Poppins', sans-serif;
			font-size: 14px;
			margin-right: auto;
			margin-left: 0;
			}
			
			.margin_auto{
			margin-left: auto;
			margin-right: 0
			}
			html[dir="rtl"] .margin_auto{
			margin-left: 0;
			margin-right: auto;
			}
			html[dir="rtl"] .address_text p {
			margin-right: auto;
			margin-left: 0;
			}
			html[dir="rtl"] .total_count {
			margin-right: auto;
			margin-left: 0;
			}
			
			.big-table table
			{
			border-collapse: separate;
			}
			
			.big-table tbody tr td:first-child:before
			{
			counter-increment: Serial;
			content: counter(Serial);
			}
			
			.fees_custom_preview p{
			font-size: 18px;
			font-weight: 500;
			}
			
			.fees_invoice_type_div{
			border-radius:10px 10px 0 0;
			}
			
			.fees_invoice_type_table{
			border-radius:0 0 10px 10px;
			}
			
			.max_modal {
			max-width: 1050px;
			}
			.invoice_text{
			margin-bottom: 0;
			font-size: 16px;
			margin-bottom: 0;
			}
			.invoice_header{
			display: flex;
			align-items: center;
			justify-content: space-between;
			grid-gap: 20px;
			margin-bottom: 30px;
			}
			.invoice_header h3{
			flex:  1 1 auto;
			font-size: 30px;
			}
			.invoice_header img {
			max-width: 250px;
			}
			.school-table-style tfoot tr td {
			padding: 10px 10px 10px 0px;
			}
			
			
			
			/* Invoice View Table */
			table {
			border-collapse: collapse;
			}
			h1,h2,h3,h4,h5,h6{
			margin: 0;
			color: #00273d;
			}
			.invoice_wrapper{
			max-width: 1200px;
			margin: auto;
			background: #fff;
			padding: 10px 30px;
            border: 10px solid;
            border-style: double;
			}
			.table {
			width: 100%;
			margin-bottom: 1rem;
			color: #212529;
			}
			.border_none{
			border: 0px solid transparent;
			border-top: 0px solid transparent !important;
			}
			.invoice_part_iner{
			background-color: #fff;
			}
			.invoice_part_iner h4{
			font-size: 30px;
			font-weight: 500;
			margin-bottom: 40px;
			
			}
			.invoice_part_iner h3{
			font-size:25px;
			font-weight: 500;
			margin-bottom: 5px;
			
			}
			.table_border thead{
			background-color: #F6F8FA;
			}
			.table td, .table th {
			padding: 5px 0;
			vertical-align: top;
			border-top: 0 solid transparent;
			color: #79838b;
			}
			.table td , .table th {
			padding: 5px 0;
			vertical-align: top !important;
			border-top: 0 solid transparent;
			color: #79838b;
			}
			.table_border tr{
			border-bottom: 1px solid #828bb2!important;
			}
			th p span, td p span{
			color: #828bb2;
			}
			.table th {
			color: #00273d;
			font-weight: 300;
			border-bottom: 1px solid #f1f2f3 !important;
			background-color: #fafafa;
			}
			
			p{
			font-size: 14px;
			color: #828bb2;
			}
			h5{
			font-size: 12px;
			font-weight: 500;
			}
			h6{
			font-size: 10px;
			font-weight: 300;
			}
			.mt_40{
			margin-top: 40px;
			}
			.table_style th, .table_style td{
			padding: 20px;
			}
			.invoice_info_table td{
			font-size: 10px;
			padding: 0px;
			}
			.invoice_info_table td h6{
			color: #6D6D6D;
			font-weight: 400;
			}
			
			.text_right{
			text-align: right;
			}
			.virtical_middle{
			vertical-align: middle !important;
			}
			.logo_img {
			max-width: 120px;
			}
			.logo_img img{
			width: 100%;
			}
			.border_bottom{
			border-bottom: 1px solid #828bb2;
			}
			p{
			margin: 0;
			}
			.font_18 {
			font-size: 18px;
			}
			.mb-0{
			margin-bottom: 0;
			}
			.mb_30{
			margin-bottom: 30px !important;
			}
			.border_table thead tr th {
			padding: 10px;
			}
			.border_table tbody tr td {
			border-bottom: 0;
			text-align: center;
			padding: 10px;
			}
			.title_header{
			display: flex;
			align-items: center;
			justify-content: space-between;
			margin: 40px 0 15px 0;
			}
			.address_text p{
			max-width: 200px;
			font-size: 14px;
			margin-bottom: 0;
			color: #828BB2;
			font-weight: 400;
			margin-right: 0;
			margin-left: auto;
			}
			.addressleft_text{
			max-width: 200px;
			font-size: 14px;
			margin-bottom: 0;
			color: #828bb2;
			font-weight: 400;
			}
			.addressleft_text span{
			color: #828bb2;
			display: block;
			white-space: nowrap;
			}
			.addressright_text{
			width: 250px;
			border-radius: 20px;
			padding: 20px;
			margin-right: 0;
			margin-left: auto;
			}
			.addressright_text p span{
			color: #828bb2;
			}
			.description_table th{
			color: #fff;
			font-weight: 300;
			border-bottom: 0;
			background-color: transparent;
			text-align: center;
			}
			.description_table th:first-child{
			border-radius: 10px 0px 0px 10px;
			}
			.description_table th:last-child{
			border-radius: 0px 10px 10px 0px;
			}
			.description_table tbody td{
			background: transparent;
			color: #828bb2;
			border-bottom: 0;
			}
			tfoot .footer_text{
			color: #828bb2;
			margin-top: 10px;
			}
			tfoot .footer_text  span{
			display: block;
			color: #828bb2;
			margin-top: 10px;
			}
			.total_count{
			display: flex;
			justify-content: space-between;
			}
			.mt_20{
			margin-top: 20px;
			}
			.total_amountPay{
			display: flex;
			width: 250px;
			border-radius: 10px;
			background: #374E6B;
			padding: 15px 20px;
			justify-content: space-between;
			margin-left: auto;
			margin-right: 0;
			}
			.total_amountPay span{
			color: #fff;
			font-size: 14px;
			}
			.table_footer p{
			font-size: 14px;
			color: #828BB2;
			}
			.footer_logo p{
			font-size: 14px;
			color: #828BB2;
			}
			.footer_logo img{
			max-width: 100px;
			}
			.footer_logo {
			display: flex;
			flex-direction: column;
			align-items: flex-end;
			}
			html, body {
			height: 100%;
			}
			.invoice_wrapper{
			display: flex;
			flex-direction: column;
			}
			.invoice_footer{
			flex: 1 1 auto;
			display: flex;
			align-items: flex-end;
			}
			
			
			.addressright_text p > span {
			flex: 40% 0 0;
			}
			
			.addressright_text p {
			color: #fff;
			font-size: 14px;
			font-weight: 300;
			display: flex;
			align-items: center;
			white-space: nowrap;
			grid-gap: 20px;
			}
			
			.addressright_text {
			width: auto;
			border-radius: 20px;
			padding: 20px;
			margin-right: 0;
			margin-left: auto;
			}
			
			.total_count {
			display: flex;
			justify-content: space-between;
			border-bottom: 1px solid #f1f2f3 !important;
			padding-bottom: 5px;
			padding-right: 0;
			max-width: 280px;
			margin-right: 0;
			margin-left: auto;
			}
			
			.addressleft_text p {
			display: flex;
			grid-gap: 20px;
			}
			
			.addressleft_text p > span {
			flex: 61% 0 0;
			white-space: nowrap;
			}
			
			.table thead th {
			color: var(--base_color);
			font-size: 12px;
			font-weight: 500;
			text-transform: uppercase;
			border-top: 0px;
			padding: 12px 12px 12px 0px;
			}
			.text-right-print{
			text-align: right !important;
			}
			
			.pr-0{
			padding-right: 0px !important;
			}
			
			.col-lg-10 {
			-ms-flex: 0 0 83.333333%;
			flex: 0 0 83.333333%;
			max-width: 83.333333%;
			}
			
			th p span, td p span {
			color: #000;
			}
			hr {
			border: 1px solid #000;
			}
			
		</style>
		<script>
			var is_chrome = function () { return Boolean(window.chrome); }
			if(is_chrome)
			{
				window.print();
				// setTimeout(function(){window.close();}, 10000);
				//give them 10 seconds to print, then close
			}
			else
			{
				window.print();
			}
		</script>
		<body onLoad="loadHandler();">
			<div class="invoice_wrapper">
            <!-- invoice print part here -->
            <div class="invoice_print">
                <div class="container">
                    <div class="invoice_part_iner">
                        <div class="row" style="display: ruby-text;">
                            <div class="col-sm-6">
                                <h4 class="fs-3" style="margin-bottom: 0px;"><img src="{{asset($setting->logo)}}" title="Metashops Education" width="130px" /></h4>
                            </div>
                            <div class="col-sm-6">
                                <h4 class="fs-3" style="margin-bottom: 0px;float: right;"><img src="{{asset($setting->logo)}}" title="Metashops Education" width="130px" /></h4>
                            </div>
                        </div>
                        

                        <table class="table">
                            <thead>
                                <td class="virtical_middle" style="text-align: center;">
                                    <h4 class="fs-3" style="margin-bottom: 0px">@lang('common.view_fees_invoice')</h4>
                                    <p><strong><span>@lang('fees.invoice_number') #</span> <span>: {{$invoiceInfo->invoice_id}}</span> </strong></p>
                                    <p><strong><span>{{$generalSetting->school_name}}</span> </strong></p>
                                    <p><strong><span>{{$generalSetting->address}}</span> </strong></p>
                                </td>
                            </thead>
                        </table>
                        <table class="table">
                            <thead>
                                <td class="virtical_middle" style="text-align: right;">
                                    @php $subTotal = $invoiceDetails->sum('sub_total'); $paidAmount = $invoiceDetails->sum('paid_amount'); $paymentStatus = $subTotal - $paidAmount; @endphp
                                    <div class="">
                                        <p><strong><span>@lang('fees.create_date') </span> <span>: {{dateConvert($invoiceInfo->create_date)}}</span></strong> </p>
                                        <p><strong></span>@lang('common.vat_registration_no') </span> <span>: 123456789123456</span></strong> </p>
                                        <p><strong><span>@lang('fees.due_date') </span> <span>: {{dateConvert($invoiceInfo->due_date)}}</span></strong> </p>
                                        <p><strong><span>@lang('fees.payment_status')</span> <span>: @if ($paymentStatus == 0)
                                    @lang('fees.paid')
                                    @else
                                    @if ($paidAmount > 0)
                                    @lang('fees.partial')
                                    @else
                                    @lang('fees.unpaid')
                                    @endif
                                    @endif
                                </span>
                                </strong>
                                        </p>
                                        <br>
                                        <h3><strong><span>@lang('fees.fees_invoice_issued_to')</span></strong></h3>
                                        <p><span>@lang('student.student_name') </span> <span class="nowrap">: {{@$invoiceInfo->studentInfo->full_name}}</span> </p>
                                        <p>
                                            <span>@lang('student.guardians_name') </span> <span class="nowrap">: {{@$student->parents->guardians_name}}</span> 
                                        </p>
                                        <p>
                                            <span>@lang('student.guardians_phone') </span> <span class="nowrap">: {{@$student->parents->guardians_mobile}}</span> 
                                        </p>
                                        <p><span>@lang('student.class_section')</span> <span>: {{@$invoiceInfo->recordDetail->class->class_name}} ({{@$invoiceInfo->recordDetail->section->section_name}})</span> </p>
                                        <p><span>@lang('student.roll_no')</span> <span>: {{@$invoiceInfo->recordDetail->roll_no}}</span> </p>
                                        <p><span>@lang('student.admission_no')</span> <span>: {{@$invoiceInfo->studentInfo->admission_no}}</span> </p>



                                    </div>
                                </td>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>

            <!-- invoice print part end -->
            <table class="border_table mb_30" border="1" style="text-align: center; color: #000;direction: rtl;">
                <thead>
                    <tr style="background: #ccc;  color: 000;">
                        <th>@lang('common.sl')</th>
                        <th>@lang('fees::feesModule.subscription_duration')</th>
                        <th>@lang('fees::feesModule.subscription_price')</th>
                        <th>@lang('fees::feesModule.discount')</th>
                        <th>@lang('fees::feesModule.remaining')</th>
                        <th>@lang('fees::feesModule.amount')</th>
                        {{--
                        <th>@lang('common.taxable_amount')</th>--}}
                        <?php if ($setting->vat_on_fees): ?>
                            <th>@lang('common.sub_total')</th>
                        <?php endif ?>
                    </tr>
                </thead>
                <tbody>
                    @php $amount = 0; $weaver = 0; $paid_amount = 0; $fine = 0; $service_charge = 0; $grand_total = 0; $balance = 0; @endphp @foreach ($invoiceDetails as $key=>$invoiceDetail) @php $amount += $invoiceDetail->amount; $weaver += $invoiceDetail->weaver; $fine
                    += $invoiceDetail->fine; $service_charge += $invoiceDetail->service_charge; $paid_amount += $invoiceDetail->paid_amount; $totalAmount = ($invoiceDetail->amount + $invoiceDetail->fine) - $invoiceDetail->weaver; $grand_total += $totalAmount
                    ; $total = ($invoiceDetail->amount+ $invoiceDetail->fine) - ($invoiceDetail->paid_amount + $invoiceDetail->weaver) ; $balance += $total; @endphp
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>
                            {{@$invoiceDetail->feesType->name}} @if($invoiceDetail->note)
                            {{$invoiceDetail->note}}
                            {{--<i class="fa fa-info-circle" aria-hidden="true" data-tooltip="tooltip" title="{{$invoiceDetail->note}}" style="courser:help;"></i>--}} 
                            @endif
                        </td>
                        {{--
                        <td>{{($invoiceDetail)? currency_format($invoiceDetail->amount) : 0.00}}</td>--}}
                        <td>{{($invoiceDetail->amount)? currency_format((15 / 100) * $invoiceDetail->amount) : 0}}</td>
                        <td>-</td>
                        <td>0</td>
                        <td>{{($invoiceDetail->amount)? currency_format(($invoiceDetail->amount) + ((15 / 100) * $invoiceDetail->amount)) : 0}}</td>
                        <?php if ($setting->vat_on_fees): ?>
                            <td>{{($invoiceDetail->amount)? currency_format(($invoiceDetail->amount) + ((15 / 100) * $invoiceDetail->amount)) : 0}}</td>
                        <?php endif ?>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <table style="color:#000;direction:rtl;">
                <tfoot style="display:inline-block;">
                    <tr>
                        <td>
                            <p class="total_count" style="max-width:100%;column-gap:60px;"><span><b>@lang('fees::feesModule.the_total_amount_subject_to_tax')</b></span> <span>{{currency_format($amount)}}</span></p>
                        </td>
                    </tr>
                    {{--<tr>
                        <td>
                            <p class="total_count" style="max-width:100%;column-gap:60px;"><span><b>@lang('fees::feesModule.value_added_tax') (15%)</b></span> <span>{{currency_format((15 / 100) * $amount)}}</span></p>
                        </td>
                    </tr>--}}
                    <?php if ($setting->vat_on_fees == 1): ?>
                        <tr>
                            <td>
                                <p class="total_count" style="max-width: 100%;"><span><b>@lang('fees::feesModule.total_with_tax') (15%)</b></span> <span>{{currency_format(($amount) + (15 / 100) * $amount)}}</span></p>
                            </td>
                        </tr>
                    <?php endif ?>
                </tfoot>
            </table>
            <hr>

            <table class="table">
                <thead>
                    <td class="virtical_middle" style="text-align: center;">
                        <p style="display: grid;text-align: center;">
                            <span> <h3>تطبق الشروط و الاحكام  </h3></span>
                            <span>
                                <img src="https://sbc.metashops.sa/public/uploads/settings/sarah_seal.jpg" style="height: 125px;">
                            </span>
                        </p>
                    </td>
                    {{--<td class="virtical_middle" style="text-align: center;">
                        <p style="text-align: center;"><span><img src="data:image/png;base64,{{$qrCode}}" /></span></p>
                    </td>--}}
                </thead>
            </table>
        </div>
		</div>
	</section>
</body>
</html>
