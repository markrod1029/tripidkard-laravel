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
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
class User extends Authenticatable
{
    use HasFactory, Notifiable, LogsActivity;

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
        'photo1',
        'photo2',
        'photo3',

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



    public function cardCodes()
    {
        return $this->hasOne(CardCode::class);
    }

    public function avatar(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $value ? asset(Storage::url($value)) : asset('/storage/img/logo.jpg')
        );
    }

    protected static $logName = 'user';

    protected static $logAttributes = [
        'fname',
        'mname',
        'lname',
        'contact',
        'email',
        'role',
        'status',
        // Add other attributes to log
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(static::$logAttributes)
            ->useLogName(static::$logName)
            ->setDescriptionForEvent(fn(string $eventName) => "{$eventName}");
    }
}
