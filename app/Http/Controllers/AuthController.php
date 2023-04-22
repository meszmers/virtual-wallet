<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// todo need to implement correct auth handling from api: Not working corectly
class AuthController
{
    private string $authApi = "http://localhost/api/auth/";

    public function login(Request $request)
    {
        $request = Request::create($this->authApi.'login', 'POST', $request->all());

        $response = Route::dispatch($request)->getOriginalContent();


        if (!empty($response['token']) && !empty($response['user'])) {
            session(['u-token' => $response['token']]);

            return redirect('/dashboard');
        } elseif (!empty($response['message'])) {
            return back()->withErrors(['msg' => $response['message']]);
        }

        return back();
    }

    public function logout()
    {
        $request = Request::create($this->authApi.'logout', 'POST');
        $request->headers->set('Authorization', 'Bearer '.session()->get('u-token'));
        $request->headers->set('Accept', 'application/json');

        $response = Route::dispatch($request)->getOriginalContent();

        if (!empty($response['message']) && $response['message'] === 'Logged out') {
            session()->invalidate();
        } else {
            return back();
        }

        return redirect('/login');
    }

    // todo implement register handling
    public function register() {

    }
}
