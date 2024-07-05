<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Country;
use App\Models\State;
use Illuminate\Http\Request;

class DropDownController extends Controller
{
    protected function index()
    {
        $counteries = Country::get(['name','id']);
 
        return view('frontend/views/register',compact('counteries'));
    }
 
    public function fatchState(Request $request)
    {
        $data['states'] = State::where('country_id',$request->country_id)->get(['name','id']);
 
        return response()->json($data);
    }
 
    public function fatchCity(Request $request)
    {
        $data['cities'] = City::where('state_id',$request->state_id)->get(['name','id']);
 
        return response()->json($data);
    }
}
