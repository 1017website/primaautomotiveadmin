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
        left:-5px;
        top:20px;
        width:120px;
        font-size:25px;
        font-weight: bold;
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
            font-size: 14px!important;
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
        padding-left: 20px;
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

    table {
        border-collapse: collapse;
        font-size: 14px!important;
    }

</style>

<?php
$pages = 1;
$pageof = 1;
$pagesFirst = true;

$disc = false;
$sub = 0;

if($invoice->order){
    foreach ($invoice->order->product as $index => $value){
	if(!empty($value->disc_persen)){
		$disc = true;
	}
	$sub += $value->total;
    }
}elseif($invoice->washOrder){
    foreach ($invoice->washOrder->product as $index => $value){
	if(!empty($value->disc_persen)){
		$disc = true;
	}
	$sub += $value->total;
    }
}

?>

<div class="row paper-size">
    @if($invoice->order)
    <?php foreach ($invoice->order->product as $index => $value) { ?>
        <?php if ($pages == 1) { ?>
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
                </div>
                <!-- /HEADER -->
                <!-- FOOTER -->
                <div class="page-footer">
                    <?php if ($pagesFirst) { ?>
                       
                    <?php } ?>
                    <div class="row">
                        <div class="col-sm-12">
                            <p class="text-right text-muted" style="font-style:italic;"><?= 'Page ' . ($pageof++) . ' Of ' . ceil((count($invoice->order->product)) / 8) ?></p>
                        </div>
                    </div>
                </div>
                <!-- /FOOTER -->
                <!-- CONTENT -->
                <div class="page-content">
                    <table class="table-content" style="width: 100%;">
                        <thead>
                            <tr>
                                <th class="text-center" style="width:5%">#</th>
                                <th class="text-left" style="width:30%">{{ __('Product') }}</th>
                                <th class="text-left" style="width:20%">{{ __('Price') }}</th>
                                <th class="text-left" style="width:10%">{{ __('Qty') }}</th>                                                
								<?php if($disc){
									echo '<th class="text-left" style="width:20%" colspan=2>Disc</th>';
								} ?>                                                    
                                <th class="text-right" style="width:15%">{{ __('Total Price') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php } ?>
                        <tr>
                            <td class="text-center">{{ ($index+1) }}</td>
                            <td class="text-left">{{ $value->product_name }}</td>                                               
                            <td class="text-left">{{ __('Rp. ') }}@price($value->product_price)</td>
                            <td class="text-left">{{ $value->product_qty }}</td>
							<?php if($disc){ ?>
								<td class="text-left">{{ number_format($value->disc_persen,2).' %' }}</td>
								<td class="text-left">{{ __('Rp. ') }}@price($value->disc)</td>
							<?php } ?>
                            <td class="text-right">{{ __('Rp. ') }}@price($value->total)</td>
                        </tr>
                        <?php if ($pages == 8 || $index == (count($invoice->order->product) - 1)) { ?>
                        </tbody>
                    </table>
                </div>
                <!-- /CONTENT -->
            </div>
            <!-- /COUNTER ITEM -->
        <?php } ?>
        <!-- /end counter item -->
        <?php
        $pages++;
        $pagesFirst = false;
        if ($pages > 8) {
            $pages = 1;
        }
    }
    ?>
    @elseif($invoice->washOrder)
    <?php foreach ($invoice->washOrder->product as $index => $value) { ?>
        <?php if ($pages == 1) { ?>
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
                            <p class="lead marginbottom">To : {{ $invoice->washOrder->cust_name }}</p>
                            <p>{{ $invoice->washOrder->cust_address }}<p>
                            <p>{{ __('Car') }}: {{ $invoice->washOrder->vehicle_brand }} - {{ $invoice->washOrder->vehicle_name }} {{ $invoice->washOrder->vehicle_plate }}<p>
                            <p>{{ __('Phone') }}: {{ $invoice->washOrder->cust_phone }}</p>
                        </div>

                        <div class="col-sm-4 text-right payment-details">
                            <p class="lead marginbottom payment-info">Payment details</p>
                            <p>{{ __('Date') }}: {{ date('d M Y', strtotime($invoice->date)) }}</p>
                            <p>{{ __('Order') }}: {{ $invoice->washOrder->code }} </p>
                            <p>{{ __('Total Amount') }}: {{ __('Rp. ') }}@price($invoice->total)</p>
                        </div>

                    </div>
                </div>
                <!-- /HEADER -->
                <!-- FOOTER -->
                <div class="page-footer">
                    <?php if ($pagesFirst) { ?>
                       
                    <?php } ?>
                    <div class="row">
                        <div class="col-sm-12">
                            <p class="text-right text-muted" style="font-style:italic;"><?= 'Page ' . ($pageof++) . ' Of ' . ceil((count($invoice->washOrder->product)) / 8) ?></p>
                        </div>
                    </div>
                </div>
                <!-- /FOOTER -->
                <!-- CONTENT -->
                <div class="page-content">
                    <table class="table-content" style="width: 100%;">
                        <thead>
                            <tr>
                                <th class="text-center" style="width:5%">#</th>
                                <th class="text-left" style="width:30%">{{ __('Product') }}</th>
                                <th class="text-left" style="width:20%">{{ __('Price') }}</th>
                                <th class="text-left" style="width:10%">{{ __('Qty') }}</th>                                                
								<?php if($disc){
									echo '<th class="text-left" style="width:20%" colspan=2>Disc</th>';
								} ?>                                                    
                                <th class="text-right" style="width:15%">{{ __('Total Price') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php } ?>
                        <tr>
                            <td class="text-center">{{ ($index+1) }}</td>
                            <td class="text-left">{{ $value->product_name }}</td>                                               
                            <td class="text-left">{{ __('Rp. ') }}@price($value->product_price)</td>
                            <td class="text-left">{{ $value->product_qty }}</td>
							<?php if($disc){ ?>
								<td class="text-left">{{ number_format($value->disc_persen,2).' %' }}</td>
								<td class="text-left">{{ __('Rp. ') }}@price($value->disc)</td>
							<?php } ?>
                            <td class="text-right">{{ __('Rp. ') }}@price($value->total)</td>
                        </tr>
                        <?php if ($pages == 8 || $index == (count($invoice->washOrder->product) - 1)) { ?>
                        </tbody>
                    </table>
                </div>
                <!-- /CONTENT -->
            </div>
            <!-- /COUNTER ITEM -->
        <?php } ?>
        <!-- /end counter item -->
        <?php
        $pages++;
        $pagesFirst = false;
        if ($pages > 8) {
            $pages = 1;
        }
    }
    ?>
    @endif
    <!-- /endforeach detail item -->
</div>

<script>
    setTimeout(function () {
        print();
        close();
    }, 600);
</script>

