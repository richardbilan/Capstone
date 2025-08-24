<?php

namespace App\Http\Controllers;

use App\Models\Resident;
use Illuminate\Http\Request;

class ResidentController extends Controller
{

    public function index(Request $request)
    {
       $purok = $request->get('purok');
       $search = $request->get('search');

        $query = Resident::query();

        if ($purok) {
            $filter = preg_match('/^\d+$/', $purok) ? 'Purok ' . $purok : $purok;
            $query->where('purok', $filter);
        }

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('firstname', 'like', "%{$search}%")
                  ->orWhere('middlename', 'like', "%{$search}%")
                  ->orWhere('surname', 'like', "%{$search}%")
                  ->orWhere('rbi_no', 'like', "%{$search}%");
            });
       }

        $residents = $query->orderBy('id', 'asc')->paginate(15)->withQueryString();

        return view('residents.index', compact('residents', 'purok', 'search'));
    }
    
public function store(Request $request)
{
    $data = $request->validate([
        'firstname'           => 'required|string|max:100',
        'middlename'          => 'nullable|string|max:100',
        'surname'             => 'required|string|max:100',
        'suffix'              => 'nullable|string|max:20',
        'birthday'            => 'required|date',
        'age'                 => 'nullable|integer|min:0',
        'gender'              => 'nullable|string|max:20',
        'civil_status'        => 'nullable|string|max:50',
        'rbi_no'              => 'nullable|string|max:50',
        'purok'               => 'required|string|max:20',
        'solo_parent'         => 'nullable|string|max:100',
        'type_of_disability'  => 'nullable|string|max:255',
        'maternal_status'     => 'nullable|string|max:50',
        'remark'              => 'nullable|string',
    ]);

    // log the incoming validated payload
    \Log::info('Resident store payload', $data);

    // try to create and log the created id
    try {
        $resident = Resident::create($data);
        \Log::info('Resident created id', ['id' => $resident->id]);
        // helpful during debugging: return JSON instead of redirect so you can inspect response
        if (request()->wantsJson() || request()->ajax()) {
            return response()->json(['success' => true, 'id' => $resident->id, 'resident' => $resident], 201);
        }
        return redirect()->route('residents.index')->with('success', 'Resident added successfully. Created ID: ' . $resident->id);
    } catch (\Throwable $e) {
        \Log::error('Resident create failed', ['error' => $e->getMessage()]);
        // show error in browser (temporary)
        return back()->withErrors(['error' => 'Create failed: '.$e->getMessage()])->withInput();
    }
}

    public function update(Request $request, Resident $resident)
    {
        $data = $request->validate([
            'firstname'           => 'required|string|max:100',
            'middlename'          => 'nullable|string|max:100',
            'surname'             => 'required|string|max:100',
            'suffix'              => 'nullable|string|max:20',
            'birthday'            => 'required|date',
            'age'                 => 'nullable|integer|min:0',
            'gender'              => 'nullable|string|max:20',
            'civil_status'        => 'nullable|string|max:50',
            'rbi_no'              => 'nullable|string|max:50',
            'purok'               => 'required|string|max:20',
            'solo_parent'         => 'nullable|string|max:100',
            'type_of_disability'  => 'nullable|string|max:255',
            'maternal_status'     => 'nullable|string|max:50',
            'remark'              => 'nullable|string',
        ]);

        $resident->update($data);

        return redirect()->route('residents.index')->with('success', 'Resident updated successfully.');
    }

    public function destroy(Resident $resident)
    {
        $resident->delete();
        return redirect()->route('residents.index')->with('success', 'Resident deleted successfully.');
    }
}