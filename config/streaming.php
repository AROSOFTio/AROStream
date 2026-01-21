<?php

return [
    'station_default_domain_suffix' => env('STATION_DEFAULT_DOMAIN_SUFFIX', 'stream.arosoft.io'),
    'dns_verification_prefix' => '_arosoft-verify',
    'plans' => [
        'basic' => [
            'annual_price' => 500000,
            'max_listeners' => 300,
            'bitrates' => [48, 64],
        ],
        'standard' => [
            'annual_price' => 800000,
            'max_listeners' => 1000,
            'bitrates' => [48, 64, 96],
        ],
        'pro' => [
            'annual_price' => 1500000,
            'max_listeners' => 3000,
            'bitrates' => [48, 64, 96, 128],
        ],
    ],
    'health_check_cache_seconds' => 10,
    'icecast_status_path_default' => '/status-json.xsl',
    'node_agent' => [
        'timeout_connect_seconds' => 2,
        'timeout_total_seconds' => 8,
    ],
];
