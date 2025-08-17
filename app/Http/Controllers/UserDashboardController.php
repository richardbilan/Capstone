<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserDashboardController extends Controller
{
    public function index()
    {
        return view('user.dashboard');
    }

    public function submitTicket(Request $request)
    {
        // Handle ticket submission logic here
        // For demo, just redirect back
        return back()->with('success', 'Ticket submitted!');
    }
}