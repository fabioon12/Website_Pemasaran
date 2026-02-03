<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CustomerdashboardController extends Controller
{
    public function index()
    {
        return view('frontend.admin.dashboardcustomer.index');
    }
}
