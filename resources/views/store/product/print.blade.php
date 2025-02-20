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
            size: 58mm auto;
        }

        /* output size */
        body.receipt .sheet {
            width: 58mm;
            height: auto;
        }

        /* sheet size */
        @media print {
            body.receipt {
                width: 58mm;
                height: auto;
            }

            .sheet {
                box-shadow: none !important;
            }
        }

        img {
            width: 100%;
            max-width: 100%;
            height: auto;
        }

        p {
            margin-top: 0px !important;
            padding-top: 0px !important;
            font-size: 10pt;
        }

        /* fix for Chrome */
    </style>
</head>

<body class="receipt">
    <section class="sheet padding-10mm">
        <div>
            <center>
                <img
                    src="https://barcode.tec-it.com/barcode.ashx?data={{$storeProduct->barcode}}&code=Code128&eclevel=L" />
                <p>{{ $storeProduct->name }}</p>
            </center>
        </div>
    </section>
</body>

</html>

<script type="text/javascript">
    setTimeout(function () {
        window.print();
        window.close();
    }, 500);
</script>