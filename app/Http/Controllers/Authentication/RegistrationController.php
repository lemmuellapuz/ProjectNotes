<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Authentication\RegistrationRequest;
use Illuminate\Http\Request;

use App\Models\User;

class RegistrationController extends Controller
{
    public function index() {
        return view('contents.authentication.registration');
    }

    public function signUp(RegistrationRequest $request) {
        
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return redirect()->route('login')->with('success', 'User registered successfully.');

    }
}
