@extends('layouts.app')
@section('hideSidebar', true)

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Evacuation Centers - Barangay Ilawod</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <!-- Leaflet Routing Machine CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.css" />
</head>
<body>
<div class="container mt-4"><br><br>
    <h2>Evacuation Centers</h2>
    <p>Filter by Purok to view nearby evacuation centers, manage their status, coordinators, and view activity logs. Use location features to find the nearest centers and get directions.</p>

    <div class="row mb-3">
        <div class="col-md-2">
            <label for="purokFilter" class="form-label">Filter by Purok</label>
            <select class="form-select" id="purokFilter" onchange="filterCenters()">
                <option value="all">All Puroks</option>
                <option value="1">Purok 1</option>
                <option value="2">Purok 2</option>
                <option value="3">Purok 3</option>
                <option value="4">Purok 4</option>
                <option value="5">Purok 5</option>
                <option value="6">Purok 6</option>
                <option value="7">Purok 7</option>
            </select>
        </div>
        <div class="col-md-10">
            <label class="form-label">Map Controls</label>
            <div class="btn-group btn-group-sm w-100" role="group">
                <button type="button" class="btn btn-outline-primary" onclick="toggleMapVisibility()">
                    <i class="fas fa-eye-slash me-1"></i>Hide/Show Map
                </button>
                <button type="button" class="btn btn-success" id="findLocationBtn" onclick="getCurrentLocation()">
                    <i class="fas fa-location-arrow me-1"></i>Find Location
                </button>
                <button type="button" class="btn btn-info" onclick="findNearestEvacuationCenter()">
                    <i class="fas fa-route me-1"></i>Nearest Center
                </button>
                <button type="button" class="btn btn-warning" onclick="toggleMapView()">
                    <i class="fas fa-map me-1"></i>Satellite View
                </button> <br>
                <!-- Import KML/KMZ removed per request -->
                <button class="btn btn-primary" onclick="openCoordinatorModal('add')">Add Coordinator</button>
                <button class="btn btn-success" onclick="openCenterModal()">Add Center</button>
            </div>
        </div>
    </div>

    <!-- Interactive Map -->
    <div class="card mb-4" id="mapContainer">
        <div class="card-header">
            <i class="fas fa-map-marked-alt me-2"></i>Evacuation Centers Map - Barangay Ilawod
        </div>
        <div class="card-body p-0">
            <div id="evacuation-map" style="height: 400px; width: 100%;"></div>
        </div>
    </div>

    <div class="table-responsive mb-4">
        <table class="table table-bordered" id="centersTable">
            <thead>
                <tr>
                    <th>Center Name</th>
                    <th>Type</th>
                    <th>Purok</th>
                    <th>Status</th>
                    <th>Capacity</th>
                    <th>Relief Goods</th>
                    <th>Coordinator</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <!-- School Centers with MOU/MOA Status -->
                <tr data-purok="1,2,3,4,5" data-status="open" data-type="school" data-mou="yes">
                    <td>Camalig National High School</td>
                    <td><span class="badge bg-primary">School</span></td>
                    <td>P1, 2, 3, 4, 5</td>
                    <td>
                        <select class="form-select form-select-sm" onchange="setStatus(this)">
                            <option value="open" selected>Open</option>
                            <option value="full">Full</option>
                            <option value="closed">Closed</option>
                        </select>
                    </td>
                    <td>300+</td>
                    <td>Available</td>
                    <td>Juan Dela Cruz</td>
                    <td>
                        <button class="btn btn-sm btn-secondary" onclick="openCoordinatorModal('edit', this)">Edit</button>
                        <button class="btn btn-sm btn-danger" onclick="openCoordinatorModal('delete', this)">Delete</button>
                        <button class="btn btn-sm btn-success" onclick="showRouteToCenter('camalig-hs')">Show Route</button>
                    </td>
                </tr>
                <tr data-purok="1,2,3,4,6" data-status="open" data-type="school" data-mou="yes">
                    <td>Baligang Elementary School</td>
                    <td><span class="badge bg-primary">School</span></td>
                    <td>P1, 2, 3, 4, 6</td>
                    <td>
                        <select class="form-select form-select-sm" onchange="setStatus(this)">
                            <option value="open" selected>Open</option>
                            <option value="full">Full</option>
                            <option value="closed">Closed</option>
                        </select>
                    </td>
                    <td>100+</td>
                    <td>Available</td>
                    <td>Maria Santos</td>
                    <td>
                        <button class="btn btn-sm btn-secondary" onclick="openCoordinatorModal('edit', this)">Edit</button>
                        <button class="btn btn-sm btn-danger" onclick="openCoordinatorModal('delete', this)">Delete</button>
                        <button class="btn btn-sm btn-success" onclick="showRouteToCenter('baligang-elem')">Show Route</button>
                    </td>
                </tr>
                <tr data-purok="1,2,3,4,7" data-status="open" data-type="school" data-mou="yes">
                    <td>Camalig South Central School</td>
                    <td><span class="badge bg-primary">School</span></td>
                    <td>P1, 2, 3, 4, 7</td>
                    <td>
                        <select class="form-select form-select-sm" onchange="setStatus(this)">
                            <option value="open" selected>Open</option>
                            <option value="full">Full</option>
                            <option value="closed">Closed</option>
                        </select>
                    </td>
                    <td>300+</td>
                    <td>Available</td>
                    <td>Pedro Reyes</td>
                    <td>
                        <button class="btn btn-sm btn-secondary" onclick="openCoordinatorModal('edit', this)">Edit</button>
                        <button class="btn btn-sm btn-danger" onclick="openCoordinatorModal('delete', this)">Delete</button>
                        <button class="btn btn-sm btn-success" onclick="showRouteToCenter('camalig-south')">Show Route</button>
                    </td>
                </tr>
                <!-- Government Buildings -->
                <tr data-purok="1" data-status="open" data-type="government" data-mou="yes">
                    <td>Barangay Hall</td>
                    <td><span class="badge bg-secondary">Government</span></td>
                    <td>Purok 1</td>
                    <td>
                        <select class="form-select form-select-sm" onchange="setStatus(this)">
                            <option value="open" selected>Open</option>
                            <option value="full">Full</option>
                            <option value="closed">Closed</option>
                        </select>
                    </td>
                    <td>50</td>
                    <td>Available</td>
                    <td>Ana Rodriguez</td>
                    <td>
                        <button class="btn btn-sm btn-secondary" onclick="openCoordinatorModal('edit', this)">Edit</button>
                        <button class="btn btn-sm btn-danger" onclick="openCoordinatorModal('delete', this)">Delete</button>
                        <button class="btn btn-sm btn-success" onclick="showRouteToCenter('barangay-hall')">Show Route</button>
                    </td>
                </tr>
                <tr data-purok="2" data-status="open" data-type="government" data-mou="yes">
                    <td>Day Care Center</td>
                    <td><span class="badge bg-secondary">Government</span></td>
                    <td>Purok 2</td>
                    <td>
                        <select class="form-select form-select-sm" onchange="setStatus(this)">
                            <option value="open" selected>Open</option>
                            <option value="full">Full</option>
                            <option value="closed">Closed</option>
                        </select>
                    </td>
                    <td>30</td>
                    <td>Available</td>
                    <td>Rosa Martinez</td>
                    <td>
                        <button class="btn btn-sm btn-secondary" onclick="openCoordinatorModal('edit', this)">Edit</button>
                        <button class="btn btn-sm btn-danger" onclick="openCoordinatorModal('delete', this)">Delete</button>
                        <button class="btn btn-sm btn-success" onclick="showRouteToCenter('daycare')">Show Route</button>
                    </td>
                </tr>
                <tr data-purok="3" data-status="open" data-type="government" data-mou="yes">
                    <td>Barangay Health Center</td>
                    <td><span class="badge bg-secondary">Government</span></td>
                    <td>Purok 3</td>
                    <td>
                        <select class="form-select form-select-sm" onchange="setStatus(this)">
                            <option value="open" selected>Open</option>
                            <option value="full">Full</option>
                            <option value="closed">Closed</option>
                        </select>
                    </td>
                    <td>25</td>
                    <td>Available</td>
                    <td>Dr. Carlos Lopez</td>
                    <td>
                        <button class="btn btn-sm btn-secondary" onclick="openCoordinatorModal('edit', this)">Edit</button>
                        <button class="btn btn-sm btn-danger" onclick="openCoordinatorModal('delete', this)">Delete</button>
                        <button class="btn btn-sm btn-success" onclick="showRouteToCenter('health-center')">Show Route</button>
                    </td>
                </tr>
                <tr data-purok="4" data-status="open" data-type="government" data-mou="yes">
                    <td>Multi-purpose Building</td>
                    <td><span class="badge bg-secondary">Government</span></td>
                    <td>Purok 4</td>
                    <td>
                        <select class="form-select form-select-sm" onchange="setStatus(this)">
                            <option value="open" selected>Open</option>
                            <option value="full">Full</option>
                            <option value="closed">Closed</option>
                        </select>
                    </td>
                    <td>100</td>
                    <td>Available</td>
                    <td>Luis Fernandez</td>
                    <td>
                        <button class="btn btn-sm btn-secondary" onclick="openCoordinatorModal('edit', this)">Edit</button>
                        <button class="btn btn-sm btn-danger" onclick="openCoordinatorModal('delete', this)">Delete</button>
                        <button class="btn btn-sm btn-success" onclick="showRouteToCenter('multipurpose')">Show Route</button>
                    </td>
                </tr>
                <!-- Private Homes with MOU/MOA -->
                <tr data-purok="5" data-status="open" data-type="private" data-mou="yes">
                    <td>Garcia Residence (Bahay ni Edsel M. Garcia)</td>
                    <td><span class="badge bg-warning">Private Home</span></td>
                    <td>Purok 5</td>
                    <td>
                        <select class="form-select form-select-sm" onchange="setStatus(this)">
                            <option value="open" selected>Open</option>
                            <option value="full">Full</option>
                            <option value="closed">Closed</option>
                        </select>
                    </td>
                    <td>15</td>
                    <td>MOU Required</td>
                    <td>Edsel M. Garcia</td>
                    <td>
                        <button class="btn btn-sm btn-secondary" onclick="openCoordinatorModal('edit', this)">Edit</button>
                        <button class="btn btn-sm btn-danger" onclick="openCoordinatorModal('delete', this)">Delete</button>
                        <button class="btn btn-sm btn-success" onclick="showRouteToCenter('garcia-residence')">Show Route</button>
                        <button class="btn btn-sm btn-primary" onclick="viewMOUStatus('garcia-residence')">MOU Status</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="card mb-4">
        <div class="card-header fw-bold">Evacuation Center Activity Logs</div>
        <div class="card-body" style="max-height: 250px; overflow-y: auto;">
            <ul class="list-group" id="logsList">
                <li class="list-group-item d-flex justify-content-between align-items-start">
                    <div class="me-auto">
                        <div class="fw-bold">Garcia Residence - Status Changed</div>
                        <small class="text-muted">Status changed from Closed to Open</small>
                    </div>
                    <small class="text-muted">2 hours ago</small>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-start">
                    <div class="me-auto">
                        <div class="fw-bold">Camalig National High School - Coordinator Updated</div>
                        <small class="text-muted">New coordinator assigned: Juan Dela Cruz</small>
                    </div>
                    <small class="text-muted">1 day ago</small>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-start">
                    <div class="me-auto">
                        <div class="fw-bold">Barangay Hall - Capacity Alert</div>
                        <small class="text-muted">Center approaching full capacity (45/50)</small>
                    </div>
                    <small class="text-muted">2 days ago</small>
                </li>
            </ul>
        </div>
    </div>
