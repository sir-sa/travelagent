<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory;

    protected $fillable = ['accommodation_id', 'user_id', 'start_date', 'end_date', 'rate'];

    public function accommodation()
    {
        return $this->belongsTo(Accommodation::class);
    }

    public function users()
    {
        return $this->belongsTo(User::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function isDateWithinContract($date)
    {
        return $date->between($this->start_date, $this->end_date);
    }
}
