<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Convenience extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'conveniences';
    
    protected $fillable = [
        'name',
        'ad_id',
    ];

    public function ad()
    {
        return $this->belongsTo(Ad::class, 'ad_id');
    }
}
