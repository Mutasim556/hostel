<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\BookingInvoice;
use App\Models\Admin\Otp;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OtpController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(string $type,string $id=null)
    {

        if($type=='booking_cancellation'){
            $invoice = BookingInvoice::with('bookingperson')->where('id',$id)->first();
            $otpd = rand(100000,999999);
            $check = Otp::where([['otp_type','booking_cancellation'],['receiver_number',$invoice->bookingperson->booking_phone_number],['otp_end_time','>',Carbon::now()]])->first();
            if(!$check){
                $otp = new Otp();
                $otp->otp = $otpd;
                $otp->otp_type = $type;
                $otp->receiver_number = $invoice->bookingperson->booking_phone_number;
                $otp->otp_end_time = Carbon::now()->addMinutes(5);
                $otp->save();
                return $otp->otp;
            }else{
                $now = Carbon::now();
                return response([
                    'message'=>'You can send otp again after '.ceil($now->diffInMinutes($check->otp_end_time,false))." minutes",
                ],404);
            }
        }
    }
}
