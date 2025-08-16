<?php

namespace App\Http\Controllers\Admin\Reports;

use App\Http\Controllers\Controller;
use App\Models\Admin\Booking;
use App\Models\Admin\BookingInvoice;
use App\Models\Admin\BookingPayment;
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


    public function dueCollections(){
        $bookingPayments = BookingPayment::with('invoice','createdBy')
                            ->where([['pay_amount','!=',0]])
                            ->when(request()->start_date,function($q){
                                return $q->whereDate('payment_date','>=',request()->start_date);
                            })
                            ->when(request()->end_date,function($q){
                                return $q->whereDate('payment_date','<=',request()->end_date);
                            })
                            ->when(request()->invoice_id,function($q){
                                return $q->whereHas('invoice',function($query){
                                    return $query->where('id',request()->invoice_id);
                                });
                            })
                            ->when(request()->phone,function($q){
                                return $q->whereHas('invoice',function($query){
                                    return $query->whereHas('bookingperson',function($qq){
                                        return $qq->where('booking_phone_number',request()->phone);
                                    });
                                });
                            })
                            ->when(request()->service,function($q){
                                return $q->whereHas('invoice',function($query){
                                    return $query->where('service_id',request()->service);
                                });
                            })
                            ->when(request()->user,function($q){
                                return $q->where('created_by',request()->user);
                            })
                            ->when((!request()->user&&!request()->start_date&&!request()->end_date&&!request()->invoice_id&&!request()->phone&&!request()->service),function($q){
                                $q->limit(50);
                            })
                           ->get();
        return view('backend.blade.reports.due_collection',compact('bookingPayments'));
    }

    public function invoiceDueList(){
        $invoices = BookingInvoice::with(['bookingperson','createuser'])
                    ->when(request()->start_date,function($q){
                        return $q->whereDate('created_at','>=',request()->start_date);
                    })
                    ->when(request()->end_date,function($q){
                        return $q->whereDate('created_at','<=',request()->end_date);
                    })
                    ->when(request()->invoice_id,function($q){
                        return $q->where('id',request()->invoice_id);
                    })
                    ->when(request()->phone,function($q){
                        return $q->whereHas('bookingperson',function($qq){
                            return $qq->where('booking_phone_number',request()->phone);
                        });
                    })
                    ->when(request()->user,function($q){
                        return $q->where('created_by',request()->user);
                    })
                    ->where([['checkeout_status',0],['cancel_status',0]])
                    ->get();
        return view('backend.blade.reports.invoice_due_list',compact('invoices'));
    }
}
