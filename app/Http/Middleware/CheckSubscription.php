<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CheckSubscription
{
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();

        // 1. Check if user is active and has an end date
        // 2. Check if the current time has passed the end date
        if (!$user->is_active || ($user->subscription_end_date && Carbon::now()->gt($user->subscription_end_date))) {
            
            // Optional: Automatically deactivate them in the DB if expired
            if ($user->is_active) {
                $user->update(['is_active' => false]);
            }

            return redirect()->route('billing')->with('error', 'Your IntelliStock subscription has expired or is inactive.');
        }

        return $next($request);
    }
}
