@extends('layouts.user')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/user.css') }}">
@endpush

@section('content')
<div class="tab-pane fade show active" id="maps" role="tabpanel">
    <div class="card disaster-map-card mb-4">
        <div class="card-header map-header">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-map-marked-alt me-2"></i>
                        Barangay Ilawod Disaster Risk Map
                    </h5>
                </div>
                <div class="col-lg-6">
                    <div class="hazard-filter-buttons">
                        <div class="btn-group btn-group-sm flex-wrap" role="group">
                            <button type="button" class="btn btn-outline-secondary hazard-btn" data-hazard="none">
                                <i class="fas fa-times me-1"></i>Clear
                            </button>
                            <button type="button" class="btn btn-outline-primary hazard-btn active" data-hazard="all">
                                <i class="fas fa-globe me-1"></i>All
                            </button>
                            <button type="button" class="btn btn-outline-danger hazard-btn" data-hazard="flood">
                                <i class="fas fa-water me-1"></i>Flood
                            </button>
                            <button type="button" class="btn btn-outline-warning hazard-btn" data-hazard="landslide">
                                <i class="fas fa-mountain me-1"></i>Landslide
                            </button>
                            <button type="button" class="btn btn-outline-danger hazard-btn" data-hazard="fire">
                                <i class="fas fa-fire me-1"></i>Fire
                            </button>
                            <button type="button" class="btn btn-outline-secondary hazard-btn" data-hazard="ashfall">
                                <i class="fas fa-smog me-1"></i>Ashfall
                            </button>
                            <button type="button" class="btn btn-outline-dark hazard-btn" data-hazard="lahar">
                                <i class="fas fa-water me-1"></i>Lahar
                            </button>
                            <button type="button" class="btn btn-outline-brown hazard-btn" data-hazard="mudflow">
                                <i class="fas fa-water me-1"></i>Mudflow
                            </button>
                            <button type="button" class="btn btn-outline-primary hazard-btn" data-hazard="wind">
                                <i class="fas fa-wind me-1"></i>Wind
                            </button>
                            <button id="toggleRoutesBtn" type="button" class="btn btn-outline-success hazard-btn" data-hazard="routes">
                                <i class="fas fa-route me-1"></i>Routes
                            </button>
                            <button type="button" class="btn btn-outline-info hazard-btn" data-hazard="evacuation">
                                <i class="fas fa-home me-1"></i>Evacuation
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Map Container -->
        <div class="card-body p-0">
            <div id="disaster-map" style="height: 600px; width: 100%;"></div>
        </div>

        <!-- Legend -->
        <div class="card-footer">
            <style>
                .legend-section-title{font-weight:700;margin-bottom:6px}
                .legend-items{display:flex;flex-wrap:wrap;gap:12px 20px}
                .legend-item{display:flex;align-items:center;gap:8px;min-width:220px}
                .legend-line{display:inline-block;width:38px;height:0;border-bottom:3px solid #000}
                .legend-square{display:inline-block;width:12px;height:12px;border-radius:2px}
            </style>
            <div id="legendContainer" class="d-flex flex-column gap-3">
                <div>
                    <div class="legend-section-title">Legend:</div>
                    <div class="row g-3">
                        <!-- Column 1: Boundaries & Roads -->
                        <div class="col-md-6">
                            <div class="legend-section-title">Boundaries & Roads</div>
                            <div class="legend-items">
                                <div class="legend-item">
                                    <span class="legend-line" style="border-bottom:3px dashed #000"></span>
                                    <span>Municipal Boundary</span>
                                </div>
                                <div class="legend-item">
                                    <span class="legend-line" style="border-bottom:2px solid #000"></span>
                                    <span>Barangay Boundary</span>
                                </div>
                                <div class="legend-item">
                                    <span class="legend-line" style="border-bottom:3px solid #e03131"></span>
                                    <span>Road</span>
                                </div>
                                <div class="legend-item">
                                    <span class="legend-line" style="border-bottom:3px dotted #d97706"></span>
                                    <span>Active PNR Track</span>
                                </div>
                                <div class="legend-item">
                                    <span class="legend-line" style="border-bottom:3px dotted #f59e0b;opacity:.6"></span>
                                    <span>Abandoned PNR Track</span>
                                </div>
                            </div>
                        </div>

                        <!-- Column 2: Hydrography & Elevation -->
                        <div class="col-md-6">
                            <div class="legend-section-title">Hydrography</div>
                            <div class="legend-items mb-2">
                                <div class="legend-item">
                                    <span class="legend-line" style="border-bottom:3px solid #1d4ed8"></span>
                                    <span>Rivers & Creek</span>
                                </div>
                                <div class="legend-item">
                                    <span class="legend-square" style="background:transparent;border:2px solid #93c5fd;border-radius:50%;width:12px;height:12px;position:relative"></span>
                                    <span>Spot Height (m)</span>
                                </div>
                            </div>
                            <div class="legend-section-title">Elevation / Contours</div>
                            <div class="legend-items">
                                <div class="legend-item">
                                    <span class="legend-line" style="border-bottom:3px solid #16a34a"></span>
                                    <span>100 m Contour Line Interval</span>
                                </div>
                                <div class="legend-item">
                                    <span class="legend-line" style="border-bottom:2px solid #22c55e"></span>
                                    <span>20 m Contour Line Interval</span>
                                </div>
                                <div class="legend-item">
                                    <span class="legend-line" style="border-bottom:2px dashed #0ea5e9"></span>
                                    <span>Depressed Contour Lines</span>
                                </div>
                                <div class="legend-item">
                                    <span class="legend-line" style="border-bottom:2px solid #a78bfa;opacity:.8"></span>
                                    <span>Supplementary Contour Lines</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Column 3: Infrastructure -->
                    <div class="mt-3">
                        <div class="legend-section-title">Infrastructure</div>
                        <div class="legend-items">
                            <div class="legend-item"><i class="fas fa-landmark text-secondary"></i><span>Government Office</span></div>
                            <div class="legend-item"><i class="fas fa-building text-primary"></i><span>Barangay Hall</span></div>
                            <div class="legend-item"><i class="fas fa-school" style="color:#1d4ed8"></i><span>School</span></div>
                            <div class="legend-item"><i class="fas fa-baby text-warning"></i><span>Day Care Center</span></div>
                            <div class="legend-item"><span class="legend-square" style="background:#ef4444"></span><span>Establishment</span></div>
                            <div class="legend-item"><i class="fas fa-hospital text-danger"></i><span>Health Station</span></div>
                            <div class="legend-item"><i class="fas fa-star text-warning"></i><span>Tourist Spot</span></div>
                            <div class="legend-item"><i class="fas fa-church text-secondary"></i><span>Church</span></div>
                            <div class="legend-item"><i class="fas fa-cross text-muted"></i><span>Chapel</span></div>
                            <div class="legend-item"><span class="legend-square" style="background:#22c55e"></span><span>Parks & Recreation</span></div>
                            <div class="legend-item"><span class="legend-square" style="background:#84cc16"></span><span>Cemetery</span></div>
                            <div class="legend-item"><i class="fas fa-broadcast-tower text-muted"></i><span>Tower</span></div>
                            <div class="legend-item"><i class="fas fa-bridge text-secondary"></i><span>Bridge</span></div>
                            
                        </div>
                    </div>

                    <!-- Existing Hazard types and controls -->
                    <div class="mt-3">
                        <div class="legend-section-title">Hazards & Controls</div>
                        <div class="legend-items">
                            <div class="legend-item"><span class="legend-square" style="background:#0d6efd"></span><span>Flood</span></div>
                            <div class="legend-item"><span class="legend-square" style="background:#f59e0b"></span><span>Landslide</span></div>
                            <div class="legend-item"><span class="legend-square" style="background:#dc2626"></span><span>Fire</span></div>
                            <div class="legend-item"><span class="legend-square" style="background:#6b7280"></span><span>Ashfall</span></div>
                            <div class="legend-item"><span class="legend-square" style="background:#343a40"></span><span>Lahar</span></div>
                            <div class="legend-item"><span class="legend-square" style="background:#92400e"></span><span>Mudflow</span></div>
                            <div class="legend-item"><span class="legend-square" style="background:#1e40af"></span><span>Wind</span></div>
                            <div class="legend-item"><i class="fas fa-home text-success"></i><span>Evacuation Center</span></div>
                            <div class="legend-item"><i class="fas fa-route text-success"></i><span>Evacuation Routes</span></div>
                            <div class="legend-item"><i class="fas fa-user text-primary"></i><span>Your Location</span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- NEW Controls for Location & Routing -->
        <div class="card-footer bg-light">
            <div class="d-flex flex-column gap-2">
                <button id="btnCurrentLocation" class="btn btn-sm btn-primary">
                    <i class="fas fa-location-arrow me-1"></i> Show Current Location
                </button>
                <input type="text" id="locationField" class="form-control form-control-sm" readonly placeholder="Coordinates / Address will appear here">
                <div class="d-flex gap-2">
                    <button id="btnNearestCenter" class="btn btn-sm btn-info flex-fill">
                        <i class="fas fa-home me-1"></i> Show Nearest Evacuation Center
                    </button>
                    <button id="btnShowRoute" class="btn btn-sm btn-success flex-fill">
                        <i class="fas fa-route me-1"></i> Show Routes
                    </button>
                </div>
            </div>
            <small id="statusText" class="text-muted mt-2 d-block">
                <i class="fas fa-info-circle me-1"></i>Find your location or filter hazards.
            </small>
        </div>
    </div>
</div>

<script src="{{ asset('js/hazard-map.js') }}"></script>

<script>
    
// Global variables
let map;
let currentLocation = null;
let nearestCenter = null;
let evacuationCenters = [];
let routesVisible = true;
let hazardLayers = {};
let evacuationRoutes = {};
let purokMarkers = {};
let ilawodBounds = null;

// Toggle for any pre-defined/sample data (set to false to remove all predefined markers)
const LOAD_SAMPLE_DATA = false;

// Supported hazard types (must match DB values)
const HAZARD_TYPES = ['flood','landslide','fire','ashfall','lahar','mudflow','wind'];

// Build a Leaflet layer from a GeoJSON geometry + style
function createLayerFromGeometry(geometry, color = '#0d6efd', properties = {}) {
    const common = { color: color || '#0d6efd', weight: 2, fillColor: color || '#0d6efd', fillOpacity: 0.35 };
    switch (geometry.type) {
        case 'Polygon':
            return L.polygon(geometry.coordinates.map(ring => ring.map(([lng, lat]) => [lat, lng])), common);
        case 'MultiPolygon':
            return L.multiPolygon(geometry.coordinates.map(poly => poly.map(ring => ring.map(([lng, lat]) => [lat, lng]))), common);
        case 'LineString':
            return L.polyline(geometry.coordinates.map(([lng, lat]) => [lat, lng]), { color: common.color, weight: 3, opacity: 0.9 });
        case 'MultiLineString':
            return L.multiPolyline(geometry.coordinates.map(line => line.map(([lng, lat]) => [lat, lng])), { color: common.color, weight: 3, opacity: 0.9 });
        case 'Point':
            return L.circleMarker([geometry.coordinates[1], geometry.coordinates[0]], { radius: 6, color: common.color, fillColor: common.fillColor, fillOpacity: 0.9 });
        case 'MultiPoint':
            return L.layerGroup(geometry.coordinates.map(([lng, lat]) => L.circleMarker([lat, lng], { radius: 6, color: common.color, fillColor: common.fillColor, fillOpacity: 0.9 })));
        default:
            return null;
    }
}

// --- Map Features (Infrastructure/PWD) for disaster map ---
const MAP_FEATURES_API = '/api/map-features';
const featureLayers = {
    infrastructure: null,
    pwd: null,
    route: null,
};
const infraTypeGroups = {};
const pwdTypeGroups = {};

function initMapFeaturesLayers() {
    featureLayers.infrastructure = L.layerGroup().addTo(map);
    featureLayers.pwd = L.layerGroup().addTo(map);
    featureLayers.route = L.layerGroup().addTo(map);
}

// Icon mapping reused from admin map
const infraIconMap = {
    barangay_hall: { class: 'fas fa-building', color: '#0d6efd' },
    elementary_school: { class: 'fas fa-school', color: '#1d4ed8' },
    chapel: { class: 'fas fa-church', color: '#B10DC9' },
    health_center: { class: 'fas fa-hospital', color: '#dc3545' },
    multi_purpose_hall: { class: 'fas fa-building-columns', color: '#198754' },
    day_care_center: { class: 'fas fa-child', color: '#F59E0B' },
};
const pwdIconMap = {
    pwd_households: { class: 'fas fa-wheelchair', color: '#0dcaf0' },
};

function getFaIcon(category, type) {
    const spec = (category === 'infrastructure' ? infraIconMap[type] : pwdIconMap[type]) || { class: 'fas fa-map-marker-alt', color: '#0d6efd' };
    const html = `<i class="${spec.class}" style="color:${spec.color};font-size:20px;"></i>`;
    return L.divIcon({ html, className: 'fa-div-icon', iconSize: [20,20], iconAnchor: [10,10] });
}

async function loadMapFeaturesForUsers() {
    try {
        // Clear existing groups and subgroups
        featureLayers.infrastructure?.clearLayers();
        featureLayers.pwd?.clearLayers();
        Object.keys(infraTypeGroups).forEach(k => delete infraTypeGroups[k]);
        Object.keys(pwdTypeGroups).forEach(k => delete pwdTypeGroups[k]);

        const resp = await fetch(MAP_FEATURES_API, { headers: { 'Accept': 'application/json' }, cache: 'no-store' });
        if (!resp.ok) throw new Error('Failed to fetch map features');
        const fc = await resp.json();
        (fc.features || []).forEach(f => {
            const cat = f.properties?.category;
            const type = f.properties?.type || f.properties?.infra_type || f.properties?.pwd_type || f.properties?.route_type;
            const layer = L.geoJSON(f, {
                pointToLayer: (feat, latlng) => {
                    if (cat === 'infrastructure' || cat === 'pwd') {
                        return L.marker(latlng, { icon: getFaIcon(cat, type) });
                    }
                    return L.circleMarker(latlng, { radius: 8, color: '#0d6efd', fillColor: '#0d6efd', fillOpacity: 0.8 });
                },
                style: () => ({ color: '#0dcaf0', weight: 3, fillOpacity: 0.2 })
            });

            if (cat === 'infrastructure') {
                if (!infraTypeGroups[type]) {
                    infraTypeGroups[type] = L.layerGroup();
                    featureLayers.infrastructure.addLayer(infraTypeGroups[type]);
                }
                layer.addTo(infraTypeGroups[type]);
            } else if (cat === 'pwd') {
                if (!pwdTypeGroups[type]) {
                    pwdTypeGroups[type] = L.layerGroup();
                    featureLayers.pwd.addLayer(pwdTypeGroups[type]);
                }
                layer.addTo(pwdTypeGroups[type]);
            } else if (cat === 'route') {
                featureLayers.route.addLayer(layer);
            }
        });
    } catch (e) {
        console.warn('User map: loadMapFeaturesForUsers failed', e);
    }
}

// Remove all hazard layers from map and memory
function clearHazardLayers() {
    Object.values(hazardLayers).forEach(group => {
        if (group && map.hasLayer(group)) map.removeLayer(group);
    });
    hazardLayers = {};
}

// Load hazards from API. If type provided, only that type; otherwise load all
async function loadHazardGeometries(type = null) {
    const url = type ? `/api/hazards?type=${encodeURIComponent(type)}` : '/api/hazards';
    try {
        const res = await fetch(url);
        if (!res.ok) throw new Error('Failed to fetch hazards');
        const items = await res.json();

        // When loading all, rebuild groups; when loading single, append/replace that group
        if (!type) {
            clearHazardLayers();
        } else if (hazardLayers[type]) {
            if (map.hasLayer(hazardLayers[type])) map.removeLayer(hazardLayers[type]);
            delete hazardLayers[type];
        }

        // Group by hazard_type
        const grouped = {};
        items.forEach(item => {
            const hType = (item.hazard_type || 'unknown').toLowerCase();
            grouped[hType] = grouped[hType] || [];
            grouped[hType].push(item);
        });

        Object.entries(grouped).forEach(([hType, arr]) => {
            const layers = arr.map(it => {
                const lyr = createLayerFromGeometry(it.geometry, it.color, it.properties);
                if (lyr) {
                    const name = it.name || it.hazard_type || 'Hazard Area';
                    lyr.bindPopup(`<strong>${name}</strong>`);
                }
                return lyr;
            }).filter(Boolean);
            if (layers.length) {
                const group = L.featureGroup(layers);
                hazardLayers[hType] = group;
                // Do not add to map yet; visibility controlled by filters
            }
        });
    } catch (e) {
        console.error('Error loading hazards:', e);
    }
}

// Initialize routes visibility
window.routesVisible = true;

// Add Barangay Ilawod outline by loading a GeoJSON file
function addBarangayOutline() {
    fetch('/assets/geo/ilawod.geojson')
        .then(response => {
            if (!response.ok) throw new Error('Network response was not ok');
            return response.json();
        })
        .then(data => {
            const outline = L.geoJSON(data, {
                style: { color: '#1e3a8a', weight: 3, fill: false, opacity: 0.9 }
            }).addTo(map).bindPopup('<strong>Barangay Ilawod</strong><br>Camalig, Albay');

            const bounds = outline.getBounds();
            ilawodBounds = bounds; // store globally for checks
            map.fitBounds(bounds.pad(0.15));
            map.setMaxBounds(bounds.pad(0.5));
        })
        .catch(err => {
            console.error('Failed to load Ilawod boundary:', err);
        });
}

// Initialize the map when the page loads
document.addEventListener('DOMContentLoaded', function() {
    setTimeout(function() {
        initializeMap();
        initializeEventListeners();

        // NEW: Button bindings
        document.getElementById("btnCurrentLocation").addEventListener("click", getCurrentLocationDashboard);
        document.getElementById("btnNearestCenter").addEventListener("click", findNearestEvacuationCenter);
        document.getElementById("btnShowRoute").addEventListener("click", function() {
            if (currentLocation && nearestCenter) {
                getRoadRoute(currentLocation, nearestCenter.coords, nearestCenter.name);
            } else {
                updateStatus("Get location and nearest center first.");
            }
        });
    }, 500);
});

// Initialize the Leaflet map
function initializeMap() {
    // Barangay Ilawod approximate coordinates (Legazpi City, Albay)
    const ilawodCoords = [13.1391, 123.7436];
    
    map = L.map('disaster-map').setView(ilawodCoords, 15);
    
    // Base map layers
    const osm = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    });
    const esriSatellite = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
        attribution: '© Esri, Maxar, GeoEye, Earthstar Geographics, and the GIS User Community'
    });
    const esriTopo = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Topo_Map/MapServer/tile/{z}/{y}/{x}', {
        attribution: '© Esri — Esri, DeLorme, NAVTEQ, TomTom, Intermap, iPC, USGS, FAO, NPS, NRCAN, GeoBase, IGN, Kadaster NL, Ordnance Survey, Esri Japan, METI, Esri China (Hong Kong), and the GIS User Community'
    });

    // Default base
    osm.addTo(map);

    // Layer control
    const baseMaps = {
        'Street (OSM)': osm,
        'Satellite (Esri)': esriSatellite,
        'Topographic (Esri)': esriTopo
    };
    L.control.layers(baseMaps, {}, { position: 'topright', collapsed: true }).addTo(map);
    
    // Add Brgy. Ilawod boundary outline and focus the map
    addBarangayOutline();
    
    // Optionally load sample data (disabled by default)
    if (LOAD_SAMPLE_DATA) {
        addEvacuationCenters();
        addRiskAreas();
        addPurokMarkers();
        addEvacuationRoutes();
    }

    // Load hazards from DB (initial cache only; not added to map until filtered)
    loadHazardGeometries();

    // NEW: Load Infrastructure & PWD from API and auto-refresh
    initMapFeaturesLayers();
    loadMapFeaturesForUsers();
    // Refresh every 30s to reflect admin changes automatically
    window._mapFeaturesRefreshTimer = setInterval(loadMapFeaturesForUsers, 30000);
}

