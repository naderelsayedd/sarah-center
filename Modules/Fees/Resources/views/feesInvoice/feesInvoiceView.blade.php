<?php $setting =generalSetting(); ?>
    @extends('backEnd.master') @section('title') @lang('fees::feesModule.view_fees_invoice') @endsection @section('mainContent') @push('css')
    <link rel="stylesheet" href="{{url('Modules\Fees\Resources\assets\css\feesStyle.css')}}" />
    <style>
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
        	th p span, td p span {
            color: #000;
        	}
        	hr {
            border: 1px solid #000;
        	}
            .invoice_wrapper {
                border: 10px solid;
                border-style: double;
                padding: 30px;
            }
    </style>
    @endpush

    <section class="sms-breadcrumb mb-40 white-box">
        <div class="container-fluid">
            <div class="row justify-content-between">
                <h1>@lang('fees::feesModule.view_fees_invoice')</h1>
                <div class="bc-pages">
                    <a href="{{route('dashboard')}}">@lang('common.dashboard')</a>
                    <a href="#">@lang('fees.fees')</a>
                    <a href="">@lang('fees.fees_invoice')</a>
                    <a href="#">@lang('fees::feesModule.view_fees_invoice')</a>
                </div>
            </div>
        </div>
    </section>
    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="max_1200 text-right">
            <a href="{{route('fees.fees-invoice-view',['id'=>$invoiceInfo->id,'state'=>'print'])}}" class="primary-btn small fix-gr-bg" target="_blank">
                <span class="ti-printer pr-2"></span> @lang('common.print')
            </a>
        </div>
        <div class="invoice_wrapper">
            <!-- invoice print part here -->
            <div class="invoice_print">
                <div class="container">
                    <div class="invoice_part_iner">
                        <div class="row">
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

                        <br>
                        <br>
                        <table class="table">
                            <thead>
                                <td class="virtical_middle" style="text-align: left;">
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
                                        
                                        <p>
                                            <span>@lang('student.student_name') </span> <span class="nowrap">: {{@$invoiceInfo->studentInfo->full_name}}</span> 
                                        </p>
                                        <p>
                                            <span>@lang('student.guardians_name') </span> <span class="nowrap">: {{@$student->parents->guardians_name}}</span> 
                                        </p>
                                        <p>
                                            <span>@lang('student.guardians_phone') </span> <span class="nowrap">: {{@$student->parents->guardians_mobile}}</span> 
                                        </p>
                                        <p>
                                            <span>@lang('student.class_section')</span> <span>: {{@$invoiceInfo->recordDetail->class->class_name}} ({{@$invoiceInfo->recordDetail->section->section_name}})</span> 
                                        </p>
                                        <p>
                                            <span>@lang('student.roll_no')</span> <span>: {{@$invoiceInfo->recordDetail->roll_no}}</span> 
                                        </p>
                                        <p>
                                            <span>@lang('student.admission_no')</span> <span>: {{@$invoiceInfo->studentInfo->admission_no}}</span> 
                                        </p>



                                    </div>
                                </td>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>

            <!-- invoice print part end -->
            <table class="border_table mb_30" border="1" style="text-align: center; color: #000;">
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
            <br>
            <br>
            <table style="width: 40%; color: #000; float: right;">
                <tfoot>
                    <tr>
                        <td>
                            <p class="total_count" style="max-width: 100%;"><span><b>@lang('fees::feesModule.the_total_amount_subject_to_tax')</b></span> <span>{{currency_format($amount)}}</span></p>
                        </td>
                    </tr>
                    {{--<tr>
                        <td>
                            <p class="total_count" style="max-width: 100%;"><span><b>@lang('fees::feesModule.value_added_tax') (15%)</b></span> <span>{{currency_format((15 / 100) * $amount)}}</span></p>
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
    </section>
    @endsection @push('script')
    <script>
        $('[data-tooltip="tooltip"]').tooltip();
    </script>
    @endpush