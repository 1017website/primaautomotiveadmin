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

?>

<div class="row paper-size">
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

				</div>
				<hr>
				<div class="row">

					<div class="col-sm-6 from">
						<p class="lead marginbottom">{{ __('Nama') }} : {{ $mechanic->name }}</p>
						<p class="lead marginbottom">{{ __('Position') }} : {{ $mechanic->position }}</p>
					</div>
					<div class="col-sm-6 from">
						<p class="lead marginbottom">{{ __('Phone') }} : {{ $mechanic->phone }}</p>
						<p class="lead marginbottom">{{ __('Address') }} : {{ $mechanic->address }}</p>
					</div>
				</div>
			</div>
			<!-- /HEADER -->
			<!-- FOOTER -->
			<div class="page-footer">
				<?php if ($pagesFirst) { ?>
					<div class="row">
						<div class="col-sm-1 margintop">
						
						</div>
						<div class="col-sm-3 margintop">
							<table>
								<tr>
									<td style="width:8rem;text-align:center;white-space: nowrap;">Penerima</td>
									<td style="width:5rem;"></td>
									<td style="width:8rem;text-align:center;white-space: nowrap;"></td>
								</tr>
								<tr>
									<td style="height:5rem;border-bottom: 1pt solid black;"></td>
									<td></td>
									<td style="height:5rem;"></td>
								</tr>
							</table>
						</div>
						<div class="col-sm-4 margintop">

						</div>
						<div class="col-sm-4 text-right pull-right invoice-total">
							<table style="float:right;text-align: right;">
								<tr>
									<td>{{ __('Total') }}</td><td>:</td><td>{{ __('Rp. ') }}@price($invoice->total_salary)</td>
								</tr>
							</table>
						</div>
					</div>
				<?php } ?>
				<div class="row">
					<div class="col-sm-12">
						<p class="text-right text-muted" style="font-style:italic;"><?= 'Page ' . ($pageof++) . ' Of ' . 1 ?></p>
					</div>
				</div>
			</div>
			<!-- /FOOTER -->
			<!-- CONTENT -->
			<div class="page-content">
				<div class="row table-row">
					<div class="col-6">
						<table class="table-content">
							<thead>
								<tr>
									<th colspan="3" class="text-left" style="width:50%">PENERIMAAN</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td class="text-left">Gaji Pokok</td>
									<td class="text-left">:</td>
									<td class="text-left">{{ __('Rp. ') }}@price($invoice->employee_salary)</td>
								</tr>
								<?php if ($invoice->positional_allowance > 0) { ?>
									<tr>
										<td class="text-left">Tunjangan Jabatan</td>
										<td class="text-left">:</td>
										<td class="text-left">{{ __('Rp. ') }}@price($invoice->positional_allowance)</td>
									</tr>
								<?php } ?>
								<?php if ($invoice->healty_allowance > 0) { ?>
									<tr>
										<td class="text-left">Tunjangan Kesehatan</td>
										<td class="text-left">:</td>
										<td class="text-left">{{ __('Rp. ') }}@price($invoice->healty_allowance)</td>
									</tr>
								<?php } ?>
								<?php if ($invoice->other_allowance > 0) { ?>
									<tr>
										<td class="text-left">Tunjangan Lain-Lain</td>
										<td class="text-left">:</td>
										<td class="text-left">{{ __('Rp. ') }}@price($invoice->other_allowance)</td>
									</tr>
								<?php } ?>
								<?php if ($invoice->description_other <> '' && $invoice->total_other > 0) { ?>
									<tr>
										<td class="text-left"><?= $invoice->description_other ?></td>
										<td class="text-left">:</td>
										<td class="text-left">{{ __('Rp. ') }}@price($invoice->total_other)</td>
									</tr>
								<?php } ?>
								<?php if ($invoice->bonus > 0) { ?>
									<tr>
										<td class="text-left">Bonus</td>
										<td class="text-left">:</td>
										<td class="text-left">{{ __('Rp. ') }}@price($invoice->bonus)</td>
									</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
					<div class="col-6">
						<table class="table-content">
							<thead>
								<tr>
									<th colspan="3" class="text-left" style="width:50%">POTONGAN</th>
								</tr>
							</thead>
							<tbody>
								<?php if ($invoice->penalty > 0) { ?>
									<tr>
										<td>Penalty</td>
										<td>:</td>
										<td>{{ __('Rp. ') }}@price($invoice->penalty)</td>
									</tr>
								<?php } ?>
								<?php if ($invoice->credit > 0) { ?>
									<tr>
										<td>Credit</td>
										<td>:</td>
										<td>{{ __('Rp. ') }}@price($invoice->credit)</td>
									</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
				</div>
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
    ?>
    <!-- /endforeach detail item -->
</div>

<script>
    setTimeout(function () {
        print();
        close();
    }, 600);
</script>

