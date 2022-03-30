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
            right:14px;
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
            background-color:#66c591;
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
                            <li class="breadcrumb-item"><a href="{{ route('invoice.index') }}">{{ __('Invoice') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('Detail') }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">

        <div class="div-top">
            <a class="btn btn-default" href="{{ route('invoice.index') }}">{{ __('Back') }}</a>
        </div>

        <div class="card bg-white shadow default-border-radius">
            <div class="card-body">
                <h5 class="card-title">{{ __('Detail Invoice') }}</h5>
                <div class="border-top"></div>

                <div class="container bootstrap snippets bootdeys">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="panel panel-default invoice" id="invoice">
                                <div class="panel-body">
                                    <div class="invoice-ribbon"><div class="ribbon-inner">{{ strtoupper($invoice->getStatusPayment()) }}</div></div>
                                    <div class="row">

                                        <div class="col-sm-6 top-left">
                                            <img src="" class="img-fluid">
                                        </div>

                                        <div class="col-sm-6 top-right">
                                            <h3 class="marginright">{{ $invoice->code }}</h3>
                                            <span class="marginright">{{ date('d M Y', strtotime($invoice->date)) }}</span>
                                        </div>

                                    </div>
                                    <hr>
                                    <div class="row">

                                        <div class="col-sm-4 from">
                                            <p class="lead marginbottom">From : Ryan</p>
                                            <p>Semolowaru Timur II, Semolowaru, Kec. Sukolilo, Kota SBY, Jawa Timur 60119</p>
                                            <p>Phone: 0878-5372-2011</p>
                                            <p>Email: info@primaautomotive.id</p>
                                        </div>

                                        <div class="col-sm-4 to">
                                            <p class="lead marginbottom">To : {{ $invoice->order->cust_name }}</p>
                                            <p>{{ $invoice->order->cust_address }}<p>
                                            <p>Car: {{ $invoice->order->vehicle_brand }} - {{ $invoice->order->vehicle_name }} {{ $invoice->order->vehicle_plate }}<p>
                                            <p>Phone: {{ $invoice->order->cust_phone }}</p>
                                        </div>

                                        <div class="col-sm-4 text-right payment-details">
                                            <p class="lead marginbottom payment-info">Payment details</p>
                                            <p>Date: {{ date('d M Y', strtotime($invoice->date)) }}</p>
                                            <p>Order: {{ $invoice->order->code }} </p>
                                            <p>Total Amount: {{ __('Rp. ') }}@price($invoice->total)</p>
                                        </div>

                                    </div>

                                    <div class="row table-row">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th class="text-center" style="width:5%">#</th>
                                                    <th class="text-left" style="width:50%">Service</th>
                                                    <th class="text-right" style="width:15%">Total Price</th>
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
                                            <p class="lead marginbottom">THANK YOU!</p>

                                            <button class="btn btn-success" id="invoice-print"><i class="fa fa-print"></i> Print Invoice</button>
                                            <button class="btn btn-danger"><i class="fa fa-envelope-o"></i> Mail Invoice</button>
                                        </div>
                                        <div class="col-sm-6 text-right pull-right invoice-total">
                                            <p>Subtotal : $1019</p>
                                            <p>Discount (10%) : $101 </p>
                                            <p>VAT (8%) : $73 </p>
                                            <p>Total : $991 </p>
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

    <script type="text/javascript">

    </script>

</x-app-layout>