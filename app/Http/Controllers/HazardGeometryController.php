<?php

namespace App\Http\Controllers;

use App\Models\HazardGeometry;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class HazardGeometryController extends Controller
{
    // GET /api/hazards?type=flood
    public function index(Request $request): JsonResponse
    {
        $type = $request->query('type');
        $query = HazardGeometry::query();
        if ($type) {
            $query->where('hazard_type', $type);
        }
        $items = $query->orderBy('id')->get();
        return response()->json($items);
    }

    // POST /api/hazards
    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'hazard_type' => 'required|string|max:50',
            'name'        => 'nullable|string|max:255',
            'color'       => 'nullable|string|max:20',
            'geometry'    => 'required|array', // GeoJSON geometry object
            'properties'  => 'nullable|array',
        ]);

        $data['created_by'] = Auth::id();
        $data['updated_by'] = Auth::id();

        $geom = HazardGeometry::create($data);
        return response()->json($geom, 201);
    }

    // PUT /api/hazards/{id}
    public function update(Request $request, HazardGeometry $hazard): JsonResponse
    {
        $data = $request->validate([
            'hazard_type' => 'sometimes|string|max:50',
            'name'        => 'nullable|string|max:255',
            'color'       => 'nullable|string|max:20',
            'geometry'    => 'sometimes|array',
            'properties'  => 'nullable|array',
        ]);

        $data['updated_by'] = Auth::id();

        $hazard->update($data);
        return response()->json($hazard);
    }

    // DELETE /api/hazards/{id}
    public function destroy(HazardGeometry $hazard): JsonResponse
    {
        $hazard->delete();
        return response()->json(['ok' => true]);
    }
}
