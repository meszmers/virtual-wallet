<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

// todo need to implement correct auth handling from api: Not working corectly
class AuthController extends Controller
{
    private string $authApi = "http://localhost/api/auth/";

    public function login(Request $request)
    {
        $req = Request::create($this->authApi.'login', 'POST', $request->all());

        $response = Route::dispatch($req)->getOriginalContent();

        if (!empty($response['token']) && !empty($response['user'])) {
            $request->session()->put('u-token', $response['token']);

            return redirect('/dashboard');
        } elseif (!empty($response['message'])) {
            return back()->withErrors(['msg' => $response['message']]);
        }

        return back();
    }

    public function logout(Request $request)
    {
        $req = Request::create($this->authApi.'logout', 'POST');
        $req->headers->set('Authorization', 'Bearer '.session()->get('u-token'));
        $req->headers->set('Accept', 'application/json');

        $response = Route::dispatch($req)->getOriginalContent();

        if (!empty($response['message']) && $response['message'] === 'Logged out') {
            $request->session()->invalidate();

            return redirect('/login');
        } else {
            return back();
        }
    }

    public function register(Request $request) {

        $req = Request::create($this->authApi.'register', 'POST', $request->all());

        $response = Route::dispatch($req)->getOriginalContent();

        if (!empty($response['token']) && !empty($response['user'])) {
            $request->session()->put('u-token', $response['token']);

            return redirect('/dashboard');
        } elseif (!empty($response['message'])) {
            return back()->withErrors(['msg' => $response['message']]);
        }

        return back();
    }
}
