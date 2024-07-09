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
            // $countryId = DB::table('countries')
            //     ->where('name', 'LIKE', "%$search%")
            //     ->pluck('id');

            // $stateId = DB::table('states')
            //     ->where('name', 'LIKE', "%$search%")
            //     ->pluck('id');

            // $cityId = DB::table('cities')
            //     ->where('name', 'LIKE', "%$search%")
            //     ->pluck('id');

            // $users = User::where('name', 'LIKE', "%$search%")
            //     ->orWhere('email', 'LIKE', "%$search%")
            //     ->orWhereIn('countries', $countryId)
            //     ->orWhereIn('states', $stateId)
            //     ->orWhereIn('cities', $cityId)
            //     ->get();

            $users = DB::table('users')
                ->leftJoin('countries', 'users.countries', '=', 'countries.id')
                ->leftJoin('states', 'users.states', '=', 'states.id')
                ->leftJoin('cities', 'users.cities', '=', 'cities.id')
                ->where(function ($query) use ($search) {
                    $query->where('users.name', '=', "$search")
                        ->orWhere('users.email', 'LIKE', "%$search%")
                        ->orWhere('countries.name', 'LIKE', "%$search%")
                        ->orWhere('states.name', 'LIKE', "%$search%")
                        ->orWhere('cities.name', 'LIKE', "%$search%");
                })
                ->select(
                    'users.name as user_name',
                    'users.email',
                    'countries.name as countries_name',
                    'states.name as states_name',
                    'cities.name as cities_name',
                    'users.hobbies',
                    'users.gender',
                    'users.date_of_birth',
                    'users.type',
                    'users.status'
                )
                ->get();


            foreach ($users as $user) {

                // $data = DB::table('users')
                //     ->select(
                //         'countries.name as countries_name',
                //         'states.name as states_name',
                //         'cities.name as cities_name',
                //     )
                //     ->join('countries', 'users.countries', '=', 'countries.id')
                //     ->join('states', 'users.states', '=', 'states.id')
                //     ->join('cities', 'users.cities', '=', 'cities.id')
                //     ->where('users.id', $user->id)
                //     ->first();

                $suggestions[] = [
                    'name' => $user->user_name,
                    'email' => $user->email,
                    'countries' => $user->countries_name ?? '',
                    'states' => $user->states_name ?? '',
                    'cities' => $user->cities_name ?? '',
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
