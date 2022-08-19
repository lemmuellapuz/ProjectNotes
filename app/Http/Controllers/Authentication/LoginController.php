<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Authentication\LoginRequest;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index() {
        
        if(isset(Auth::user()->id)) return redirect()->route('notes.index');

        return view('contents.authentication.login');
    }

    public function signIn(LoginRequest $request) {

        if(Auth::attempt($request->validated())) {
            return redirect()->route('notes.index');
        }

        return redirect()->back()->with('error', 'Invalid Credentials.');

    }
}
