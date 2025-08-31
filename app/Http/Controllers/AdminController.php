<?php

namespace App\Http\Controllers;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.dashboard');
    }

    public function tickets()
    {
        // Return tickets view
    }

    public function sendNotification()
    {
        // Handle notification sending
    }
}