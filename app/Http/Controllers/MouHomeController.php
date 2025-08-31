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
<<<<<<< HEAD
        'other_facilities' => 'nullable|string',
=======
>>>>>>> 7a584067cb8174031fa332c11a54a086080e3cd5
        'notes' => 'nullable|string',
        'agreement' => 'required', // keep validation
    ]);

    // Convert checkbox to boolean (1 or 0)
    $data['agreement'] = $request->has('agreement') ? 1 : 0;

<<<<<<< HEAD
    // Store facilities as JSON array
    $facilities = $request->input('facilities', []);
    // Merge additional "other facilities" (comma-separated)
    $otherRaw = $request->input('other_facilities', '');
    if (is_string($otherRaw) && trim($otherRaw) !== '') {
        $others = array_map('trim', explode(',', $otherRaw));
        // keep non-empty custom entries as typed
        $others = array_filter($others, fn($v) => $v !== '');
        $facilities = array_merge($facilities, $others);
    }
    // normalize values (e.g., firstaid -> first_aid)
    $normalize = function($v) {
        // keep exact custom text, only normalize our known key variant
        if (is_string($v)) {
            $low = strtolower($v);
            if ($low === 'firstaid') return 'first_aid';
        }
        return $v;
    };
    $data['facilities'] = array_values(array_unique(array_map($normalize, $facilities)));
=======
    // Map facilities to boolean fields
    $facilityFields = ['toilet', 'water', 'electricity', 'kitchen', 'parking', 'first_aid'];
    $facilities = $request->input('facilities', []);
    foreach ($facilityFields as $field) {
        $data[$field] = in_array($field, $facilities) ? 1 : 0;
    }
>>>>>>> 7a584067cb8174031fa332c11a54a086080e3cd5

    // Map form fields to database columns
    $data['homeowner_name'] = $data['full_name'];
    $data['additional_info'] = $data['notes'];
    $data['status'] = 'Pending';

<<<<<<< HEAD
    // Only keep fillable fields for creation
    $createData = [
        'homeowner_name' => $data['homeowner_name'],
        'contact_number' => $data['contact_number'],
        'address' => $data['address'],
        'house_type' => $data['house_type'],
        'capacity' => $data['capacity'],
        'facilities' => $data['facilities'],
        'additional_info' => $data['additional_info'] ?? null,
        'agreement' => $data['agreement'],
        'status' => $data['status'],
    ];

    MouHome::create($createData);
=======
    MouHome::create($data);
>>>>>>> 7a584067cb8174031fa332c11a54a086080e3cd5

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