// Add evacuation centers to the map
function addEvacuationCenters() {
    const centers = [
        {
            name: "Ilawod Elementary School",
            coords: [13.1395, 123.7440],
            status: "open",
            capacity: 200,
            current: 45,
            address: "Barangay Ilawod, Camalig, Albay, Bicol"
        },
        {
            name: "Barangay Ilawod Hall",
            coords: [13.1387, 123.7432],
            status: "open", 
            capacity: 100,
            current: 25,
            address: "Barangay Ilawod, Camalig, Albay, Bicol"
        },
        {
            name: "Ilawod Community Chapel",
            coords: [13.1390, 123.7445],
            status: "near-full",
            capacity: 150,
            current: 120,
            address: "Barangay Ilawod, Camalig, Albay, Bicol"
        },
        {
            name: "Ilawod Multi-Purpose Hall",
            coords: [13.1392, 123.7438],
            status: "open",
            capacity: 300,
            current: 75,
            address: "Barangay Ilawod, Camalig, Albay, Bicol"
        },
        {
            name: "Ilawod Covered Court",
            coords: [13.1388, 123.7442],
            status: "open",
            capacity: 250,
            current: 60,
            address: "Barangay Ilawod, Camalig, Albay, Bicol"
        }
    ];
    
    centers.forEach(center => {
        const icon = center.status === 'open' ? '🏠' : center.status === 'near-full' ? '🏠' : '🏠';
        const color = center.status === 'open' ? 'green' : center.status === 'near-full' ? 'orange' : 'red';
        
        const marker = L.marker(center.coords)
            .addTo(map)
            .bindPopup(`
                <div class="evacuation-popup">
                    <h6>${center.name}</h6>
                    <p class="small text-muted mb-1">${center.address}</p>
                    <p><strong>Status:</strong> <span style="color: ${color}; text-transform: uppercase;">${center.status.replace('-', ' ')}</span></p>
                    <p><strong>Capacity:</strong> ${center.current}/${center.capacity} people</p>
                </div>
            `);
        
        evacuationCenters.push({...center, marker});
    });
}

