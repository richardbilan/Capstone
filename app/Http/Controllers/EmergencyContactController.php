<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmergencyContact;

class EmergencyContactController extends Controller
{
    // Show all contacts
    public function index()
    {
        $contacts = EmergencyContact::all(); // Fetch all contacts
        return view('hazard.contacts', compact('contacts')); // Pass to Blade
    }

    public function store(Request $request)
{
    $request->validate([
        'office_name' => 'required|string|max:255',
        'address' => 'required|string|max:255',
        'contact_number' => 'nullable|string|max:255',
        'type' => 'required|string|max:50',
    ]);

    EmergencyContact::create($request->all());

    return redirect()->route('contacts')->with('success', 'Contact added successfully');
}

public function update(Request $request, $id)
{
    $request->validate([
        'office_name' => 'required|string|max:255',
        'address' => 'required|string|max:255',
        'contact_number' => 'nullable|string|max:255',
        'type' => 'required|string|max:50',
    ]);

    $contact = EmergencyContact::findOrFail($id);
    $contact->update($request->all());

    return redirect()->route('contacts')->with('success', 'Contact updated successfully');
}
public function destroy($id)
{
    $contact = EmergencyContact::findOrFail($id);
    $contact->delete();

    return redirect()->route('contacts')->with('success', 'Contact deleted successfully');
}

}
