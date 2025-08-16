<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Checkout Receipt</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #f4f4f4;
      padding: 0.6rem;
      display: flex;
      justify-content: center;
    }

    .receipt {
      background: white;
      width: 100%;
      max-width: 650px;
      padding: 1rem;
      border-radius: 10px;
      box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    .receipt h2 {
      text-align: center;
      margin-bottom: 0px;
      color: #333;
    }
    .receipt h5 {
      text-align: center;
      margin-bottom: 1rem;
      margin-top: -.1rem;
      color: #333;
    }

    .receipt .info {
      margin-bottom: 1rem;
      font-size: 0.95rem;
      color: #555;
    }

    .receipt .info div {
      margin: 0.25rem 0;
    }

    .receipt table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 1.5rem;
    }

    .receipt table thead {
      background-color: #f0f0f0;
    }

    .receipt table th,
    .receipt table td {
      padding: 0.75rem;
      border-bottom: 1px solid #e0e0e0;
      text-align: left;
    }

    .receipt .totals {
      display: flex;
      justify-content: space-between;
      margin-bottom: 0.5rem;
      font-size: 1rem;
      /* float: right; */
      width: 300px;
    }
    .receipt .totals th,
    .receipt .totals td{
        padding: .3rem 1rem;
    }

    .receipt .totals strong {
      color: #222;
    }

    .receipt .footer {
      text-align: center;
      margin-top: 4rem;
      font-size: 0.85rem;
      color: #777;
    }

    @media print {
      body {
        background: none;
        padding: 0;
      }
      .receipt {
        box-shadow: none;
        margin: 0;
        border-radius: 0;
      }
    }
  </style>
</head>
<body>
  <div class="receipt">
    <h2>Buddhijibi Hostel Clearance</h2>
    <h5>Phone : 01321742746</h5>
    <div class="info">
      <div><strong>Invoice : #</strong> {{ str_pad( $bookingI->id, 8, '0', STR_PAD_LEFT); }} [ {{ date('Y-m-d h:i:s A',strtotime($bookingI->created_at)) }} ]</div>

      <div><strong>Booking Info : </strong>{{ date('Y-m-d',strtotime($bookingI->booking_start_date)) }} to {{ date('Y-m-d',strtotime($bookingI->booking_end_date)) }} [
        @php
          foreach ($bookingI->bookings as $kk=>$value) {
                echo $value->seat->seat_number;
                if(count($bookingI->bookings)-2==$kk){
                    echo ",";
                }
          }
        @endphp
       ]</div>
      <div><strong>Checkout Date : </strong>{{ date('Y-m-d h:i:s A',strtotime($bookingI->checkout_date)) }}</div>
      <div><strong>Customer Name : </strong>{{ $bookingI->bookingperson->booking_person_name }}</div>
      <div><strong>Customer Phone : </strong>{{ $bookingI->bookingperson->booking_phone_number }}</div>
      <div><strong>Customer Address : </strong>{{ $bookingI->bookingperson->booking_person_address }}</div>
    </div>

    <table>
      <thead>
        <tr>
          <th>Seat Charge</th>
          <th>Service Charge</th>
          <th>Discount</th>
          <th>Payable</th>
          <th>Paid</th>
          <th>Due</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>{{ $bookingI->seat_price }} BDT</td>
          <td>{{ $bookingI->seat_service_charge }} BDT</td>
          <td>{{ $bookingI->discount }} BDT</td>
          <td>{{ $bookingI->total_payable }} BDT</td>
          <td>{{ $bookingI->total_paid }} BDT</td>
          <td>{{ $bookingI->total_due }} BDT</td>
        </tr>

      </tbody>
    </table>
    <u><h4 style="text-align: center;">Payments</h4></u>
    <table>
      <thead>
        <tr>
          <th>Payment Date</th>
          <th>Received By</th>
          <th>Payment Method</th>
          <th>Amount</th>
        </tr>
      </thead>
      <tbody>
        @php
            $total_amount = 0;
        @endphp
        @foreach ($bookingI->payments as $key=>$payment)
        @php
            $total_amount = $total_amount+$payment->pay_amount;
            if($payment->pay_amount==0){
              continue;
            }
        @endphp
        <tr>
          <td>{{ $payment->payment_date }}</td>
          <td>{{ $payment->createdBy->name }}</td>
          <td>{{ $payment->payment_method }}</td>
          <td>{{ $payment->pay_amount }} BDT</td>
        </tr>
        @endforeach

      </tbody>
      <thead>
        <tr>
          <td colspan="3">Total </td>
          <td>= {{ $total_amount==0?'N/A':$total_amount." BDT" }} </td>
        </tr>
      </thead>
    </table>
    @if ($bookingI->cancel_status==1)
    <u><h4 style="text-align: center;">Refund</h4></u>
    <table>
      <thead>
        <tr>
            <th>Checkout Date</th>
            <th>Service Charge Refund</th>
            <th>Total Refund</th>
        </tr>
      </thead>
      <tbody>
       <tr>
        <td>{{ date('d M , Y h:i A',strtotime($bookingI->cancel_date)) }}</td>
        <td>{{ $bookingI->canceled->service_charge_refund }} BDT</td>
        <td>{{ $bookingI->canceled->refund_amount }} BDT</td>
       </tr>

      </tbody>
    </table>
    @endif

    @if ($bookingI->checkeout_status==1)
    <u><h4 style="text-align: center;"></h4></u>
    <table>
      <thead>
        <tr>
          <th>Checkout Date</th>
          <th>Note</th>
          <th>Penalty</th>
        </tr>
      </thead>
      <tbody>
       <tr>
        <td>{{ date('d M , Y h:i A',strtotime($bookingI->checkout_date))}}</td>
        <td>{{ $bookingI->checkout->customer_review }}</td>
        <td>{{ $bookingI->checkout->total_penalty }} BDT</td>
       </tr>

      </tbody>
      <thead>
        <tr>
          <td colspan="2">Total </td>
          <td>= {{ $bookingI->checkout->total_penalty==0?'N/A':$bookingI->checkout->total_penalty." BDT" }} </td>
        </tr>
      </thead>
    </table>
    @endif


    @if ($bookingI->cancel_status==1)
    <div class="totals">
        <table>
            <tr>
                <th>Total Payable </th>
                <td>{{ $bookingI->total_payable }} /-</td>
            </tr>
            <tr>
                <th>Total Paid</th>
                <td>{{ $bookingI->total_paid }} /-<</td>
            </tr>
            <tr>
                <th>Refund Amount</th>
                <td>{{ $bookingI->canceled->refund_amount }} /-<</td>
            </tr>
        </table>
    </div>
    @elseif($bookingI->checkeout_status==1)
    <div class="totals">
        <table>
            <tr>
                <th>Total Payable </th>
                <td>{{ $bookingI->total_payable }} /-</td>
            </tr>
            <tr>
                <th>Penalty</th>
                <td>{{ $bookingI->checkout->total_penalty }} /-<</td>
            </tr>
            <tr>
                <th>Total Paid</th>
                <td>{{ $bookingI->total_paid+$bookingI->checkout->total_penalty }} /-<</td>
            </tr>

        </table>
    </div>
    @endif



    <div class="footer">
      Thank you for your payment!<br/>
      This receipt was generated electronically.
    </div>
  </div>
</body>
</html>