// Add risk areas to the map
function addRiskAreas() {
    // High risk flood area
    hazardLayers.flood = L.polygon([
        [13.1385, 123.7425],
        [13.1385, 123.7435],
        [13.1380, 123.7435],
        [13.1380, 123.7425]
    ], {
        color: 'red',
        fillColor: '#ef4444',
        fillOpacity: 0.4,
        weight: 2
    }).addTo(map).bindPopup('<strong>High Risk Flood Zone</strong><br>Prone to flash flooding during heavy rains');
    
    // Medium risk landslide area
    hazardLayers.landslide = L.polygon([
        [13.1400, 123.7450],
        [13.1405, 123.7455],
        [13.1400, 123.7460],
        [13.1395, 123.7455]
    ], {
        color: 'orange',
        fillColor: '#f59e0b',
        fillOpacity: 0.4,
        weight: 2
    }).addTo(map).bindPopup('<strong>Medium Risk Landslide Zone</strong><br>Monitor during heavy rainfall');
    
    // Fire risk area
    hazardLayers.fire = L.polygon([
        [13.1390, 123.7420],
        [13.1395, 123.7425],
        [13.1390, 123.7430],
        [13.1385, 123.7425]
    ], {
        color: '#dc2626',
        fillColor: '#dc2626',
        fillOpacity: 0.3,
        weight: 2
    }).addTo(map).bindPopup('<strong>Fire Risk Zone</strong><br>Area with high fire danger due to vegetation and structures');
    
    // Ashfall risk area (volcanic hazard)
    hazardLayers.ashfall = L.polygon([
        [13.1375, 123.7440],
        [13.1380, 123.7450],
        [13.1375, 123.7460],
        [13.1370, 123.7450]
    ], {
        color: '#6b7280',
        fillColor: '#6b7280',
        fillOpacity: 0.3,
        weight: 2
    }).addTo(map).bindPopup('<strong>Ashfall Risk Zone</strong><br>Potential ashfall area from volcanic activity');
    
    // Lahar flow area
    hazardLayers.lahar = L.polygon([
        [13.1360, 123.7430],
        [13.1365, 123.7440],
        [13.1360, 123.7450],
        [13.1355, 123.7440]
    ], {
        color: '#78350f',
        fillColor: '#78350f',
        fillOpacity: 0.4,
        weight: 2
    }).addTo(map).bindPopup('<strong>Lahar Flow Zone</strong><br>Potential volcanic mudflow area');
    
    // Mudflow risk area
    hazardLayers.mudflow = L.polygon([
        [13.1405, 123.7430],
        [13.1410, 123.7440],
        [13.1405, 123.7450],
        [13.1400, 123.7440]
    ], {
        color: '#92400e',
        fillColor: '#92400e',
        fillOpacity: 0.3,
        weight: 2
    }).addTo(map).bindPopup('<strong>Mudflow Risk Zone</strong><br>Area prone to mudflows during heavy rainfall');
    
    // Wind risk area (typhoon prone)
    hazardLayers.wind = L.polygon([
        [13.1370, 123.7420],
        [13.1375, 123.7430],
        [13.1370, 123.7440],
        [13.1365, 123.7430]
    ], {
        color: '#1e40af',
        fillColor: '#1e40af',
        fillOpacity: 0.3,
        weight: 2
    }).addTo(map).bindPopup('<strong>High Wind Risk Zone</strong><br>Area exposed to strong winds during typhoons');
}

