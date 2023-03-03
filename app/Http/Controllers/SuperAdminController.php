<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class SuperAdminController extends Controller
{

    public function index () 
    {
        return view('pages.artisan.index');
    }

    public function artisan_run (Request $request) 
    {
        set_time_limit(60 * 2); //60 seconds * 2 = 2 minutes

        try{
            Artisan::call($request->command);
            return redirect()->back();
        }catch (Exception $e){
            dd($e);
        }
    }
}
