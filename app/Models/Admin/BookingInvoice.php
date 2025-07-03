<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class BookingInvoice extends Model
{
    public function booking(){
        return $this->hasMany(Booking::class,'invoice_id','id');
    }

    public function bookingperson(){
        return $this->belongsTo(BookingPerson::class,'booking_person','id');
    }
}
