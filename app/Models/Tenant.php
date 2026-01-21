<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'contact_name', 'contact_email', 'status'];

    public function stations()
    {
        return $this->hasMany(Station::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function streamers()
    {
        return $this->hasMany(Streamer::class);
    }

    public function setting()
    {
        return $this->hasOne(TenantSetting::class);
    }
}
