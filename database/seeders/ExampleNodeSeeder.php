<?php

namespace Database\Seeders;

use App\Models\Node;
use Illuminate\Database\Seeder;

class ExampleNodeSeeder extends Seeder
{
    public function run(): void
    {
        Node::firstOrCreate(
            ['name' => 'Local Node'],
            [
                'base_url' => env('NODE_AGENT_URL', 'http://localhost:9001'),
                'shared_secret' => env('NODE_AGENT_SECRET', 'local-secret'),
                'capacity_stations' => 200,
                'capacity_listeners' => 5000,
                'status' => 'active',
            ]
        );
    }
}
