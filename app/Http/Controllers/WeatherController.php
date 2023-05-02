<?php

namespace App\Http\Controllers;

use App\Models\Pref;
use Illuminate\Http\Request;
use App\Models\Weather;

class WeatherController extends Controller
{

    

    public function index() { 

        $prefs = Pref::all();
        return view('sky.index', ['prefs' => $prefs]);
        
    }
}
