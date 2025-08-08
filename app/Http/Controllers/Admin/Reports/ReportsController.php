<?php

namespace App\Http\Controllers\Admin\Reports;

use App\Http\Controllers\Controller;
use App\Models\Admin\Booking;
use App\Models\Admin\CancelBooking;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
    public function seatWiseBooking(){
        $start_date = isset(request()->start_date)?request()->start_date:date('Y-m-d');
        $end_date = isset(request()->end_date)?request()->end_date:date('Y-m-d');
        // dd($end_date);
        $room = isset(request()->room)?request()->room:'All';
        $type = isset(request()->booking_type)?request()->booking_type:'All';

        $booked = Booking::with('invoice','seat','room')
                ->when(isset(request()->start_date),function($query)use($start_date){
                    return $query->whereDate('created_at','>=',$start_date);
                })
                ->when(isset(request()->end_date),function($query)use($end_date){
                    return $query->whereDate('created_at','<=',$end_date);
                })
                ->when($room!='All',function($query)use($room){
                    return $query->where('room_id',$room);
                })
                ->when($type!='All',function($query)use($room,$type){
                    return $query->whereHas('invoice',function($q)use($type){
                        $q->where('service_id',$type);
                    });
                })
                ->get();
        $reports = $booked;
        return view('backend.blade.reports.seat_wise_booking_report',compact('reports'));
    }


    public function cancelRefund(){
        $start_date = isset(request()->start_date)?request()->start_date:'';
        $end_date = isset(request()->end_date)?request()->end_date:'';
        // dd($end_date);
        $room = isset(request()->room)?request()->room:'All';
        $type = isset(request()->booking_type)?request()->booking_type:'All';
        $cBooking = CancelBooking::with('invoice','invoice.bookings')
                    ->whereHas('invoice',function($query)use($start_date,$end_date,$type){
                        return $query->when($start_date!='',function($q)use($start_date){
                            return $q->whereDate('cancel_date','>=',$start_date);
                        })->when($end_date!='',function($q)use($end_date){
                            return $q->whereDate('cancel_date','<=',$end_date);
                        })
                        ->when($type!='All',function($q)use($type){
                            return $q->where('service_id',$type);
                        });
                    })
                    ->whereHas('invoice.bookings',function($query)use($room){
                        return $query->when($room!='All',function($q)use($room){
                            return $q->where('room_id',$room);
                        });
                    })
                    ->get();
        // dd($cBooking);
        return view('backend.blade.reports.cancel_refund_report',compact('cBooking'));
    }
}
