<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Domain extends Model
{
    use HasFactory;

    protected $fillable = [
        'station_id',
        'hostname',
        'type',
        'verification_token',
        'verified_at',
        'ssl_status',
    ];

    protected $casts = [
        'verified_at' => 'datetime',
    ];

    public function station()
    {
        return $this->belongsTo(Station::class);
    }

    public function isVerified(): bool
    {
        return (bool) $this->verified_at;
    }
}
