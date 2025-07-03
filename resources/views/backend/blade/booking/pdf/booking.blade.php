<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Hostel Seat Booking Invoice</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            color: #333;
            line-height: 1.6;
            padding: 20px;
            font-size: 11px;
        }
        .invoice-box {
            max-width: 700px;
            margin: auto;
            border: 1px solid #eee;
            padding: 30px;
            box-shadow: 0 0 10px rgba(0,0,0,.15);
        }
        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #2c3e50;
        }
        .details, .footer {
            margin-top: 20px;
        }
        .details table {
            width: 100%;
        }
        .details td {
            padding: 8px 5px;
        }
        .details td.label {
            font-weight: bold;
            width: 40%;
        }
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 14px;
            color: #888;
        }
        .signature {
            margin-top: 60px;
            text-align: right;
            padding-right: 50px;
        }
        .signature p {
            margin-top: 50px;
            border-top: 1px solid #000;
            display: inline-block;
            padding-top: 5px;
        }
    </style>
</head>
<body>
    <div class="invoice-box">
        <h2>Budhdhijibi Hostel Booking Invoice</h2>

        <div class="details">
            <table>
                <tr>
                    <td class="label">Invoice ID:</td>
                    <td>#{{ str_pad( $bookingI->id, 6, '0', STR_PAD_LEFT); }}</td>
                </tr>
                <tr>
                    <td class="label">Bookig Person :</td>
                    <td>{{ $bookingI->bookingperson->booking_person_name }}</td>
                </tr>
                 <tr>
                    <td class="label">Bookig Person :</td>
                    <td>{{ $bookingI->bookingperson->booking_phone_number }}</td>
                </tr>
                 <tr>
                    <td class="label">Bookig Person :</td>
                    <td>{{ $bookingI->bookingperson->booking_person_address }}</td>
                </tr>
                @php
                    $bookingData = \App\Models\Admin\Booking::with('hostel','room')->where('id',$bookingI->booking->first()->id)->first();
                    // dd($bookingData);
                @endphp
                <tr>
                    <td class="label">Hostel Name:</td>
                    <td>{{ $bookingData->hostel->hostel_name }}</td>
                </tr>
                <tr>
                    <td class="label">Building:</td>
                    <td>{{ $bookingData->building?$bookingData->building->building_number:'N/A' }}</td>
                </tr>
                <tr>
                    <td class="label">Block:</td>
                    <td>{{  $bookingData->seat->block }}</td>
                </tr>
                <tr>
                    <td class="label">Floor:</td>
                    <td>{{  $bookingData->floor }} Floor</td>
                </tr>
                <tr>
                    <td class="label">Room Number:</td>
                    <td>{{ $bookingData->room->room_number }}</td>
                </tr>
                <tr>
                    <td class="label">Seat Number:</td>
                    <td>
                        @foreach ($bookingI->booking as $key=>$value)
                            @php
                                $ss = App\Models\Admin\Seat::where('id',$value->seat_id)->first()
                            @endphp
                            {{ $ss->seat_number." " }} &nbsp;&nbsp;
                        @endforeach
                    </td>
                </tr>
                <tr>
                    <td class="label">Booking Date:</td>
                    <td>{{ date('d M , Y',strtotime($bookingI->booking_start_date)) }}</td>
                </tr>
                <tr>
                    <td class="label">Total Fee:</td>
                    <td> BDT {{ $bookingI->seat_price+$bookingData->seat_service_charge }}</td>
                </tr>
                <tr>
                    <td class="label">Discount:</td>
                    <td> BDT {{ $bookingI->discount }}</td>
                </tr>
                <tr>
                    <td class="label">Payable :</td>
                    <td> BDT {{ $bookingI->total_payable }}</td>
                </tr>
                <tr>
                    <td class="label">Paid :</td>
                    <td> BDT {{ $bookingI->total_paid }}</td>
                </tr>
                <tr>
                    <td class="label">Due :</td>
                    <td> BDT {{ $bookingI->total_due }}</td>
                </tr>
            </table>
        </div>

        <div class="signature">
            <p>Authorized Signature</p>
        </div>

        <div class="footer">
            Thank you for booking with us!<br>
            This is a system-generated invoice.
        </div>
    </div>
</body>
</html>