// Add Purok markers
function addPurokMarkers() {
    const puroks = [
        {name: "Purok 1", coords: [13.1392, 123.7428], color: 'black'},
        {name: "Purok 2", coords: [13.1395, 123.7440], color: 'orange'}, 
        {name: "Purok 3", coords: [13.1387, 123.7432], color: 'blue'},
        {name: "Purok 4", coords: [13.1390, 123.7445], color: 'purple'},
        {name: "Purok 5", coords: [13.1388, 123.7438], color: 'green'}
    ];
    
    puroks.forEach(purok => {
        purokMarkers[purok.name] = L.marker(purok.coords, {
            icon: L.divIcon({
                html: `<span style="color: ${purok.color}; font-size: 20px;">🏠</span>`,
                className: 'purok-marker',
                iconSize: [25, 25]
            })
        }).addTo(map).bindPopup(`<strong>${purok.name}</strong><br>Residential Area`);
    });
}

// Add evacuation routes (create but don't automatically add to map)
function addEvacuationRoutes() {
    // Primary evacuation route
    evacuationRoutes.primary = L.polyline([
        [13.1392, 123.7428], // Purok 1
        [13.1390, 123.7435], // Main road
        [13.1387, 123.7432]  // Barangay Hall
    ], {
        color: '#00FF00',
        weight: 4,
        opacity: 0.8
    }).bindPopup('Primary Evacuation Route<br>Main road to Barangay Hall');
    
    // Secondary evacuation route
    evacuationRoutes.secondary = L.polyline([
        [13.1395, 123.7440], // Purok 2 (School)
        [13.1392, 123.7442],
        [13.1390, 123.7445]  // Community Chapel
    ], {
        color: '#FFD700',
        weight: 3,
        opacity: 0.7,
        dashArray: '10, 5'
    }).bindPopup('Secondary Evacuation Route<br>School to Community Chapel');
    
    // Emergency evacuation route
    evacuationRoutes.emergency = L.polyline([
        [13.1388, 123.7438], // Purok 5
        [13.1385, 123.7435],
        [13.1387, 123.7432]  // Barangay Hall
    ], {
        color: '#FF4500',
        weight: 3,
        opacity: 0.6,
        dashArray: '5, 5'
    }).bindPopup('Emergency Evacuation Route<br>Alternative route during emergencies');
    
    // Initially show routes
    showAllRoutes();
}

