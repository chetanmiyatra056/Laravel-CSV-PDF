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
        $users = User::all();
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
        // $startDate = $request['startdate'];
        $endDate = $request->input('query');

        $startDate = "2024-07-01";
        // $endDate = "2024-07-01";
        // $search = $request->input('query');
        $suggestions = [];

        // if ($search != "") {

        $users = DB::table('users')
            ->leftJoin('countries', 'users.countries', '=', 'countries.id')
            ->leftJoin('states', 'users.states', '=', 'states.id')
            ->leftJoin('cities', 'users.cities', '=', 'cities.id')
            ->where('users.date_of_birth', '>=', $startDate)
            ->where('users.date_of_birth', '<=', $endDate)
            ->select(
                'users.id',
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
            
        // dd($users);

        // $users = DB::table('users')
        //     ->leftJoin('countries', 'users.countries', '=', 'countries.id')
        //     ->leftJoin('states', 'users.states', '=', 'states.id')
        //     ->leftJoin('cities', 'users.cities', '=', 'cities.id')
        //     ->orwhere(function ($query) use ($search) {
        //         $query->where('users.name', 'LIKE', "$search%")
        //             ->orWhere('users.email', 'LIKE', "$search%")
        //             ->orWhere('countries.name', 'LIKE', "$search%")
        //             ->orWhere('states.name', 'LIKE', "$search%")
        //             ->orWhere('cities.name', 'LIKE', "$search%");
        //     })
        //     ->select(
        //         'users.id',
        //         'users.name as user_name',
        //         'users.email',
        //         'countries.name as countries_name',
        //         'states.name as states_name',
        //         'cities.name as cities_name',
        //         'users.hobbies',
        //         'users.gender',
        //         'users.date_of_birth',
        //         'users.type',
        //         'users.status'
        //     )
        //     ->get();


        foreach ($users as $user) {

            $profiles = DB::table('profiles')
                ->where('user_id', $user->id)
                ->get();

            $uploads = $profiles->pluck('upload')->toArray();
            $uploadsString = implode(", ", $uploads);

            $suggestions[] = [
                'id' => $user->id,
                'name' => $user->user_name,
                'email' => $user->email,
                'countries' => $user->countries_name ?? '',
                'states' => $user->states_name ?? '',
                'cities' => $user->cities_name ?? '',
                'hobbies' => $user->hobbies,
                'gender' => $user->gender,
                'date_of_birth' => $user->date_of_birth,
                'type' => $user->type,
                'profiles' => $uploadsString,
                'status' => $user->status,
            ];
        }
        // }

        return response()->json($suggestions);
    }
}
