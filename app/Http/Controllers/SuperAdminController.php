<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SuperAdminController extends Controller
{
    public function dashboard(){
        $data = [
            'title' => "Dashboard Patrol ABB"
        ];
        return view('super-admin.dashboard',$data);
    }
}
