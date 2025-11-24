<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        if(auth()->user()->admin){
            return view('dashboard');
        }
        return view('dashboard_user');
    }
}