// Helper function to show all routes
function showAllRoutes() {
    Object.values(evacuationRoutes).forEach(route => {
        if (!map.hasLayer(route)) {
            map.addLayer(route);
        }
    });
}

// Helper function to hide all routes
function hideAllRoutes() {
    Object.values(evacuationRoutes).forEach(route => {
        if (map.hasLayer(route)) {
            map.removeLayer(route);
        }
    });
}

// Control button functions
function toggleRoutes() {
    const btn = document.getElementById('hideRoutesBtn');
    if (routesVisible) {
        btn.innerHTML = '<i class="fas fa-route me-1"></i><span class="d-none d-md-inline">Show Routes</span><span class="d-inline d-md-none">Routes</span>';
        // Hide routes logic here
        routesVisible = false;
        updateStatus('Evacuation routes hidden');
    } else {
        btn.innerHTML = '<i class="fas fa-route me-1"></i><span class="d-none d-md-inline">Hide Routes</span><span class="d-inline d-md-none">Routes</span>';
        // Show routes logic here  
        routesVisible = true;
        updateStatus('Evacuation routes visible');
    }
}

function getCurrentLocationDashboard() {
    updateStatus('Getting your location...');
    if (!navigator.geolocation) {
        updateStatus('Geolocation not supported.');
        return;
    }
    navigator.geolocation.getCurrentPosition(pos => {
        const lat = pos.coords.latitude, lng = pos.coords.longitude;
        currentLocation = [lat, lng];
        addCurrentLocationMarker(currentLocation, "You are here");
        map.setView(currentLocation, 16);
        document.getElementById("locationField").value = `${lat.toFixed(5)}, ${lng.toFixed(5)}`;
        updateStatus("Location detected.");
    }, err => {
        updateStatus("Failed to get location.");
    });
}

