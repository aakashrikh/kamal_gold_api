<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
      @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800;900&display=swap');
      * {
      margin: 0;
      padding: 0;
      margin: 0;
      }
      html,
      body {
      font-family: 'Montserrat', sans-serif;
      }
      #grandtotal {
      font-size: 2em !important;
      font-weight: bold !important;
      }
      #invoice-POS {
      box-shadow: 0 0 1in -0.25in rgba(0, 0, 0, 0.5);
      padding: 2mm;
      width: 80mm;
      background: #fff;
      }
      #invoice-POS ::selection {
      color: #fff;
      }
      #invoice-POS ::moz-selection {
      background: #f31544;
      color: #fff;
      }
      #invoice-POS h1 {
      font-size: 1.5em;
      color: #222;
      }
      #invoice-POS h2 {
      font-size: 2em;
      font-weight: 300;
      }
      #invoice-POS h3 {
      font-size: 1.2em;
      font-weight: 300;
      line-height: 1em;
      text-align: center;
      }
      #invoice-POS p {
      width: 100%;
      text-align: center;
      }
      #invoice-POS .info p {
      text-align: center;
      font-size: 1em;
      line-height: 10px;
      margin: 5px;
      }
      #invoice-POS .info p span {
      line-height: 12px;
      }
      #invoice-POS .new_h3 {
      text-align: center;
      font-size: 1em;
      font-weight: 300;
      line-height: 2em;
      }
      #invoice-POS p {
      font-size: 1em;
      color: #666;
      line-height: 1.2em;
      }
      #invoice-POS #top,
      #invoice-POS #mid,
      #invoice-POS #bot {
      /* Targets all id with 'col-' */
      border-bottom: 2px solid #b0b0b0;
      }
      #invoice-POS #top {
      min-height: 20px;
      }
      /* #invoice-POS #mid {
      margin-top: 10px;
      } */
      #invoice-POS #bot {
      min-height: 50px;
      /* padding-bottom: 10px; */
      }
      .invoice_heading {
      text-align: center;
      font-size: 1em;
      font-weight: 300;
      padding-bottom: 10px;
      border-bottom: 1px solid #eee;
      }
      #invoice-POS .clientlogo {
      float: left;
      height: 60px;
      width: 60px;
      background: url(http://michaeltruong.ca/images/client.jpg) no-repeat;
      background-size: 60px 60px;
      border-radius: 50px;
      }
      #invoice-POS .info {
      display: block;
      margin-left: 0;
      }
      #invoice-POS .title {
      float: right;
      }
      #invoice-POS .title p {
      text-align: right;
      }
      #invoice-POS table {
      width: 100%;
      border-collapse: collapse;
      }
      #invoice-POS .tabletitle {
      font-size: 0.5em;
      border-top:1px dotted #eee !important;
      border-bottom:1px dotted #eee !important;
      }
      #invoice-POS .service {
      border-bottom: 1px solid #eee;
      }
      #invoice-POS .item {
      width: 24mm;
      }
      #invoice-POS .itemtext {
      font-size: 1.2em;
      line-height: 1.5em;
      padding-left: 5px;
      }
      .Rate h2 {
      font-size: 1.5em !important;
      color: #222 !important;
      }
      .payment h2 {
      font-size: 1.5em !important;
      color: #222 !important;
      }
      #legalcopy .legal {
      text-align: center;
      font-size: 1em;
      }
      #customer_details .customer_details_h3 {
      text-align: center;
      font-size: 1em;
      font-weight: 300;
      line-height: 2em;
      }
      .name_phone_main {
      border-bottom: 1px solid #eee;
      }
      .customer_order_details_main {
      border-bottom: 1px solid #eee;
      }
      #name_phone {
      display: flex !important;
      align-items: center !important;
      max-width: 100% !important;
      width: 100% !important;
      }
      #name_phone .phone_email_head {
      width: 30%;
      text-align: start;
      font-size: 1em;
      line-height: 1.5em;
      float: left;
      }
      #name_phone .phone_email_content {
      width: 70%;
      text-align: start;
      font-size: 1em;
      line-height: 1.5em;
      float: right;
      }
      #customer_order_details {
      display: flex;
      align-items: center;
      width: 100%;
      }
      #customer_order_details .customer_order_details_head {
      width: 40%;
      text-align: start;
      font-size: 1em;
      line-height: 1.5em;
      float: left;
      }
      #customer_order_details .customer_order_details_content {
      width: 60%;
      text-align: start;
      font-size: 1em;
      line-height: 1.5em;
      float: right;
      }
      .kot_heading {
      text-align: center;
      font-size: 1.5em !important;
      line-height: 2.5em;
      border-bottom: 1px solid #eee;
      padding-top:30px
      }
      .table_data {
      font-size: 1.15em !important;
      padding-bottom: 20px !important;
      font-weight: lighter !important;
      text-align:center
      }
      .kot_dT {
      /* display: flex; */
      /* align-items: center; */
      width: 100%;
      font-size: 0.5em;
      text-align: center;
      }
      .mt-10 {
      margin-top: 10px;
      }
      .text-center {
      text-align: center;
      }
    </style>
  </head>
  <body>
    <div id="invoice-POS">
        <!-- {/*KOT start*/}  -->
      <div id="legalcopy">
        <p class="kot_dT kot_heading">
          KOT No: {{$data[0]->cart[0]->kot}}<br>
          Token For: {{$data[0]->order_code}}<br>
          Date:{{$data[0]->created_at}}
        </p>
      </div>
      <div id="bot" class="mt-10">
        <div id="table">
          <table>
            <tbody>
              <tr class="tabletitle">
                <td class="count text-center">
                  <h4 class="table_data">#</h4>
                </td>
                <td class="item text-center">
                  <h4 class="table_data">Item</h4>
                </td>
                <td class="Hours text-center">
                  <h4 class="table_data">Qty</h4>
                </td>
              </tr>
              @if(isset($data[0]->cart))
              <?php
                $x = 1;
                ?>
              @foreach($data[0]->cart as $product)
              <tr class="service">
                <td class="tableitem" style="text-align: center;width: 20%;">
                  <p class="itemtext" style="font-size:1em">{{$x}}</p>
                </td>
                <td class="tableitem" style="text-align: center;width: 60%;">
                  <p class="itemtext" style="font-size:1em">
                    {{$product->product->product_name}}
                    @if($product->variant != null)
                    - {{$product->variant->variants_name}}
                    @endif
                    @if(count($product->addons)>0)
                    <strong>AddOns: </strong>
                    @foreach($product->addons as $pp)
                    {{$pp->addon_name}}
                    @endforeach
                    @endif
                  </p>
                </td>
                <td class="tableitem" style="text-align: center;width: 20%;">
                  <p class="itemtext" style="font-size:1em">{{ $product->product_quantity}}</p>
                </td>
              </tr>
              <?php
                $x++;
                ?>
              @endforeach
              @endif
            </tbody>
          </table>

          @if($data[0]->instruction != null)
            <p>Instruction: {{$data[0]->instruction}}</p>
            @endif

        </div>
      </div>
      <!-- {/*KOT End*/} -->
    </div>
    <!--End Invoice-->
  </body>
</html>
