<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ListController extends Controller
{
    public function list()
    {
        // $search = $request['search'] ?? "";

        // if ($search != "") {
        //     //where
        //     $users = User::where('name', 'LIKE', "%$search%")
        //         ->orWhere('email', 'LIKE', "%$search%")
        //         ->get();

        //     // if(!$users){

        //     $country = DB::table('countries')
        //         ->where('name', 'LIKE', "%$search%")
        //         ->first();

        //     if ($country) {
        //         $users = User::where('countries', 'LIKE', "$country->id")->get();
        //     }

        //     $state = DB::table('states')
        //         ->where('name', 'LIKE', "%$search%")
        //         ->first();

        //     if ($state) {
        //         $users = User::where('states', 'LIKE', $state->id)->get();
        //     }

        //     $city = DB::table('cities')
        //         ->where('name', 'LIKE', "%$search%")
        //         ->first();

        //     if ($city) {
        //         $users = User::where('cities', 'LIKE', $city->id)->get();
        //     }

        // }
        // } else {
        $users = User::all();
        // }
        return view('frontend.list', compact('users'));
    }


    public function pdf()
    {
        // return view("frontend.list");

        $users = User::all();

        return view('frontend.pdf', compact('users'));
    }

    public function searchSuggestions(Request $request)
    {
        $search = $request->input('query');
        $suggestions = [];

        if ($search != "") {
            // $users = User::where('name', 'LIKE', "%$search%")
            //     ->orWhere('email', 'LIKE', "%$search%")
            //     ->get();

            //     $users = User::with('Country', function($query) use ($search) {
            //         $query->where('name', 'LIKE', '%' . $search . '%');
            //    })->get();


            // $country = Country::where('name', 'LIKE', "%$search%")
            // ->get();

            // if ($country) {
            // $users = User::where('countries', 'LIKE', "$country->id")->first();
            // }

            $users = User::with(['Country', 'State', 'City'])
                ->where('name', 'LIKE', "%$search%")
                ->orWhere('email', 'LIKE', "%$search%")
                // ->orWhereHas('Country', function ($query) use ($search) {
                //     $query->where('name', 'LIKE', "%$search%");
                // })
                // ->orWhereHas('State', function ($query) use ($search) {
                //     $query->where('name', 'LIKE', "%$search%");
                // })
                // ->orWhereHas('City', function ($query) use ($search) {
                //     $query->where('name', 'LIKE', "%$search%");
                // })
                ->get();


            foreach ($users as $user) {

                $country = DB::table('countries')
                    ->where('id', $user->countries)
                    ->first();

                $state = DB::table('states')
                    ->where('id', $user->states)
                    ->first();

                $cities = DB::table('cities')
                    ->where('id', $user->cities)
                    ->first();

                // $profiles = DB::table('profiles')
                //     ->where('user_id', $user->id)
                //     ->get();

                $suggestions[] = [
                    'name' => $user->name,
                    'email' => $user->email,
                    'countries' => $country->name ?? '',
                    'states' => $state->name ?? '',
                    'cities' => $cities->name ?? '',
                    'hobbies' => $user->hobbies,
                    'gender' => $user->gender,
                    'date_of_birth' => $user->date_of_birth,
                    'type' => $user->type,
                    // 'profiles' => $profiles,
                    'status' => $user->status,
                ];
            }
        }

        return response()->json($suggestions);
    }
}
