<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ListController extends Controller
{
    public function list()
    {
        // return view("frontend.list");

        $users = User::all();

        return view('frontend.list', compact('users'));
    }
    public function pdf()
    {
        // return view("frontend.list");

        $users = User::all();

        return view('frontend.pdf', compact('users'));
    }
}
