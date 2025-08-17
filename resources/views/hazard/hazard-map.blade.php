@extends('layouts.layout')

@section('title', $title ?? 'Ilawod Barangay Hazard Management System')

@section('additional_styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
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
    </style>
@endsection

@section('additional_scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Burger menu functionality
            const burgerBtn = document.getElementById('burgerMenuBtn');
            const sidebar = document.getElementById('hazardSidebar');
            const mapContainer = document.querySelector('.map-container');

            burgerBtn.addEventListener('click', function() {
                sidebar.classList.toggle('active');
                mapContainer.classList.toggle('sidebar-open');
                burgerBtn.classList.toggle('sidebar-open');
                
                // Invalidate map size after transition
                setTimeout(() => {
                    if (window.mapInstance) {
                        window.mapInstance.invalidateSize();
                    }
                }, 300);
            });

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
        });

        function initializeHazardMap() {
            // Show loading indicator
            const loadingIndicator = document.getElementById('mapLoading');
            if (loadingIndicator) {
                loadingIndicator.style.display = 'block';
            }

            // Initialize Leaflet map - Ilawod, Camalig, Albay, Philippines
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

            window.mapInstance = map;

            // Set up checkbox event listeners
            setupCheckboxListeners();

            // Hide loading indicator
            if (loadingIndicator) {
                loadingIndicator.style.display = 'none';
            }

            // Set initial map view to Ilawod, Camalig, Albay
            map.setView([13.1768, 123.6507], 16);
        }

        function setupCheckboxListeners() {
            // Hazard checkboxes
            document.querySelectorAll('.hazard-checkbox').forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    filterHazards();
                });
            });
        }



        function filterHazards() {
            const checkedHazards = [];
            document.querySelectorAll('.hazard-checkbox:checked').forEach(checkbox => {
                checkedHazards.push(checkbox.dataset.hazard);
            });

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
            <div class="map-container">
                <div id="hazard-map" style="height: 600px;"></div>
                <div class="map-loading" id="mapLoading" style="display: none;">
                    <i class="fas fa-spinner fa-spin"></i> Loading map...
                </div>
            </div>
        </div>
    </div>
</div>
@endsection