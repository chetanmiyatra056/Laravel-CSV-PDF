<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EditPasswordController extends Controller
{
    public function password()
    {
        return view("frontend.password");
    }

    public function upassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|min:4|max:8',
            'password' => 'required|min:4|max:8',
            'confirm_password' => 'required|same:password|min:4|max:8'
        ]);

        if (!Hash::check($request->current_password, auth()->user()->password)) {
            return back()->with("error", "Current password doesn't match!");
        }

        User::whereId(auth()->user()->id)->update([
            'password' => Hash::make($request->confirm_password)
        ]);

        return back()->with("success", "Password changed successfully!");
    }
}
