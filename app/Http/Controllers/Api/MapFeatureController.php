<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MapFeature;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class MapFeatureController extends Controller
{
    // GET /api/map-features
    public function index(Request $request)
    {
        $q = MapFeature::query();
        if ($request->filled('category')) {
            $q->where('category', $request->string('category'));
        }
        if ($request->filled('type')) {
            $q->where('type', $request->string('type'));
        }

        $features = $q->latest('id')->get()->map(function (MapFeature $f) {
            return $this->toGeoJSON($f);
        })->values();

        return response()->json([
            'type' => 'FeatureCollection',
            'features' => $features,
        ]);
    }

    // GET /api/map-features/{id}
    public function show($id)
    {
        $f = MapFeature::findOrFail($id);
        return response()->json($this->toGeoJSON($f));
    }

    // POST /api/map-features (supports single feature or array under `features`)
    public function store(Request $request)
    {
        $payload = $request->all();
        $isBatch = isset($payload['features']) && is_array($payload['features']);

        $saved = [];

        DB::beginTransaction();
        try {
            if ($isBatch) {
                foreach ($payload['features'] as $feature) {
                    $saved[] = $this->saveOneFeature($feature);
                }
            } else {
                $saved[] = $this->saveOneFeature($payload);
            }
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Failed to store map feature(s): '.$e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return response()->json(['message' => 'Error storing feature(s)'], 500);
        }

        if ($isBatch) {
            return response()->json([
                'type' => 'FeatureCollection',
                'features' => $saved,
            ], 201);
        }
        return response()->json($saved[0], 201);
    }

    // PUT /api/map-features/{id}
    public function update(Request $request, $id)
    {
        $f = MapFeature::findOrFail($id);
        $data = $request->all();

        DB::beginTransaction();
        try {
            if (isset($data['properties']) && is_array($data['properties'])) {
                $f->properties = $data['properties'];
            }
            if (isset($data['name'])) $f->name = $data['name'];
            if (isset($data['description'])) $f->description = $data['description'];
            if (isset($data['category'])) $f->category = $data['category'];
            if (isset($data['type'])) $f->type = $data['type'];
            if (isset($data['geometry'])) {
                $f->geometry = $data['geometry'];
                // If Point, update lat/lng convenience fields
                if (isset($data['geometry']['type']) && strtolower($data['geometry']['type']) === 'point') {
                    $coords = $data['geometry']['coordinates'] ?? null;
                    if (is_array($coords) && count($coords) >= 2) {
                        $f->longitude = $coords[0];
                        $f->latitude = $coords[1];
                    }
                }
            }
            $f->save();
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Failed to update map feature: '.$e->getMessage());
            return response()->json(['message' => 'Error updating feature'], 500);
        }

        return response()->json($this->toGeoJSON($f));
    }

    // DELETE /api/map-features/{id}
    public function destroy($id)
    {
        $f = MapFeature::findOrFail($id);
        $f->delete();
        return response()->json(['message' => 'Deleted']);
    }

    private function saveOneFeature(array $feature)
    {
        // Validate bare minimum
        $category = $feature['category'] ?? ($feature['properties']['category'] ?? null);
        $type = $feature['type']
            ?? ($feature['properties']['type']
            ?? $feature['properties']['infra_type']
            ?? $feature['properties']['pwd_type']
            ?? $feature['properties']['route_type']
            ?? null);
        $geometry = $feature['geometry'] ?? null;

        if (!$category || !$type || !is_array($geometry)) {
            throw new \InvalidArgumentException('Missing required fields: category, type, geometry');
        }

        $name = $feature['name'] ?? ($feature['properties']['name'] ?? null);
        $description = $feature['description'] ?? ($feature['properties']['description'] ?? null);
        $properties = $feature['properties'] ?? null;

        $mf = new MapFeature();
        $mf->category = $category;
        $mf->type = $type;
        $mf->name = $name;
        $mf->description = $description;
        $mf->properties = $properties;
        $mf->geometry = $geometry; // store raw GeoJSON

        // If point, store lat/lng as convenience columns
        if (isset($geometry['type']) && strtolower($geometry['type']) === 'point') {
            $coords = $geometry['coordinates'] ?? null;
            if (is_array($coords) && count($coords) >= 2) {
                $mf->longitude = $coords[0];
                $mf->latitude = $coords[1];
            }
        }

        $mf->save();
        return $this->toGeoJSON($mf);
    }

    private function toGeoJSON(MapFeature $f): array
    {
        $props = $f->properties ?? [];
        $props['category'] = $f->category;
        $props['type'] = $f->type;
        if (!empty($f->name)) $props['name'] = $f->name;
        if (!empty($f->description)) $props['description'] = $f->description;
        $feature = [
            'type' => 'Feature',
            'id' => $f->id,
            'properties' => $props,
            'geometry' => $f->geometry,
        ];
        return $feature;
    }
}
