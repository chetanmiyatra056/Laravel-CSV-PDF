<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

class SellerController extends Controller
{
    public function seller()
    {
        return view("frontend.seller");
    }
}
