<?php

namespace App\Http\Middleware;

use Closure;
use App\Website;

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
        
        if ($this->isWebsiteDefined($request->website)) {
            return redirect('/home');
        }

        return $next($request);
    }

    /**
     * @param $website
     * @return bool
     */
    protected function isWebsiteDefined($website): bool
    {
        if (is_null($website)){
            return true;
        }

        return $this->isNotOwns($this->getInstaceWebsite($website));
    }

    /**
     * @param $website
     * @return \App\Models\Website
     */
    protected function getInstaceWebsite($website)
    {
        if ($website instanceof Website) {
            return $website;
        }
        
        return Website::where('username', $website)->firstOrFail();
    }

    protected function isNotOwns(Website $website): bool
    {
        return !auth()->user()->owns($website);
    }
}
