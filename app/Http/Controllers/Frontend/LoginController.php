<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login()
    {
        return view("frontend.login");
    }

    public function postlogin(Request $request)
    {
        // print_r($request->all());

        $credentials =  $request->validate([
            'email' => 'string|required|regex:/(.+)@(.+)\.(.+)/i',
            'type' => 'required',
            'password' => 'string|required|min:4|max:8',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->put("email", $request->input("email"));

            if ($request->input("type") == "seller") {
                return redirect()->route('seller')->withSuccess('You have successfully logged in!');
            } else {
                return redirect()->route('welcome')->withSuccess('You have successfully logged in!');
            }
        } else {
            return redirect()->intended('login')->with('error', 'Not loggin! check username, type and password');
        }
    }
}
