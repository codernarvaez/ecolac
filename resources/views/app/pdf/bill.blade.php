<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Factura de Venta</title>
    <link rel="stylesheet" href="http://ecolac.test/css/fonts.css">
    <style>
        .clearfix:after {
            content: "";
            display: table;
            clear: both;
        }

        a {
            color: #0087C3;
            text-decoration: none;
        }

        body {
            position: relative;
            margin: 0 auto; 
            width: 100%;
            color: #555555;
            background: #FFFFFF; 
            font-family: 'Nunito', sans-serif;
            font-size: 14px;
        }

        header {
            padding: 10px 0;
            margin-bottom: 20px;
            border-bottom: 1px solid #AAAAAA;
        }

        #logo {
            float: left;
            margin-top: 8px;
        }

        #logo img {
            width: 200px;
        }

        #company {
            text-align: right;
        }


        #details {
            margin-bottom: 50px;
        }

        #client {
            padding-left: 6px;
            border-left: 6px solid #0087C3;
            float: left;
        }

        #client .to {
            color: #777777;
        }

        h2.name {
            font-size: 1.4em;
            font-weight: normal;
            margin: 0;
        }

        #invoice {
            text-align: right;
        }

        #invoice h1 {
            color: #0087C3;
            font-size: 2.4em;
            line-height: 1em;
            font-weight: normal;
            margin: 0  0 10px 0;
        }

        #invoice .date {
            font-size: 1.1em;
            color: #777777;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
            margin-bottom: 20px;
        }

        table th,
        table td {
            padding: 20px;
            background: #f9f9fb;
            text-align: center;
            border-bottom: 1px solid #FFFFFF;
        }

        table th {
            white-space: nowrap;        
            font-weight: normal;
        }

        table td {
            text-align: right;
        }

        table td h3{
            color: #4b7aed;
            font-size: 1.2em;
            font-weight: normal;
            margin: 0 0 0.2em 0;
        }

        table thead th{
            color: #6c6e86;
            background-color: #1f1e2e;
        }

        table .no {
            font-size: 1.6em;
        }

        table .desc {
            text-align: left;
        }

        table tbody .unit {
            background: #efefef;
        }

        table .qty {
        }

        table td.unit,
        table td.qty,
        table td.total {
            font-size: 1.2em;
        }

        table tbody tr:last-child td {
            border: none;
        }

        table tfoot td {
            padding: 10px 20px;
            background: #FFFFFF;
            border-bottom: none;
            font-size: 1.2em;
            white-space: nowrap; 
            border-top: 1px solid #4b7aed; 
        }

        table tfoot tr:first-child td {
            border-top: none; 
        }

        table tfoot tr:last-child td {
            color: #4b7aed;
            font-size: 1.4em;
            border-top: 1px solid #4b7aed; 

        }

        table tfoot tr td:first-child {
            border: none;
        }

        #thanks{
            font-size: 2em;
            margin-bottom: 50px;
        }

        #notices{
            padding-left: 6px;
            border-left: 6px solid #0087C3;  
        }

        #notices .notice {
            font-size: 1.2em;
        }

        footer {
            color: #777777;
            width: 100%;
            height: 30px;
            position: absolute;
            bottom: 0;
            border-top: 1px solid #AAAAAA;
            padding: 8px 0;
            text-align: center;
        }


    </style>
  </head>
  <body>
    <header class="clearfix">
      <div id="logo">
        <img src="http://ecolac.test/img/logo_b.png">
      </div>
      <div id="company">
        <h2 class="name">Ecolac CIA Ltda</h2>
        <div>Paris S/N y Vía a Zamora, Loja. Ecuador.</div>
        <div>(07) 2611411 / EXT 106</div>
      </div>
      </div>
    </header>
    <main>
      <div id="details" class="clearfix">
        <div id="client">
          <div class="to">FACTURA A:</div>
          <h2 class="name">{{ $sale->client->firstname . ' ' . $sale->client->lastname }}</h2>
          <div class="address">{{ $sale->client->location->address }}</div>
          <div class="email"><a href="mailto:john@example.com">{{ $sale->client->email }}</a></div>
        </div>
        <div id="invoice">
          <h1>FACTURA #</h1>
          <div class="date">Fecha: {{ date('d/m/Y', strtotime($sale->created_at)) }}</div>
        </div>
      </div>
      <table border="0" cellspacing="0" cellpadding="0">
        <thead>
          <tr>
            <th class="no">#</th>
            <th class="desc">DESCRIPCION</th>
            <th class="unit">P. UNITARIO</th>
            <th class="qty">CANTIDAD</th>
            <th class="total">TOTAL</th>
          </tr>
        </thead>
        <tbody>
            @php
                $count = 0;    
            @endphp
            @foreach ($sale->details as $detail)
            <tr>
                <td class="no">{{ $count = $count + 1 }}</td>
                <td class="desc"><h3>#{{ $detail->product->code }}</h3>{{ $detail->product->name }}</td>
                <th class="unit">{{ number_format((float)($detail->parcial/$detail->quantity), 2, '.', '') }}</th>
                <td class="qty">{{ $detail->quantity }}</td>
                <td class="total">${{ number_format((float)$detail->parcial, 2, '.', '') }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
          <tr>
            <td colspan="2"></td>
            <td colspan="2">TOTAL</td>
            <td>${{ number_format((float)$sale->total, 2, '.', '') }}</td>
          </tr>
        </tfoot>
      </table>
    </main>
    <footer>
        La factura se creó en una computadora y es válida sin la firma y el sello.
    </footer>
  </body>
</html>