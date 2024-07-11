<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function apiindex()
    {
        $array = [
            [
                'name' => 'abcd',
                'email' => 'abcd@gmail.com'
            ],
            [
                'name' => 'efgh',
                'email' => 'efgh@gmail.com'
            ]
        ];

        return response()->json([
            'message' => '2 User found',
            'data' => $array,
            'status' => true
        ], 200);
    }
}