</div>

<!-- Coordinator Modal -->
<div class="modal fade" id="coordinatorModal" tabindex="-1" aria-labelledby="coordinatorModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="coordinatorForm">
        <div class="modal-header">
          <h5 class="modal-title" id="coordinatorModalLabel">Coordinator</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <!-- Fields for add/edit coordinator -->
          <div id="coordinatorFormFields">
            <div class="mb-3">
              <label for="coordinatorName" class="form-label">Coordinator Name</label>
              <input type="text" class="form-control" id="coordinatorName" name="coordinatorName" required>
            </div>
            <div class="mb-3">
              <label for="coordinatorContact" class="form-label">Contact Number</label>
              <input type="text" class="form-control" id="coordinatorContact" name="coordinatorContact" required>
            </div>
          </div>
          <!-- Delete confirmation -->
          <div id="deleteConfirmation" class="text-danger d-none">
            Are you sure you want to delete this coordinator?
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary" id="coordinatorSaveBtn">Save</button>
          <button type="button" class="btn btn-danger d-none" id="coordinatorDeleteBtn">Delete</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Add Center Modal -->
<div class="modal fade" id="centerModal" tabindex="-1" aria-labelledby="centerModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="centerForm">
        <div class="modal-header">
          <h5 class="modal-title" id="centerModalLabel">Add Evacuation Center</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="mb-3">
                <label for="centerName" class="form-label">Center Name</label>
                <input type="text" class="form-control" id="centerName" name="centerName" required>
            </div>
            <div class="mb-3">
                <label for="centerPurok" class="form-label">Purok</label>
                <select class="form-select" id="centerPurok" name="centerPurok" required>
                    <option value="" disabled selected>Select Purok</option>
                    <option value="1">Purok 1</option>
                    <option value="2">Purok 2</option>
                    <option value="3">Purok 3</option>
                    <option value="4">Purok 4</option>
                    <option value="5">Purok 5</option>
                    <option value="6">Purok 6</option>
                    <option value="7">Purok 7</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="centerStatus" class="form-label">Status</label>
                <select class="form-select" id="centerStatus" name="centerStatus" required>
                    <option value="open">Open</option>
                    <option value="full">Full</option>
                    <option value="closed">Closed</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="centerCoordinator" class="form-label">Coordinator</label>
                <input type="text" class="form-control" id="centerCoordinator" name="centerCoordinator" required>
            </div>
            <div class="mb-3">
                <label for="centerContact" class="form-label">Contact Number</label>
                <input type="text" class="form-control" id="centerContact" name="centerContact" required>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-success">Add Center</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<!-- Leaflet Routing Machine JS -->
