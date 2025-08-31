<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class SuperAdminController extends Controller
{
    public function index()
    {
         $pendingUsers = User::where('is_approved', false)->get();
         $users = User::all();
         // You must return the view here!
         return view('superadmin.manage_users', compact('pendingUsers', 'users'));
    }

    public function approve($id)
    {
        $user = User::findOrFail($id);
        $user->is_approved = true;
        $user->save();
        return redirect()->back()->with('success', 'User approved!');
    }

    public function reject($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->back()->with('success', 'User rejected and deleted!');
    }

    public function delete($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->back()->with('success', 'User deleted!');
    }

    // Add edit/update methods as needed
}