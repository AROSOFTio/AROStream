<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Node extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'base_url',
        'shared_secret',
        'capacity_stations',
        'capacity_listeners',
        'status',
    ];

    public function stations()
    {
        return $this->hasMany(Station::class);
    }
}
