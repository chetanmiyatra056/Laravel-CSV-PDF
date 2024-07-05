<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EditController extends Controller
{
    public function edit(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|regex:/(.+)@(.+)\.(.+)/i',
            'countries' => 'required',
            'states' => 'required',
            'cities' => 'required',
            'hobbies' => 'required',
            'gender' => 'required',
            'date' => 'required',
            'type' => 'required',
            'current_profile' => 'array',
            'update_profile' => 'array',
        ]);

        $user = User::find($id);
        $user->name =  $request->input('name');
        $user->email = $request->input('email');
        $user->countries = $request->input('countries');
        $user->states = $request->input('states');
        $user->cities = $request->input('cities');
        $user->hobbies = implode(',', $request->input('hobbies'));
        $user->gender = $request->input('gender');
        
        $_stockupdate= Carbon::parse( $request->input('date'))->format('Y-m-d'); 
        
        $user->date_of_birth =$_stockupdate;

        $user->type = $request->input('type');

        // Update Multiple file and store images in profile table
        if ($request->hasfile('update_profile')) {
            // $images = [];
            foreach ($request->file('update_profile') as $image) {
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

        if ($user->update()) {
            return redirect('/profile')->with('success', 'Update successful!');
        } else {
            return redirect('/profile')->with('error', 'Update Not successful!');
        }
    }
}
