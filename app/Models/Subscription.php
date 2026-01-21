<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'station_id',
        'plan',
        'starts_at',
        'renews_at',
        'status',
        'last_payment_reference',
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'renews_at' => 'datetime',
    ];

    public function station()
    {
        return $this->belongsTo(Station::class);
    }
}
