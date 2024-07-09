<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
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
            // $countryId = DB::table('countries')
            //     ->where('name', '=', $search)
            //     ->pluck('id');

            // $stateId = DB::table('states')
            //     ->where('name', '=', $search)
            //     ->pluck('id');

            // $cityId = DB::table('cities')
            //     ->where('name', '=', $search)
            //     ->pluck('id');

            // $users = User::
            // where('name', '=', $search)
            // ->orWhere('email', '=', $search)
            // // ->orWhere('email', 'LIKE', "%$search%")
            // ->orWhereIn('countries', $countryId)
            // ->orWhereIn('states', $stateId)
            // ->orWhereIn('cities', $cityId)
            // ->get();

            $users = DB::table('users')
                
                // ->leftJoin('countries', 'users.countries', '=', 'countries.id')
                ->where('name', '=', $search)
                ->orWhere('email', '=', $search)
                // ->orWhere('countries.name', 'LiKE', "%$search%")
                ->select(
               
                    // 'countries.name as countries_name',
                
                )
                ->get();



            // $users = DB::table('users')
            // ->select(
            //     'countries.name as countries_name',
            //     'states.name as states_name',
            //     'cities.name as cities_name',
            // )
            // ->join('countries', 'users.countries', '=', 'countries.id')
            // ->join('states', 'users.states', '=', 'states.id')
            // ->join('cities', 'users.cities', '=', 'cities.id')
            // ->where('name', '=', $search)
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

                $data = DB::table('users')
                    ->select(
                        'countries.name as countries_name',
                        'states.name as states_name',
                        'cities.name as cities_name',
                    )
                    ->join('countries', 'users.countries', '=', 'countries.id')
                    ->join('states', 'users.states', '=', 'states.id')
                    ->join('cities', 'users.cities', '=', 'cities.id')
                    ->where('users.id', $user->id)
                    ->first();

                $profiles = DB::table('profiles')
                    ->where('user_id', $user->id)
                    ->get();

                $uploads = $profiles->pluck('upload')->toArray();
                $uploadsString = implode(", ", $uploads);

                $suggestions[] = [
                    'name' => $user->name,
                    'email' => $user->email,
                    'countries' => $data->countries_name ?? '',
                    'states' => $data->states_name ?? '',
                    'cities' => $data->cities_name ?? '',
                    'hobbies' => $user->hobbies,
                    'gender' => $user->gender,
                    'date_of_birth' => $user->date_of_birth,
                    'type' => $user->type,
                    'profiles' => $uploadsString,
                    'status' => $user->status,
                ];
            }
        }

        return response()->json($suggestions);
    }
}
