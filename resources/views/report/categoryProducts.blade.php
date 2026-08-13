<html>
<head>
    <style>
        .customers {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
            font-size: 10px !important;
        }

        .customers td, #customers th {
            border: 1px solid #ddd;
            padding: 5px;
        }

        .customers tr:nth-child(even){background-color: #f2f2f2;}

        .customers tr:hover {background-color: #ddd;}

        .customers th {
            padding-top: 10px;
            padding-bottom: 10px;
            padding-left: 4px;
            text-align: left;
            background-color: #04AA6D;
            color: white;
        }
        h3{
            text-align:center;
        }
    </style>
</head>
<body>

<h3>Product List</h3>

<table class="customers">
    <thead>
        <tr>
            <th>S/L</th>
            <th>Product</th>
            <th><i class="fa fa-hand-o-right" aria-hidden="true"></i> Price</th>
            <th>Sale Price</th>
            <th>Qty</th>
            <th>Remarks</th>
        </tr>
    </thead>
    <tbody>
        @if ($products->isEmpty())
            <tr>
                <td colspan="6" style="text-align: center;">No products available.</td>
            </tr>
        @else
            @foreach ($products as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->title }}</td>
                    <td>{{ $item->original_price }}</td>
                    <td>{{ $item->discount_price }}</td>
                    <td>{{ $item->stock }}</td>
                    <td></td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>

</body>
</html>




