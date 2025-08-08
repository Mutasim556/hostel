<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    public function hostel(){
        return $this->belongsTo(Hostel::class,'hostel_id','id');
    }

    public function room(){
        return $this->belongsTo(Room::class,'room_id','id');
    }

    public function building(){
        return $this->belongsTo(HostelBuilding::class,'building_id','id');
    }

    public function seat(){
        return $this->belongsTo(Seat::class,'seat_id','id');
    }

    public function invoice()
    {
        return $this->belongsTo(BookingInvoice::class, 'invoice_id', 'id');
    }

    public function bookingPayment()
    {
        return $this->belongsTo(BookingPayment::class, 'invoice_id', 'invoice_id');
    }

    public function bookings(){
        return $this->hasMany(Booking::class,'invoice_id','id');
    }
}
