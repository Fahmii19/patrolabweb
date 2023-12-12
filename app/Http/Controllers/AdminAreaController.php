<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminAreaController extends Controller
{
    public function dashboard(){
        $data = [
            'title' => "Dashboard Admin Area Patrol ABB"
        ];
        return view('admin-area.dashboard', $data);
    }
}
