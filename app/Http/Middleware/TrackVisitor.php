<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Visitor;
use Jenssegers\Agent\Agent;
use Carbon\Carbon;

class TrackVisitor
{
    public function handle(Request $request, Closure $next)
    {
        $agent = new Agent();
        $currentTime = now();

       

        // Check if session is new or expired
        $lastVisit = $request->session()->get('last_visit');
        $sessionExpired = !$lastVisit || $currentTime->diffInSeconds(Carbon::createFromTimestamp($lastVisit)) > 60;

        // If no visitor record or session is new/expired
        if ( $sessionExpired) {
            $os = $agent->platform();
            $osVersion = $agent->version($os);
            $system = $os . ' ' . $osVersion;

            // Create a new visitor record
            Visitor::create([
                'ip_address' => $request->ip(),
                'browser' => $agent->browser(),
                'device' => $agent->device(),
                'os' => $system,
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
            ]);

            // Update the session last visit timestamp
            $request->session()->put('last_visit', $currentTime->timestamp);
        }

        return $next($request);
    }
}
