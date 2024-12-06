<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reservation extends Model
{
    use HasFactory;
    use SoftDeletes;

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

    public function getStartDateAttribute($value)
    {
        return \Carbon\Carbon::parse($value);
    }

    public function getEndDateAttribute($value)
    {
        return \Carbon\Carbon::parse($value);
    }
}
