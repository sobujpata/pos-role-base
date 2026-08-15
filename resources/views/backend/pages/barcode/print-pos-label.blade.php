<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POS Label Print</title>

    <style>
        @page {
            size: 38mm 19mm;
            margin: 0;
        }

        * {
            box-sizing: border-box;
        }

        html,
        body {
            margin: 0;
            padding: 0;
            width: 38mm;
            height: 19mm;
            background: #fff;
            font-family: Arial, Helvetica, sans-serif;
            color: #000;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: flex-start;
        }

        .label {
            width: 38mm;
            height: 19mm;
            padding: 0.8mm 1mm;
            overflow: hidden;
            background: #fff;
            text-align: center;
        }

        .brand {
            font-size: 10px;
            font-weight: bold;
            line-height: 1;
            margin-bottom: 0.4mm;
            white-space: nowrap;
            margin-top:5px;
        }

        .title {
            font-size: 5px;
            line-height: 1;
            margin-bottom: 0.5mm;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .barcode-wrap {
            width: 100%;
            text-align: center;
            margin: 0;
            padding: 0;
        }

        .barcode {
            display: block;
            width: 34mm;
            height: 7mm;
            margin: 0 auto;
            object-fit: fill;
            image-rendering: pixelated;
        }

        .code-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
            font-size: 5px;
            line-height: 1;
            margin-top: 0.4mm;
            padding-left: 5px;
            padding-right: 5px;
        }

        .price {
            font-size: 5px;
            font-weight: bold;
            line-height: 1;
            margin-top: 0.5mm;
            white-space: nowrap;
        }

        @media print {
            html,
            body {
                width: 38mm;
                height: 19mm;
            }

            .label {
                page-break-after: avoid;
            }
        }
    </style>
</head>

<body onload="window.print(); setTimeout(() => window.close(), 800);">

    @php
        $sku = $product->sku;
        // $sku = 'A2566988';
    @endphp

    <div class="label">

        <div class="brand">
            {{ $shopDetails->shop_name ?? 'Salim' }}
        </div>

        <div class="title">
            {{ Str::limit($product->title ?? 'Product', 20) }}
        </div>

        <div class="barcode-wrap">

            <img
                class="barcode"
                src="data:image/png;base64,{{ DNS1D::getBarcodePNG($sku, 'C128', 3, 50) }}"
                alt="Barcode"
            >

        </div>

        <div class="code-row">
            <span>{{ $sku }}</span>
            <span>SL-{{ $product->id }}</span>
        </div>

        <div class="price">
            MRP: {{ number_format($product->price ?? 0, 2) }}
            |
            Disc Price: {{ number_format($product->discount_price ?? 0, 2) }}
        </div>

    </div>

</body>
</html>