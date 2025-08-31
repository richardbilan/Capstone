@extends('layouts.layout')

@section('title', $title ?? 'Ilawod Barangay Hazard Management System')

@section('additional_styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<<<<<<< HEAD
    <link rel="stylesheet" href="https://unpkg.com/leaflet-draw@1.0.4/dist/leaflet.draw.css" />
=======
>>>>>>> 7a584067cb8174031fa332c11a54a086080e3cd5
    <style>
        /* Disaster Management Dashboard Custom Styles */
        :root {
            /* Professional Disaster Management Color Palette */
            --primary-blue: #1e3a8a;
            --secondary-blue: #3b82f6;
            --accent-blue: #60a5fa;
            --success-green: #059669;
            --warning-orange: #d97706;
            --danger-red: #dc2626;
            --neutral-gray: #6b7280;
            --light-gray: #f8fafc;
            --dark-gray: #374151;
            
            /* Risk Level Colors */
            --high-risk: #ef4444;
            --medium-risk: #f59e0b;
            --low-risk: #10b981;
            
            /* Background Colors */
            --card-bg: #ffffff;
            --panel-bg: #f8fafc;
            --border-color: #e5e7eb;
            
            /* Text Colors */
            --text-primary: #111827;
            --text-secondary: #6b7280;
            --text-muted: #9ca3af;
            
            /* Shadows */
            --card-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --elevated-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        /* Global Styles */
        body {
            background: linear-gradient(135deg, var(--light-gray) 0%, #e2e8f0 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: var(--text-primary);
        }

        /* Hazard Map Wrapper */
        .hazard-map-wrapper {
            position: relative;
            height: 100vh;
            overflow: hidden;
        }

        /* Burger Menu Button */
        .burger-menu-btn {
            position: fixed;
            top: 4rem;
            left: 1rem;
            z-index: 1001;
            background: var(--primary-blue);
            color: white;
            border: none;
            border-radius: 8px;
            padding: 0.75rem;
            font-size: 1.2rem;
            box-shadow: var(--elevated-shadow);
            transition: all 0.3s ease;
        }

        .burger-menu-btn:hover {
            background: var(--secondary-blue);
            transform: translateY(-2px);
        }

        .burger-menu-btn.sidebar-open {
            left: 21rem;
            top: 4rem;
        }

<<<<<<< HEAD
=======


>>>>>>> 7a584067cb8174031fa332c11a54a086080e3cd5
        /* Hazard Sidebar */
        .hazard-sidebar {
            position: fixed;
            top: 0;
            left: -300px;
            width: 300px;
            height: 100%;
            background: rgba(33, 37, 41, 0.95);
            backdrop-filter: blur(10px);
            z-index: 1000;
            transition: left 0.3s ease;
            overflow-y: auto;
            box-shadow: var(--elevated-shadow);
        }

        .hazard-sidebar.active {
            left: 0;
        }

        /* Map container adjustments when sidebar is open */
        .map-container {
            transition: margin-left 0.3s ease;
        }

        .map-container.sidebar-open {
            margin-left: 300px;
        }

<<<<<<< HEAD
        /* Shift main map area when sidebar is open (actual container on this page) */
        .map-main-container.sidebar-open {
            margin-left: 300px;
        }

=======
>>>>>>> 7a584067cb8174031fa332c11a54a086080e3cd5
        /* Hide zoom controls completely */
        .leaflet-control-zoom {
            display: none !important;
        }

        /* Map Legend Container */
        .map-legend-container {
            position: fixed;
            bottom: 1rem;
            right: 1rem;
            width: 300px;
            max-height: 70vh;
            background: var(--card-bg);
            border-radius: 12px;
            box-shadow: var(--elevated-shadow);
            z-index: 1000;
            overflow: hidden;
        }

        .legend-header {
            background: linear-gradient(135deg, var(--primary-blue) 0%, var(--secondary-blue) 100%);
            color: white;
            padding: 1rem;
            border-radius: 12px 12px 0 0;
        }

        .legend-header h6 {
            font-weight: 700;
            font-size: 1rem;
            margin: 0;
        }

        #legendToggle {
            background: white;
            color: var(--primary-blue);
            border: 2px solid white;
            border-radius: 6px;
            padding: 0.375rem 0.75rem;
            font-size: 0.875rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        #legendToggle:hover {
            background: var(--panel-bg);
            transform: translateY(-1px);
        }

        .legend-content {
            max-height: 60vh;
            overflow-y: auto;
            background: var(--panel-bg);
            padding: 1rem;
        }

        /* Legend Sections */
        .legend-section {
            margin-bottom: 1.5rem;
            background: var(--card-bg);
            border-radius: 8px;
            padding: 1rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .legend-section-title {
            font-size: 0.9rem;
            font-weight: 700;
            margin-bottom: 0.75rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid var(--border-color);
            color: var(--text-primary);
        }

        .legend-items {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.375rem;
            border-radius: 4px;
            transition: background 0.2s ease;
        }

        .legend-color {
            width: 18px;
            height: 18px;
            display: inline-block;
            border-radius: 3px;
            border: 1px solid rgba(0,0,0,0.1);
            flex-shrink: 0;
        }

        .legend-item:hover {
            background: var(--light-gray);
        }

        .legend-icon {
            font-size: 1rem;
            width: 20px;
            text-align: center;
        }

        .legend-line {
            width: 20px;
            text-align: center;
            display: inline-block;
        }

        .legend-square {
            width: 18px;
            height: 18px;
            border-radius: 3px;
            display: inline-block;
            border: 1px solid rgba(0, 0, 0, 0.1);
        }

        .legend-text {
            font-size: 0.875rem;
            color: var(--text-primary);
            font-weight: 500;
        }

        /* Risk Level Colors */
        .high-risk {
            background: var(--high-risk);
        }

        .medium-risk {
            background: var(--medium-risk);
        }

        .low-risk {
            background: var(--low-risk);
        }

        /* Map Main Container */
        .map-main-container {
            margin-left: 0;
            padding: 1rem;
            transition: margin-left 0.3s ease;
            height: 100vh;
            overflow: auto;
        }

        .map-title {
            color: var(--primary-blue);
            font-weight: 700;
            font-size: 1.5rem;
            margin-bottom: 1rem;
            text-align: center;
        }

        .map-container {
            position: relative;
            background: var(--card-bg);
            border-radius: 12px;
            box-shadow: var(--elevated-shadow);
            overflow: hidden;
        }

        .disaster-map,
        #hazard-map {
            height: 600px;
            width: 100%;
            border: none;
            border-radius: 12px;
        }

        .map-loading {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: var(--card-bg);
            padding: 1rem 2rem;
            border-radius: 8px;
            box-shadow: var(--card-shadow);
            color: var(--text-primary);
            font-weight: 600;
            z-index: 1000;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .map-legend-container {
                position: fixed;
                bottom: 0;
                right: 0;
                left: 0;
                width: 100%;
                max-height: 60vh;
                border-radius: 12px 12px 0 0;
            }

            .legend-content {
                max-height: 50vh;
            }

            .map-main-container {
                padding: 0.5rem;
                padding-bottom: 5rem;
            }

            .map-title {
                font-size: 1.25rem;
                padding: 0.5rem;
            }

            #hazard-map {
                height: 500px;
            }
        }

        /* Text Colors for specific elements */
        .text-purple {
            color: #7c3aed !important;
        }

        .text-warning {
            color: var(--warning-orange) !important;
        }

        .text-secondary {
            color: var(--neutral-gray) !important;
        }

        .text-info {
            color: var(--accent-blue) !important;
        }

        .text-success {
            color: var(--success-green) !important;
        }

        .text-primary {
            color: var(--primary-blue) !important;
        }

        .text-dark {
            color: var(--dark-gray) !important;
        }

        .text-danger {
            color: var(--danger-red) !important;
        }

        /* Infrastructure marker styling */
        .infrastructure-marker {
            background: transparent !important;
            border: none !important;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .infrastructure-marker i {
            text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
        }
<<<<<<< HEAD

        /* Draft action bar (Save/Cancel new drawings) */
        .draft-actions {
            position: absolute;
            bottom: 80px;
            left: 16px;
            z-index: 1000;
            display: none;
        }
        .draft-actions .btn {
            margin-right: 6px;
        }
=======
>>>>>>> 7a584067cb8174031fa332c11a54a086080e3cd5
    </style>
@endsection

@section('additional_scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<<<<<<< HEAD
    <script src="https://unpkg.com/leaflet-draw@1.0.4/dist/leaflet.draw.js"></script>
    <script src="https://unpkg.com/@turf/turf@6/turf.min.js"></script>
=======
>>>>>>> 7a584067cb8174031fa332c11a54a086080e3cd5
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Burger menu functionality
            const burgerBtn = document.getElementById('burgerMenuBtn');
            const sidebar = document.getElementById('hazardSidebar');
<<<<<<< HEAD
            // On this page the main wrapper is .map-main-container
            const mapContainer = document.querySelector('.map-main-container');

            burgerBtn.addEventListener('click', function() {
                sidebar.classList.toggle('active');
                mapContainer?.classList.toggle('sidebar-open');
=======
            const mapContainer = document.querySelector('.map-container');

            burgerBtn.addEventListener('click', function() {
                sidebar.classList.toggle('active');
                mapContainer.classList.toggle('sidebar-open');
>>>>>>> 7a584067cb8174031fa332c11a54a086080e3cd5
                burgerBtn.classList.toggle('sidebar-open');
                
                // Invalidate map size after transition
                setTimeout(() => {
                    if (window.mapInstance) {
                        window.mapInstance.invalidateSize();
                    }
                }, 300);
            });

<<<<<<< HEAD
            // --- Generic point placement helpers (used by Infrastructures and PWDs) ---
            let pointPlacement = null; // { category, typeKey, type, handler }
            function startPointPlacement({ category, typeKey, type }) {
                stopPointPlacement();
                pointPlacement = { category, typeKey, type };
                const mapEl = document.getElementById('hazardMap');
                if (mapEl) mapEl.style.cursor = 'crosshair';
                const handler = function(e) {
                    placePointMarker(category, typeKey, type, e.latlng);
                    stopPointPlacement();
                };
                pointPlacement.handler = handler;
                map.once('click', handler);
            }

            function stopPointPlacement() {
                const mapEl = document.getElementById('hazardMap');
                if (mapEl) mapEl.style.cursor = '';
                if (pointPlacement?.handler) {
                    try { map.off('click', pointPlacement.handler); } catch {}
                }
                pointPlacement = null;
            }

            function placePointMarker(category, typeKey, type, latlng) {
                let style = { color: '#0d6efd', fillColor: '#0d6efd' };
                if (category === 'infrastructure') style = window.infraStyles[type] || style;
                if (category === 'pwd') style = window.pwdStyles[type] || style;
                const cm = L.circleMarker(latlng, { color: style.color, fillColor: style.fillColor, weight: 2, fillOpacity: 0.8, radius: 9 });
                const feature = {
                    type: 'Feature',
                    properties: { category },
                    geometry: { type: 'Point', coordinates: [latlng.lng, latlng.lat] }
                };
                feature.properties[typeKey] = type;
                feature.properties.pointType = 'circlemarker';
                cm.feature = feature;
                draftLayerGroup.addLayer(cm);
                showDraftActions();
            }

            // --- Routes draw helper: enable ONLY polyline mode ---
            function startRoutesPolylineDraw(routeType) {
                try {
                    // Disable other draw modes if active
                    drawControl._toolbars.draw._modes.polygon?.handler.disable();
                    drawControl._toolbars.draw._modes.rectangle?.handler.disable();
                    drawControl._toolbars.draw._modes.circle?.handler.disable();
                    drawControl._toolbars.draw._modes.marker?.handler.disable();
                    drawControl._toolbars.draw._modes.circlemarker?.handler.disable();
                } catch {}
                try {
                    drawControl._toolbars.draw._modes.polyline.handler.enable();
                } catch (e) {
                    console.warn('Could not start polyline draw for routes', e);
                }
            }

=======
>>>>>>> 7a584067cb8174031fa332c11a54a086080e3cd5
            // Legend toggle functionality
            const legendToggle = document.getElementById('legendToggle');
            const legendContent = document.getElementById('legendContent');

            legendToggle.addEventListener('click', function() {
                if (legendContent.style.display === 'none') {
                    legendContent.style.display = 'block';
                    legendToggle.innerHTML = '<i class="fas fa-eye-slash"></i>';
                    legendToggle.title = 'Hide Legend';
                } else {
                    legendContent.style.display = 'none';
                    legendToggle.innerHTML = '<i class="fas fa-eye"></i>';
                    legendToggle.title = 'Show Legend';
                }
            });

            // Initialize map
            initializeHazardMap();
<<<<<<< HEAD
            // Load existing infrastructure/routes/PWD features from DB on page load
            if (typeof loadMapFeatures === 'function') {
                loadMapFeatures();
            }
=======
>>>>>>> 7a584067cb8174031fa332c11a54a086080e3cd5
        });

        function initializeHazardMap() {
            // Show loading indicator
            const loadingIndicator = document.getElementById('mapLoading');
            if (loadingIndicator) {
                loadingIndicator.style.display = 'block';
            }

            // Initialize Leaflet map - Ilawod, Camalig, Albay, Philippines
<<<<<<< HEAD
            const map = L.map('hazardMap').setView([13.1768, 123.6507], 16); // Ilawod, Camalig, Albay coordinates

            // Base layers: Streets + Satellite
            const streets = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: ' OpenStreetMap contributors'
            }).addTo(map);
            const satellite = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
                attribution: 'Tiles &copy; Esri &mdash; Source: Esri, Maxar, Earthstar Geographics, and the GIS User Community'
            });
            // Layer switcher
            L.control.layers({ 'Streets': streets, 'Satellite': satellite }, {}).addTo(map);
            // Hide loading once default base is ready
            streets.on('load', function() {
                const loadingIndicator = document.getElementById('mapLoading');
                if (loadingIndicator) loadingIndicator.style.display = 'none';
            });

            // FeatureGroup to store editable layers
            const hazardLayerGroup = L.featureGroup().addTo(map);

            // Global registries
            window.mapLayers = { hazardZones: [] };
            window.hazardLayerGroup = hazardLayerGroup;

            // Color/style mapping per hazard type
            window.hazardStyles = {
                flood: { color: '#0d6efd', fillColor: '#0d6efd' },
                landslide: { color: '#ffc107', fillColor: '#ffc107' },
                fire: { color: '#dc3545', fillColor: '#dc3545' },
                ashfall: { color: '#6c757d', fillColor: '#6c757d' },
                lahar: { color: '#343a40', fillColor: '#343a40' },
                mudflow: { color: '#198754', fillColor: '#198754' },
                wind: { color: '#0dcaf0', fillColor: '#0dcaf0' }
            };

            // Styles for infrastructure point markers
            window.infraStyles = {
                barangay_hall: { color: '#0d6efd', fillColor: '#0d6efd' },
                elementary_school: { color: '#FFDC00', fillColor: '#FFDC00' },
                chapel: { color: '#B10DC9', fillColor: '#B10DC9' },
                health_center: { color: '#dc3545', fillColor: '#dc3545' },
                multi_purpose_hall: { color: '#198754', fillColor: '#198754' },
                day_care_center: { color: '#F59E0B', fillColor: '#F59E0B' }
            };

            // Styles for PWD point markers (single style for now)
            window.pwdStyles = {
                pwd_households: { color: '#ffffff', fillColor: '#ffffff' }
            };

            // Initialize draw controls for authenticated users
            @auth
            const drawControl = new L.Control.Draw({
                draw: {
                    polygon: {
                        allowIntersection: false,
                        showArea: true,
                        shapeOptions: { color: '#0d6efd', weight: 2, fillOpacity: 0.3 }
                    },
                    polyline: {
                        shapeOptions: { color: '#0d6efd', weight: 3 }
                    },
                    rectangle: {
                        shapeOptions: { color: '#0d6efd', weight: 2, fillOpacity: 0.2 }
                    },
                    circle: {
                        shapeOptions: { color: '#0d6efd', weight: 2, fillOpacity: 0.2 }
                    },
                    circlemarker: {
                        color: '#0d6efd'
                    },
                    marker: true
                },
                edit: {
                    featureGroup: hazardLayerGroup,
                    remove: true
                }
            });
            map.addControl(drawControl);

            const CSRF_TOKEN = '{{ csrf_token() }}';
            const ROUTE_BUFFER_METERS = 15; // default corridor width for lines

            // A temporary feature group to hold newly drawn (unsaved) layers
            const draftLayerGroup = new L.FeatureGroup();
            map.addLayer(draftLayerGroup);
            const draftActionsEl = document.getElementById('draftActions');
            const btnSaveDrafts = document.getElementById('btnSaveDrafts');
            const btnCancelDrafts = document.getElementById('btnCancelDrafts');

            function showDraftActions() { if (draftActionsEl) draftActionsEl.style.display = 'block'; }
            function hideDraftActions() { if (draftActionsEl) draftActionsEl.style.display = 'none'; }

            // --- Map Features API wiring ---
            const MAP_FEATURES_API = '/api/map-features';
            const featureLayers = {
                infrastructure: L.layerGroup(),
                route: L.layerGroup(),
                pwd: L.layerGroup(),
            };
            // Keep sub-groups by type for filtering
            const infraTypeGroups = {};
            const pwdTypeGroups = {};
            // Add feature layers to map
            featureLayers.infrastructure.addTo(map);
            featureLayers.route.addTo(map);
            featureLayers.pwd.addTo(map);

            // --- Ilawod outline from local GeoJSON ---
            const ILAWOD_GEOJSON_URL = '/assets/geo/ilawod.geojson';
            let ilawodLayer = null;
            async function loadIlawodOutline() {
                try {
                    const resp = await fetch(ILAWOD_GEOJSON_URL, { cache: 'no-store' });
                    if (!resp.ok) throw new Error('Failed to fetch ilawod.geojson');
                    const geo = await resp.json();
                    drawIlawodGeoJSON(geo);
                } catch (e) {
                    console.warn('Ilawod outline load failed:', e);
                }
            }
            function drawIlawodGeoJSON(geo) {
                try { if (ilawodLayer) map.removeLayer(ilawodLayer); } catch {}
                ilawodLayer = L.geoJSON(geo, {
                    style: function() {
                        return {
                            color: '#000000',
                            weight: 2,
                            fill: false,
                            fillOpacity: 0
                        };
                    }
                }).addTo(map);
                const b = ilawodLayer.getBounds();
                if (b && b.isValid()) {
                    map.fitBounds(b.pad(0.05));
                }
            }
            // Load Ilawod outline on init
            loadIlawodOutline();

            function getStyleForFeature(feature) {
                const props = feature.properties || {};
                const styles = {
                    infrastructure: window.infraStyles || {},
                    pwd: window.pwdStyles || {},
                    route: { evac_routes: { color: '#0dcaf0', weight: 6, fillOpacity: 0.8 } },
                };
                const cat = props.category;
                const type = props.type || props.infra_type || props.pwd_type || props.route_type;
                return (styles[cat] && styles[cat][type]) ? styles[cat][type] : { color: '#666' };
            }

            // Icon mapping for infra and pwd
            const infraIconMap = {
                barangay_hall: { class: 'fas fa-building', colorClass: 'text-primary', color: '#0d6efd' },
                elementary_school: { class: 'fas fa-school', color: '#FFDC00' },
                chapel: { class: 'fas fa-church', color: '#B10DC9' },
                health_center: { class: 'fas fa-hospital', colorClass: 'text-danger', color: '#dc3545' },
                multi_purpose_hall: { class: 'fas fa-building-columns', colorClass: 'text-success', color: '#198754' },
                day_care_center: { class: 'fas fa-child', color: '#F59E0B' },
            };
            const pwdIconMap = {
                pwd_households: { class: 'fas fa-wheelchair', colorClass: 'text-info', color: '#0dcaf0' },
            };

            function getFaIcon(category, type) {
                const spec = (category === 'infrastructure' ? infraIconMap[type] : pwdIconMap[type]) || { class: 'fas fa-map-marker-alt', color: '#0d6efd' };
                const cls = [spec.class, spec.colorClass].filter(Boolean).join(' ');
                // Larger icon: increase font-size and icon box size
                const colorStyle = spec.color ? `color:${spec.color};` : '';
                const html = `<i class="${cls}" style="${colorStyle}font-size:20px;"></i>`;
                return L.divIcon({ html, className: 'fa-div-icon', iconSize: [20, 20], iconAnchor: [10,10] });
            }

            function syncFeatureVisibility() {
                // Infra: single-select behavior like hazards
                const selInfra = getSelectedInfraType();
                Object.entries(infraTypeGroups).forEach(([t, lg]) => {
                    if (selInfra && t !== selInfra) {
                        featureLayers.infrastructure.removeLayer(lg);
                    } else {
                        featureLayers.infrastructure.addLayer(lg);
                    }
                });
                // If a selection exists but no group yet (e.g., fresh reload), reload features
                if (selInfra && !infraTypeGroups[selInfra]) {
                    // Fire and forget; load will call sync again
                    loadMapFeatures().catch(()=>{});
                }
                // PWD: single-select behavior
                const selPwd = getSelectedPwdType();
                Object.entries(pwdTypeGroups).forEach(([t, lg]) => {
                    if (selPwd && t !== selPwd) {
                        featureLayers.pwd.removeLayer(lg);
                    } else {
                        featureLayers.pwd.addLayer(lg);
                    }
                });
                if (selPwd && !pwdTypeGroups[selPwd]) {
                    loadMapFeatures().catch(()=>{});
                }
            }

            async function loadMapFeatures() {
                try {
                    // Clear containers and type maps
                    Object.values(featureLayers).forEach(lg => lg.clearLayers());
                    Object.keys(infraTypeGroups).forEach(k => delete infraTypeGroups[k]);
                    Object.keys(pwdTypeGroups).forEach(k => delete pwdTypeGroups[k]);
                    const resp = await fetch(MAP_FEATURES_API, { headers: { 'Accept': 'application/json' } });
                    if (!resp.ok) throw new Error('Failed to load features');
                    const fc = await resp.json();
                    (fc.features || []).forEach(f => {
                        const layer = L.geoJSON(f, {
                            pointToLayer: (feat, latlng) => {
                                const cat = feat.properties?.category;
                                const type = feat.properties?.type || feat.properties?.infra_type || feat.properties?.pwd_type;
                                if (cat === 'infrastructure' || cat === 'pwd') {
                                    return L.marker(latlng, { icon: getFaIcon(cat, type) });
                                }
                                return L.circleMarker(latlng, { radius: 9, fillOpacity: 0.8, weight: 2, ...getStyleForFeature(feat) });
                            },
                            style: feat => getStyleForFeature(feat)
                        });
                        const cat = f.properties?.category;
                        const type = f.properties?.type || f.properties?.infra_type || f.properties?.pwd_type || f.properties?.route_type;
                        if (cat === 'infrastructure') {
                            if (!infraTypeGroups[type]) {
                                infraTypeGroups[type] = L.layerGroup();
                                featureLayers.infrastructure.addLayer(infraTypeGroups[type]);
                            }
                            layer.addTo(infraTypeGroups[type]);
                            // Add child layers to edit group so edit/delete works and retain feature refs
                            layer.eachLayer(l => { try { l.feature = f; hazardLayerGroup.addLayer(l); } catch {} });
                        } else if (cat === 'pwd') {
                            if (!pwdTypeGroups[type]) {
                                pwdTypeGroups[type] = L.layerGroup();
                                featureLayers.pwd.addLayer(pwdTypeGroups[type]);
                            }
                            layer.addTo(pwdTypeGroups[type]);
                            layer.eachLayer(l => { try { l.feature = f; hazardLayerGroup.addLayer(l); } catch {} });
                        } else if (cat === 'route') {
                            featureLayers.route.addLayer(layer);
                        }
                    });
                    // Apply current filters after load
                    syncFeatureVisibility();
                } catch (e) {
                    console.warn('loadMapFeatures error', e);
                }
            }

            // Helper: get currently selected hazard type(s)
            function getSelectedHazardTypes() {
                const types = [];
                document.querySelectorAll('.hazard-checkbox:checked').forEach(cb => types.push(cb.dataset.hazard));
                return types;
            }

            // Helper: get selected Infrastructure type (expect max 1)
            function getSelectedInfraType() {
                const selected = Array.from(document.querySelectorAll('.infra-checkbox:checked'));
                return selected.length === 1 ? selected[0].dataset.layer : null;
            }

            // Helper: get selected PWD type (expect max 1)
            function getSelectedPwdType() {
                const selected = Array.from(document.querySelectorAll('.pwd-checkbox:checked'));
                return selected.length === 1 ? selected[0].dataset.layer : null;
            }

            // Sync UI selection to a single hazard and load it
            function selectOnlyHazard(hazard) {
                document.querySelectorAll('.hazard-checkbox').forEach(cb => {
                    cb.checked = (cb.dataset.hazard === hazard);
                });
                if (typeof loadHazardsForTypes === 'function') {
                    loadHazardsForTypes([hazard]);
                }
            }

            // Attach checkbox change -> load selected hazards
            document.querySelectorAll('.hazard-checkbox').forEach(cb => {
                cb.addEventListener('change', () => {
                    const types = getSelectedHazardTypes();
                    if (typeof loadHazardsForTypes === 'function') {
                        loadHazardsForTypes(types);
                    }
                });
            });

            // Infra checkboxes: enforce single-select and sync visibility
            document.querySelectorAll('.infra-checkbox').forEach(cb => {
                cb.addEventListener('change', (e) => {
                    if (e.target.checked) {
                        document.querySelectorAll('.infra-checkbox').forEach(x => { if (x !== e.target) x.checked = false; });
                    }
                    syncFeatureVisibility();
                });
            });

            // PWD checkboxes: enforce single-select and sync visibility
            document.querySelectorAll('.pwd-checkbox').forEach(cb => {
                cb.addEventListener('change', (e) => {
                    if (e.target.checked) {
                        document.querySelectorAll('.pwd-checkbox').forEach(x => { if (x !== e.target) x.checked = false; });
                    }
                    syncFeatureVisibility();
                });
            });

            // Save drafts -> POST then move to correct layer group
            if (btnSaveDrafts) btnSaveDrafts.addEventListener('click', async () => {
                const toSave = [];
                draftLayerGroup.eachLayer(l => toSave.push(l));
                if (!toSave.length) { hideDraftActions(); return; }
                // Split drafts into map-features (infra/pwd/route) and hazards
                const mapFeatureFeatures = [];
                const hazardLayers = [];
                for (const layer of toSave) {
                    const f = layer.feature || layer.toGeoJSON();
                    const cat = f.properties?.category;
                    if (cat === 'infrastructure' || cat === 'pwd' || cat === 'route') {
                        // Normalize type
                        const type = f.properties.type || f.properties.infra_type || f.properties.pwd_type || f.properties.route_type;
                        mapFeatureFeatures.push({
                            // top-level fields to satisfy backend validation
                            category: cat,
                            type: type,
                            // attach original properties and geometry
                            properties: { category: cat, type, ...(f.properties || {}) },
                            geometry: f.geometry
                        });
                    } else {
                        hazardLayers.push({ layer, feature: f });
                    }
                }

                // 1) Save map-features batch
                if (mapFeatureFeatures.length) {
                    try {
                        const resp = await fetch(MAP_FEATURES_API, {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF_TOKEN, 'Accept': 'application/json' },
                            body: JSON.stringify({ features: mapFeatureFeatures })
                        });
                        if (!resp.ok) {
                            let msg = 'Failed to save map features';
                            try { const t = await resp.text(); if (t) msg += `: ${resp.status} ${t}`; } catch {}
                            throw new Error(msg);
                        }
                        await resp.json();
                    } catch (e) {
                        console.error(e);
                        alert(`Error saving features. ${e.message || ''}`);
                    }
                }

                // 2) Save hazards individually (existing flow)
                for (const item of hazardLayers) {
                    const { layer, feature: f } = item;
                    const hazardType = f.properties?.hazard_type || getSelectedHazardTypes()[0];
                    const color = (window.hazardStyles[hazardType] || {}).color || '#0d6efd';
                    try {
                        const resp = await fetch('/api/hazards', {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF_TOKEN, 'Accept': 'application/json' },
                            body: JSON.stringify({ hazard_type: hazardType, color, geometry: f.geometry, properties: f.properties || {} })
                        });
                        if (!resp.ok) throw new Error('Failed to save hazard');
                        const saved = await resp.json();
                        layer.feature = { type: 'Feature', properties: { id: saved.id, hazard_type: saved.hazard_type, ...(f.properties || {}) }, geometry: f.geometry };
                        hazardLayerGroup.addLayer(layer);
                        draftLayerGroup.removeLayer(layer);
                    } catch (err) {
                        console.error(err);
                        alert('Error saving hazard geometry.');
                    }
                }

                // After saving, reload map-features and clear drafts
                await loadMapFeatures();
                draftLayerGroup.clearLayers();
                if (draftLayerGroup.getLayers().length === 0) hideDraftActions();
            });

            // Cancel drafts -> clear temporary layers
            if (btnCancelDrafts) btnCancelDrafts.addEventListener('click', () => {
                draftLayerGroup.clearLayers();
                hideDraftActions();
            });

            // Attach Edit buttons -> select hazard and enable edit mode
            document.querySelectorAll('.hazard-edit-btn').forEach(btn => {
                btn.addEventListener('click', () => {
                    const hazard = btn.dataset.hazard;
                    selectOnlyHazard(hazard);
                    try {
                        // Enable Leaflet.draw edit mode for current featureGroup
                        drawControl._toolbars.edit._modes.edit.handler.enable();
                    } catch (e) {
                        console.warn('Could not enable edit mode', e);
                    }
                });
            });

            // Infrastructure Edit buttons -> focus type, enable edit/delete modes
            document.querySelectorAll('.infra-edit-btn').forEach(btn => {
                btn.addEventListener('click', () => {
                    const infraType = btn.dataset.layer; // e.g., barangay_hall
                    // Select only the corresponding infrastructure checkbox
                    document.querySelectorAll('.infra-checkbox').forEach(cb => { cb.checked = (cb.dataset.layer === infraType); });
                    // Do not force point placement; allow admin to use ANY draw tool
                    stopPointPlacement();
                    // Sync visibility to only this infra type
                    syncFeatureVisibility();
                    // Enable edit and delete modes
                    try { drawControl._toolbars.edit._modes.edit.handler.enable(); } catch {}
                    try { drawControl._toolbars.edit._modes.remove.handler.enable(); } catch {}
                });
            });

            // Routes Edit buttons -> restrict to polyline draw only
            document.querySelectorAll('.routes-edit-btn').forEach(btn => {
                btn.addEventListener('click', () => {
                    const routeType = btn.dataset.layer; // e.g., evac_routes
                    document.querySelectorAll('.routes-checkbox').forEach(cb => { cb.checked = (cb.dataset.layer === routeType); });
                    startRoutesPolylineDraw(routeType);
                });
            });

            // PWD Edit buttons -> focus type, enable edit/delete modes
            document.querySelectorAll('.pwd-edit-btn').forEach(btn => {
                btn.addEventListener('click', () => {
                    const pwdType = btn.dataset.layer; // e.g., pwd_households
                    document.querySelectorAll('.pwd-checkbox').forEach(cb => { cb.checked = (cb.dataset.layer === pwdType); });
                    // Do not force point placement; allow admin to use ANY draw tool
                    stopPointPlacement();
                    // Sync visibility to only this PWD type
                    syncFeatureVisibility();
                    try { drawControl._toolbars.edit._modes.edit.handler.enable(); } catch {}
                    try { drawControl._toolbars.edit._modes.remove.handler.enable(); } catch {}
                });
            });

            // Create new geometry (stage into drafts; save after clicking Save)
            map.on(L.Draw.Event.CREATED, async function (e) {
                let layer = e.layer;
                let layerType = e.layerType; // polygon | polyline | rectangle | circle | marker | circlemarker

                // 1) If Routes active: ONLY allow polyline
                const selectedRoutes = Array.from(document.querySelectorAll('.routes-checkbox:checked'));
                if (selectedRoutes.length === 1) {
                    const routeType = selectedRoutes[0].dataset.layer;
                    if (layerType !== 'polyline') {
                        alert('Evacuation Routes can only be drawn as a line.');
                        try { map.removeLayer(layer); } catch {}
                        return;
                    }
                    // Tag as route feature and push to drafts
                    const gj = layer.toGeoJSON();
                    gj.properties = { category: 'route', route_type: routeType };
                    layer.feature = gj;
                    draftLayerGroup.addLayer(layer);
                    showDraftActions();
                    return;
                }

                // 2) If Infrastructure or PWD is selected -> allow ANY tool and save as map-feature draft
                const infraType = getSelectedInfraType();
                const pwdType = getSelectedPwdType();
                if ((infraType && !pwdType) || (!infraType && pwdType)) {
                    const category = infraType ? 'infrastructure' : 'pwd';
                    const typeKey = infraType ? 'infra_type' : 'pwd_type';
                    const typeVal = infraType || pwdType;

                    // Apply category-specific styling
                    try {
                        const styleMap = category === 'infrastructure' ? (window.infraStyles || {}) : (window.pwdStyles || {});
                        const style = styleMap[typeVal] || { color: '#0d6efd', fillColor: '#0d6efd' };
                        layer.setStyle?.({ ...style, weight: 2, fillOpacity: 0.5 });
                    } catch {}

                    // Normalize point layers to circleMarker and capture radius for circle
                    let gj = layer.toGeoJSON();
                    let geo = gj.geometry;
                    const properties = { category };
                    properties[typeKey] = typeVal;

                    if (layerType === 'circle') {
                        properties.radius = layer.getRadius();
                    } else if (layerType === 'marker') {
                        // convert to icon marker
                        const latlng = layer.getLatLng();
                        const icon = getFaIcon(category, typeVal);
                        const mk = L.marker(latlng, { icon });
                        layer = mk;
                        layerType = 'marker';
                        gj = layer.toGeoJSON();
                        geo = gj.geometry;
                        properties.pointType = 'icon-marker';
                    } else if (layerType === 'circlemarker') {
                        // convert circleMarker to icon marker as well
                        const latlng = layer.getLatLng();
                        const icon = getFaIcon(category, typeVal);
                        const mk = L.marker(latlng, { icon });
                        layer = mk;
                        layerType = 'marker';
                        gj = layer.toGeoJSON();
                        geo = gj.geometry;
                        properties.pointType = 'icon-marker';
                    }

                    layer.feature = { type: 'Feature', properties, geometry: geo };
                    draftLayerGroup.addLayer(layer);
                    showDraftActions();
                    return;
                }

                // 3) Default hazard drawing flow (hazards only)
                const types = getSelectedHazardTypes();
                if (types.length !== 1) {
                    alert('Please select exactly one hazard type in the sidebar before drawing.');
                    try { map.removeLayer(layer); } catch {}
                    return;
                }
                const hazardType = types[0];
                const style = window.hazardStyles[hazardType] || { color: '#0d6efd', fillColor: '#0d6efd' };
                // Apply style to supported shapes
                try { layer.setStyle?.({ ...style, weight: 2, fillOpacity: 0.3 }); } catch {}

                // Build geometry and properties
                let gj = layer.toGeoJSON();
                let geo = gj.geometry;
                const properties = {};
                // Ensure all saved features are fillable
                if (layerType === 'polyline') {
                    try {
                        const buffered = turf.buffer(gj, ROUTE_BUFFER_METERS, { units: 'meters' });
                        // Replace drawn line with buffered polygon for map and save
                        const poly = L.geoJSON(buffered, { style: { ...style, weight: 2, fillOpacity: 0.3 } });
                        let replacedLayer;
                        poly.eachLayer(l => { replacedLayer = l; });
                        if (replacedLayer) {
                            layer = replacedLayer;
                            layerType = 'polygon';
                            gj = buffered.features ? buffered.features[0] : buffered;
                            geo = gj.geometry;
                        }
                    } catch (err) {
                        console.error('Buffer failed, saving as line without fill', err);
                    }
                }
                if (layerType === 'circle') {
                    properties.radius = layer.getRadius();
                } else if (layerType === 'circlemarker' || layerType === 'marker') {
                    // Force points to be fillable dots
                    properties.pointType = 'circlemarker';
                    const latlng = layer.getLatLng();
                    const cm = L.circleMarker(latlng, { color: style.color, fillColor: style.fillColor, weight: 2, fillOpacity: 0.5, radius: 8 });
                    layer = cm;
                    layerType = 'circlemarker';
                }
                // Stage as draft instead of saving immediately
                layer.feature = { type: 'Feature', properties: { hazard_type: hazardType, ...properties }, geometry: geo };
                draftLayerGroup.addLayer(layer);
                showDraftActions();
            });

            // Edit existing geometry
            map.on(L.Draw.Event.EDITED, async function (e) {
                const layers = e.layers;
                layers.eachLayer(async function (layer) {
                    const feat = layer?.feature;
                    const id = feat?.id || feat?.properties?.id;
                    if (!id) return;
                    const geo = layer.toGeoJSON().geometry;
                    const baseProps = { ...(feat?.properties || {}) };
                    // Update point metadata
                    if (layer instanceof L.Circle) {
                        baseProps.radius = layer.getRadius();
                    } else if (layer instanceof L.CircleMarker) {
                        baseProps.pointType = 'circlemarker';
                    } else if (layer instanceof L.Marker) {
                        if (baseProps.category === 'infrastructure' || baseProps.category === 'pwd') {
                            baseProps.pointType = 'icon-marker';
                        } else {
                            baseProps.pointType = 'marker';
                        }
                    }
                    const isMapFeature = !!baseProps.category && !!baseProps.type && !baseProps.hazard_type;
                    const url = isMapFeature ? `/api/map-features/${id}` : `/api/hazards/${id}`;
                    const payload = isMapFeature ? { geometry: geo, properties: baseProps } : { geometry: geo, properties: baseProps };
                    try {
                        const resp = await fetch(url, {
                            method: 'PUT',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': CSRF_TOKEN,
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify(payload)
                        });
                        if (!resp.ok) throw new Error('Failed to update');
                    } catch (err) {
                        console.error(err);
                        alert('Error updating geometry.');
                    }
                });
            });

            // Delete geometry
            map.on(L.Draw.Event.DELETED, async function (e) {
                const layers = e.layers;
                layers.eachLayer(async function (layer) {
                    const feat = layer?.feature;
                    const id = feat?.id || feat?.properties?.id;
                    if (!id) return;
                    const props = feat?.properties || {};
                    const isMapFeature = !!props.category && !!props.type && !props.hazard_type;
                    const url = isMapFeature ? `/api/map-features/${id}` : `/api/hazards/${id}`;
                    try {
                        const resp = await fetch(url, {
                            method: 'DELETE',
                            headers: { 'X-CSRF-TOKEN': CSRF_TOKEN, 'Accept': 'application/json' }
                        });
                        if (!resp.ok) throw new Error('Failed to delete');
                    } catch (err) {
                        console.error(err);
                        alert('Error deleting geometry.');
                    }
                });
            });
            @endauth

            // Load hazards based on checked boxes
            async function loadHazardsForTypes(types) {
                // Clear existing hazard layers
                window.mapLayers.hazardZones.forEach(layer => {
                    try { window.mapInstance.removeLayer(layer); } catch {}
                });
                window.mapLayers.hazardZones = [];
                window.hazardLayerGroup.clearLayers();

                const allBounds = [];
                for (const t of types) {
                    try {
                        const resp = await fetch(`/api/hazards?type=${encodeURIComponent(t)}`);
                        if (!resp.ok) continue;
                        const items = await resp.json();
                        items.forEach(item => {
                            const style = window.hazardStyles[item.hazard_type] || { color: item.color || '#0d6efd', fillColor: item.color || '#0d6efd' };
                            const feature = { type: 'Feature', properties: { id: item.id, hazard_type: item.hazard_type, ...(item.properties || {}) }, geometry: item.geometry };
                            const layer = L.geoJSON(feature, {
                                style: function(f) {
                                    return { ...style, weight: 2, fillOpacity: 0.3 };
                                },
                                pointToLayer: function (f, latlng) {
                                    const radius = f.properties?.radius;
                                    if (radius) {
                                        return L.circle(latlng, { radius, color: style.color, fillColor: style.fillColor, weight: 2, fillOpacity: 0.2 });
                                    }
                                    if (f.properties?.pointType === 'circlemarker') {
                                        return L.circleMarker(latlng, { color: style.color, fillColor: style.fillColor, weight: 2, fillOpacity: 0.5, radius: 8 });
                                    }
                                    return L.marker(latlng);
                                }
                            });
                            layer.eachLayer(l => {
                                // Keep the feature on child layer for edit/deletes
                                l.feature = feature;
                                @auth
                                window.hazardLayerGroup.addLayer(l);
                                @endauth
                                window.mapLayers.hazardZones.push(l);
                                if (l.getBounds) {
                                    allBounds.push(l.getBounds());
                                }
                            });
                            layer.addTo(window.mapInstance);
                        });
                    } catch (err) {
                        console.error('Failed loading hazards for', t, err);
                    }
                }

                // Fit bounds if any
                if (allBounds.length) {
                    const bounds = allBounds.reduce((acc, b) => acc ? acc.extend(b) : L.latLngBounds(b.getSouthWest(), b.getNorthEast()), null);
                    if (bounds) window.mapInstance.fitBounds(bounds, { padding: [20, 20] });
                }
            }
