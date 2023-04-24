<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

class SanctumAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */

    // Todo need to fix request to take Auth token
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->session()->has('u-token')) {

            $req = Request::create('/api/auth/check', 'POST');
            $req->headers->set('Authorization', 'Bearer '.$request->session()->get('u-token'));
            $req->headers->set('Accept', 'application/json');

            $response = Route::dispatch($req)->getOriginalContent();

            if (!empty($response['message']) && $response['message'] === 'Unauthenticated.') {
                session()->invalidate();

                return redirect('login');
            }

            return $next($request);
        }

        return back();
    }
}
