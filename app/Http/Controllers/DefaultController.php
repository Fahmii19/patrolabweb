<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DefaultController extends Controller
{
    public function dashboard(){
        $data = [
            'title' => "Dashboard Guard Patrol ABB"
        ];
        return view('default.dashboard', $data);
    }
}
