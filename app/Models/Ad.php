<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ad extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'ads';
    protected $fillable = [
        'title',
        'description',
        'prem_type',
        'accom_type',
        'guest_count',
        'price',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function conveniences()
    {
        return $this->hasMany(Convenience::class, 'ad_id');
    }

    public function materials()
    {
        return $this->hasMany(Material::class, 'ad_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
