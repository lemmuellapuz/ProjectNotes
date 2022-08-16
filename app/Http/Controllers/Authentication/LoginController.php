<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Authentication\LoginRequest;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index() {
        return view('contents.authentication.login');
    }

    public function signIn(LoginRequest $request) {

        if(Auth::attempt($request->validated())) {
            return 'Signed in';
        }

        return redirect()->back()->with('error', 'Invalid Credentials.');

    }
}
