<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocaleForAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        app()->setLocale('ro');

        return $next($request);
    }
}
