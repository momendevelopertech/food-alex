<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class localization
{
    public function handle(Request $request, Closure $next)
    {
        $local = ($request->hasHeader('x-localization')) ? $request->header('x-localization') : ($request->cookie('locale') ?? 'ar');
        App::setLocale($local);
        return $next($request);
    }
}
