<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

class UserlogoutController extends Controller
{
    public function userlogout()
    {
        return view("frontend.userlogout");
    }
}
