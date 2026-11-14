<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Company;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class WhopWebhookController extends Controller
{
    public function handle(Request $request)
    {
        $signature = $request->header('X-Whop-Signature');
        if ($signature !== config('services.whop.webhook_secret')) {
            return response()->json(['error' => 'Invalid signature'], 403);
        }

        $payload = $request->all();
        $event = $payload['action'] ?? ''; // Whop uses 'action' or 'event_type'

        // 1. Log the attempt so you can debug in storage/logs/laravel.log
        Log::info('Whop Webhook Received', ['event' => $event]);

        // 2. Only handle successful payments/memberships
        if ($event === 'membership.went_active' || $event === 'payment.succeeded') {
            
            $email = $payload['data']['email'] ?? null;
            
            if ($email) {
                $user = User::where('email', $email)->first();

                if ($user) {
                    // Create a new Company for them if they don't have one
                    if (!$user->company_id) {
                        $company = Company::create([
                            'name' => $user->name . "'s Org",
                        ]);
                        $user->company_id = $company->id;
                    }

                    // Activate subscription
                    $user->is_active = true;
                    // Set end date to 31 days from now
                    $user->subscription_end_date = Carbon::now()->addDays(31);
                    $user->save();

                    return response()->json(['message' => 'User activated'], 200);
                }
            }
        }

        return response()->json(['message' => 'Event ignored'], 200);
    }
}
