<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! auth()->check()) {
            return redirect()->route('login');
        }

        if (auth()->user()->user_type !== User::TYPE_ADMIN) {
            abort(403, 'Esta operação é reservada ao administrador.');
        }

        return $next($request);
    }
}
