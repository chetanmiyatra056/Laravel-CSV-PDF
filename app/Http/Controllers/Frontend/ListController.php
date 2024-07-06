<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ListController extends Controller
{
    public function list(Request $request)
    {
        $search = $request['search'] ?? "";

        if ($search != "") {
            //where
            $users = User::where('name', 'LIKE', "%$search%")
                ->orWhere('email', 'LIKE', "%$search%")
                ->get();

            // if(!$users){

            $country = DB::table('countries')
                ->where('name', 'LIKE', "%$search%")
                ->first();

            if ($country) {
                $users = User::where('countries', 'LIKE', "$country->id")->get();
            }

            $state = DB::table('states')
                ->where('name', 'LIKE', "%$search%")
                ->first();

            if ($state) {
                $users = User::where('states', 'LIKE', $state->id)->get();
            }

            $city = DB::table('cities')
                ->where('name', 'LIKE', "%$search%")
                ->first();

            if ($city) {
                $users = User::where('cities', 'LIKE', $city->id)->get();
            }

            // }
        } else {
            $users = User::all();
        }
        return view('frontend.list', compact('users', 'search'));
    }


    public function pdf()
    {
        // return view("frontend.list");

        $users = User::all();

        return view('frontend.pdf', compact('users'));
    }
}
