<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Profile;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function register()
    {
        $counteries = Country::get(['name', 'id']);

        return view('frontend.register', compact('counteries'));
    }

    public function postregister(Request $request)
    {
        // print_r($request->all());

        $request->validate([
            'name' => 'required|unique:users',
            'email' => 'required|unique:users|regex:/(.+)@(.+)\.(.+)/i',
            'countries' => 'required',
            'states' => 'required',
            'cities' => 'required',
            'hobbies' => 'required',
            'gender' => 'required',
            'date' => 'required',
            'type' => 'required',
            'password' => 'required|min:4|max:8',
            'confirm_password' => 'required|same:password|min:4|max:8',
            'profile' => 'required',
        ]);

        $user = new User;
        $user->name = $request["name"];
        $user->email = $request["email"];
        $user->countries = $request["countries"];
        $user->states = $request["states"];
        $user->cities = $request["cities"];
        $user->hobbies = implode(',', $request["hobbies"]);
        $user->gender = $request["gender"];

        $_stockupdate = Carbon::parse($request["date"])->format('Y-m-d');

        $user->date_of_birth = $_stockupdate;
        $user->type = $request["type"];
        $user->status = $request["status"];

        // $user ->password = $request["password"];
        $user->password = Hash::make($request["password"]);

        // echo $request ->file ('profile')->store('uploads');
        // die;


        // Upload Multiple Files and Store in Profile Table
        if ($request->hasfile('profile')) {
            // $images = [];

            foreach ($request->file('profile') as $image) {
                $name = time() . '_' . $image->getClientOriginalName();
                $destinationPath = public_path('uploads');
                $image->move($destinationPath, $name);

                // $images[] = $name;

                $user->save();

                Profile::create([
                    'upload' => $name,
                    'user_id' => $user->id,
                ]);
            }
        }

        if ($user->save()) {
            return redirect('/login')->with('success', 'Registration successful! Now LogIn.');
        } else {
            return redirect('/register')->with('error', 'Registration Not successful!');
        }
    }
}