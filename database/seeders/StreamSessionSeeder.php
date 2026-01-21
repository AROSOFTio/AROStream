<?php

namespace Database\Seeders;

use App\Models\Station;
use App\Models\StreamSession;
use App\Models\Streamer;
use Illuminate\Database\Seeder;

class StreamSessionSeeder extends Seeder
{
    public function run(): void
    {
        $stations = Station::all();
        if ($stations->isEmpty()) {
            return;
        }

        $streamers = Streamer::all();

        foreach ($stations as $index => $station) {
            $streamer = $streamers[$index % max(1, $streamers->count())] ?? null;
            $listenersPeak = rand(120, 1400);
            $listenersAvg = (int) ($listenersPeak * 0.6);

            StreamSession::create([
                'station_id' => $station->id,
                'streamer_id' => $streamer?->id,
                'status' => $index % 2 === 0 ? 'live' : 'ended',
                'started_at' => now()->subHours(rand(1, 6)),
                'ended_at' => $index % 2 === 0 ? null : now()->subMinutes(rand(10, 90)),
                'listeners_current' => $index % 2 === 0 ? rand(80, $listenersPeak) : 0,
                'listeners_peak' => $listenersPeak,
                'listeners_avg' => $listenersAvg,
                'bitrate_kbps' => rand(96, 192),
                'metadata' => [
                    'mount' => $station->mount_normal ?? '/live',
                    'genre' => $index % 2 === 0 ? 'Electronic' : 'Talk',
                    'now_playing' => $index % 2 === 0 ? 'Midnight Signal' : 'Morning Update',
                ],
            ]);
        }
    }
}
