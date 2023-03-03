<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class NoTechnicians
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->user()->title_id == 10 || $request->user()->title_id == 11) {
            return redirect()->route('technician_page');
        }
        return $next($request);
    }
}
