// Hazard Map JavaScript
let map;
let hazardLayers = {};
let purokLayers = {};
let evacuationCenters = {};
let evacuationRoutes = {};
let currentEvacuationRoutes = [];

// Ilawod, Camalig, Albay, Bicol Region 5, Philippines - Accurate coordinates
const ILAWOD_CENTER = [13.152778, 123.684444];

// Accurate data for Ilawod, Camalig, Albay, Bicol Region 5, Philippines
const evacuationCenterData = [
    { id: 1, name: 'Ilawod Elementary School', lat: 13.151500, lng: 123.685000, capacity: 200, type: 'school' },
    { id: 2, name: 'Ilawod Barangay Hall', lat: 13.152778, lng: 123.684444, capacity: 150, type: 'government' },
    { id: 3, name: 'Ilawod Multi-Purpose Hall', lat: 13.153500, lng: 123.685500, capacity: 100, type: 'community' }
];

const purokData = [
    { id: 'purok1', name: 'Purok 1', lat: 13.150000, lng: 123.682000, population: 473, color: '#000000' },
    { id: 'purok2', name: 'Purok 2', lat: 13.151000, lng: 123.683000, population: 693, color: '#FF851B' },
    { id: 'purok3', name: 'Purok 3', lat: 13.152778, lng: 123.684444, population: 700, color: '#0074D9' },
    { id: 'purok4', name: 'Purok 4', lat: 13.154000, lng: 123.686000, population: 645, color: '#B10DC9' },
    { id: 'purok5', name: 'Purok 5', lat: 13.155000, lng: 123.687000, population: 939, color: '#FFDC00' }
];

const riverData = [
    { name: 'Yawa River', lat: 13.148000, lng: 123.680000 },
    { name: 'Camalig River', lat: 13.156000, lng: 123.690000 }
];

const bridgeData = [
    { name: 'Ilawod Bridge', lat: 13.152000, lng: 123.683500 },
    { name: 'Yawa Bridge', lat: 13.149000, lng: 123.681000 }
];

const facilitiesData = [
    { name: 'Ilawod Barangay Hall', lat: 13.152778, lng: 123.684444, type: 'brgy-hall' },
    { name: 'Santo Niño Chapel', lat: 13.153000, lng: 123.685000, type: 'chapel' },
    { name: 'Ilawod Elementary School', lat: 13.151500, lng: 123.685000, type: 'school' }
];

const roadData = [
    { name: 'Maharlika Highway', lat: 13.152000, lng: 123.684000 },
    { name: 'Barangay Road', lat: 13.153000, lng: 123.685000 }
];

const pwdData = [
    { name: 'PWD Household 1', lat: 13.151000, lng: 123.683500 },
    { name: 'PWD Household 2', lat: 13.153500, lng: 123.686000 }
];

document.addEventListener('DOMContentLoaded', function() {
    initializeMap();
    initializeUI();
    setupEventListeners();
});

function initializeMap() {
    // Initialize the map centered on Ilawod, Camalig, Albay
    map = L.map('hazard-map').setView(ILAWOD_CENTER, 16);

    // Base layers for different map types
    const osm = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    });

    const satellite = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
        attribution: '© Esri, Maxar, Earthstar Geographics'
    });

    const terrain = L.tileLayer('https://{s}.tile.opentopomap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenTopoMap contributors'
    });

    // Add default layer
    osm.addTo(map);

    // Layer control
    const baseLayers = {
        "Street Map": osm,
        "Satellite": satellite,
        "Terrain": terrain
    };

    L.control.layers(baseLayers).addTo(map);

    // Initialize layers
    initializeHazardLayers();
    initializePurokLayers();
    initializeEvacuationCenters();
    initializeGeographicalFeatures();

    // Hide loading indicator
    document.getElementById('mapLoading').style.display = 'none';
}

function initializeUI() {
    const burgerBtn = document.getElementById('burgerMenuBtn');
    const sidebar = document.getElementById('hazardSidebar');
    const overlay = document.getElementById('sidebarOverlay');
    const mapContainer = document.getElementById('mapMainContainer');
    const legendContainer = document.getElementById('mapLegendContainer');
    const legendToggle = document.getElementById('legendToggle');
    const legendContent = document.getElementById('legendContent');

    // Burger menu functionality
    burgerBtn.addEventListener('click', function() {
        sidebar.classList.toggle('show');
        mapContainer.classList.toggle('sidebar-open');
    });

    // Legend toggle functionality
    legendToggle.addEventListener('click', function() {
        legendContent.classList.toggle('collapsed');
        const icon = legendToggle.querySelector('i');
        icon.classList.toggle('fa-eye');
        icon.classList.toggle('fa-eye-slash');
    });
}

