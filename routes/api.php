<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WhopWebhookController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
| Your Whop Webhook will hit this endpoint.
*/

Route::post('/webhooks/whop', [WhopWebhookController::class, 'handle']);