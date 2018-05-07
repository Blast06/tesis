<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Website;

class ClientMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (is_null($request->website) || $this->isNotOwns($request->website)) {
            return redirect('/home');
        }

        return $next($request);
    }
    
    private function isNotOwns(Website $website): bool
    {
        return !auth()->user()->owns($website);
    }
}