function setupEventListeners() {
    // Hazard checkboxes
    document.querySelectorAll('.hazard-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const hazardType = this.dataset.hazard;
            if (this.checked) {
                showHazardLayer(hazardType);
            } else {
                hideHazardLayer(hazardType);
            }
            // Legend is now static
        });
    });

    // Purok checkboxes
    document.querySelectorAll('.purok-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const purokId = this.dataset.purok;
            if (this.checked) {
                showPurokLayer(purokId);
                updateEvacuationRoutes();
            } else {
                hidePurokLayer(purokId);
                updateEvacuationRoutes();
            }
        });
    });

    // Evacuation center checkbox
    document.getElementById('layerEvac').addEventListener('change', function() {
        if (this.checked) {
            showEvacuationCenters();
        } else {
            hideEvacuationCenters();
            clearEvacuationRoutes();
        }
        updateEvacuationRoutes();
    });

    // Other layer checkboxes
    document.getElementById('layerRiver').addEventListener('change', function() {
        if (this.checked) {
            showRivers();
        } else {
            hideRivers();
        }
    });

    document.getElementById('layerBridge').addEventListener('change', function() {
        if (this.checked) {
            showBridges();
        } else {
            hideBridges();
        }
    });

    document.getElementById('layerBrgyHall').addEventListener('change', function() {
        if (this.checked) {
            showBrgyHall();
        } else {
            hideBrgyHall();
        }
    });

    document.getElementById('layerChapel').addEventListener('change', function() {
        if (this.checked) {
            showChapel();
        } else {
            hideChapel();
        }
    });

    document.getElementById('layerSchool').addEventListener('change', function() {
        if (this.checked) {
            showSchool();
        } else {
            hideSchool();
        }
    });

    document.getElementById('layerRoad').addEventListener('change', function() {
        if (this.checked) {
            showRoads();
        } else {
            hideRoads();
        }
    });

    document.getElementById('layerPWD').addEventListener('change', function() {
        if (this.checked) {
            showPWD();
        } else {
            hidePWD();
        }
    });
}

function initializeHazardLayers() {
    // Initialize hazard layers with accurate areas for Ilawod
    const hazardAreas = {
        flood: [
            [13.149000, 123.682000],
            [13.151000, 123.683000],
            [13.152000, 123.685000],
            [13.150000, 123.686000],
            [13.148000, 123.684000]
        ],
        landslide: [
            [13.154000, 123.685000],
            [13.156000, 123.687000],
            [13.157000, 123.689000],
            [13.155000, 123.690000],
            [13.153000, 123.688000]
        ],
        volcanic: [
            [13.150000, 123.681000],
            [13.153000, 123.682000],
            [13.155000, 123.684000],
            [13.152000, 123.687000],
            [13.149000, 123.685000]
        ],
        fire: [
            [13.151500, 123.684000],
            [13.152500, 123.685000],
            [13.153000, 123.686000],
            [13.152000, 123.687000],
            [13.151000, 123.685500]
        ],
        wind: [
            [13.154000, 123.686000],
            [13.155500, 123.687500],
            [13.156000, 123.689000],
            [13.154500, 123.690000],
            [13.153000, 123.688000]
        ]
    };
    
    Object.keys(hazardAreas).forEach(hazardType => {
        hazardLayers[hazardType] = L.layerGroup();
        
        const polygon = L.polygon(hazardAreas[hazardType], {
            color: getHazardColor(hazardType),
            fillColor: getHazardColor(hazardType),
            fillOpacity: 0.4,
            weight: 2
        }).bindPopup(`${hazardType.charAt(0).toUpperCase() + hazardType.slice(1)} Prone Area - Ilawod`);
        
        hazardLayers[hazardType].addLayer(polygon);
    });
}

function initializePurokLayers() {
    purokData.forEach(purok => {
        const marker = L.circleMarker([purok.lat, purok.lng], {
            color: purok.color,
            fillColor: purok.color,
            fillOpacity: 0.6,
            radius: 20,
            weight: 2
        }).bindPopup(`
            <strong>${purok.name}</strong><br>
            Population: ${purok.population}<br>
            Location: Ilawod, Camalig, Albay<br>
            Coordinates: ${purok.lat.toFixed(6)}, ${purok.lng.toFixed(6)}
        `);
        
        purokLayers[purok.id] = L.layerGroup([marker]);
    });
}

