<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SuperAdminController extends Controller
{
    public function dashboard(){
        $data = [
            'title' => "Dashboard Super Admin Patrol ABB"
        ];
        return view('super-admin.dashboard',$data);
    }
}
