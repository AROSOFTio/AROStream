<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StationHealthSnapshot extends Model
{
    use HasFactory;

    protected $fillable = [
        'station_id',
        'online',
        'listeners',
        'mount',
        'raw',
        'checked_at',
    ];

    protected $casts = [
        'online' => 'boolean',
        'checked_at' => 'datetime',
        'raw' => 'array',
    ];

    public function station()
    {
        return $this->belongsTo(Station::class);
    }
}
