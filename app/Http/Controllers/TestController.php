<?php

namespace App\Http\Controllers\Spotify;

use Illuminate\Http\Request;

class TestController extends Controller
{
    //
    public function test(Request $request)
    {

        return response()->json(['message' => 'Testing, 123'], 200);
    }
}
