<link href="{{asset('css/app.css') }}" rel="stylesheet" >
<link href="{{asset('css/style.min.css')}}" rel="stylesheet">
<link href="{{asset('css/custom.css')}}" rel="stylesheet">
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

        @page {
            size: landscape;
            margin: 0;
        }

        html, body {
            height: 14cm;
            width: 22.5cm;
        }

    }

    html, body {
        height: 14cm;
        width: 22.5cm;
    }


</style>

<div class="container-fluid">
    <div class="row paper-size">
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
                            <p class="lead marginbottom">{{ __('From') }} : Ryan</p>
                            <p>Semolowaru Timur II, Semolowaru, Kec. Sukolilo, Kota SBY, Jawa Timur 60119</p>
                            <p>{{ __('Phone') }}: 0878-5372-2011</p>
                            <p>{{ __('Email') }}: info@primaautomotive.id</p>
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
                                    <th class="text-left" style="width:50%">{{ __('Service') }}</th>
                                    <th class="text-right" style="width:15%">{{ __('Total Price') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($invoice->order->detail as $row => $value)
                                <tr>
                                    <td class="text-center">{{ ($row+1) }}</td>
                                    <td class="text-left">{{ $value->service_name }}</td>
                                    <td class="text-right">{{ __('Rp. ') }}@price($value->service_price)</td>
                                </tr>
                                @endforeach
                                <tr class="last-row"></tr>
                            </tbody>
                        </table>

                    </div>

                    <div class="row">
                        <div class="col-sm-6 margintop">
                            <p>{{ __('Noted') }} : {{ $invoice->order->description }}</p>
                        </div>
                        <div class="col-sm-6 text-right pull-right invoice-total">
                            <p>{{ __('Subtotal') }} : {{ __('Rp. ') }}@price($invoice->total)</p>
                            <p>{{ __('Down Payment') }} : {{ __('Rp. ') }}@price($invoice->dp)</p>
                            <p>{{ __('Tax') }} : {{ __('Rp. ') }}0 </p>
                            <p>{{ __('Total') }} : {{ __('Rp. ') }}@price($invoice->total - $invoice->dp)</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

