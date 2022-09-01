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
        top:0px;
        right:0px;
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
            height: 100%;
            display: block;
            font-family: "Calibri";
        }
        
        .page-first{
            margin-top:100px!important;
        }
    }

    html, body {
        height: 13.97cm;
        width: 21.59cm;
    }

    .paper-size:last-child {
        page-break-after: auto;
    }

    .page-layout {
        background-color: #fff;
        box-sizing: border-box;
        box-shadow: 0 0 5px rgb(0 0 0 / 10%);
        width: 100%;
        margin-bottom: 20px;
        display: inline-block;
        padding: 10px;
        position: relative;
        page-break-after: always;
        height: 16cm;
    }

    .page-layout .page-header {
        border-bottom: unset;
        margin: 0;
        padding: 0;
        page-break-inside: avoid;
        position: relative;
        width: 100%;
        margin-bottom: 20px;
        padding-top:10px;
    }

    .page-layout .page-footer {
        bottom: 15px !important;
        box-sizing: border-box;
        left: 0;
        page-break-inside: avoid;
        padding: 0 15px;
        position: absolute;
        width: 100%;
    }
</style>

<?php
$pages = 1;
$pageof = 1;
$pagesFirst = true;
?>

<div class="row paper-size">
    <?php foreach ($invoice->detail as $index => $value) : ?>
        <?php if ($pages == 1) : ?>
            <!-- COUNTER ITEM -->
            <div class="page-layout">
                <!-- HEADER -->
                <div class="page-header {{ (!$pagesFirst) ? 'page-first' : '' }}">
                    <div class="invoice-ribbon">
                        <div class="ribbon-inner {{ $invoice->getColorPayment() }}">
                            <b>{{ strtoupper($invoice->getStatusPayment()) }}</b>
                        </div>
                    </div>
                    <div class="row">

                        <div class="col-sm-6 top-left">
                            <img src="{{asset('plugins/images/logo-inv.png')}}" class="img-fluid">
                        </div>

                        <div class="col-sm-6 top-right text-center">
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
                        </div>

                        <div class="col-sm-4 text-right payment-details">
                            <p class="lead marginbottom payment-info">Payment details</p>
                            <p>{{ __('Date') }}: {{ date('d M Y', strtotime($invoice->date)) }}</p>
                            <p>{{ __('Total Amount') }}: {{ __('Rp. ') }}@price($invoice->total)</p>
                        </div>

                    </div>
                </div>
                <!-- /HEADER -->
                <!-- FOOTER -->
                <div class="page-footer">
                    <?php if ($pagesFirst) { ?>
                        <div class="row">
                            <div class="col-sm-6 margintop">
                                <p>{{ __('Noted') }} : {{ $invoice->description }}</p>

                            </div>
                            <div class="col-sm-6 text-right pull-right invoice-total">

                                <p>{{ __('Subtotal') }} : {{ __('Rp. ') }}@price($invoice->total)</p>

                                <p>{{ __('Payment') }} : {{ __('Rp. ') }}@price($invoice->dp)</p>                                      

                                <p>{{ __('Change') }} : {{ __('Rp. ') }}@price($invoice->dp - $invoice->total)</p>

                            </div>
                        </div>
                    <?php } ?>
                </div>
                <!-- /FOOTER -->
                <!-- CONTENT -->
                <div class="page-content">
                    <table class="table-content" style="width: 100%;">
                        <thead>
                            <tr>
                                <th class="text-center" style="width:5%">#</th>
                                <th class="text-left" style="width:40%">{{ __('Product') }}</th>
                                <th class="text-left" style="width:20%">{{ __('Price') }}</th>
                                <th class="text-left" style="width:10%">{{ __('Qty') }}</th>                                                
                                <th class="text-right" style="width:15%">{{ __('Total') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php endif; ?>
                        <tr>
                            <td class="text-center">{{ ($index+1) }}</td>
                            <td class="text-left">{{ $value->product_name }}</td>                                               
                            <td class="text-left">{{ __('Rp. ') }}@price($value->product_price)</td>
                            <td class="text-left">{{ $value->qty }}</td>
                            <td class="text-right">{{ __('Rp. ') }}@price($value->product_price * $value->qty)</td>
                        </tr>
                        <?php if ($pages == 8 || $index == (count($invoice->detail) - 1)) : ?>
                        </tbody>
                    </table>
                </div>
                <!-- /CONTENT -->
            </div>
            <!-- /COUNTER ITEM -->
        <?php endif; ?>
        <!-- /end counter item -->
        <?php
        $pages++;
        $pagesFirst = false;
        if ($pages > 8)
            $pages = 1;
    endforeach;
    ?>
    <!-- /endforeach detail item -->
</div>

<script>
    setTimeout(function () {
        print();
        close();
    }, 600);
</script>