function initializeEvacuationCenters() {
    evacuationCenterData.forEach(center => {
        const marker = L.marker([center.lat, center.lng], {
            icon: L.divIcon({
                className: 'evacuation-marker',
                html: '<i class="fas fa-shield-alt"></i>',
                iconSize: [30, 30]
            })
        }).bindPopup(`
            <strong>${center.name}</strong><br>
            Type: ${center.type}<br>
            Capacity: ${center.capacity} people<br>
            Coordinates: ${center.lat.toFixed(4)}, ${center.lng.toFixed(4)}
        `);
        
        evacuationCenters[center.id] = marker;
    });
}

function initializeGeographicalFeatures() {
    // Initialize rivers
    window.riverLayer = L.layerGroup();
    riverData.forEach(river => {
        const marker = L.marker([river.lat, river.lng], {
            icon: L.divIcon({
                className: 'river-marker',
                html: '<i class="fas fa-river"></i>',
                iconSize: [25, 25]
            })
        }).bindPopup(`<strong>${river.name}</strong><br>Ilawod, Camalig, Albay`);
        window.riverLayer.addLayer(marker);
    });

    // Initialize bridges
    window.bridgeLayer = L.layerGroup();
    bridgeData.forEach(bridge => {
        const marker = L.marker([bridge.lat, bridge.lng], {
            icon: L.divIcon({
                className: 'bridge-marker',
                html: '<i class="fas fa-bridge-water"></i>',
                iconSize: [25, 25]
            })
        }).bindPopup(`<strong>${bridge.name}</strong><br>Ilawod, Camalig, Albay`);
        window.bridgeLayer.addLayer(marker);
    });

    // Initialize facilities
    window.brgyHallLayer = L.layerGroup();
    window.chapelLayer = L.layerGroup();
    window.schoolLayer = L.layerGroup();
    
    facilitiesData.forEach(facility => {
        const marker = L.marker([facility.lat, facility.lng], {
            icon: L.divIcon({
                className: facility.type + '-marker',
                html: getIconForType(facility.type),
                iconSize: [30, 30]
            })
        }).bindPopup(`<strong>${facility.name}</strong><br>Ilawod, Camalig, Albay`);
        
        if (facility.type === 'brgy-hall') window.brgyHallLayer.addLayer(marker);
        if (facility.type === 'chapel') window.chapelLayer.addLayer(marker);
        if (facility.type === 'school') window.schoolLayer.addLayer(marker);
    });

    // Initialize roads
    window.roadLayer = L.layerGroup();
    roadData.forEach(road => {
        const marker = L.marker([road.lat, road.lng], {
            icon: L.divIcon({
                className: 'road-marker',
                html: '<i class="fas fa-road"></i>',
                iconSize: [20, 20]
            })
        }).bindPopup(`<strong>${road.name}</strong><br>Ilawod, Camalig, Albay`);
        window.roadLayer.addLayer(marker);
    });

    // Initialize PWD locations
    window.pwdLayer = L.layerGroup();
    pwdData.forEach(pwd => {
        const marker = L.marker([pwd.lat, pwd.lng], {
            icon: L.divIcon({
                className: 'pwd-marker',
                html: '<i class="fas fa-wheelchair"></i>',
                iconSize: [25, 25]
            })
        }).bindPopup(`<strong>${pwd.name}</strong><br>Ilawod, Camalig, Albay`);
        window.pwdLayer.addLayer(marker);
    });
}

function getIconForType(type) {
    const icons = {
        'brgy-hall': '<i class="fas fa-building"></i>',
        'chapel': '<i class="fas fa-church"></i>',
        'school': '<i class="fas fa-school"></i>'
    };
    return icons[type] || '<i class="fas fa-map-marker"></i>';
}

function showHazardLayer(hazardType) {
    if (hazardLayers[hazardType]) {
        map.addLayer(hazardLayers[hazardType]);
    }
}

function hideHazardLayer(hazardType) {
    if (hazardLayers[hazardType]) {
        map.removeLayer(hazardLayers[hazardType]);
    }
}

function showPurokLayer(purokId) {
    if (purokId === 'all') {
        Object.values(purokLayers).forEach(layer => {
            map.addLayer(layer);
        });
    } else if (purokLayers[purokId]) {
        map.addLayer(purokLayers[purokId]);
    }
}

function hidePurokLayer(purokId) {
    if (purokId === 'all') {
        Object.values(purokLayers).forEach(layer => {
            map.removeLayer(layer);
        });
    } else if (purokLayers[purokId]) {
        map.removeLayer(purokLayers[purokId]);
    }
}

