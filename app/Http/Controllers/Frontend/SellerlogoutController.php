<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

class SellerlogoutController extends Controller
{
    public function sellerlogout()
    {
        return view("frontend.sellerlogout");
    }
}