<script src="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.min.js"></script>
<!-- Leaflet Draw CSS/JS for manual boundary digitizing -->
<link rel="stylesheet" href="https://unpkg.com/leaflet-draw@1.0.4/dist/leaflet.draw.css" />
<script src="https://unpkg.com/leaflet-draw@1.0.4/dist/leaflet.draw.js"></script>
<!-- osmtogeojson to convert Overpass data to GeoJSON -->
<script src="https://unpkg.com/osmtogeojson@2.2.12/osmtogeojson.js"></script>
<!-- JSZip for KMZ reading and togeojson for KML/KMZ -> GeoJSON conversion -->
<script src="https://cdn.jsdelivr.net/npm/jszip@3.10.1/dist/jszip.min.js"></script>
<script src="https://unpkg.com/@tmcw/togeojson@5.7.0/dist/togeojson.umd.js"></script>
<!-- No Google Maps API key needed - using OpenStreetMap only -->

<script>
let evacuationMap;
let evacuationCenters = [];
let currentLocationMarker = null;
let userLocation = null;
let isSatelliteView = false;
let editingRow = null;
let ilawodLayer = null;
let ilawodBounds = null;
let routingControl = null;
let drawnBoundary; // FeatureGroup for user-drawn Ilawod boundary

// Blade-provided address/coords for MOU evacuation (optional)
const MOU_ADDRESS = @json($mouAddress ?? null);
const MOU_LAT = @json($mouLat ?? null);
const MOU_LNG = @json($mouLng ?? null);
const ILAWOD_GEOJSON_URL = "{{ asset('assets/geo/ilawod.geojson') }}?v={{ time() }}";

// Initialize map when the page loads
document.addEventListener('DOMContentLoaded', function() {
    initializeEvacuationMap();
    loadEvacuationCentersData();
    // Try to route to the provided MOU address when available
    if (MOU_ADDRESS || (MOU_LAT && MOU_LNG)) {
        // Slight delay to ensure map and bounds are ready
        setTimeout(routeToMouAddressIfAny, 500);
    }
    setupKmlImport();
});

// Set up Leaflet Draw for manual Ilawod boundary digitizing (global scope)
function setupBoundaryDrawing() {
    try {
        if (!evacuationMap) return;
        if (!drawnBoundary) {
            drawnBoundary = new L.FeatureGroup();
            evacuationMap.addLayer(drawnBoundary);
        }

        const drawControl = new L.Control.Draw({
            draw: {
                polygon: {
                    allowIntersection: false,
                    showArea: false,
                    shapeOptions: { color: '#d9534f', weight: 3, dashArray: '6,6' }
                },
                polyline: false,
                rectangle: false,
                circle: false,
                marker: false,
                circlemarker: false
            },
            edit: {
                featureGroup: drawnBoundary,
                remove: true
            }
        });
        evacuationMap.addControl(drawControl);

        evacuationMap.on(L.Draw.Event.CREATED, async function (e) {
            // Only keep one boundary at a time
            drawnBoundary.clearLayers();
            const layer = e.layer;
            drawnBoundary.addLayer(layer);

            // Build a clean FeatureCollection for saving
            const gj = layer.toGeoJSON();
            const fc = {
                type: 'FeatureCollection',
                features: [{
                    type: 'Feature',
                    properties: { name: 'Barangay Ilawod', source: 'manual-draw' },
                    geometry: gj.geometry
                }]
            };

            // Show it using the same style and lock bounds
            drawIlawodGeoJSON(fc);

            // Try copying to clipboard for quick saving
            try {
                await navigator.clipboard.writeText(JSON.stringify(fc, null, 2));
                alert('Boundary drawn. GeoJSON copied to clipboard. Paste into public/assets/geo/ilawod.geojson and save.');
            } catch (_) {
                console.warn('Clipboard write failed');
            }
        });
    } catch (err) {
        console.error('setupBoundaryDrawing failed:', err);
    }
}

function initializeEvacuationMap() {
    // Initialize Leaflet map with zoom restrictions
    evacuationMap = L.map('evacuation-map', {
        zoomControl: true,
        scrollWheelZoom: false,
        doubleClickZoom: false,
        boxZoom: false,
        keyboard: false,
        dragging: true
    }).setView([13.1775283, 123.6449343], 16);

    // Add OpenStreetMap tiles
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(evacuationMap);

    // Configure zoom limits
    evacuationMap.setMinZoom(8);
    evacuationMap.setMaxZoom(20);

    // Load and draw Ilawod boundary from OSM (fallback to local file)
    loadIlawodOutline();

    // Drawing tools disabled per request

    // Add barangay location marker
    addBarangayLocationMarker();
    
    // Add evacuation centers
    addEvacuationCentersToMap();
}

// Load Ilawod boundary from local GeoJSON only, style it, fit and lock bounds
async function loadIlawodOutline() {
    try {
        const local = await (await fetch(ILAWOD_GEOJSON_URL, { cache: 'no-store' })).json();
        if (!local || !local.features || !local.features.length) {
            console.warn('Ilawod local GeoJSON is empty. Import or draw the boundary, then save to public/assets/geo/ilawod.geojson');
            return;
        }
        drawIlawodGeoJSON(local);
    } catch (e) {
        console.error('Local GeoJSON load failed:', e);
    }
}

