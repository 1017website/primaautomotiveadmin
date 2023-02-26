<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <!--    <link href="{{asset('css/app.css') }}" rel="stylesheet" type="text/css" media="all">-->
    <link href="{{asset('css/style.min.css')}}" rel="stylesheet" type="text/css" media="all">
    <link href="{{asset('css/custom.css')}}" rel="stylesheet" type="text/css" media="all">
</head>

<?php
$disc = false;
$sub = 0;
foreach ($invoice->detail as $index => $value){
	if(!empty($value->disc)){
		$disc = true;
		$sub += (($value->product_price * $value->qty) - $value->disc);
	}
}
?>

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
                <div class="invoice-ribbon">
                    <div class="ribbon-inner {{ $invoice->getColorPayment() }}">
                        {{ strtoupper($invoice->getStatusPayment()) }}
                    </div>
                </div>
                <div class="row">

                    <table style="width:100%;">
                        <tr>
                            <td class="top-left" style="width:50%;">
                                <img src="{{asset('plugins/images/logo-inv.png')}}" class="img-fluid">
                            </td>
                            <td class="top-right" style="width:50%;">
                                <h3 class="marginright">{{ $invoice->code }}</h3>
                                <span class="marginright">{{ date('d M Y', strtotime($invoice->date)) }}</span>
                            </td>
                        </tr>
                    </table>

                </div>
                <hr>
                <div class="row">
                    <table style="width:100%;">
                        <tr>
                            <td class="top-left" style="width:33%;">
                                <p class="lead marginbottom">{{ __('From') }} : {{ isset($setting) ? $setting->name : '' }}</p>
                                <p>{{ isset($setting) ? $setting->address : '' }}</p>
                                <p>{{ __('Phone') }}: {{ isset($setting) ? $setting->phone : '' }}</p>
                                <p>{{ __('Email') }}: {{ isset($setting) ? $setting->email : '' }}</p>
                            </td>
                            <td class="top-left" style="width:33%;">
                                <?php
                                if (!empty($invoice->cust_id)) {
                                    $cust = $invoice->customer->name;
                                    $add = $invoice->customer->address;
                                    $note = '';
                                } else {
                                    $cust = 'Internal';
                                    $add = '';
                                    $note = '';
                                }
                                ?>
                                <p class="lead marginbottom">To : {{ $cust }}</p>
                                <p>{{ $add }}<p>
                                <p><?= $note ?><p>
                            </td>
                            <td class="top-right" style="width:33%;">
                                <p class="lead marginbottom payment-info">Payment details</p>
                                <p>{{ __('Date') }}: {{ date('d M Y', strtotime($invoice->date)) }}</p>
                                <p>{{ __('Total Amount') }}: {{ __('Rp. ') }}@price($invoice->total)</p>
                            </td>
                        </tr>
                    </table>
                </div>

                <div class="row table-row">
                    <table class="table table-striped" style="width:100%;">
                        <thead>
                            <tr>
                                <th class="text-center" style="width:5%">#</th>
                                <th class="text-left" style="width:25%">{{ __('Product') }}</th>
                                <th class="text-left" style="width:20%">{{ __('Price') }}</th>
                                <th class="text-left" style="width:10%">{{ __('Qty') }}</th>                                                
								<?php if($disc){
									echo '<th class="text-left" style="width:20%">Disc</th>';
								} ?>                                             
                                <th class="text-right" style="width:25%">{{ __('Total') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($invoice->detail as $index => $value)
                            <tr>
                                <td class="text-center">{{ ($index+1) }}</td>
                                <td class="text-left">{{ $value->product_name }}</td>                                               
                                <td class="text-left">{{ __('Rp. ') }}@price($value->product_price)</td>
                                <td class="text-left">{{ $value->qty }}</td>
								<?php if($disc){ ?>
									<td class="text-left">{{ number_format($value->disc_persen,2).' %' }}</td>
								<?php } ?>
                                <td class="text-right">{{ __('Rp. ') }}@price(($value->product_price * $value->qty) - $value->disc)</td>
                            </tr>
                            @endforeach
                            <tr class="last-row"></tr>
                        </tbody>
                    </table>

                </div>

                <div class="page-footer">
                    <div class="row">
                        <div class="col-sm-12 margintop" style="padding-bottom:1rem;">
                            <p>{{ __('Noted') }} : {{ $invoice->description }}</p>
                        </div>

                        <table style="width:100%;">
                            <tr>
                                <td>
                                    <table>
                                        <tr>
                                            <td style="width:8rem;text-align:center;white-space: nowrap;">Hormat Kami,</td>
                                            <td style="width:5rem;"></td>
                                            <td style="width:8rem;text-align:center;white-space: nowrap;">Penerima</td>
                                        </tr>
                                        <tr>
                                            <td style="height:5rem;border-bottom: 1pt solid black;"></td>
                                            <td></td>
                                            <td style="height:5rem;border-bottom: 1pt solid black;"></td>
                                        </tr>
                                    </table>
                                </td>

                                <td>
                                    <table style="float:right;text-align: right;">
										<?php if(!empty($invoice->disc_persen_header)){ ?>
										<tr>
											<td>{{ __('Subtotal') }}</td><td>:</td><td>{{ __('Rp. ') }}@price($sub)</td>
										</tr>
										<tr>
											<td>{{ __('Disc') }}</td><td>:</td><td>{{ number_format($invoice->disc_persen_header,2) . ' %' }}</td>
										</tr>
										<?php } ?>
                                        <tr>
                                            <td>{{ __('Grand Total') }}</td><td>:</td><td>{{ __('Rp. ') }}@price($invoice->total)</td>
                                        </tr>
                                        <tr>
                                            <td>{{ __('Payment') }}</td><td>:</td><td>{{ __('Rp. ') }}@price($invoice->dp)</td>
                                        </tr>
                                        <tr>
                                            <td>{{ __('Change') }}</td><td>:</td><td>{{ __('Rp. ') }}@price($invoice->dp - $invoice->total)</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>

                        <table style="width:70%; margin-top: 2rem;">
                            <tr>
                                <td>
                                    <table class="top-left">
                                        <tr style="vertical-align:top;">
                                            <td colspan="3"><p>{{ __('Pembayaran Mohon Ditunjukan Ke : ') }}</p></td>
                                        </tr>
                                        <tr style="vertical-align:top;">
                                            <td style="width:10%;"><p>{{ __('BCA') }}</td>
                                            <td style="width:5%;"><p>{{ __(':') }}</p></td>
                                            <td style="width:85%;"><p>{{ __('5200999721') }}</p></td>
                                        </tr>
                                        <tr style="vertical-align:top;">
                                            <td style="width:10%;"><p>{{ __('BNI') }}</td>
                                            <td style="width:5%;"><p>{{ __(':') }}</p></td>
                                            <td style="width:85%;"><p>{{ __('0982099091') }}</p></td>
                                        </tr>
                                        <tr style="vertical-align:top;">
                                            <td style="width:10%;"><p>{{ __('Mandiri') }}</td>
                                            <td style="width:5%;"><p>{{ __(':') }}</p></td>
                                            <td style="width:85%;"><p>{{ __('1400000250721') }}</p></td>
                                        </tr>
                                        <tr style="vertical-align:top;">
                                            <td style="width:10%;"><p>{{ __('A/n') }}</td>
                                            <td style="width:5%;"><p>{{ __(':') }}</p></td>
                                            <td style="width:85%;"><p>{{ __('CV Prima Karya Otomotif / Muhammad Ryan Ramadhani') }}</p></td>
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