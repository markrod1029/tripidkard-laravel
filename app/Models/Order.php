<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    /** @use HasFactory<\Database\Factories\OrderFactory> */
    use HasFactory;
    protected $guarded = [];

     // Relationship with User
     public function user()
     {
         return $this->belongsTo(User::class);
     }

     // Relationship with Merchant (through User)
     public function merchant()
     {
         return $this->belongsToThrough(Merchant::class, User::class);
     }


}

