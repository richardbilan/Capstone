<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alert;

class AlertController extends Controller
{
    public function index()
    {
        $alerts = Alert::orderBy('created_at', 'desc')->get();
        $today = now()->format('Y-m-d');
        return view('hazard.alerts', compact('alerts', 'today'));
    }
}