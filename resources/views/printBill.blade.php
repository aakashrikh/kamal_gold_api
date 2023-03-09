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
      <center id="top">
        <div class="info">
          <h2 style="text-align: center;">{{$data[0]->vendor->shop_name}}</h2>
        </div>
        <!-- {/*End Info*/} -->
      </center>
      <!-- {/*End InvoiceTop*/} -->
      <div id="mid">
        <div class="info">
          @if($data[0]->vendor->address != '')
          <p>
            <span>{{$data[0]->vendor->address}}</span>
            <br />
          </p>
          @endif
          @if($data[0]->vendor->gstin != '')
          <p>
            <span>
          <center style="text-align: center"> GSTIN- {{$data[0]->vendor->gstin}} </center>
          </span>
          </p>
          @endif
          <h3 class="new_h3">
            @if($data[0]->order_type != 'TakeAway' && $data[0]->order_type != 'Delivery')
            <span> Dine In</span>
            @else
            {{$data[0]->order_type}}
            @endif
          </h3>
        </div>
      </div>
      <!-- {/* customer-details */} -->
      <div id="customer_details">
        <h3 class="customer_details_h3">------Customer Details------</h3>
        <div class="name_phone_main">
          <div id="name_phone">
            <div class="phone_email_head">Name</div>
            <div class="phone_email_content">
              @if($data[0]->user->id == 1 || $data[0]->user->name == '')
              <span>N/A</span>
              @else
              {{$data[0]->user->name}}
              @endif
            </div>
          </div>
          <div id="name_phone">
            <div class="phone_email_head">Phone</div>
            <div class="phone_email_content">
              @if($data[0]->user->id == 1 || $data[0]->user->name == '')
              <span>N/A</span>
              @else
              {{$data[0]->user->contact}}
              @endif
            </div>
          </div>
        </div>
      </div>
      <!-- {/* end-customer-details */} -->
      <!-- {/* customer_order_details */} -->
      <div id="customer_details">
        <div class="customer_order_details_main">
          <div id="customer_order_details">
            <div class="customer_order_details_head">Order Time</div>
            <div class="customer_order_details_content">
              {{$data[0]->created_at}}
            </div>
          </div>
          <div id="customer_order_details">
            <div class="customer_order_details_head">Order Code</div>
            <div class="customer_order_details_content">
              {{$data[0]->order_code}}
            </div>
          </div>
          <!-- <div id="customer_order_details">
            <div class="customer_order_details_head">Table Number</div>
            <div class="customer_order_details_content">221</div>
            </div> -->
          <div>
            <div id="customer_order_details">
              <div class="customer_order_details_head">
                Payment Method
              </div>
              <div class="customer_order_details_content">
                @if(count($data[0]->transactions)==1)
                <span>
                {{$data[0]->transactions[0]->txn_method}}
                </span>
                @else
                @foreach($data[0]->transactions as $tt)
                {{$tt->txn_method}} - {{$tt->txn_amount}},
                @endforeach
                @endif
                <!-- if split method -->
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- {/* end_customer_order_details */} -->
      <!-- {/*End Invoice Mid*/} -->
      <div id="bot">
        <!-- if gst!=null -->
        <!-- <h3>---GST Invoice---</h3> -->
        <h3 class="invoice_heading">---Invoice---</h3>
        <div id="table">
          <table>
            <tbody>
              <tr class="tabletitle" style="width: 100% !important">
                <td class="count" style="width: 5%">
                  <h4 class="table_data">#</h4>
                </td>
                <td class="item" style="width: 50%">
                  <h4 class="table_data">Item</h4>
                </td>
                <td class="Hours" style="width: 15%">
                  <h4 class="table_data">Qty</h4>
                </td>
                <td class="Rate" style="width: 15%">
                  <h4 class="table_data">Rate</h4>
                </td>
                <td class="Amount" style="width: 15%">
                  <h4 class="table_data">Amt.</h4>
                </td>
              </tr>
              @if(isset($data[0]->cart))
              <?php
                $x = 1;
                ?>
              @foreach($data[0]->cart as $product)
              <tr class="service" style="width:100% !important">
                <td class="tableitem">
                  <p class="itemtext" style="font-size:1em;margin-bottom:5mm">{{$x}}</p>
                </td>
                <td class="tableitem">
                  <p class="itemtext" style="font-size:1em;margin-bottom:5mm">
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
                <td class="tableitem">
                  <p class="itemtext" style="font-size:1em;margin-bottom:5mm">{{ $product->product_quantity}}</p>
                </td>
                <td class="tableitem">
                  <p class="itemtext" style="font-size:1em;margin-bottom:5mm">
                    {{$product->product_price /
                    $product->product_quantity}}
                  </p>
                </td>
                <td class="tableitem">
                  <p class="itemtext" style="font-size:1em;margin-bottom:5mm">{{$product->product_price}}</p>
                </td>
              </tr>
              <?php
                $x++;
                ?>
              @endforeach
              @endif
            </tbody>
          </table>
        </div>
        <div id="table">
          <table>
            <tbody>
              <tr class="tabletitle">
                <td class="Rate" style="width:60%">
                  <h2 style="font-size: 1.05em;font-weight:300">Sub Total</h2>
                </td>
                <td  style="width:20%"></td>
                <td class="payment" style="width:20%">
                  <h2 style="font-size: 1.05em;font-weight:300;">{{$data[0]->order_amount}}</h2>
                </td>
              </tr>
              @if($data[0]->cgst != 0)
              <tr class="tabletitle">
                <td class="Rate" style="width:60%">
                  <h2 style="font-size: 1.05em;font-weight:300">Tax(C.G.S.T)</h2>
                </td>
                <td  style="width:20%"></td>
                <td class="payment" style="width:20%">
                  <h2 style="font-size: 1.05em;font-weight:300">{{$data[0]->cgst}}</h2>
                </td>
              </tr>
              <tr class="tabletitle">
                <td class="Rate" style="width:60%">
                  <h2 style="font-size: 1.05em;font-weight:300">Tax(S.G.S.T)</h2>
                </td>
                <td  style="width:20%"></td>
                <td class="payment" style="width:20%">
                  <h2 style="font-size: 1.05em;font-weight:300">{{$data[0]->sgst}}</h2>
                </td>
              </tr>
              @endif
              @if($data[0]->discount != 0)
              <tr class="tabletitle">
                <td class="Rate" style="width:60%">
                  <h2 style="font-size: 1.05em;font-weight:300">Discount</h2>
                </td>
                <td  style="width:20%"></td>
                <td class="payment" style="width:20%">
                  <h2 style="font-size: 1.05em;font-weight:300">{{$data[0]->discount}}</h2>
                </td>
              </tr>
              @endif
              <tr class="tabletitle">
                <td class="Rate" style="width:60%">
                  <h2 id="grandtotal" style="font-size: 1.2em">
                    Grand Total
                  </h2>
                </td>
                <td  style="width:15%"></td>
                <td class="payment" style="width:25%">
                  <h2 id="grandtotal" style="font-size: 1.2em;font-weight:bold">
                    ₹ {{$data[0]->total_amount}}
                  </h2>
                </td>
              </tr>
            </tbody>
          </table>

        </div>
        @if($data[0]->instruction != null)
        <p>Instruction: {{$data[0]->instruction}}</p>
        @endif
        <!-- {/*End Table*/} -->
        <div id="legalcopy">
          <p class="legal">

            Thank's Visit Again!
            <br>
            WEAZY DINE
          </p>
        </div>
      </div>
      <!-- {/*End InvoiceBot*/}
        {/*KOT start*/} -->


      <!-- {/*KOT End*/} -->
    </div>
    <!--End Invoice-->
  </body>
</html>
