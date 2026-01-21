<?php

use App\Http\Controllers\Api\ProvisioningWebhookController;
use App\Http\Controllers\Api\StationStatusController;
use Illuminate\Support\Facades\Route;

Route::get('/stations/{station}/status', StationStatusController::class);
Route::post('/internal/node-agent/callback', ProvisioningWebhookController::class);
