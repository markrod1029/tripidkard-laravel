<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\CardCode;
use App\Models\Merchant;
use Illuminate\Support\Facades\Storage;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'fname',
        'mname',
        'lname',
        'contact',
        'email',
        'password',
        'role',
        'avatar',
        'status',

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }


    public function merchant()
    {
        return $this->hasOne(Merchant::class);
    }


    public function enterprise()
    {
        return $this->hasOne(Enterprise::class);
    }


    public function cardCodes()
    {
        return $this->hasOne(CardCode::class);
    }

    public function avatar(): Attribute
    {
        return Attribute::make(

        get: fn ($value) => asset(Storage::url($value) ?? 'noimage.png'),
        );
    }
}
