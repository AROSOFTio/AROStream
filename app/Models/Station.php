<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Station extends Model
{
    use HasFactory;

    public const STATUS_PROVISIONING = 'provisioning';
    public const STATUS_ACTIVE = 'active';
    public const STATUS_SUSPENDED = 'suspended';
    public const STATUS_ERRORED = 'errored';

    protected $fillable = [
        'tenant_id',
        'node_id',
        'name',
        'slug',
        'station_key',
        'status',
        'plan',
        'source_password',
        'admin_password',
        'mount_low',
        'mount_normal',
        'bitrate_low',
        'bitrate_normal',
        'container_id',
        'internal_port',
        'status_url',
        'public_stream_base',
        'last_provisioned_at',
        'frequency',
        'branding_primary_color',
        'branding_secondary_color',
        'branding_logo_url',
        'branding_slogan',
    ];

    protected $casts = [
        'last_provisioned_at' => 'datetime',
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function node()
    {
        return $this->belongsTo(Node::class);
    }

    public function domains()
    {
        return $this->hasMany(Domain::class);
    }

    public function subscription()
    {
        return $this->hasOne(Subscription::class);
    }

    public function healthSnapshots()
    {
        return $this->hasMany(StationHealthSnapshot::class);
    }

    public function streamers()
    {
        return $this->hasMany(Streamer::class);
    }

    public function streamSessions()
    {
        return $this->hasMany(StreamSession::class);
    }
}
