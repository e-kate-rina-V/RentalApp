<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
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

    public function scopeFilterByPremType(Builder $query, ?string $premType): Builder
    {
        return $premType ? $query->where('prem_type', $premType) : $query;
    }

    public function scopeFilterByAccomType(Builder $query, ?string $accomType): Builder
    {
        return $accomType ? $query->where('accom_type', $accomType) : $query;
    }

    public function scopeFilterByPriceRange(Builder $query, ?float $priceRange): Builder
    {
        return $priceRange ? $query->where('price', '<=', $priceRange) : $query;
    }

    public function scopeFilterByGuestCount(Builder $query, ?int $guestCount): Builder
    {
        return $guestCount ? $query->where('guest_count', '>=', $guestCount) : $query;
    }

    public function scopeFilterByConveniences(Builder $query, ?array $conveniences): Builder
    {
        if ($conveniences) {
            foreach ($conveniences as $convenience => $value) {
                if ($value) {
                    $query->whereHas('conveniences', function ($q) use ($convenience) {
                        $q->where('name', $convenience);
                    });
                }
            }
        }

        return $query;
    }

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

    public static function getList()
    {
        return self::select('id', 'title', 'user_id')->get();  
    }
}
