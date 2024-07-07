<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LogoutController extends Controller
{
    public function logout(Request $request)
    {
        // Session::flush();
        // $request->session()->flush();
        Auth::logout();
        // session_unset();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('You have logged out successfully!');
    }
}
