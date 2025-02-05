<?php
$generator = new Picqer\Barcode\BarcodeGeneratorHTML();
$generatorPNG = new Picqer\Barcode\BarcodeGeneratorPNG();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Barcode</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/3.0.3/normalize.css">
    <link rel="stylesheet" href="../paper.css">
    <style>
        .sheet {
            box-shadow: rgba(0, 0, 0, 0.15) 1.95px 1.95px 2.6px;
        }

        @page {
            size: 58mm 100mm
        }

        /* output size */
        body.receipt .sheet {
            width: 58mm;
            height: 100mm;
        }

        /* sheet size */
        @media print {
            body.receipt {
                width: 58mm;
                height: 100mm;
            }

            .sheet {
                box-shadow: none !important;
            }
        }

        /* fix for Chrome */
    </style>
</head>

<body class="receipt">
    <section class="sheet padding-10mm">
        <br>
        <!--            &nbsp;&nbsp;&nbsp;-->
        <div>
            <center>
                <!--                <img src="data:image/png;base64,{{ base64_encode($generatorPNG->getBarcode($storeProduct->barcode , $generatorPNG::TYPE_UPC_A)) }}">-->
                <img style="width:80%"
                    src="https://barcode.tec-it.com/barcode.ashx?data={{$storeProduct->barcode}}&code=Code128&eclevel=L'/">
                <p style="margin-top:0px!important;padding-top:0px!important;padding-bottom:1rem!important;margin-bottom:1rem!important;font-size:11pt">{{ $storeProduct->name }}</p>
            </center>
    </section>
</body>

</html>

<script type="text/javascript">
    setTimeout(function () {
        window.print();
        window.close();
    }, 500);
</script>