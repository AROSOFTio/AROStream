<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Station;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProvisioningWebhookController extends Controller
{
    public function __invoke(Request $request)
    {
        $payload = $request->validate([
            'station_key' => 'required|string',
            'status_url' => 'nullable|url',
            'public_stream_base' => 'nullable|url',
            'status' => 'nullable|string',
        ]);

        $station = Station::where('station_key', $payload['station_key'])->first();

        if (!$station) {
            return response()->json(['message' => 'Station not found'], 404);
        }

        $station->update([
            'status_url' => $payload['status_url'] ?? $station->status_url,
            'public_stream_base' => $payload['public_stream_base'] ?? $station->public_stream_base,
            'status' => $payload['status'] ?? $station->status,
        ]);

        Log::info('Provisioning webhook processed', ['station' => $station->id]);

        return response()->json(['ok' => true]);
    }
}
