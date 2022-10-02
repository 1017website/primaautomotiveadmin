<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link href="{{asset('css/app.css') }}" rel="stylesheet" type="text/css" media="all">
    <link href="{{asset('css/style.min.css')}}" rel="stylesheet" type="text/css" media="all">
    <link href="{{asset('css/custom.css')}}" rel="stylesheet" type="text/css" media="all">
</head>
<style>
    .page{
        size: A4 portrait;
    }
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

                    <div class="col-sm-6 top-left">
                        <img src="{{asset('plugins/images/logo-inv.png')}}" class="img-fluid">
                    </div>

                    <div class="col-sm-6 top-right">
                        <h3 class="marginright">{{ $invoice->code }}</h3>
                        <span class="marginright">{{ date('d M Y', strtotime($invoice->date)) }}</span>
                    </div>

                </div>
                <hr>
                <div class="row">

                    <div class="col-sm-4 from">
                        <p class="lead marginbottom">{{ __('From') }} : {{ isset($setting) ? $setting->name : '' }}</p>
                        <p>{{ isset($setting) ? $setting->address : '' }}</p>
                        <p>{{ __('Phone') }}: {{ isset($setting) ? $setting->phone : '' }}</p>
                        <p>{{ __('Email') }}: {{ isset($setting) ? $setting->email : '' }}</p>
                    </div>

                    <div class="col-sm-4 to">
                        <p class="lead marginbottom">To : {{ $invoice->order->cust_name }}</p>
                        <p>{{ $invoice->order->cust_address }}<p>
                        <p>{{ __('Car') }}: {{ $invoice->order->vehicle_brand }} - {{ $invoice->order->vehicle_name }} {{ $invoice->order->vehicle_plate }}<p>
                        <p>{{ __('Phone') }}: {{ $invoice->order->cust_phone }}</p>
                    </div>

                    <div class="col-sm-4 text-right payment-details">
                        <p class="lead marginbottom payment-info">Payment details</p>
                        <p>{{ __('Date') }}: {{ date('d M Y', strtotime($invoice->date)) }}</p>
                        <p>{{ __('Order') }}: {{ $invoice->order->code }} </p>
                        <p>{{ __('Total Amount') }}: {{ __('Rp. ') }}@price($invoice->total)</p>
                    </div>

                </div>

                <div class="row table-row">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th class="text-center" style="width:5%">#</th>
                                <th class="text-left" style="width:40%">{{ __('Service') }}</th>
                                <th class="text-left" style="width:20%">{{ __('Cost') }}</th>
                                <th class="text-left" style="width:10%">{{ __('Qty') }}</th>                                                
                                <th class="text-right" style="width:15%">{{ __('Total Price') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($invoice->order->detail as $row => $value)
                            <tr>
                                <td class="text-center">{{ ($row+1) }}</td>
                                <td class="text-left">{{ $value->service_name }}</td>                                               
                                <td class="text-left">{{ __('Rp. ') }}@price($value->service_price)</td>
                                <td class="text-left">{{ $value->service_qty }}</td>
                                <td class="text-right">{{ __('Rp. ') }}@price($value->service_total)</td>
                            </tr>
                            @endforeach
                            <tr class="last-row"></tr>
                        </tbody>
                    </table>

                </div>

                <div class="page-footer">
                    <div class="row">
                        <div class="col-sm-12 margintop" style="padding-bottom:1rem;">
                            <p>{{ __('Noted') }} : {{ $invoice->order->description }}</p>
                        </div>

                        <div class="col-sm-4 margintop">
                            <table>
                                <tr style="vertical-align:top;">
                                    <td colspan="3"><p>{{ __('Pembayaran Mohon Ditunjukan Ke : ') }}</p></td>
                                </tr>
                                <tr style="vertical-align:top;">
                                    <td><p>{{ __('BCA') }}</td>
                                    <td><p>{{ __(':') }}</p></td>
                                    <td><p>{{ __('5200999721') }}</p></td>
                                </tr>
                                <tr style="vertical-align:top;">
                                    <td><p>{{ __('BNI') }}</td>
                                    <td><p>{{ __(':') }}</p></td>
                                    <td><p>{{ __('0982099091') }}</p></td>
                                </tr>
                                <tr style="vertical-align:top;">
                                    <td><p>{{ __('Mandiri') }}</td>
                                    <td><p>{{ __(':') }}</p></td>
                                    <td><p>{{ __('1400000250721') }}</p></td>
                                </tr>
                                <tr style="vertical-align:top;">
                                    <td><p>{{ __('A/n') }}</td>
                                    <td><p>{{ __(':') }}</p></td>
                                    <td><p>{{ __('CV Prima Karya Otomotif / Muhammad Ryan Ramadhani') }}</p></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-sm-4 margintop">
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
                        </div>
                        <div class="col-sm-4 text-right pull-right invoice-total">
                            <table style="float:right;text-align: right;">
                                <tr>
                                    <td>{{ __('Subtotal') }}</td><td>:</td><td>{{ __('Rp. ') }}@price($invoice->total)</td>
                                </tr>
                                <tr>
                                    <td>{{ __('Payment') }}</td><td>:</td><td>{{ __('Rp. ') }}@price($invoice->dp)</td>
                                </tr>
                                <tr>
                                    <td>{{ __('Remaining Pay') }}</td><td>:</td><td>{{ __('Rp. ') }}@price($invoice->total - $invoice->dp)</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>