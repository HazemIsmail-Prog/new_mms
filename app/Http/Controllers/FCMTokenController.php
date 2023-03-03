<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FCMTokenController extends Controller
{
    public function store(Request $request)
    {
        auth()->user()->fcm_tokens()->create(['fcm_token' => $request->fcm_token]);

        return response(['data' => [], 'error' => 0, 'message' => 'Success']);
    }
}
