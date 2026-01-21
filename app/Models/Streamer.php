<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Streamer extends Model
{
    use HasFactory;

    protected $fillable = [
        'tenant_id',
        'station_id',
        'name',
        'handle',
        'status',
        'bio',
        'last_seen_at',
    ];

    protected $casts = [
        'last_seen_at' => 'datetime',
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function station()
    {
        return $this->belongsTo(Station::class);
    }

    public function sessions()
    {
        return $this->hasMany(StreamSession::class);
    }
}
