<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

class SanctumAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!empty(session()->get('u-token'))) {

            // todo need to fix that this request checks set token and return if that token is valid.
            // todo Currntly not working request
//            $req = Request::create('/api/user', 'GET');
//            $req->headers->set('Authorization', 'Bearer '.session()->get('u-token'));
//            $req->headers->set('Accept', 'application/json');
//
//
//            dd($req);
//
//            $response = Route::dispatch($req);
//            var_dump(auth('sanctum')->check());
//            var_dump($req->headers);
//            dd($response);
//
//            if (!empty($response['message']) && $response['message'] === 'Unauthenticated.') {
//                session()->invalidate();
//
//                return redirect('login');
//            }

            return $next($request);
        }

        return back();
    }
}
