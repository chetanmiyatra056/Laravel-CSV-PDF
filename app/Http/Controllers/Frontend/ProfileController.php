<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Profile;

class ProfileController extends Controller
{
    public function profile()
    {
        $counteries = Country::get(['name','id']);
 
        return view('frontend.profile',compact('counteries'));
        // return view("frontend.profile");
    }

    public function destroy($id)
    {
        $record = Profile::find($id);

        if ($record) {
            $file_path = public_path('uploads/' . $record->upload);

            if (file_exists($file_path)) {
                unlink($file_path);
            }

            $record->delete();

            return response()->json(['success' => true, 'message' => 'Record deleted successfully.']);
        }

        return response()->json(['success' => false, 'message' => 'Record not found.'], 404);
    }
}
