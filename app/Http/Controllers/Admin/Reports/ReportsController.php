<?php

namespace App\Http\Controllers\Admin\Reports;

use App\Http\Controllers\Controller;
use App\Models\Admin\Booking;
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
                // ->select('room.room_number')
                ->get();
// dd($type);
        $reports = $booked;
        return view('backend.blade.reports.seat_wise_booking_report',compact('reports'));
    }
}