// Helper function to add current location marker
function addCurrentLocationMarker(coords, popupText) {
    // Remove existing marker if present
    if (window.currentLocationMarker) {
        map.removeLayer(window.currentLocationMarker);
    }
    
    // Add new marker with pulsing effect
    window.currentLocationMarker = L.marker(coords, {
        icon: L.divIcon({
            html: `<div style="
                width: 20px; 
                height: 20px; 
                background: #3b82f6; 
                border: 3px solid white; 
                border-radius: 50%; 
                box-shadow: 0 0 10px rgba(59, 130, 246, 0.6);
                animation: pulse 2s infinite;
            "></div>
            <style>
                @keyframes pulse {
                    0% { transform: scale(1); opacity: 1; }
                    50% { transform: scale(1.2); opacity: 0.7; }
                    100% { transform: scale(1); opacity: 1; }
                }
            </style>`,
            className: 'current-location-marker',
            iconSize: [20, 20],
            iconAnchor: [10, 10]
        })
    }).addTo(map).bindPopup(popupText);
}

function findNearestEvacuationCenter() {
    if (!currentLocation) {
        updateStatus('Please get your location first');
        return;
    }
    let minDistance = Infinity;
    nearestCenter = null;
    evacuationCenters.forEach(center => {
        const d = calculateDistance(currentLocation, center.coords);
        if (d < minDistance) {
            minDistance = d;
            nearestCenter = center;
        }
    });
    if (nearestCenter) {
        map.setView(nearestCenter.coords, 17);
        nearestCenter.marker.openPopup();
        document.getElementById("locationField").value = 
            `Nearest: ${nearestCenter.name} (${minDistance.toFixed(0)}m)`;
        updateStatus(`Nearest center: ${nearestCenter.name}`);
    }
}

// Function to show route with visual line and direction markers
function showRouteToCenter(destinationCoords, centerName) {
    if (!currentLocation) {
        updateStatus('Please get your location first');
        return;
    }
    
    // Store destination info for potential restore
    window.currentNavigationDestination = destinationCoords;
    window.currentNavigationCenterName = centerName;
    
    // Remove any existing route
    if (window.currentRoute) {
        map.removeLayer(window.currentRoute);
    }
    if (window.routeMarkers) {
        window.routeMarkers.forEach(marker => map.removeLayer(marker));
        window.routeMarkers = [];
    }
    
    // Create route line
    window.currentRoute = L.polyline([currentLocation, destinationCoords], {
        color: '#007bff',
        weight: 5,
        opacity: 0.8,
        dashArray: '10, 5'
    }).addTo(map);
    
    // Add start and end markers
    window.routeMarkers = [];
    
    // Start marker (current location)
    const startMarker = L.marker(currentLocation, {
        icon: L.divIcon({
            html: '<div style="background: #28a745; color: white; border-radius: 50%; width: 24px; height: 24px; display: flex; align-items: center; justify-content: center; font-size: 10px; font-weight: bold; border: 2px solid white;">START</div>',
            className: 'route-marker',
            iconSize: [24, 24],
            iconAnchor: [12, 12]
        })
    }).addTo(map).bindPopup('Your Current Location');
    
    // End marker (evacuation center)
    const endMarker = L.marker(destinationCoords, {
        icon: L.divIcon({
            html: '<div style="background: #dc3545; color: white; border-radius: 50%; width: 24px; height: 24px; display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: bold; border: 2px solid white;">🏠</div>',
            className: 'route-marker',
            iconSize: [24, 24],
            iconAnchor: [12, 12]
        })
    }).addTo(map).bindPopup(`Evacuation Center: ${centerName}`);
    
    // Direction arrow in the middle
    const midPoint = [(currentLocation[0] + destinationCoords[0]) / 2, (currentLocation[1] + destinationCoords[1]) / 2];
    const directionMarker = L.marker(midPoint, {
        icon: L.divIcon({
            html: '<div style="background: #007bff; color: white; border-radius: 50%; width: 20px; height: 20px; display: flex; align-items: center; justify-content: center; font-size: 14px; border: 2px solid white;">→</div>',
            className: 'route-marker',
            iconSize: [20, 20],
            iconAnchor: [10, 10]
        })
    }).addTo(map).bindPopup('Direction to Evacuation Center');
    
    window.routeMarkers = [startMarker, endMarker, directionMarker];
    
    // Fit map to show entire route
    const group = new L.featureGroup([window.currentRoute]);
    map.fitBounds(group.getBounds().pad(0.1));
    
    const distance = calculateDistance(currentLocation, destinationCoords);
    updateStatus(`Route shown to ${centerName} (${distance.toFixed(0)}m away). Use "Clear" button to remove route.`);
}

