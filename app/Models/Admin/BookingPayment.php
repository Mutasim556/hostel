<?php

namespace App\Models\Admin;

use App\Models\Admin;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class BookingPayment extends Model
{
    protected function paymentDate(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Carbon::parse($value)->format('d M , Y') // or any format
        );
    }
    public function invoice(){
        return $this->belongsTo(BookingInvoice::class,'invoice_id','id');
    }

    public function createdBy(){
        return $this->belongsTo(Admin::class,'created_by','id');
    }

    public function bookings()
    {
        return $this->hasOne(Booking::class, 'invoice_id', 'invoice_id');
    }
}
