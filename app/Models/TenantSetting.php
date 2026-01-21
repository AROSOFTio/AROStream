<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TenantSetting extends Model
{
    protected $fillable = [
        'tenant_id',
        'station_name_default',
        'frequency_default',
        'primary_color',
        'secondary_color',
        'logo_url',
        'slogan',
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }
}