function drawIlawodGeoJSON(geo) {
    if (ilawodLayer) {
        evacuationMap.removeLayer(ilawodLayer);
        ilawodLayer = null;
    }
    ilawodLayer = L.geoJSON(geo, {
        style: function() {
            return {
                color: '#000000',
                weight: 2,
                fill: false,
                fillOpacity: 0
            };
        }
    }).addTo(evacuationMap);

    ilawodBounds = ilawodLayer.getBounds();
    if (ilawodBounds && ilawodBounds.isValid()) {
        evacuationMap.fitBounds(ilawodBounds.pad(0.05));
        evacuationMap.setMaxBounds(ilawodBounds.pad(0.10));
    }
}

async function fetchIlawodFromOSM() {
    // Try 1: Find Camalig admin area then search Ilawod within it
    const q1 = `
        [out:json][timeout:30];
        rel["boundary"="administrative"]["name"~"Camalig",i];
        map_to_area -> .cam;
        (
          rel(area.cam)["boundary"="administrative"]["admin_level"="10"]["name"~"^Ilawod$",i];
          rel(area.cam)["boundary"="administrative"]["name"~"Barangay Ilawod",i];
          way(area.cam)["boundary"="administrative"]["admin_level"="10"]["name"~"Ilawod",i];
          rel(area.cam)["place"~"neighbourhood|suburb|quarter|village"]["name"~"^Ilawod$",i];
          way(area.cam)["place"~"neighbourhood|suburb|quarter|village"]["name"~"^Ilawod$",i];
        );
        out ids tags center geom;`;

    // Try 2: Coordinate-based search around Ilawod center (from Google/OSM view)
    const centerLat = 13.17653;
    const centerLon = 123.65024;
    const q2 = `
        [out:json][timeout:30];
        (
          rel(around:7000,${centerLat},${centerLon})["boundary"="administrative"]["admin_level"="10"]["name"~"Ilawod",i];
          way(around:7000,${centerLat},${centerLon})["boundary"="administrative"]["admin_level"="10"]["name"~"Ilawod",i];
          rel(around:7000,${centerLat},${centerLon})["boundary"="administrative"]["name"~"Barangay Ilawod",i];
          rel(around:7000,${centerLat},${centerLon})["place"~"neighbourhood|suburb|quarter|village"]["name"~"^Ilawod$",i];
          way(around:7000,${centerLat},${centerLon})["place"~"neighbourhood|suburb|quarter|village"]["name"~"^Ilawod$",i];
        );
        out ids tags center geom;`;
    const endpoints = [
        'https://overpass-api.de/api/interpreter',
        'https://overpass.kumi.systems/api/interpreter'
    ];
    async function run(query) {
        let data = null;
        let lastErr;
        for (const url of endpoints) {
            try {
                const res = await fetch(url, {
                    method: 'POST',
                    body: 'data=' + encodeURIComponent(query),
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' }
                });
                if (!res.ok) throw new Error('Overpass API error ' + res.status);
                data = await res.json();
                if (data && data.elements && data.elements.length) return data;
            } catch (e) {
                lastErr = e;
            }
        }
        if (!data) throw lastErr || new Error('Overpass request failed');
        return data;
    }
    // Run Try 1, if empty run Try 2
    let data = await run(q1);
    if (!data || !data.elements || !data.elements.length) {
        data = await run(q2);
    }
    if (!data || !data.elements || !data.elements.length) return null;
    const gj = osmtogeojson(data);
    // Keep only polygonal features
    gj.features = gj.features.filter(f => f.geometry && (f.geometry.type === 'Polygon' || f.geometry.type === 'MultiPolygon'));
    return gj.features.length ? gj : null;
}

