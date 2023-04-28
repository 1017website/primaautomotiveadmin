<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <!--    <link href="{{asset('css/app.css') }}" rel="stylesheet" type="text/css" media="all">-->
    <link href="{{asset('css/style.min.css')}}" rel="stylesheet" type="text/css" media="all">
    <link href="{{asset('css/custom.css')}}" rel="stylesheet" type="text/css" media="all">
</head>

<style>
    .body{
        font-family: 'Nunito Sans';
    }

    @media print {
        @page {
            size: auto;
        }
    }
    .col-xs-1, .col-sm-1, .col-md-1, .col-lg-1, .col-xs-2, .col-sm-2, .col-md-2, .col-lg-2, .col-xs-3, .col-sm-3, .col-md-3, .col-lg-3, .col-xs-4, .col-sm-4, .col-md-4, .col-lg-4, .col-xs-5, .col-sm-5, .col-md-5, .col-lg-5, .col-xs-6, .col-sm-6, .col-md-6, .col-lg-6, .col-xs-7, .col-sm-7, .col-md-7, .col-lg-7, .col-xs-8, .col-sm-8, .col-md-8, .col-lg-8, .col-xs-9, .col-sm-9, .col-md-9, .col-lg-9, .col-xs-10, .col-sm-10, .col-md-10, .col-lg-10, .col-xs-11, .col-sm-11, .col-md-11, .col-lg-11, .col-xs-12, .col-sm-12, .col-md-12, .col-lg-12 {
        border:0;
        padding:0;
        margin-left:-0.00001;
        display: grid;
    }

    .page{
        size: A4 portrait;
    }
    /*Invoice*/
    .invoice .top-left {
        text-align:left;
    }

    .invoice .top-right {
        text-align:right;
    }

    .invoice .table-row {
        margin-left:-15px;
        margin-right:-15px;
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

    .invoice .invoice-total {
        margin-right:-10px;
    }

    .invoice .last-row {
        border-bottom:1px solid #ddd;
    }

    .invoice-ribbon {
        width:85px;
        height:88px;
        overflow:hidden;
        position:absolute;
        top:-45px;
        right:-40px;
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
            font-size: 14px!important;
        }

        .invoice .btn {
            margin-top:10px;
        }
    }

    @media print {
        .invoice {
            font-family: monospace;
            font-size: 14px!important;
            size: A4;
            -webkit-print-color-adjust: exact !important;   /* Chrome, Safari 6 – 15.3, Edge */
            color-adjust: exact !important;                 /* Firefox 48 – 96 */
            print-color-adjust: exact !important;           /* Firefox 97+, Safari 15.4+ */
        }
    }

</style>

<div class="row page">
    <div class="col-sm-12">
        <div class="panel panel-default invoice" id="invoice">
            <div class="panel-body">
                <div class="row">

                    <table style="width:100%;">
                        <tr>
                            <td class="top-left" style="width:50%;">
                                <img src="{{asset('plugins/images/logo-inv.png')}}" class="img-fluid">
                            </td>
                            <td class="top-right" style="width:50%;">
                                
                            </td>
                        </tr>
                    </table>

                </div>
                <hr>

                <div class="row table-row">
                    <table class="table table-striped" style="width:100%;">
                        <thead>
                            <tr>
                                <th class="text-center" style="width:5%">#</th>
                                <th class="text-left" style="width:25%">{{ __('Service') }}</th>
								<th class="text-left" style="width:25%">{{ __('Desc') }}</th>
                                <th class="text-left" style="width:20%">{{ __('Cost') }}</th>
                                <th class="text-left" style="width:10%">{{ __('Qty') }}</th>                                                
                                <th class="text-right" style="width:20%">{{ __('Total Price') }}</th>
                            </tr>
                        </thead>
                        <tbody>
							<?php $sub = 0 ?>
                            @foreach ($invoice as $row => $value)
                            <tr>
                                <td class="text-center">{{ ($row+1) }}</td>
                                <td class="text-left">{{ $value->service_name }}</td>                                         
								<td class="text-left">{{ $value->service_desc }}</td>
                                <td class="text-left">{{ __('Rp. ') }}@price($value->service_price)</td>
                                <td class="text-left">{{ $value->service_qty }}</td>
                                <td class="text-right">{{ __('Rp. ') }}@price($value->service_total)</td>
                            </tr>
							<?php $sub += $value->service_total; ?>
                            @endforeach
                            <tr class="last-row"></tr>
                        </tbody>
                    </table>

                </div>

                <div class="page-footer">
                    <div class="row">

                        <table style="width:100%;">
                            <tr>
                                <td>
                                    <table>
                                        <tr>
                                            <td style="width:8rem;text-align:center;white-space: nowrap;"></td>
                                            <td style="width:5rem;"></td>
                                            <td style="width:8rem;text-align:center;white-space: nowrap;"></td>
                                        </tr>
                                        <tr>
                                            <td style="height:5rem;"></td>
                                            <td></td>
                                            <td style="height:5rem;"></td>
                                        </tr>
                                    </table>
                                </td>

                                <td>
                                    <table style="float:right;text-align: right;">
										<tr>
											<td>{{ __('Subtotal') }}</td><td>:</td><td>{{ __('Rp. ') }}@price($sub)</td>
										</tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>