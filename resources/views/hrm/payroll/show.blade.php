<x-app-layout>
    <style>
        /*Invoice*/
        .invoice .top-left {
            font-size:65px;
            color:#3ba0ff;
        }

        .invoice .top-right {
            text-align:right;
            padding-right: 10px;
            padding-top: 40px;
        }

        .invoice .table-row {
            margin-left:-15px;
            margin-right:-15px;
            margin-top:25px;
        }

        .invoice .payment-info {
            font-weight:500;
        }

        .invoice .table-row .table>thead {
            border-top:1px solid #ddd;
        }

        .invoice .table-row .table>thead>tr>th {
            border-bottom:none;
        }

        .invoice .table>tbody>tr>td {
            padding:8px 20px;
        }

        .invoice .invoice-total {
            margin-right:-10px;
            font-size:16px;
        }

        .invoice .last-row {
            border-bottom:1px solid #ddd;
        }

        .invoice-ribbon {
            width:85px;
            height:88px;
            overflow:hidden;
            position:absolute;
            top:-1px;
            right:11px;
        }

        .ribbon-inner {
            text-align:center;
            -webkit-transform:rotate(45deg);
            -moz-transform:rotate(45deg);
            -ms-transform:rotate(45deg);
            -o-transform:rotate(45deg);
            position:relative;
            padding:7px 0;
            left:-5px;
            top:11px;
            width:120px;
            font-size:15px;
            color:#fff;
        }

        .ribbon-inner:before,.ribbon-inner:after {
            content:"";
            position:absolute;
        }

        .ribbon-inner:before {
            left:0;
        }

        .ribbon-inner:after {
            right:0;
        }

        @media(max-width:575px) {
            .invoice .top-left,.invoice .top-right,.invoice .payment-details {
                text-align:center;
            }

            .invoice .from,.invoice .to,.invoice .payment-details {
                float:none;
                width:100%;
                text-align:center;
                margin-bottom:25px;
            }

            .invoice p.lead,.invoice .from p.lead,.invoice .to p.lead,.invoice .payment-details p.lead {
                font-size:22px;
            }

            .invoice .btn {
                margin-top:10px;
            }
        }

        @media print {
            .invoice {
                width:900px;
                height:800px;
            }
        }

    </style>
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('payroll.index') }}">{{ __('Payroll') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('Detail') }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">

        <div class="card bg-white shadow default-border-radius">
            <div class="card-body">
                <h5 class="card-title">{{ __('Detail Payroll') }}</h5>
                <div class="border-top"></div>


                <div class="row">
                    <div class="col-sm-12">
                        <div class="panel panel-default invoice" id="invoice">
                            <div class="panel-body">
                                <div class="invoice-ribbon">
                                    <div class="ribbon-inner {{ $payroll->getColorPayment() }}">
                                        {{ strtoupper($payroll->getStatusPayment()) }}
                                    </div>
                                </div>
                                <div class="row">

                                    <div class="col-sm-6 top-left">
                                        <img src="{{asset('plugins/images/logo-inv.png')}}" class="img-fluid">
                                    </div>

                                </div>
                                <hr>
                                <div class="row">

                                    <div class="col-sm-12 from">
                                        <p class="lead marginbottom">{{ __('Nama') }} : {{ $mechanic->name }}</p>
                                        <p class="lead marginbottom">{{ __('Position') }} : {{ $mechanic->position }}</p>
                                        <p class="lead marginbottom">{{ __('Phone') }} : {{ $mechanic->phone }}</p>
                                        <p class="lead marginbottom">{{ __('Address') }} : {{ $mechanic->address }}</p>

                                    </div>

                                </div>

                                <div class="row table-row">
									<div class="col-6">
										<table class="table table-striped">
											<thead>
												<tr>
													<th colspan="3" class="text-left" style="width:50%">PENERIMAAN</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td>Gaji Pokok</td>
													<td>:</td>
													<td>{{ __('Rp. ') }}@price($payroll->employee_salary)</td>
												</tr>
												<?php if ($payroll->positional_allowance > 0) { ?>
													<tr>
														<td>Tunjangan Jabatan</td>
														<td>:</td>
														<td>{{ __('Rp. ') }}@price($payroll->positional_allowance)</td>
													</tr>
												<?php } ?>
												<?php if ($payroll->healty_allowance > 0) { ?>
													<tr>
														<td>Tunjangan Kesehatan</td>
														<td>:</td>
														<td>{{ __('Rp. ') }}@price($payroll->healty_allowance)</td>
													</tr>
												<?php } ?>
												<?php if ($payroll->other_allowance > 0) { ?>
													<tr>
														<td>Tunjangan Lain-Lain</td>
														<td>:</td>
														<td>{{ __('Rp. ') }}@price($payroll->other_allowance)</td>
													</tr>
												<?php } ?>
												<?php if ($payroll->description_other <> '' && $payroll->total_other > 0) { ?>
													<tr>
														<td><?= $payroll->description_other ?></td>
														<td>:</td>
														<td>{{ __('Rp. ') }}@price($payroll->total_other)</td>
													</tr>
												<?php } ?>
												<?php if ($payroll->bonus > 0) { ?>
													<tr>
														<td>Bonus</td>
														<td>:</td>
														<td>{{ __('Rp. ') }}@price($payroll->bonus)</td>
													</tr>
												<?php } ?>
											</tbody>
										</table>
									</div>
									<div class="col-6">
										<table class="table table-striped">
											<thead>
												<tr>
													<th colspan="3" class="text-left" style="width:50%">POTONGAN</th>
												</tr>
											</thead>
											<tbody>
												<?php if ($payroll->penalty > 0) { ?>
													<tr>
														<td>Penalty</td>
														<td>:</td>
														<td>{{ __('Rp. ') }}@price($payroll->penalty)</td>
													</tr>
												<?php } ?>
												<?php if ($payroll->credit > 0) { ?>
													<tr>
														<td>Penalty</td>
														<td>:</td>
														<td>{{ __('Rp. ') }}@price($payroll->credit)</td>
													</tr>
												<?php } ?>
											</tbody>
										</table>
									</div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6 margintop">
                                        <a class="btn btn-primary" href="{{ route('payroll.print', $payroll->id) }}" target="_blank"><i class="fa fa-print"></i>{{ __('Print') }}</a>

                                    </div>
                                    <div class="col-sm-6 text-right pull-right invoice-total">

                                        <p>{{ __('Total') }} : {{ __('Rp. ') }}@price($payroll->total_salary)</p>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>


            </div>

        </div>

    </div>

    <script type="text/javascript">
       
    </script>

</x-app-layout>