// If coordinates or an address were provided, find destination and draw a route
async function routeToMouAddressIfAny() {
    if (!(MOU_ADDRESS || (MOU_LAT && MOU_LNG))) return;

    try {
        let dest;
        if (MOU_LAT && MOU_LNG) {
            dest = L.latLng(parseFloat(MOU_LAT), parseFloat(MOU_LNG));
        } else {
            const q = encodeURIComponent(MOU_ADDRESS + ', Ilawod, Camalig, Albay, Philippines');
            const res = await fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${q}&limit=1`);
            const data = await res.json();
            if (!Array.isArray(data) || data.length === 0) {
                console.warn('MOU address not found:', MOU_ADDRESS);
                return;
            }
            dest = L.latLng(parseFloat(data[0].lat), parseFloat(data[0].lon));
        }

        // Destination marker
        const label = MOU_ADDRESS ? MOU_ADDRESS : `${dest.lat.toFixed(6)}, ${dest.lng.toFixed(6)}`;
        L.marker(dest, { title: 'MOU Destination' }).addTo(evacuationMap)
            .bindPopup(`<strong>Destination</strong><br>${label}`).openPopup();

        // Origin: use user location if available; else Barangay center
        const origin = userLocation ? L.latLng(userLocation.lat, userLocation.lng) : L.latLng(13.1775283, 123.6449343);
        createOrUpdateRoute(origin, dest);

        // Fit route into view while respecting Ilawod bounds
        const bounds = L.latLngBounds([origin, dest]);
        evacuationMap.fitBounds(bounds.pad(0.15));
    } catch (e) {
        console.error('Geocoding/routing error:', e);
    }
}

function createOrUpdateRoute(originLatLng, destLatLng) {
    if (routingControl) {
        evacuationMap.removeControl(routingControl);
        routingControl = null;
    }
    routingControl = L.Routing.control({
        waypoints: [originLatLng, destLatLng],
        lineOptions: { styles: [{ color: '#e55300', weight: 5, opacity: 0.9 }] },
        router: L.Routing.osrmv1({ serviceUrl: 'https://router.project-osrm.org/route/v1' }),
        addWaypoints: false,
        draggableWaypoints: false,
        show: false,
        fitSelectedRoutes: false
    }).addTo(evacuationMap);
}

function loadEvacuationCentersData() {
    // Evacuation centers data matching the table
    evacuationCenters = [
        {
            id: 'camalig-hs',
            name: 'Camalig National High School',
            type: 'school',
            status: 'open',
            capacity: 300,
            purok: ['1', '2', '3', '4', '5'],
            coordinates: [13.1470, 123.6920],
            coordinator: 'Juan Dela Cruz',
            contact: '09171234567'
        },
        {
            id: 'baligang-elem',
            name: 'Baligang Elementary School',
            type: 'school',
            status: 'open',
            capacity: 100,
            purok: ['1', '2', '3', '4', '6'],
            coordinates: [13.1430, 123.6880],
            coordinator: 'Maria Santos',
            contact: '09179876543'
        },
        {
            id: 'camalig-south',
            name: 'Camalig South Central School',
            type: 'school',
            status: 'open',
            capacity: 300,
            purok: ['1', '2', '3', '4', '7'],
            coordinates: [13.1460, 123.6910],
            coordinator: 'Pedro Reyes',
            contact: '09185551234'
        },
        {
            id: 'barangay-hall',
            name: 'Barangay Hall',
            type: 'government',
            status: 'open',
            capacity: 50,
            purok: ['1'],
            coordinates: [13.1450, 123.6900],
            coordinator: 'Ana Rodriguez',
            contact: '09176667890'
        },
        {
            id: 'daycare',
            name: 'Day Care Center',
            type: 'government',
            status: 'open',
            capacity: 30,
            purok: ['2'],
            coordinates: [13.1440, 123.6890],
            coordinator: 'Rosa Martinez',
            contact: '09173334567'
        },
        {
            id: 'health-center',
            name: 'Barangay Health Center',
            type: 'government',
            status: 'open',
            capacity: 25,
            purok: ['3'],
            coordinates: [13.1435, 123.6885],
            coordinator: 'Dr. Carlos Lopez',
            contact: '09182223456'
        },
        {
            id: 'multipurpose',
            name: 'Multi-purpose Building',
            type: 'government',
            status: 'open',
            capacity: 100,
            purok: ['4'],
            coordinates: [13.1465, 123.6915],
            coordinator: 'Luis Fernandez',
            contact: '09177778901'
        },
        {
            id: 'garcia-residence',
            name: 'Garcia Residence',
            type: 'private',
            status: 'open',
            capacity: 15,
            purok: ['5'],
            coordinates: [13.1455, 123.6905],
            coordinator: 'Edsel M. Garcia',
            contact: '09184445678'
        }
    ];
}

function addBarangayLocationMarker() {
    let barangayMarker = L.marker([13.1757857, 123.6497455], {
        icon: L.divIcon({
            html: '<div style="background: rgba(108,117,125,0.15); color: #343a40; padding: 6px 12px; border-radius: 16px; font-weight: 600; text-align: center; font-size: 12px; border: 1px solid rgba(108,117,125,0.6); backdrop-filter: blur(2px); cursor: pointer;">📍 BARANGAY ILAWOD<br><span style="font-weight:500;">Camalig, Albay</span></div>',
            className: 'barangay-marker',
            iconSize: [200, 40],
            iconAnchor: [100, 20]
        })
    }).addTo(evacuationMap);
    
    // Detailed description shown on hover
    barangayMarker.bindPopup(`
        <div style="text-align:left; min-width:240px;">
            <h6 style="margin:0 0 6px 0;"><strong>Barangay Ilawod</strong></h6>
            <div style="font-size: 12px; line-height:1.4;">
                <div><strong>Type</strong>: barangay</div>
                <div><strong>Island group</strong>: Luzon</div>
                <div><strong>Region</strong>: Bicol Region (Region V)</div>
                <div><strong>Province</strong>: Albay</div>
                <div><strong>Municipality</strong>: Camalig</div>
                <div><strong>Postal code</strong>: 4502</div>
                <div><strong>Population (2020)</strong>: 2,664</div>
                <div><strong>Philippine major island(s)</strong>: Luzon</div>
                <div><strong>Coordinates</strong>: 13.1768, 123.6507 (13° 11' North, 123° 39' East)</div>
                <div><strong>Estimated elevation</strong>: 113.3 m (371.7 ft)</div>
            </div>
        </div>
    `);

    // Open description on hover, close when cursor leaves
    barangayMarker.on('mouseover', () => barangayMarker.openPopup());
    barangayMarker.on('mouseout', () => barangayMarker.closePopup());
}

function addEvacuationCentersToMap() {
    evacuationCenters.forEach(center => {
        let iconHtml;
        switch(center.type) {
            case 'school':
                iconHtml = `<div style="color: green; font-size: 24px;">🏫</div>`;
                break;
            case 'government':
                iconHtml = `<div style="color: blue; font-size: 24px;">🏛️</div>`;
                break;
            case 'private':
                iconHtml = `<div style="color: brown; font-size: 24px;">🏘️</div>`;
                break;
            default:
                iconHtml = `<div style="color: green; font-size: 24px;">🏠</div>`;
        }
        
        let marker = L.marker(center.coordinates, {
            icon: L.divIcon({
                html: iconHtml,
                className: 'evacuation-center-marker',
                iconSize: [30, 30],
                iconAnchor: [15, 15]
            })
        }).addTo(evacuationMap);
        
        let popupContent = `
            <div class="evacuation-popup">
                <h6>${center.name}</h6>
                <p><strong>Status:</strong> <span class="badge bg-success">${center.status.toUpperCase()}</span></p>
                <p><strong>Capacity:</strong> ${center.capacity} people</p>
                <p><strong>Coordinator:</strong> ${center.coordinator}</p>
                <p><strong>Contact:</strong> ${center.contact}</p>
                <button class="btn btn-sm btn-success" onclick="showRouteToCenter('${center.id}')">Show Route</button>
            </div>
        `;
        
        marker.bindPopup(popupContent);
    });
}

// Toggle between standard and satellite view
function toggleMapView() {
    const toggleBtn = document.querySelector('[onclick="toggleMapView()"]');
    
    evacuationMap.eachLayer(function(layer) {
        if (layer instanceof L.TileLayer) {
            evacuationMap.removeLayer(layer);
        }
    });
    
    if (isSatelliteView) {
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(evacuationMap);
        toggleBtn.innerHTML = '<i class="fas fa-map me-1"></i>Satellite View';
        isSatelliteView = false;
    } else {
        L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
            attribution: '&copy; Esri, Maxar, GeoEye, Earthstar Geographics, CNES/Airbus DS, USDA, USGS, AeroGRID, IGN, and the GIS User Community'
        }).addTo(evacuationMap);
        toggleBtn.innerHTML = '<i class="fas fa-map me-1"></i>Standard View';
        isSatelliteView = true;
    }
}

// Location tracking functions
function getCurrentLocation() {
    const btn = document.getElementById('findLocationBtn');
    btn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Finding Location...';
    btn.disabled = true;

    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            function(position) {
                const lat = position.coords.latitude;
                const lng = position.coords.longitude;
                const accuracy = position.coords.accuracy;
                userLocation = { lat: lat, lng: lng };

                showLocationOnLeafletMap(lat, lng, accuracy);
                
                // Show location popup with address
                getLocationAddress(lat, lng).then(address => {
                    alert(`Location Found!\nLatitude: ${lat.toFixed(6)}\nLongitude: ${lng.toFixed(6)}\nAccuracy: ${accuracy.toFixed(0)}m\nAddress: ${address}`);
                });

                btn.innerHTML = '<i class="fas fa-check me-1"></i>Location Found';
                setTimeout(() => {
                    btn.innerHTML = '<i class="fas fa-location-arrow me-1"></i>Find My Location';
                    btn.disabled = false;
                }, 2000);

                // If there's a destination address, re-route from new origin
                if (MOU_ADDRESS) {
                    routeToMouAddressIfAny();
                }
            },
            function(error) {
                console.error('Error getting location:', error);
                let errorMsg = 'Location access denied or unavailable';
                if (error.code === 1) errorMsg = 'Location access denied by user';
                else if (error.code === 2) errorMsg = 'Location unavailable';
                else if (error.code === 3) errorMsg = 'Location request timeout';
                
                alert(errorMsg);
                btn.innerHTML = '<i class="fas fa-exclamation-triangle me-1"></i>Location Error';
                btn.classList.add('btn-danger');
                
                setTimeout(() => {
                    btn.innerHTML = '<i class="fas fa-location-arrow me-1"></i>Find My Location';
                    btn.classList.remove('btn-danger');
                    btn.disabled = false;
                }, 3000);
            },
            {
                enableHighAccuracy: true,
                timeout: 15000,
                maximumAge: 0
            }
        );
    } else {
        alert('Geolocation is not supported by this browser.');
        btn.innerHTML = '<i class="fas fa-location-arrow me-1"></i>Find My Location';
        btn.disabled = false;
    }
}

function showLocationOnLeafletMap(lat, lng, accuracy = null) {
    if (currentLocationMarker) {
        evacuationMap.removeLayer(currentLocationMarker);
    }

    // Add accuracy circle if available
    if (accuracy && accuracy < 100) {
        L.circle([lat, lng], {
            radius: accuracy,
            color: '#3388ff',
            fillColor: '#3388ff',
            fillOpacity: 0.2,
            weight: 2
        }).addTo(evacuationMap);
    }

    currentLocationMarker = L.marker([lat, lng], {
        icon: L.divIcon({
            html: '<div style="background: #FF0000; color: white; border-radius: 50%; width: 20px; height: 20px; text-align: center; line-height: 20px; border: 2px solid white;">📍</div>',
            className: 'current-location-marker',
            iconSize: [24, 24],
            iconAnchor: [12, 12]
        })
    }).addTo(evacuationMap);

    const accuracyText = accuracy ? `<p>Accuracy: ±${accuracy.toFixed(0)} meters</p>` : '';
    currentLocationMarker.bindPopup(`
        <div style="text-align: center;">
            <h6><strong>Your Current Location</strong></h6>
            <p>Latitude: ${lat.toFixed(6)}<br>
            Longitude: ${lng.toFixed(6)}</p>
            ${accuracyText}
        </div>
    `);

    // Automatically zoom to user's location and adjust view
    evacuationMap.setView([lat, lng], 15);
    
    // If user is far from Barangay Ilawod, create a view that shows both locations
    const barangayLat = 13.1757857;
    const barangayLng = 123.6497455;
    const distance = calculateDistance(lat, lng, barangayLat, barangayLng);
    
    // If more than 5km away, zoom out to show both locations
    if (distance > 5) {
        const bounds = L.latLngBounds([[lat, lng], [barangayLat, barangayLng]]);
        evacuationMap.fitBounds(bounds, { padding: [20, 20] });
    }
}

// Get address from coordinates using reverse geocoding
async function getLocationAddress(lat, lng) {
    try {
        const response = await fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&zoom=18&addressdetails=1`);
        const data = await response.json();
        
        if (data && data.display_name) {
            return data.display_name;
        } else {
            return `Near Barangay Ilawod, Camalig, Albay`;
        }
    } catch (error) {
        console.error('Error getting address:', error);
        return `Coordinates: ${lat.toFixed(6)}, ${lng.toFixed(6)}`;
    }
}

