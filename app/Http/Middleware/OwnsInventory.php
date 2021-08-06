<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\Request;

class OwnsInventory
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $inventory = $request->route('inventory');
        if (Auth::user()->owns($inventory)) {
            return $next($request);
        }

        return response([], 403);
    }
}
