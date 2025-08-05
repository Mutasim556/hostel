<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class BookingInvoice extends Model
{
    public function bookings()
    {
        return $this->hasMany(Booking::class, 'invoice_id', 'id');
    }
    public function service(){
        return $this->belongsTo(ServiceType::class, 'service_id', 'id');
    }
    public function bookingperson()
    {
        return $this->belongsTo(BookingPerson::class, 'booking_person', 'id');
    }

    // Get all rooms from bookings
    public function rooms()
    {
        return $this->hasManyThrough(
            Room::class,       // Final model
            Booking::class,    // Intermediate model
            'invoice_id',      // Foreign key on Booking (links to invoice)
            'id',              // Local key on Room (primary key)
            'id',              // Local key on BookingInvoice
            'room_id'          // Foreign key on Booking (points to Room)
        );
    }

    public function payments(){
        return $this->hasMany(BookingPayment::class,'invoice_id','id');
    }

    public function canceled(){
        return $this->hasOne(CancelBooking::class,'invoice_id','id');
    }
    public function checkout(){
        return $this->hasOne(Checkout::class,'invoice_id','id');
    }
    // public function service(){
    //     $this->belongsTo(ServiceType::class,'service_id','id');
    // }
}