// Enhanced route display with travel time estimates
function showRouteWithInfo(center) {
    if (!userLocation) return;
    
    const distance = calculateDistance(
        userLocation.lat,
        userLocation.lng,
        center.coordinates[0],
        center.coordinates[1]
    );
    
    const routeLine = L.polyline([
        [userLocation.lat, userLocation.lng],
        center.coordinates
    ], {
        color: '#FF0000',
        weight: 4,
        opacity: 0.8
    }).addTo(evacuationMap);

    const walkingTime = Math.round((distance / 5) * 60);
    const drivingTime = Math.round((distance / 30) * 60);
    
    routeLine.bindPopup(`
        <div style="text-align: center;">
            <h6><strong>Route to ${center.name}</strong></h6>
            <p><strong>Distance:</strong> ${distance.toFixed(2)} km</p>
            <p><strong>Walking:</strong> ~${walkingTime} minutes</p>
            <p><strong>Driving:</strong> ~${drivingTime} minutes</p>
        </div>
    `).openPopup();

    // Auto-fit bounds to show both locations
    evacuationMap.fitBounds(routeLine.getBounds(), { padding: [20, 20] });
}

function findNearestEvacuationCenter() {
    if (!userLocation) {
        alert('Please find your location first by clicking "Find My Location"');
        return;
    }

    let nearestCenter = null;
    let shortestDistance = Infinity;

    evacuationCenters.forEach(center => {
        const distance = calculateDistance(
            userLocation.lat,
            userLocation.lng,
            center.coordinates[0],
            center.coordinates[1]
        );

        if (distance < shortestDistance && center.status === 'open') {
            shortestDistance = distance;
            nearestCenter = center;
        }
    });

    if (nearestCenter) {
        showRouteWithInfo(nearestCenter);
        alert(`Nearest evacuation center: ${nearestCenter.name} (${shortestDistance.toFixed(2)} km away)`);
    } else {
        alert('No open evacuation centers found.');
    }
}