=======
            const map = L.map('hazard-map').setView([13.1768, 123.6507], 16); // Ilawod, Camalig, Albay coordinates

            // Add tile layer
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);

            // Database structure for Puroks in Ilawod, Camalig, Albay
            const purokData = [
                {
                    id: 1,
                    name: 'Purok 1',
                    barangay: 'Ilawod',
                    municipality: 'Camalig',
                    province: 'Albay',
                    color: '#000000',
                    coordinates: [
                        [13.1788, 123.6487],
                        [13.1798, 123.6497],
                        [13.1808, 123.6507],
                        [13.1798, 123.6517],
                        [13.1788, 123.6507],
                        [13.1788, 123.6487]
                    ]
                },
                {
                    id: 2,
                    name: 'Purok 2',
                    barangay: 'Ilawod',
                    municipality: 'Camalig',
                    province: 'Albay',
                    color: '#FF851B',
                    coordinates: [
                        [13.1798, 123.6497],
                        [13.1808, 123.6507],
                        [13.1818, 123.6517],
                        [13.1808, 123.6527],
                        [13.1798, 123.6517],
                        [13.1798, 123.6497]
                    ]
                },
                {
                    id: 3,
                    name: 'Purok 3',
                    barangay: 'Ilawod',
                    municipality: 'Camalig',
                    province: 'Albay',
                    color: '#0074D9',
                    coordinates: [
                        [13.1748, 123.6487],
                        [13.1758, 123.6497],
                        [13.1768, 123.6507],
                        [13.1758, 123.6517],
                        [13.1748, 123.6507],
                        [13.1748, 123.6487]
                    ]
                },
                {
                    id: 4,
                    name: 'Purok 4',
                    barangay: 'Ilawod',
                    municipality: 'Camalig',
                    province: 'Albay',
                    color: '#B10DC9',
                    coordinates: [
                        [13.1758, 123.6497],
                        [13.1768, 123.6507],
                        [13.1778, 123.6517],
                        [13.1768, 123.6527],
                        [13.1758, 123.6517],
                        [13.1758, 123.6497]
                    ]
                },
                {
                    id: 5,
                    name: 'Purok 5',
                    barangay: 'Ilawod',
                    municipality: 'Camalig',
                    province: 'Albay',
                    color: '#FFDC00',
                    coordinates: [
                        [13.1768, 123.6507],
                        [13.1778, 123.6517],
                        [13.1788, 123.6527],
                        [13.1778, 123.6537],
                        [13.1768, 123.6527],
                        [13.1768, 123.6507]
                    ]
                }
            ];

            // Don't add Purok polygons initially - controlled by checkboxes

            // Database structure for Hazard Zones in Ilawod, Camalig, Albay
            const hazardZones = [
                {
                    id: 1,
                    name: 'Flood Prone Area',
                    type: 'flood',
                    color: '#0d6efd',
                    severity: 'high',
                    barangay: 'Ilawod',
                    municipality: 'Camalig',
                    province: 'Albay',
                    coordinates: [
                        [13.1748, 123.6487],
                        [13.1758, 123.6497],
                        [13.1768, 123.6507],
                        [13.1758, 123.6517],
                        [13.1748, 123.6507],
                        [13.1748, 123.6487]
                    ]
                },
                {
                    id: 2,
                    name: 'Landslide Prone Area',
                    type: 'landslide',
                    color: '#ffc107',
                    severity: 'high',
                    barangay: 'Ilawod',
                    municipality: 'Camalig',
                    province: 'Albay',
                    coordinates: [
                        [13.1768, 123.6477],
                        [13.1778, 123.6487],
                        [13.1788, 123.6497],
                        [13.1778, 123.6507],
                        [13.1768, 123.6497],
                        [13.1768, 123.6477]
                    ]
                },
                {
                    id: 3,
                    name: 'Fire Hazard Zone',
                    type: 'fire',
                    color: '#dc3545',
                    severity: 'medium',
                    barangay: 'Ilawod',
                    municipality: 'Camalig',
                    province: 'Albay',
                    coordinates: [
                        [13.1778, 123.6497],
                        [13.1788, 123.6507],
                        [13.1798, 123.6517],
                        [13.1788, 123.6527],
                        [13.1778, 123.6517],
                        [13.1778, 123.6497]
                    ]
                },
                {
                    id: 4,
                    name: 'Ashfall Zone',
                    type: 'ashfall',
                    color: '#6c757d',
                    severity: 'high',
                    barangay: 'Ilawod',
                    municipality: 'Camalig',
                    province: 'Albay',
                    coordinates: [
                        [13.1738, 123.6477],
                        [13.1748, 123.6487],
                        [13.1758, 123.6497],
                        [13.1748, 123.6507],
                        [13.1738, 123.6497],
                        [13.1738, 123.6477]
                    ]
                },
                {
                    id: 5,
                    name: 'Lahar Flow Zone',
                    type: 'lahar',
                    color: '#343a40',
                    severity: 'high',
                    barangay: 'Ilawod',
                    municipality: 'Camalig',
                    province: 'Albay',
                    coordinates: [
                        [13.1758, 123.6517],
                        [13.1768, 123.6527],
                        [13.1778, 123.6537],
                        [13.1768, 123.6547],
                        [13.1758, 123.6537],
                        [13.1758, 123.6517]
                    ]
                },
                {
                    id: 6,
                    name: 'Mudflow Zone',
                    type: 'mudflow',
                    color: '#198754',
                    severity: 'medium',
                    barangay: 'Ilawod',
                    municipality: 'Camalig',
                    province: 'Albay',
                    coordinates: [
                        [13.1788, 123.6517],
                        [13.1798, 123.6527],
                        [13.1808, 123.6537],
                        [13.1798, 123.6547],
                        [13.1788, 123.6537],
                        [13.1788, 123.6517]
                    ]
                },
                {
                    id: 7,
                    name: 'Wind Hazard Zone',
                    type: 'wind',
                    color: '#0dcaf0',
                    severity: 'medium',
                    barangay: 'Ilawod',
                    municipality: 'Camalig',
                    province: 'Albay',
                    coordinates: [
                        [13.1798, 123.6537],
                        [13.1808, 123.6547],
                        [13.1818, 123.6557],
                        [13.1808, 123.6567],
                        [13.1798, 123.6557],
                        [13.1798, 123.6537]
                    ]
                }
            ];

            // Don't add hazard zones initially - controlled by checkboxes

            // Define evacuation centers - Matching dashboard data
            const evacuationCenters = [
                { name: 'Barangay Ilawod Elementary School', coords: [13.1381, 123.7274], status: 'Open', capacity: 200, current: 45, type: 'school' },
                { name: 'Barangay Hall', coords: [13.1391, 123.7284], status: 'Open', capacity: 100, current: 25, type: 'government' },
                { name: 'Community Chapel', coords: [13.1401, 123.7294], status: 'Near Full', capacity: 150, current: 120, type: 'religious' },
                { name: 'Garcia Family Home', coords: [13.1385, 123.7280], status: 'Closed', capacity: 50, current: 0, type: 'mou' },
                { name: 'Santos Residence', coords: [13.1395, 123.7290], status: 'Open', capacity: 30, current: 15, type: 'mou' }
            ];

            // Infrastructure points in Ilawod, Camalig, Albay - Database ready structure
            const infrastructurePoints = [
                { 
                    id: 1,
                    name: 'Barangay Hall Ilawod', 
                    coords: [13.1768, 123.6507], 
                    icon: 'fas fa-building', 
                    color: '#0074D9', 
                    type: 'government',
                    barangay: 'Ilawod',
                    municipality: 'Camalig',
                    province: 'Albay'
                },
                { 
                    id: 2,
                    name: 'Ilawod Elementary School', 
                    coords: [13.1778, 123.6517], 
                    icon: 'fas fa-school', 
                    color: '#FFDC00', 
                    type: 'education',
                    barangay: 'Ilawod',
                    municipality: 'Camalig',
                    province: 'Albay'
                },
                { 
                    id: 3,
                    name: 'Ilawod Chapel', 
                    coords: [13.1758, 123.6497], 
                    icon: 'fas fa-church', 
                    color: '#B10DC9', 
                    type: 'religious',
                    barangay: 'Ilawod',
                    municipality: 'Camalig',
                    province: 'Albay'
                },
                { 
                    id: 4,
                    name: 'Health Center', 
                    coords: [13.1748, 123.6507], 
                    icon: 'fas fa-hospital', 
                    color: '#DC2626', 
                    type: 'health',
                    barangay: 'Ilawod',
                    municipality: 'Camalig',
                    province: 'Albay'
                },
                { 
                    id: 5,
                    name: 'Multi-Purpose Hall', 
                    coords: [13.1788, 123.6527], 
                    icon: 'fas fa-building-columns', 
                    color: '#059669', 
                    type: 'community',
                    barangay: 'Ilawod',
                    municipality: 'Camalig',
                    province: 'Albay'
                },
                { 
                    id: 6,
                    name: 'Day Care Center', 
                    coords: [13.1738, 123.6517], 
                    icon: 'fas fa-child', 
                    color: '#F59E0B', 
                    type: 'education',
                    barangay: 'Ilawod',
                    municipality: 'Camalig',
                    province: 'Albay'
                }
            ];

            // Don't add infrastructure or evacuation centers initially - controlled by checkboxes

            // Define evacuation routes - Matching dashboard structure
            const evacuationRoutes = [
                {
                    name: 'Primary Route 1',
                    type: 'primary',
                    color: '#00FF00',
                    weight: 4,
                    coordinates: [
                        [13.1351, 123.7264],
                        [13.1371, 123.7284],
                        [13.1391, 123.7284],
                        [13.1411, 123.7304]
                    ]
                },
                {
                    name: 'Secondary Route 1',
                    type: 'secondary',
                    color: '#FFD700',
                    weight: 3,
                    dashArray: '10, 5',
                    coordinates: [
                        [13.1361, 123.7274],
                        [13.1381, 123.7274],
                        [13.1401, 123.7294]
                    ]
                },
                {
                    name: 'Emergency Route 1',
                    type: 'emergency',
                    color: '#FF4500',
                    weight: 2,
                    dashArray: '5, 5',
                    coordinates: [
                        [13.1341, 123.7294],
                        [13.1361, 123.7294],
                        [13.1381, 123.7294],
                        [13.1401, 123.7294]
                    ]
                }
            ];

            // Don't add evacuation routes initially - controlled by checkboxes

            // Add infrastructure markers to map permanently
            infrastructurePoints.forEach(point => {
                const marker = L.marker(point.coords, {
                    icon: L.divIcon({
                        html: `<i class="${point.icon}" style="color: ${point.color}; font-size: 20px;"></i>`,
                        iconSize: [20, 20],
                        className: 'infrastructure-marker'
                    })
                }).addTo(map);

                marker.bindPopup(`
                    <div class="popup-content">
                        <h6><strong>${point.name}</strong></h6>
                        <p><strong>Type:</strong> ${point.type.charAt(0).toUpperCase() + point.type.slice(1)}</p>
                        <p><strong>Location:</strong> ${point.barangay}, ${point.municipality}, ${point.province}</p>
                    </div>
                `);
            });

            // Store map layers for checkbox control
            window.mapLayers = {
                hazardZones: []
            };

            // Store data for filtering
            window.mapData = {
                hazardZones
            };