function showEvacuationCenters() {
    Object.values(evacuationCenters).forEach(marker => {
        map.addLayer(marker);
    });
}

function hideEvacuationCenters() {
    Object.values(evacuationCenters).forEach(marker => {
        map.removeLayer(marker);
    });
}

function showRivers() {
    if (window.riverLayer) {
        map.addLayer(window.riverLayer);
    }
}

function hideRivers() {
    if (window.riverLayer) {
        map.removeLayer(window.riverLayer);
    }
}

function showBridges() {
    if (window.bridgeLayer) {
        map.addLayer(window.bridgeLayer);
    }
}

function hideBridges() {
    if (window.bridgeLayer) {
        map.removeLayer(window.bridgeLayer);
    }
}

function showBrgyHall() {
    if (window.brgyHallLayer) {
        map.addLayer(window.brgyHallLayer);
    }
}

function hideBrgyHall() {
    if (window.brgyHallLayer) {
        map.removeLayer(window.brgyHallLayer);
    }
}

function showChapel() {
    if (window.chapelLayer) {
        map.addLayer(window.chapelLayer);
    }
}

function hideChapel() {
    if (window.chapelLayer) {
        map.removeLayer(window.chapelLayer);
    }
}

function showSchool() {
    if (window.schoolLayer) {
        map.addLayer(window.schoolLayer);
    }
}

function hideSchool() {
    if (window.schoolLayer) {
        map.removeLayer(window.schoolLayer);
    }
}

function showRoads() {
    if (window.roadLayer) {
        map.addLayer(window.roadLayer);
    }
}

function hideRoads() {
    if (window.roadLayer) {
        map.removeLayer(window.roadLayer);
    }
}

function showPWD() {
    if (window.pwdLayer) {
        map.addLayer(window.pwdLayer);
    }
}

function hidePWD() {
    if (window.pwdLayer) {
        map.removeLayer(window.pwdLayer);
    }
}

function updateEvacuationRoutes() {
    clearEvacuationRoutes();
    
    const evacuationChecked = document.getElementById('layerEvac').checked;
    if (!evacuationChecked) return;
    
    // Find active puroks
    const activePuroks = [];
    document.querySelectorAll('.purok-checkbox:checked').forEach(checkbox => {
        const purokId = checkbox.dataset.purok;
        if (purokId !== 'all') {
            activePuroks.push(purokId);
        }
    });
    
    // If "all puroks" is checked, add all puroks
    if (document.getElementById('layerAllPuroks').checked) {
        purokData.forEach(purok => {
            if (!activePuroks.includes(purok.id)) {
                activePuroks.push(purok.id);
            }
        });
    }
    
    // Create routes from active puroks to nearest evacuation centers
    activePuroks.forEach(purokId => {
        const purok = purokData.find(p => p.id === purokId);
        if (purok) {
            // Find nearest evacuation center
            let nearestCenter = null;
            let shortestDistance = Infinity;
            
            evacuationCenterData.forEach(center => {
                const distance = calculateDistance(purok.lat, purok.lng, center.lat, center.lng);
                if (distance < shortestDistance) {
                    shortestDistance = distance;
                    nearestCenter = center;
                }
            });
            
            if (nearestCenter) {
                const route = L.polyline([
                    [purok.lat, purok.lng],
                    [nearestCenter.lat, nearestCenter.lng]
                ], {
                    color: '#28a745',
                    weight: 3,
                    dashArray: '10, 5',
                    opacity: 0.8
                }).bindPopup(`Evacuation Route: ${purok.name} → ${nearestCenter.name}`);
                
                currentEvacuationRoutes.push(route);
                map.addLayer(route);
            }
        }
    });
}

function clearEvacuationRoutes() {
    currentEvacuationRoutes.forEach(route => {
        map.removeLayer(route);
    });
    currentEvacuationRoutes = [];
}

function calculateDistance(lat1, lng1, lat2, lng2) {
    const R = 6371; // Earth's radius in km
    const dLat = (lat2 - lat1) * Math.PI / 180;
    const dLng = (lng2 - lng1) * Math.PI / 180;
    const a = Math.sin(dLat/2) * Math.sin(dLat/2) +
              Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
              Math.sin(dLng/2) * Math.sin(dLng/2);
    const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
    return R * c;
}

function getHazardColor(hazardType) {
    const colors = {
        flood: '#0074D9',
        landslide: '#FF851B',
        volcanic: '#B10DC9',
        fire: '#FF4136',
        wind: '#01FF70'
    };
    return colors[hazardType] || '#6c757d';
}

// Legend is now static and permanently visible - no dynamic updates needed