<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StreamSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'station_id',
        'streamer_id',
        'status',
        'started_at',
        'ended_at',
        'listeners_current',
        'listeners_peak',
        'listeners_avg',
        'bitrate_kbps',
        'metadata',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
        'metadata' => 'array',
    ];

    public function station()
    {
        return $this->belongsTo(Station::class);
    }

    public function streamer()
    {
        return $this->belongsTo(Streamer::class);
    }
}
