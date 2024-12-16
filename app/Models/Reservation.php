<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Reservation extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'reservations';

    protected $casts = [
        'arrival_date' => 'datetime',
    ];
    
    protected $fillable = [
        'arrival_date',
        'depart_date',
        'nights_num',
        'guestAdultCount',
        'guestChildrenCount',
        'guestBabyCount',
        'guestPets',
        'total_cost',
        'ad_id',
        'user_id',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ad()
    {
        return $this->belongsTo(Ad::class);
    }

    public function getArrivalDateAttribute($value)
    {
        return Carbon::parse($value);
    }

    public function getDepartDateAttribute($value)
    {
        return Carbon::parse($value);
    }
}
