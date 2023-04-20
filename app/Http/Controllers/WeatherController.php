<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Weather;

class WeatherController extends Controller
{

    public function index() {

    $prefs = Weather::all();
        return view('sky.index', ['prefs' => $prefs]);

        // return view('sky.index');
        

    }
}
