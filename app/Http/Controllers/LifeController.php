<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class LifeController extends Controller
{
    public function index() {

        return Inertia::render(
            'Life/Index',
            [
                //値を受け渡す
                
            ]
        );
        
    }

    public function index2() {

        return Inertia::render(
            'Life/Index2',
            [
                //値を受け渡す
                
            ]
        );
        
    }

    public function index3() {

        return Inertia::render(
            'Life/Index3',
            [
                //値を受け渡す
                
            ]
        );
        
    }
    public function index4() {

        return Inertia::render(
            'Life/Index4',
            [
                //値を受け渡す
                
            ]
        );
        
    }
}
