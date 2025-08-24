<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MouHome;

class MouHomeController extends Controller
{
    // Admin: show all applications
    public function index()
    {
        $mouHomes = MouHome::orderBy('created_at', 'desc')->get();
        return view('hazard.mou-homes', compact('mouHomes'));
    }

    // User: store submission
    
    public function store(Request $request)
{
    $data = $request->validate([
        'full_name' => 'required|string|max:255',
        'contact_number' => 'required|string|max:20',
        'address' => 'required|string|max:255',
        'house_type' => 'required|string|max:50',
        'capacity' => 'required|string|max:20',
        'facilities' => 'array',
        'notes' => 'nullable|string',
        'agreement' => 'required', // keep validation
    ]);

    // Convert checkbox to boolean (1 or 0)
    $data['agreement'] = $request->has('agreement') ? 1 : 0;

    // Map facilities to boolean fields
    $facilityFields = ['toilet', 'water', 'electricity', 'kitchen', 'parking', 'first_aid'];
    $facilities = $request->input('facilities', []);
    foreach ($facilityFields as $field) {
        $data[$field] = in_array($field, $facilities) ? 1 : 0;
    }

    // Map form fields to database columns
    $data['homeowner_name'] = $data['full_name'];
    $data['additional_info'] = $data['notes'];
    $data['status'] = 'Pending';

    MouHome::create($data);

    return redirect()->back()->with('success', 'Your application has been submitted successfully!');
}


    public function updateStatus(Request $request, MouHome $mouHome)
    {
        $request->validate([
            'status' => 'required|in:Pending,Approved,Rejected',
        ]);

        $mouHome->status = $request->status;
        $mouHome->save();

        return redirect()->back()->with('success', 'Application status updated successfully.');
    }
}