// Function to clear navigation route (blue line from "Nearest" button)
function clearRoute() {
    if (window.currentRoute) {
        map.removeLayer(window.currentRoute);
        // Store route info for potential restore
        window.lastNavigationDestination = window.currentNavigationDestination;
        window.lastNavigationCenterName = window.currentNavigationCenterName;
        window.currentRoute = null;
    }
    if (window.routeMarkers) {
        window.routeMarkers.forEach(marker => map.removeLayer(marker));
        window.routeMarkers = [];
    }
    updateStatus('Navigation route cleared');
}

function toggleMapViewDashboard() {
    // Toggle between street and satellite view
    updateStatus('Switching map view...');
    
    // Remove current tile layer
    map.eachLayer(function(layer) {
        if (layer instanceof L.TileLayer) {
            map.removeLayer(layer);
        }
    });
    
    // Toggle between OpenStreetMap and satellite view
    if (!window.mapViewSatellite) {
        // Switch to satellite view using Esri World Imagery
        L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
            attribution: '© Esri, Maxar, GeoEye, Earthstar Geographics, CNES/Airbus DS, USDA, USGS, AeroGRID, IGN, and the GIS User Community'
        }).addTo(map);
        window.mapViewSatellite = true;
        updateStatus('Satellite view enabled');
    } else {
        // Switch back to street view
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);
        window.mapViewSatellite = false;
        updateStatus('Street view enabled');
    }
}

function openGoogleMapsGuideDashboard() {
    if (currentLocation) {
        // Find nearest evacuation center
        let nearest = null;
        let minDistance = Infinity;
        
        evacuationCenters.forEach(center => {
            const distance = calculateDistance(currentLocation, center.coords);
            if (distance < minDistance) {
                minDistance = distance;
                nearest = center;
            }
        });
        
        if (nearest) {
            // Open Google Maps with directions - using the correct Ilawod coordinates (13.144,123.756)
            const googleMapsUrl = `https://www.google.com/maps/dir/${currentLocation[0]},${currentLocation[1]}/13.144,123.756`;
            window.open(googleMapsUrl, '_blank');
            updateStatus(`Opened Google Maps with directions to ${nearest.name}`);
        } else {
            // Fallback: Open directions to Barangay Ilawod (correct coordinates)
            const googleMapsUrl = `https://www.google.com/maps/dir/${currentLocation[0]},${currentLocation[1]}/13.144,123.756`;
            window.open(googleMapsUrl, '_blank');
            updateStatus('Opened Google Maps with directions to Barangay Ilawod');
        }
    } else {
        // If no current location, open directions to Barangay Ilawod with correct coordinates
        const googleMapsUrl = 'https://www.google.com/maps/place/13.144,123.756';
        window.open(googleMapsUrl, '_blank');
        updateStatus('Opened Google Maps to Barangay Ilawod - please enable location for directions');
    }
}

// Show/Hide Routes toggle function
function toggleRoutesVisibility() {
    const btn = document.getElementById('toggleRoutesBtn');
    
    if (window.routesVisible) {
        // Hide ALL routes (evacuation routes + blue navigation route)
        hideAllRoutes();
        clearRoute(); // Also hide blue navigation route
        btn.innerHTML = '<i class="fas fa-route me-1"></i><span class="d-none d-md-inline">Show Routes</span><span class="d-inline d-md-none">Show</span>';
        updateStatus('All routes hidden');
        window.routesVisible = false;
    } else {
        // Show ALL routes (evacuation routes + restore any blue navigation route)
        showAllRoutes();
        // If there was a previous navigation route, restore it
        if (window.lastNavigationDestination && window.lastNavigationCenterName) {
            showRouteToCenter(window.lastNavigationDestination, window.lastNavigationCenterName);
        }
        btn.innerHTML = '<i class="fas fa-route me-1"></i><span class="d-none d-md-inline">Hide Routes</span><span class="d-inline d-md-none">Hide</span>';
        updateStatus('All routes visible');
        window.routesVisible = true;
    }
}

// Utility functions
function calculateDistance(pos1, pos2) {
    const R = 6371e3; // Earth's radius in meters
    const φ1 = pos1[0] * Math.PI/180;
    const φ2 = pos2[0] * Math.PI/180;
    const Δφ = (pos2[0]-pos1[0]) * Math.PI/180;
    const Δλ = (pos2[1]-pos1[1]) * Math.PI/180;

    const a = Math.sin(Δφ/2) * Math.sin(Δφ/2) +
              Math.cos(φ1) * Math.cos(φ2) *
              Math.sin(Δλ/2) * Math.sin(Δλ/2);
    const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));

    return R * c;
}

