<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ListController extends Controller
{
    // public function list(Request $request)
    // {
    //     $search = $request['search'] ?? "";

    //     if ($search != "") {
    //         //where
    //         $users = User::where('name', 'LIKE', "%$search%")
    //             ->orWhere('email', 'LIKE', "%$search%")
    //             ->get();

    //         // if(!$users){

    // $country = DB::table('countries')
    //     ->where('name', 'LIKE', "%$search%")
    //     ->first();

    // if ($country) {
    //     $users = User::where('countries', 'LIKE', "$country->id")->get();
    // }

    // $state = DB::table('states')
    //     ->where('name', 'LIKE', "%$search%")
    //     ->first();

    // if ($state) {
    //     $users = User::where('states', 'LIKE', $state->id)->get();
    // }

    // $city = DB::table('cities')
    //     ->where('name', 'LIKE', "%$search%")
    //     ->first();

    // if ($city) {
    //     $users = User::where('cities', 'LIKE', $city->id)->get();
    // }

    // }
    //     } else {
    //         $users = User::all();
    //     }
    //     return view('frontend.list', compact('users', 'search'));
    // }

    public function list(Request $request)
    {
        $search = $request->input('search', '');

        if ($search != "") {
            // Initial query to search users by name or email
            $users = User::where('name', 'LIKE', "%$search%")
                ->orWhere('email', 'LIKE', "%$search%")
                ->get();

            // Search for country
            $country = DB::table('countries')
                ->where('name', 'LIKE', "%$search%")
                ->first();

            if ($country) {
                $users = $users->merge(User::where('countries', $country->id)->get());
            }

            // Search for state
            $state = DB::table('states')
                ->where('name', 'LIKE', "%$search%")
                ->first();

            if ($state) {
                $users = $users->merge(User::where('states', $state->id)->get());
            }

            // Search for city
            $city = DB::table('cities')
                ->where('name', 'LIKE', "%$search%")
                ->first();

            if ($city) {
                $users = $users->merge(User::where('cities', $city->id)->get());
            }
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

    public function searchSuggestions(Request $request)
    {
        $search = $request->input('query');
        $suggestions = [];

        if ($search != "") {
            $users = User::where('name', 'LIKE', "%$search%")
                ->orWhere('email', 'LIKE', "%$search%")
                ->get();

            // $users = User::with(['countries', 'states', 'cities'])
            //     ->where('name', 'LIKE', "%$search%")
            //     ->orWhere('email', 'LIKE', "%$search%")
            // ->orWhereHas('countries', function ($query) use ($search) {
            //     $query->where('name', 'LIKE', "%$search%");
            // })
            // ->orWhereHas('states', function ($query) use ($search) {
            //     $query->where('name', 'LIKE', "%$search%");
            // })
            // ->orWhereHas('cities', function ($query) use ($search) {
            //     $query->where('name', 'LIKE', "%$search%");
            // })
            // ->get();


            foreach ($users as $user) {

                // $country = DB::table('countries')
                //     ->where('id', $user->countries)
                //     ->first();

                // $state = DB::table('states')
                //     ->where('id', $user->states)
                //     ->first();

                // $cities = DB::table('cities')
                //     ->where('id', $user->cities)
                //     ->first();

                $suggestions[] = [
                    'name' => $user->name,
                    'email' => $user->email,
                    'countries' => $user->countries ?? '',
                    'states' => $user->states ?? '',
                    'cities' => $user->cities ?? '',
                    'hobbies' => $user->hobbies,
                    'gender' => $user->gender,
                    'date_of_birth' => $user->date_of_birth,
                    'type' => $user->type,
                    // 'profiles' => $user->profiles,
                    'status' => $user->status,
                ];
            }
        }

        return response()->json($suggestions);
    }


}