function calculateDistance(lat1, lon1, lat2, lon2) {
    const R = 6371;
    const dLat = (lat2 - lat1) * Math.PI / 180;
    const dLon = (lon2 - lon1) * Math.PI / 180;
    const a = Math.sin(dLat/2) * Math.sin(dLat/2) +
              Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
              Math.sin(dLon/2) * Math.sin(dLon/2);
    const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
    return R * c;
}

function showRouteToCenter(centerId) {
    const center = evacuationCenters.find(c => c.id === centerId);
    if (!center) return;
    
    if (userLocation) {
        showRouteWithInfo(center);
    } else {
        evacuationMap.setView(center.coordinates, 16);
        alert(`${center.name} location highlighted on map. Find your location first to see the route.`);
    }
}

// Existing evacuation center management functions
function filterCenters() {
    const purok = document.getElementById('purokFilter').value;
    document.querySelectorAll('#centersTable tbody tr').forEach(row => {
        if (purok === 'all' || row.getAttribute('data-purok').includes(purok)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}

function setStatus(select) {
    const newStatus = select.value;
    const row = select.closest('tr');
    const centerName = row.cells[0].textContent;
    row.setAttribute('data-status', newStatus);
    
    // Add log entry
    const logsList = document.getElementById('logsList');
    const logItem = document.createElement('li');
    logItem.className = 'list-group-item d-flex justify-content-between align-items-start';
    logItem.innerHTML = `
        <div class="me-auto">
            <div class="fw-bold">${centerName} - Status Changed</div>
            <small class="text-muted">Status changed to ${newStatus.charAt(0).toUpperCase() + newStatus.slice(1)}</small>
        </div>
        <small class="text-muted">Just now</small>
    `;
    logsList.insertBefore(logItem, logsList.firstChild);
    
    console.log(`${centerName} status changed to: ${newStatus}`);
}

function showMapCenter() {
    alert('Map center feature - showing evacuation centers per purok');
}

function openCoordinatorModal(action, btn = null) {
    const modal = new bootstrap.Modal(document.getElementById('coordinatorModal'));
    const formFields = document.getElementById('coordinatorFormFields');
    const deleteConfirmation = document.getElementById('deleteConfirmation');
    const saveBtn = document.getElementById('coordinatorSaveBtn');
    const deleteBtn = document.getElementById('coordinatorDeleteBtn');
    const nameInput = document.getElementById('coordinatorName');
    const contactInput = document.getElementById('coordinatorContact');

    editingRow = null;

    if (action === 'add') {
        document.getElementById('coordinatorModalLabel').innerText = 'Add Coordinator';
        formFields.classList.remove('d-none');
        deleteConfirmation.classList.add('d-none');
        saveBtn.classList.remove('d-none');
        deleteBtn.classList.add('d-none');
        nameInput.value = '';
        contactInput.value = '';
    } else if (action === 'edit') {
        document.getElementById('coordinatorModalLabel').innerText = 'Edit Coordinator';
        formFields.classList.remove('d-none');
        deleteConfirmation.classList.add('d-none');
        saveBtn.classList.remove('d-none');
        deleteBtn.classList.add('d-none');
        if (btn) {
            editingRow = btn.closest('tr');
            nameInput.value = editingRow.cells[6].innerText;
            contactInput.value = editingRow.getAttribute('data-contact') || '';
        }
    } else if (action === 'delete') {
        document.getElementById('coordinatorModalLabel').innerText = 'Delete Coordinator';
        formFields.classList.add('d-none');
        deleteConfirmation.classList.remove('d-none');
        saveBtn.classList.add('d-none');
        deleteBtn.classList.remove('d-none');
        if (btn) {
            editingRow = btn.closest('tr');
        }
    }
    modal.show();
}

function openCenterModal() {
    const modal = new bootstrap.Modal(document.getElementById('centerModal'));
    document.getElementById('centerForm').reset();
    modal.show();
}

function viewMOUStatus(centerId) {
    alert('MOU/MOA Status: Active\nAgreement signed on: January 15, 2025\nValid until: January 15, 2026\n\nThis private home is authorized to serve as an evacuation center under the terms of the signed Memorandum of Understanding.');
}

// Form event listeners
document.getElementById('centerForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const name = document.getElementById('centerName').value;
    const purok = document.getElementById('centerPurok').value;
    const status = document.getElementById('centerStatus').value;
    const coordinator = document.getElementById('centerCoordinator').value;
    const contact = document.getElementById('centerContact').value;

    const tbody = document.querySelector('#centersTable tbody');
    const tr = document.createElement('tr');
    tr.setAttribute('data-purok', purok);
    tr.setAttribute('data-status', status);
    tr.innerHTML = `
        <td>${name}</td>
        <td><span class="badge bg-secondary">New</span></td>
        <td>Purok ${purok}</td>
        <td>
            <select class="form-select form-select-sm" onchange="setStatus(this)">
                <option value="open"${status === 'open' ? ' selected' : ''}>Open</option>
                <option value="full"${status === 'full' ? ' selected' : ''}>Full</option>
                <option value="closed"${status === 'closed' ? ' selected' : ''}>Closed</option>
            </select>
        </td>
        <td>TBD</td>
        <td>Available</td>
        <td>${coordinator}</td>
        <td>
            <button class="btn btn-sm btn-secondary" onclick="openCoordinatorModal('edit', this)">Edit</button>
            <button class="btn btn-sm btn-danger" onclick="openCoordinatorModal('delete', this)">Delete</button>
            <button class="btn btn-sm btn-success" onclick="showRouteToCenter('new-center')">Show Route</button>
        </td>
    `;
    tbody.appendChild(tr);

    bootstrap.Modal.getInstance(document.getElementById('centerModal')).hide();
    
    // Show success message
    alert('Evacuation center added successfully!');
});

document.getElementById('coordinatorForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const name = document.getElementById('coordinatorName').value;
    const contact = document.getElementById('coordinatorContact').value;
    if (editingRow) {
        editingRow.cells[6].innerText = name;
        editingRow.setAttribute('data-contact', contact);
        
        // Add log entry
        const logsList = document.getElementById('logsList');
        const logItem = document.createElement('li');
        logItem.className = 'list-group-item d-flex justify-content-between align-items-start';
        logItem.innerHTML = `
            <div class="me-auto">
                <div class="fw-bold">${editingRow.cells[0].textContent} - Coordinator Updated</div>
                <small class="text-muted">New coordinator assigned: ${name}</small>
            </div>
            <small class="text-muted">Just now</small>
        `;
        logsList.insertBefore(logItem, logsList.firstChild);
    }
    bootstrap.Modal.getInstance(document.getElementById('coordinatorModal')).hide();
});

document.getElementById('coordinatorDeleteBtn').addEventListener('click', function() {
    if (editingRow) {
        const centerName = editingRow.cells[0].textContent;
        editingRow.remove();
        
        // Add log entry
        const logsList = document.getElementById('logsList');
        const logItem = document.createElement('li');
        logItem.className = 'list-group-item d-flex justify-content-between align-items-start';
        logItem.innerHTML = `
            <div class="me-auto">
                <div class="fw-bold">${centerName} - Coordinator Removed</div>
                <small class="text-muted">Coordinator has been removed from the system</small>
            </div>
            <small class="text-muted">Just now</small>
        `;
        logsList.insertBefore(logItem, logsList.firstChild);
    }
    bootstrap.Modal.getInstance(document.getElementById('coordinatorModal')).hide();
});

// Map visibility toggle
function toggleMapVisibility() {
    const mapContainer = document.getElementById('mapContainer');
    const mapControls = document.getElementById('mapControls');
    const toggleBtn = document.getElementById('toggleMapBtn');
    
    if (mapContainer.style.display === 'none') {
        mapContainer.style.display = 'block';
        mapControls.style.display = 'block';
        toggleBtn.innerHTML = '<i class="fas fa-eye-slash me-1"></i>Hide Map';
        setTimeout(() => evacuationMap.invalidateSize(), 100);
    } else {
        mapContainer.style.display = 'none';
        mapControls.style.display = 'none';
        toggleBtn.innerHTML = '<i class="fas fa-eye me-1"></i>Show Map';
    }
}

// Enhanced purok filtering
function filterEvacuationCenters() {
    const purokFilter = document.getElementById('purokFilter').value;
    const statusFilter = document.getElementById('statusFilter').value;
    const rows = document.querySelectorAll('#evacuationTable tbody tr');
    
    rows.forEach(row => {
        const purokData = row.getAttribute('data-purok');
        const statusData = row.getAttribute('data-status');
        
        let showRow = true;
        
        if (purokFilter && purokData) {
            const puroks = purokData.split(',').map(p => p.trim());
            showRow = puroks.includes(purokFilter);
        }
        
        if (showRow && statusFilter && statusData) {
            showRow = statusData === statusFilter;
        }
        
        row.style.display = showRow ? '' : 'none';
    });
    
    updateMapMarkers();
}

// Update map markers based on filters
function updateMapMarkers() {
    const purokFilter = document.getElementById('purokFilter').value;
    const statusFilter = document.getElementById('statusFilter').value;
    
    evacuationMap.eachLayer(layer => {
        if (layer instanceof L.Marker && layer !== currentLocationMarker) {
            evacuationMap.removeLayer(layer);
        }
    });
    
    evacuationCenters.forEach(center => {
        let showMarker = true;
        
        if (purokFilter && center.purok && center.purok !== 'All') {
            const puroks = center.purok.split(',').map(p => p.trim());
            showMarker = puroks.includes(purokFilter);
        }
        
        if (showMarker && statusFilter && center.status) {
            showMarker = center.status === statusFilter;
        }
        
        if (showMarker) {
            addMarkerToMap(center);
        }
    });
}

// Add individual marker to map
function addMarkerToMap(center) {
    let iconColor = '#28a745';
    if (center.status === 'full') iconColor = '#ffc107';
    else if (center.status === 'closed') iconColor = '#dc3545';
    
    const marker = L.marker(center.coordinates, {
        icon: L.divIcon({
            className: 'evacuation-marker',
            html: `<div style="background: ${iconColor}; color: white; border-radius: 50%; width: 24px; height: 24px; text-align: center; line-height: 24px; border: 2px solid white; font-size: 12px;">${center.type === 'school' ? '🏫' : center.type === 'government' ? '🏛️' : '🏠'}</div>`,
            iconSize: [24, 24],
            iconAnchor: [12, 12]
        })
    }).addTo(evacuationMap);

    const popupContent = `
        <div style="max-width: 250px;">
            <h6><strong>${center.name}</strong></h6>
            <p><strong>Status:</strong> <span style="color: ${iconColor}">${center.status.toUpperCase()}</span></p>
            <p><strong>Capacity:</strong> ${center.capacity} people</p>
            <p><strong>Coordinator:</strong> ${center.coordinator}</p>
            <button onclick="showRouteToCenter('${center.id}')" class="btn btn-sm btn-primary">Show Route</button>
        </div>
    `;
    
    marker.bindPopup(popupContent);
}

// Google Maps Guide Integration
function openGoogleMapsGuide(centerId = null) {
    if (!userLocation) {
        alert('Please find your location first to get directions');
        return;
    }
    
    let destination = '';
    let centerName = '';
    
    if (centerId) {
        const center = evacuationCenters.find(c => c.id === centerId);
        if (center) {
            destination = `${center.coordinates[0]},${center.coordinates[1]}`;
            centerName = center.name;
        }
    } else {
        const nearest = findNearestCenter();
        if (nearest) {
            destination = `${nearest.coordinates[0]},${nearest.coordinates[1]}`;
            centerName = nearest.name;
        }
    }
    
    if (destination) {
        const origin = `${userLocation.lat},${userLocation.lng}`;
        const googleMapsUrl = `https://www.google.com/maps/dir/${origin}/${destination}`;
        
        window.open(googleMapsUrl, '_blank');
        alert(`Google Maps guide opened with turn-by-turn directions to ${centerName}`);
    } else {
        alert('No evacuation center found for directions');
    }
}

// Find nearest evacuation center
function findNearestCenter() {
    if (!userLocation) return null;
    
    let nearestCenter = null;
    let shortestDistance = Infinity;
    
    evacuationCenters.forEach(center => {
        if (center.status === 'open') {
            const distance = calculateDistance(
                userLocation.lat,
                userLocation.lng,
                center.coordinates[0],
                center.coordinates[1]
            );
            
            if (distance < shortestDistance) {
                shortestDistance = distance;
                nearestCenter = center;
            }
        }
    });
    
    return nearestCenter;
}
</script>

<style>
.evacuation-center-marker {
    background: transparent;
    border: none;
    text-align: center;
}

.barangay-marker {
    background: transparent;
    border: none;
    text-align: center;
}

.current-location-marker {
    background: transparent;
    border: none;
    text-align: center;
}

.evacuation-popup {
    min-width: 200px;
}

@media (max-width: 768px) {
    .btn-group {
        flex-wrap: wrap;
    }
    
    .btn-group .btn {
        margin-bottom: 5px;
    }
}
</style>
</body>
</html>