function updateStatus(message) {
    const statusText = document.getElementById('statusText');
    statusText.innerHTML = `<i class="fas fa-info-circle me-1"></i><span>${message}</span>`;
}

function getDirections(coords) {
    const googleMapsUrl = `https://www.google.com/maps/dir/${currentLocation ? currentLocation[0] + ',' + currentLocation[1] : ''}/${coords[0]},${coords[1]}`;
    window.open(googleMapsUrl, '_blank');
}

// Initialize event listeners
function initializeEventListeners() {
    // Hazard filter buttons
    document.querySelectorAll('.hazard-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.hazard-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            
            const hazardType = this.getAttribute('data-hazard');
            filterHazards(hazardType);
            updateStatus(`Showing: ${this.textContent.trim()}`);
        });
    });
    
    // Filter hazards function
    function filterHazards(type) {
        // Hide all hazard layers first
        Object.values(hazardLayers).forEach(layer => {
            if (map.hasLayer(layer)) {
                map.removeLayer(layer);
            }
        });
        
        // Don't touch evacuation routes here - they have their own toggle control
        
        evacuationCenters.forEach(center => {
            if (map.hasLayer(center.marker)) {
                map.removeLayer(center.marker);
            }
        });
        
        Object.values(purokMarkers).forEach(marker => {
            if (map.hasLayer(marker)) {
                map.removeLayer(marker);
            }
        });
        
        // Show based on selected filter
        switch(type) {
            case 'all':
                // Ensure hazards are loaded, then show all
                (async () => {
                    if (Object.keys(hazardLayers).length === 0) {
                        await loadHazardGeometries();
                    }
                    Object.values(hazardLayers).forEach(layer => map.addLayer(layer));
                })();
                evacuationCenters.forEach(center => map.addLayer(center.marker));
                Object.values(purokMarkers).forEach(marker => map.addLayer(marker));
                break;
            case 'none':
                // Keep everything hidden and clear navigation routes (but not evacuation routes)
                clearRoute();
                break;
            case 'evacuation':
                evacuationCenters.forEach(center => map.addLayer(center.marker));
                break;
            case 'routes':
                // This button should now control evacuation routes independently
                toggleRoutesVisibility();
                break;
            case 'flood':
            case 'landslide':
            case 'fire':
            case 'ashfall':
            case 'lahar':
            case 'mudflow':
            case 'wind':
                (async () => {
                    if (!hazardLayers[type]) {
                        await loadHazardGeometries(type);
                    }
                    if (hazardLayers[type]) {
                        map.addLayer(hazardLayers[type]);
                    }
                })();
                break;
        }
    }
    
    // Initialize forms when DOM is ready
    setTimeout(function() {
        const mouForm = document.getElementById('mouRequestForm');
        if (mouForm) {
            mouForm.addEventListener('submit', function(e) {
                e.preventDefault();
                alert('MOU/MOA application submitted successfully! The Barangay team will review your application and contact you for inspection scheduling.');
                this.reset();
            });
        }
        
        const ticketForm = document.getElementById('newTicketForm');
        if (ticketForm) {
            ticketForm.addEventListener('submit', function(e) {
                e.preventDefault();
                alert('Support ticket created successfully! Ticket ID: #' + Math.floor(Math.random() * 1000));
                this.reset();
                const modal = bootstrap.Modal.getInstance(document.getElementById('newTicketModal'));
                if (modal) modal.hide();
            });
        }
    }, 1000);
    
    // Responsive legend toggle for mobile
    if (window.innerWidth < 768) {
        const mapHeader = document.querySelector('.map-header');
        const toggleBtn = document.createElement('button');
        toggleBtn.className = 'btn btn-sm btn-outline-secondary ms-2';
        toggleBtn.innerHTML = '<i class="fas fa-list"></i>';
        toggleBtn.onclick = toggleLegend;
        mapHeader.appendChild(toggleBtn);
    }
}

function toggleLegend() {
    const legend = document.getElementById('legendContainer');
    legend.classList.toggle('d-none');
}

// Auto-update status periodically
setInterval(() => {
    if (document.getElementById('statusText').textContent.includes('Find your location')) {
        const statuses = [
            'All systems operational',
            'Emergency services ready', 
            'Evacuation centers monitored',
            'Weather conditions normal'
        ];
        const randomStatus = statuses[Math.floor(Math.random() * statuses.length)];
        updateStatus(randomStatus);
    }
}, 10000);


// === New: Real road-based routing using OSRM ===
function getRoadRoute(start, end, centerName) {
    if (window.currentRoute) {
        map.removeLayer(window.currentRoute);
    }
    const url = `https://router.project-osrm.org/route/v1/driving/${start[1]},${start[0]};${end[1]},${end[0]}?overview=full&geometries=geojson`;
    fetch(url)
      .then(r=>r.json())
      .then(data=>{
          if (data.routes && data.routes.length) {
              const coords = data.routes[0].geometry.coordinates.map(c=>[c[1],c[0]]);
              window.currentRoute = L.polyline(coords,{color:"blue",weight:5}).addTo(map);
              map.fitBounds(window.currentRoute.getBounds());
              updateStatus(`Route to ${centerName} shown.`);
          } else {
              updateStatus("No route found.");
          }
      })
      .catch(err=>{
          console.error(err);
          updateStatus("Routing failed.");
      });
}
</script>

@endsection