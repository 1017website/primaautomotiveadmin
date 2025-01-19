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
foreach ($invoice->detail as $index => $value){
	if(!empty($value->disc)){
		$disc = true;
	}
	$sub += (($value->product_price * $value->qty) - $value->disc);
}
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
                            <img style="width:30%" src="{{asset('plugins/images/logo-color.PNG')}}" class="img-fluid">
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
                                        <td>{{ __('Subtotal') }}</td><td>:</td><td>{{ __('Rp. ') }}@price($sub)</td>
                                    </tr>
									<?php if(!empty($invoice->disc_persen_header)){ ?>
                                    <tr>
                                        <td>{{ __('Disc') }} {{ number_format($invoice->disc_persen_header,2) . ' %' }}</td><td>:</td><td>{{ __('Rp. ') }}@price($invoice->disc_header)</td>
                                    </tr>
									<?php } ?>
									<?php if(!empty($invoice->ppn_persen_header)){ ?>
                                    <tr>
                                        <td>{{ __('PPn') }} {{ number_format($invoice->ppn_persen_header,2) . ' %' }}</td><td>:</td><td>{{ __('Rp. ') }}@price($invoice->ppn_header)</td>
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
                            </div>
                            <!--                            <div class="col-sm-12 margintop" style="margin-top:1rem;">
                                                            <p>{{ __('Noted') }} : {{ $invoice->description }}</p>
                                                        </div>-->
                        </div>
                    <?php } ?>
                    <div class="row">
                        <div class="col-sm-12">
                            <p class="text-right text-muted" style="font-style:italic;"><?= 'Page ' . ($pageof++) . ' Of ' . ceil((count($invoice->detail)) / 8) ?></p>
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
                                <th class="text-left" style="width:25%">{{ __('Product') }}</th>
                                <th class="text-left" style="width:20%">{{ __('Price') }}</th>
                                <th class="text-left" style="width:10%">{{ __('Qty') }}</th>   
								<?php if($disc){
									echo '<th class="text-left" colspan=2 style="width:20%">Disc</th>';
								} ?>
                                <th class="text-right" style="width:20%">{{ __('Total') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php endif; ?>
                        <tr>
                            <td class="text-center">{{ ($index+1) }}</td>
                            <td class="text-left">{{ $value->product_name }}</td>                                               
                            <td class="text-left">{{ __('Rp. ') }}@price($value->product_price)</td>
                            <td class="text-left">{{ $value->qty }}</td>
							<?php if($disc){ ?>
								<td class="text-left">{{ number_format($value->disc_persen,2).' %' }}</td>
								<td class="text-left">{{ __('Rp. ') }}@price($value->disc)</td>
							<?php } ?>
                            <td class="text-right">{{ __('Rp. ') }}@price(($value->product_price * $value->qty) - $value->disc)</td>
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