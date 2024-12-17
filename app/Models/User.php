<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, HasRoles;

    protected $table = 'users';
    protected $guarded = false;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // public function isAdmin()
    // {
    //     return $this->role === 'admin';
    // }

    public function chats(): BelongsToMany
    {
        return $this->belongsToMany(Chat::class, 'chat_user');
    }

    public function isPartOfChat($chatId)
    {
        return $this->chats()->where('id', $chatId)->exists();
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public static function getList()
    {
        return self::select('id', 'email')->get();  
    }
}