>>>>>>> 7a584067cb8174031fa332c11a54a086080e3cd5

            window.mapInstance = map;

            // Set up checkbox event listeners
            setupCheckboxListeners();

<<<<<<< HEAD
            // Fallback: hide loading indicator after init (tiles also hide on 'load')
            if (loadingIndicator) loadingIndicator.style.display = 'none';
=======
            // Hide loading indicator
            if (loadingIndicator) {
                loadingIndicator.style.display = 'none';
            }
>>>>>>> 7a584067cb8174031fa332c11a54a086080e3cd5

            // Set initial map view to Ilawod, Camalig, Albay
            map.setView([13.1768, 123.6507], 16);
        }

        function setupCheckboxListeners() {
<<<<<<< HEAD
=======
            // Hazard checkboxes
>>>>>>> 7a584067cb8174031fa332c11a54a086080e3cd5
            document.querySelectorAll('.hazard-checkbox').forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    filterHazards();
                });
            });
        }

<<<<<<< HEAD
=======


>>>>>>> 7a584067cb8174031fa332c11a54a086080e3cd5
        function filterHazards() {
            const checkedHazards = [];
            document.querySelectorAll('.hazard-checkbox:checked').forEach(checkbox => {
                checkedHazards.push(checkbox.dataset.hazard);
            });
<<<<<<< HEAD
            if (checkedHazards.length > 0) {
                loadHazardsForTypes(checkedHazards);
            } else {
                // Clear when none selected
                window.mapLayers.hazardZones.forEach(layer => {
                    try { window.mapInstance.removeLayer(layer); } catch {}
                });
                window.hazardLayerGroup?.clearLayers();
                window.mapLayers.hazardZones = [];
=======

            // Clear existing hazard zones
            window.mapLayers.hazardZones.forEach(layer => {
                window.mapInstance.removeLayer(layer);
            });
            window.mapLayers.hazardZones = [];

            // Only show hazard zones if something is checked
            if (checkedHazards.length > 0) {
                const visibleZones = [];
                
                checkedHazards.forEach(hazardType => {
                    const matchingZones = window.mapData.hazardZones.filter(zone => zone.type === hazardType);
                    matchingZones.forEach(zone => {
                        visibleZones.push(zone);
                        
                        const polygon = L.polygon(zone.coordinates, {
                            color: zone.color,
                            fillColor: zone.color,
                            fillOpacity: 0.3,
                            weight: 2
                        }).addTo(window.mapInstance);

                        polygon.bindPopup(`
                            <div class="popup-content">
                                <h6><strong>${zone.name}</strong></h6>
                                <p><strong>Type:</strong> ${zone.type.charAt(0).toUpperCase() + zone.type.slice(1)}</p>
                                <p><strong>Severity:</strong> ${zone.severity.charAt(0).toUpperCase() + zone.severity.slice(1)}</p>
                                <p><strong>Location:</strong> ${zone.barangay}, ${zone.municipality}, ${zone.province}</p>
                            </div>
                        `);

                        window.mapLayers.hazardZones.push(polygon);
                    });
                });

                // Auto-zoom to fit all visible hazard zones
                if (visibleZones.length > 0) {
                    const allCoords = [];
                    visibleZones.forEach(zone => {
                        zone.coordinates.forEach(coord => allCoords.push(coord));
                    });
                    
                    if (allCoords.length > 0) {
                        const bounds = L.latLngBounds(allCoords);
                        window.mapInstance.fitBounds(bounds, { padding: [20, 20] });
                    }
                }
            } else {
                // If no hazards are checked, zoom out to show full barangay area
>>>>>>> 7a584067cb8174031fa332c11a54a086080e3cd5
                window.mapInstance.setView([13.1768, 123.6507], 14);
            }
        }
    </script>
@endsection

{{-- Remove sidebar duplication by hiding the layout sidebar --}}
@section('hideSidebar')
@endsection

@section('content')
<div class="hazard-map-wrapper">
    <!-- Burger Menu Button -->
    <button class="burger-menu-btn" id="burgerMenuBtn">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Custom Sidebar specific to this page -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>
    <div class="hazard-sidebar" id="hazardSidebar">
        <div class="accordion bg-dark text-white" id="sidebarAccordion">

            <!-- Barangay Map Link -->
            <div class="p-2">
                <a class="nav-link text-white" href="/">
                    <i class="fas fa-map-marked-alt me-2"></i>Barangay Hazard Map
                </a>
            </div>

            <!-- All Hazards Section -->
            <div class="accordion-item bg-dark border-0">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed bg-secondary text-white" type="button" data-bs-toggle="collapse" data-bs-target="#collapseHazards">
                        <i class="fas fa-warning me-2"></i>All Hazards
                    </button>
                </h2>
                <div id="collapseHazards" class="accordion-collapse collapse">
                    <div class="accordion-body text-white">
<<<<<<< HEAD
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <div class="form-check m-0">
                                <input class="form-check-input hazard-checkbox" type="checkbox" id="hazardFlood" data-hazard="flood">
                                <label class="form-check-label" for="hazardFlood">
                                    <i class="fas fa-water text-primary me-2"></i>Flood
                                </label>
                            </div>
                            @auth
                            <button class="btn btn-sm btn-outline-light hazard-edit-btn" data-hazard="flood"><i class="fas fa-pen"></i> Edit</button>
                            @endauth
                        </div>
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <div class="form-check m-0">
                                <input class="form-check-input hazard-checkbox" type="checkbox" id="hazardLandslide" data-hazard="landslide">
                                <label class="form-check-label" for="hazardLandslide">
                                    <i class="fas fa-mountain text-warning me-2"></i>Landslide
                                </label>
                            </div>
                            @auth
                            <button class="btn btn-sm btn-outline-light hazard-edit-btn" data-hazard="landslide"><i class="fas fa-pen"></i> Edit</button>
                            @endauth
                        </div>
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <div class="form-check m-0">
                                <input class="form-check-input hazard-checkbox" type="checkbox" id="hazardFire" data-hazard="fire">
                                <label class="form-check-label" for="hazardFire">
                                    <i class="fas fa-fire text-danger me-2"></i>Fire
                                </label>
                            </div>
                            @auth
                            <button class="btn btn-sm btn-outline-light hazard-edit-btn" data-hazard="fire"><i class="fas fa-pen"></i> Edit</button>
                            @endauth
                        </div>
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <div class="form-check m-0">
                                <input class="form-check-input hazard-checkbox" type="checkbox" id="hazardAshfall" data-hazard="ashfall">
                                <label class="form-check-label" for="hazardAshfall">
                                    <i class="fas fa-cloud text-secondary me-2"></i>Ashfall
                                </label>
                            </div>
                            @auth
                            <button class="btn btn-sm btn-outline-light hazard-edit-btn" data-hazard="ashfall"><i class="fas fa-pen"></i> Edit</button>
                            @endauth
                        </div>
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <div class="form-check m-0">
                                <input class="form-check-input hazard-checkbox" type="checkbox" id="hazardLahar" data-hazard="lahar">
                                <label class="form-check-label" for="hazardLahar">
                                    <i class="fas fa-tint text-dark me-2"></i>Lahar
                                </label>
                            </div>
                            @auth
                            <button class="btn btn-sm btn-outline-light hazard-edit-btn" data-hazard="lahar"><i class="fas fa-pen"></i> Edit</button>
                            @endauth
                        </div>
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <div class="form-check m-0">
                                <input class="form-check-input hazard-checkbox" type="checkbox" id="hazardMudflow" data-hazard="mudflow">
                                <label class="form-check-label" for="hazardMudflow">
                                    <i class="fas fa-water text-success me-2"></i>Mudflow
                                </label>
                            </div>
                            @auth
                            <button class="btn btn-sm btn-outline-light hazard-edit-btn" data-hazard="mudflow"><i class="fas fa-pen"></i> Edit</button>
                            @endauth
                        </div>
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <div class="form-check m-0">
                                <input class="form-check-input hazard-checkbox" type="checkbox" id="hazardWind" data-hazard="wind">
                                <label class="form-check-label" for="hazardWind">
                                    <i class="fas fa-wind text-info me-2"></i>Wind
                                </label>
                            </div>
                            @auth
                            <button class="btn btn-sm btn-outline-light hazard-edit-btn" data-hazard="wind"><i class="fas fa-pen"></i> Edit</button>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>

            <!-- Routes Section -->
            <div class="accordion-item bg-dark border-0">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed bg-secondary text-white" type="button" data-bs-toggle="collapse" data-bs-target="#collapseRoutes">
                        <i class="fas fa-route me-2"></i>Routes
                    </button>
                </h2>
                <div id="collapseRoutes" class="accordion-collapse collapse">
                    <div class="accordion-body text-white">
                        <div class="form-check m-0 d-flex align-items-center justify-content-between mb-2">
                            <div>
                                <input class="form-check-input routes-checkbox" type="checkbox" id="routesEvac" data-layer="evac_routes">
                                <label class="form-check-label" for="routesEvac">
                                    <i class="fas fa-route text-info me-2"></i>Evacuation Routes
                                </label>
                            </div>
                            @auth
                            <button class="btn btn-sm btn-outline-light routes-edit-btn" data-layer="evac_routes"><i class="fas fa-pen"></i> Edit</button>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>

            <!-- Infrastructures Section -->
            <div class="accordion-item bg-dark border-0">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed bg-secondary text-white" type="button" data-bs-toggle="collapse" data-bs-target="#collapseInfra">
                        <i class="fas fa-city me-2"></i>Infrastructures
                    </button>
                </h2>
                <div id="collapseInfra" class="accordion-collapse collapse">
                    <div class="accordion-body text-white">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <div class="form-check m-0">
                                <input class="form-check-input infra-checkbox" type="checkbox" id="infraBrgyHall" data-layer="barangay_hall">
                                <label class="form-check-label" for="infraBrgyHall">
                                    <i class="fas fa-building text-primary me-2"></i>Barangay Hall
                                </label>
                            </div>
                            @auth
                            <button class="btn btn-sm btn-outline-light infra-edit-btn" data-layer="barangay_hall"><i class="fas fa-pen"></i> Edit</button>
                            @endauth
                        </div>
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <div class="form-check m-0">
                                <input class="form-check-input infra-checkbox" type="checkbox" id="infraElemSchool" data-layer="elementary_school">
                                <label class="form-check-label" for="infraElemSchool">
                                    <i class="fas fa-school" style="color:#FFDC00;"></i><span class="ms-2">Elementary School</span>
                                </label>
                            </div>
                            @auth
                            <button class="btn btn-sm btn-outline-light infra-edit-btn" data-layer="elementary_school"><i class="fas fa-pen"></i> Edit</button>
                            @endauth
                        </div>
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <div class="form-check m-0">
                                <input class="form-check-input infra-checkbox" type="checkbox" id="infraChapel" data-layer="chapel">
                                <label class="form-check-label" for="infraChapel">
                                    <i class="fas fa-church" style="color:#B10DC9;"></i><span class="ms-2">Chapel</span>
                                </label>
                            </div>
                            @auth
                            <button class="btn btn-sm btn-outline-light infra-edit-btn" data-layer="chapel"><i class="fas fa-pen"></i> Edit</button>
                            @endauth
                        </div>
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <div class="form-check m-0">
                                <input class="form-check-input infra-checkbox" type="checkbox" id="infraHealthCenter" data-layer="health_center">
                                <label class="form-check-label" for="infraHealthCenter">
                                    <i class="fas fa-hospital text-danger"></i><span class="ms-2">Health Center</span>
                                </label>
                            </div>
                            @auth
                            <button class="btn btn-sm btn-outline-light infra-edit-btn" data-layer="health_center"><i class="fas fa-pen"></i> Edit</button>
                            @endauth
                        </div>
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <div class="form-check m-0">
                                <input class="form-check-input infra-checkbox" type="checkbox" id="infraMultiPurpose" data-layer="multi_purpose_hall">
                                <label class="form-check-label" for="infraMultiPurpose">
                                    <i class="fas fa-building-columns text-success"></i><span class="ms-2">Multi-Purpose Hall</span>
                                </label>
                            </div>
                            @auth
                            <button class="btn btn-sm btn-outline-light infra-edit-btn" data-layer="multi_purpose_hall"><i class="fas fa-pen"></i> Edit</button>
                            @endauth
                        </div>
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <div class="form-check m-0">
                                <input class="form-check-input infra-checkbox" type="checkbox" id="infraDayCare" data-layer="day_care_center">
                                <label class="form-check-label" for="infraDayCare">
                                    <i class="fas fa-child" style="color:#F59E0B;"></i><span class="ms-2">Day Care Center</span>
                                </label>
                            </div>
                            @auth
                            <button class="btn btn-sm btn-outline-light infra-edit-btn" data-layer="day_care_center"><i class="fas fa-pen"></i> Edit</button>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>

            <!-- PWDs Section -->
            <div class="accordion-item bg-dark border-0">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed bg-secondary text-white" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePWDs">
                        <i class="fas fa-wheelchair me-2"></i>PWDs
                    </button>
                </h2>
                <div id="collapsePWDs" class="accordion-collapse collapse">
                    <div class="accordion-body text-white">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <div class="form-check m-0">
                                <input class="form-check-input pwd-checkbox" type="checkbox" id="pwdHouseholds" data-layer="pwd_households">
                                <label class="form-check-label" for="pwdHouseholds">
                                    <i class="fas fa-wheelchair text-light me-2"></i>PWD Households
                                </label>
                            </div>
                            @auth
                            <button class="btn btn-sm btn-outline-light pwd-edit-btn" data-layer="pwd_households"><i class="fas fa-pen"></i> Edit</button>
                            @endauth
=======
                        <div class="form-check">
                            <input class="form-check-input hazard-checkbox" type="checkbox" id="hazardFlood" data-hazard="flood">
                            <label class="form-check-label" for="hazardFlood">
                                <i class="fas fa-water text-primary me-2"></i>Flood
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input hazard-checkbox" type="checkbox" id="hazardLandslide" data-hazard="landslide">
                            <label class="form-check-label" for="hazardLandslide">
                                <i class="fas fa-mountain text-warning me-2"></i>Landslide
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input hazard-checkbox" type="checkbox" id="hazardFire" data-hazard="fire">
                            <label class="form-check-label" for="hazardFire">
                                <i class="fas fa-fire text-danger me-2"></i>Fire
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input hazard-checkbox" type="checkbox" id="hazardAshfall" data-hazard="ashfall">
                            <label class="form-check-label" for="hazardAshfall">
                                <i class="fas fa-cloud text-secondary me-2"></i>Ashfall
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input hazard-checkbox" type="checkbox" id="hazardLahar" data-hazard="lahar">
                            <label class="form-check-label" for="hazardLahar">
                                <i class="fas fa-tint text-dark me-2"></i>Lahar
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input hazard-checkbox" type="checkbox" id="hazardMudflow" data-hazard="mudflow">
                            <label class="form-check-label" for="hazardMudflow">
                                <i class="fas fa-water text-success me-2"></i>Mudflow
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input hazard-checkbox" type="checkbox" id="hazardWind" data-hazard="wind">
                            <label class="form-check-label" for="hazardWind">
                                <i class="fas fa-wind text-info me-2"></i>Wind
                            </label>
>>>>>>> 7a584067cb8174031fa332c11a54a086080e3cd5
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Map Legend Container - Matching dashboard.blade.php structure exactly -->
    <div class="map-legend-container" id="mapLegendContainer">
        <div class="legend-header d-flex justify-content-between align-items-center">
            <h6 class="mb-0">Legend</h6>
            <button id="legendToggle" class="btn btn-sm btn-outline-dark" title="Show/Hide Legend">
                <i class="fas fa-eye-slash"></i>
            </button>
        </div>
        <div class="legend-content" id="legendContent">
            <!-- All Hazards -->
            <div class="legend-section">
                <h6 class="legend-section-title text-danger">
                    <i class="fas fa-warning me-2"></i>All Hazards
                </h6>
                <div class="legend-items">
                    <div class="legend-item">
                        <span class="legend-color" style="background-color: #0d6efd;"></span>
                        <span class="legend-text">Flood</span>
                    </div>
                    <div class="legend-item">
                        <span class="legend-color" style="background-color: #ffc107;"></span>
                        <span class="legend-text">Landslide</span>
                    </div>
                    <div class="legend-item">
                        <span class="legend-color" style="background-color: #dc3545;"></span>
                        <span class="legend-text">Fire</span>
                    </div>
                    <div class="legend-item">
                        <span class="legend-color" style="background-color: #6c757d;"></span>
                        <span class="legend-text">Ashfall</span>
                    </div>
                    <div class="legend-item">
                        <span class="legend-color" style="background-color: #343a40;"></span>
                        <span class="legend-text">Lahar</span>
                    </div>
                    <div class="legend-item">
                        <span class="legend-color" style="background-color: #198754;"></span>
                        <span class="legend-text">Mudflow</span>
                    </div>
                    <div class="legend-item">
                        <span class="legend-color" style="background-color: #0dcaf0;"></span>
                        <span class="legend-text">Wind</span>
                    </div>
                </div>
            </div>

            <!-- Infrastructure -->
            <div class="legend-section">
                <h6 class="legend-section-title text-info">
                    <i class="fas fa-building me-2"></i>Infrastructure
                </h6>
                <div class="legend-items">
                    <div class="legend-item">
                        <i class="fas fa-building text-primary me-2"></i>
                        <span class="legend-text">Barangay Hall</span>
                    </div>
                    <div class="legend-item">
                        <i class="fas fa-school" style="color: #FFDC00;" class="me-2"></i>
                        <span class="legend-text">Elementary School</span>
                    </div>
                    <div class="legend-item">
                        <i class="fas fa-church" style="color: #B10DC9;" class="me-2"></i>
                        <span class="legend-text">Chapel</span>
                    </div>
                    <div class="legend-item">
                        <i class="fas fa-hospital text-danger me-2"></i>
                        <span class="legend-text">Health Center</span>
                    </div>
                    <div class="legend-item">
                        <i class="fas fa-building-columns text-success me-2"></i>
                        <span class="legend-text">Multi-Purpose Hall</span>
                    </div>
                    <div class="legend-item">
                        <i class="fas fa-child" style="color: #F59E0B;" class="me-2"></i>
                        <span class="legend-text">Day Care Center</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Map Container -->
    <div class="map-main-container" id="mapMainContainer">
        <div class="container-fluid p-0">
            <h3 class="text-center mb-4 fw-bold text-primary">Barangay Ilawod Hazard Map</h3>
<<<<<<< HEAD
            <div class="position-relative">
                <div id="hazardMap" style="height: 75vh; border-radius: 12px; overflow: hidden;"></div>
                @auth
                <div id="draftActions" class="draft-actions">
                    <button id="btnSaveDrafts" class="btn btn-sm btn-success"><i class="fas fa-save me-1"></i>Save</button>
                    <button id="btnCancelDrafts" class="btn btn-sm btn-secondary"><i class="fas fa-times me-1"></i>Cancel</button>
                </div>
                @endauth
            </div>
            <div class="map-loading" id="mapLoading" style="display: none;">
                <i class="fas fa-spinner fa-spin"></i> Loading map...
=======
            <div class="map-container">
                <div id="hazard-map" style="height: 600px;"></div>
                <div class="map-loading" id="mapLoading" style="display: none;">
                    <i class="fas fa-spinner fa-spin"></i> Loading map...
                </div>
>>>>>>> 7a584067cb8174031fa332c11a54a086080e3cd5
            </div>
        </div>
    </div>
</div>
@endsection