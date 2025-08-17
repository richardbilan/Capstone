<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barangay Ilawod Disaster Risk Management Dashboard</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    
    <!-- Embedded Custom CSS -->
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

        /* Dashboard Header */
        .dashboard-header {
            background: var(--card-bg);
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: var(--card-shadow);
            border-left: 4px solid var(--primary-blue);
        }

        .dashboard-title {
            color: var(--primary-blue);
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .dashboard-subtitle {
            color: var(--text-secondary);
            font-size: 1rem;
            font-weight: 500;
        }

        .alert-status .badge {
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
            font-weight: 600;
        }

        /* Navigation Tabs */
        .disaster-nav-tabs {
            border-bottom: 2px solid var(--border-color);
            background: var(--card-bg);
            border-radius: 8px 8px 0 0;
            padding: 0.5rem 0.5rem 0;
            box-shadow: var(--card-shadow);
        }

        .disaster-nav-tabs .nav-link {
            border: none;
            border-radius: 8px 8px 0 0;
            color: var(--text-secondary);
            font-weight: 600;
            padding: 0.75rem 1rem;
            margin: 0 0.25rem;
            transition: all 0.3s ease;
            position: relative;
        }

        .disaster-nav-tabs .nav-link:hover {
            background: var(--panel-bg);
            color: var(--primary-blue);
            transform: translateY(-2px);
        }

        .disaster-nav-tabs .nav-link.active {
            background: var(--primary-blue);
            color: white;
            border-bottom: 3px solid var(--secondary-blue);
        }

        .disaster-nav-tabs .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 50%;
            transform: translateX(-50%);
            width: 30px;
            height: 3px;
            background: var(--accent-blue);
            border-radius: 2px;
        }

        /* Card Styles */
        .disaster-map-card,
        .disaster-card {
            border: none;
            border-radius: 12px;
            box-shadow: var(--elevated-shadow);
            overflow: hidden;
            background: var(--card-bg);
        }

        .disaster-map-card .card-header,
        .disaster-card .card-header {
            background: linear-gradient(135deg, var(--primary-blue) 0%, var(--secondary-blue) 100%);
            color: white;
            border: none;
            padding: 1.25rem;
        }

        .card-title {
            font-weight: 700;
            font-size: 1.1rem;
        }

        /* Hazard Filter Buttons */
        .hazard-filter-buttons {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            justify-content: flex-end;
        }

        .hazard-btn {
            border-radius: 20px;
            font-size: 0.875rem;
            font-weight: 600;
            padding: 0.5rem 1rem;
            transition: all 0.3s ease;
            white-space: nowrap;
            background: white;
            color: var(--primary-blue);
            border: 2px solid var(--primary-blue);
        }

        .hazard-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
            background: var(--primary-blue);
            color: white;
        }

        .hazard-btn.active {
            background: var(--primary-blue);
            border-color: var(--primary-blue);
            color: white;
        }

        /* Map Controls Section */
        .map-controls-section {
            background: var(--panel-bg);
            border-bottom: 1px solid var(--border-color);
            padding: 1rem 1.25rem;
        }

        .control-buttons .btn-group {
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .control-btn {
            border-radius: 8px;
            font-weight: 600;
            padding: 0.5rem 0.75rem;
            transition: all 0.3s ease;
            min-width: 80px;
            background: white;
            color: var(--primary-blue);
            border: 2px solid var(--primary-blue);
        }

        .control-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            background: var(--primary-blue);
            color: white;
        }

        .status-display {
            background: var(--card-bg);
            border-radius: 8px;
            padding: 0.75rem;
            border: 1px solid var(--border-color);
        }

        .status-text {
            color: var(--text-secondary);
            font-size: 0.875rem;
            font-weight: 500;
        }

        /* Legend Panel */
        .legend-panel {
            height: 600px;
            overflow-y: auto;
            background: var(--panel-bg);
            border-right: 1px solid var(--border-color);
            padding: 0;
        }

        .legend-header {
            background: var(--primary-blue);
            color: white;
            padding: 1rem;
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .legend-title {
            margin: 0;
            font-weight: 700;
            font-size: 1rem;
        }

        .legend-content {
            padding: 1rem;
        }

        .legend-section {
            margin-bottom: 2rem;
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

        /* Map Container */
        .map-header {
            background: var(--panel-bg);
            padding: 0.75rem 1.25rem;
            border-bottom: 1px solid var(--border-color);
        }

        .map-title {
            margin: 0;
            color: var(--text-primary);
            font-weight: 700;
            font-size: 1rem;
        }

        .disaster-map {
            height: 560px;
            width: 100%;
            border: none;
        }

        /* Card Footer */
        .card-footer {
            background: var(--panel-bg);
            border-top: 1px solid var(--border-color);
            padding: 1.25rem;
        }

        .footer-section {
            margin-bottom: 1rem;
        }

        .footer-title {
            color: var(--text-primary);
            font-weight: 700;
            font-size: 0.9rem;
            margin-bottom: 0.75rem;
        }

        .risk-indicators,
        .purok-indicators {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .risk-indicator,
        .purok-indicator {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            background: var(--card-bg);
            padding: 0.375rem 0.75rem;
            border-radius: 6px;
            border: 1px solid var(--border-color);
            font-size: 0.875rem;
        }

        .risk-color {
            width: 16px;
            height: 16px;
            border-radius: 3px;
            border: 1px solid rgba(0, 0, 0, 0.1);
        }

        .purok-icon {
            font-size: 1rem;
        }

        .risk-label,
        .purok-label {
            font-weight: 600;
            color: var(--text-primary);
        }

        .emergency-status {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .status-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            background: var(--card-bg);
            padding: 0.375rem 0.75rem;
            border-radius: 6px;
            border: 1px solid var(--border-color);
        }

        .status-indicator {
            width: 12px;
            height: 12px;
            border-radius: 50%;
        }

        .status-label {
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--text-primary);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .dashboard-header {
                padding: 1rem;
            }
            
            .dashboard-title {
                font-size: 1.25rem;
            }
            
            .disaster-nav-tabs .nav-link {
                padding: 0.5rem;
                font-size: 0.875rem;
            }
            
            .map-controls-section {
                padding: 0.75rem;
            }
            
            .control-btn {
                min-width: 60px;
                padding: 0.375rem 0.5rem;
            }
            
            .hazard-filter-buttons .btn-group {
                justify-content: center;
            }
            
            .hazard-btn {
                padding: 0.375rem 0.75rem;
                font-size: 0.75rem;
            }
            
            .legend-panel {
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                z-index: 1050;
                background: var(--card-bg);
                height: 100vh;
            }
            
            .card-footer .row > div {
                margin-bottom: 1rem;
            }
            
            .risk-indicators,
            .purok-indicators {
                gap: 0.5rem;
            }
            
            .risk-indicator,
            .purok-indicator {
                font-size: 0.75rem;
                padding: 0.25rem 0.5rem;
            }
        }

        @media (max-width: 576px) {
            .disaster-nav-tabs .nav-link {
                padding: 0.375rem;
                margin: 0 0.125rem;
            }
            
            .control-buttons .btn-group {
                width: 100%;
                justify-content: space-between;
            }
            
            .control-btn {
                flex: 1;
                min-width: auto;
                font-size: 0.75rem;
            }
            
            .hazard-filter-buttons {
                justify-content: center;
            }
            
            .disaster-map {
                height: 400px;
            }
            
            .legend-panel {
                height: 500px;
            }
        }

        /* Animation and Transitions */
        .control-btn,
        .hazard-btn,
        .nav-link {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .legend-item,
        .risk-indicator,
        .purok-indicator,
        .status-item {
            transition: background 0.2s ease, transform 0.2s ease;
        }

        .legend-item:hover,
        .risk-indicator:hover,
        .purok-indicator:hover {
            transform: translateX(2px);
        }

        /* Accessibility Improvements */
        .control-btn:focus,
        .hazard-btn:focus,
        .nav-link:focus {
            outline: 2px solid var(--accent-blue);
            outline-offset: 2px;
        }

        /* High contrast mode support */
        @media (prefers-contrast: high) {
            :root {
                --border-color: #000000;
                --text-secondary: #000000;
                --panel-bg: #ffffff;
            }
        }

        /* Reduced motion support */
        @media (prefers-reduced-motion: reduce) {
            *,
            *::before,
            *::after {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
            }
        }

        /* Print styles */
        @media print {
            .disaster-nav-tabs,
            .map-controls-section,
            .card-footer {
                display: none;
            }
            
            .disaster-map {
                height: 400px;
            }
            
            .legend-panel {
                position: static;
                height: auto;
            }
        }
    </style>
</head>
<body>
<div class="container-fluid mt-4">
    <!-- Header Section -->
    <div class="dashboard-header mb-4">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h2 class="dashboard-title">
                    <i class="fas fa-shield-alt me-2 text-primary"></i>
                    Welcome, User!
                </h2>
                <p class="dashboard-subtitle mb-0">
                    <i class="fas fa-map-marker-alt me-2"></i>
                    Barangay Ilawod Disaster Risk Management Dashboard
                </p>
            </div>
            <div class="col-md-4 d-flex justify-content-end align-items-center">
    <form id="logoutForm" action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-link nav-link text-dark p-0" title="Logout">
            <i class="fas fa-sign-out-alt fa-lg"></i>
        </button>
    </form>
</div>
        </div>
    </div>

    <!-- Navigation Tabs -->
    <ul class="nav nav-tabs mb-3 disaster-nav-tabs" id="userTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="maps-tab" data-bs-toggle="tab" data-bs-target="#maps" type="button" role="tab">
                <i class="fas fa-map-marked-alt me-2"></i>
                <span class="d-none d-sm-inline">Disaster Maps</span>
                <span class="d-inline d-sm-none">Maps</span>
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="evacuation-tab" data-bs-toggle="tab" data-bs-target="#evacuation" type="button" role="tab">
                <i class="fas fa-home me-2"></i>
                <span class="d-none d-sm-inline">Evacuation Centers</span>
                <span class="d-inline d-sm-none">Centers</span>
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="evacuation-request-tab" data-bs-toggle="tab" data-bs-target="#evacuation-request" type="button" role="tab">
                <i class="fas fa-file-contract me-2"></i>
                <span class="d-none d-sm-inline">MOU/MOA Homes</span>
                <span class="d-inline d-sm-none">MOU/MOA</span>
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="tickets-tab" data-bs-toggle="tab" data-bs-target="#tickets" type="button" role="tab">
                <i class="fas fa-ticket-alt me-2"></i>
                <span class="d-none d-sm-inline">Support Tickets</span>
                <span class="d-inline d-sm-none">Support</span>
            </button>
        </li>

        <li class="nav-item" role="presentation">
            <button class="nav-link" id="notifications-tab" data-bs-toggle="tab" data-bs-target="#notifications" type="button" role="tab">
                <i class="fas fa-bell me-2"></i>
                <span class="d-none d-sm-inline">Notifications</span>
                <span class="d-inline d-sm-none">Alerts</span>
            </button>
        </li>
    </ul>

    <div class="tab-content" id="userTabsContent">
        <!-- Maps Tab -->
        <div class="tab-pane fade show active" id="maps" role="tabpanel">
            <div class="card disaster-map-card mb-4">
                <div class="card-header">
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
                                    <button type="button" class="btn btn-outline-info hazard-btn" data-hazard="fire">
                                        <i class="fas fa-fire me-1"></i>Fire
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary hazard-btn" data-hazard="ashfall">
                                        <i class="fas fa-cloud me-1"></i>Ashfall
                                    </button>
                                    <button type="button" class="btn btn-outline-dark hazard-btn" data-hazard="lahar">
                                        <i class="fas fa-tint me-1"></i>Lahar
                                    </button>
                                    <button type="button" class="btn btn-outline-success hazard-btn" data-hazard="mudflow">
                                        <i class="fas fa-water me-1"></i>Mudflow
                                    </button>
                                    <button type="button" class="btn btn-outline-primary hazard-btn" data-hazard="wind">
                                        <i class="fas fa-wind me-1"></i>Wind
                                    </button>
                                    <button type="button" class="btn btn-outline-warning hazard-btn" data-hazard="evacuation">
                                        <i class="fas fa-home me-1"></i>Centers
                                    </button>
                                    <button type="button" class="btn btn-outline-info hazard-btn" data-hazard="routes">
                                        <i class="fas fa-route me-1"></i>Routes
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Map Controls - Cleaned up to remove duplicates -->
                <div class="map-controls-section">
                    <div class="row align-items-center">
                        <div class="col-lg-8 col-md-7">
                            <div class="control-buttons">
                                <div class="btn-group btn-group-sm" role="group">
                                    <button type="button" class="btn btn-outline-primary control-btn" id="toggleRoutesBtn" onclick="toggleRoutesVisibility()">
                                        <i class="fas fa-route me-1"></i>
                                        <span class="d-none d-md-inline">Hide Routes</span>
                                        <span class="d-inline d-md-none">Routes</span>
                                    </button>
                                    <button type="button" class="btn btn-outline-success control-btn" onclick="getCurrentLocationDashboard()">
                                        <i class="fas fa-location-arrow me-1"></i>
                                        <span class="d-none d-md-inline">Location</span>
                                        <span class="d-inline d-md-none">GPS</span>
                                    </button>
                                    <button type="button" class="btn btn-outline-info control-btn" onclick="findNearestEvacuationCenter()">
                                        <i class="fas fa-search-location me-1"></i>
                                        <span class="d-none d-md-inline">Nearest</span>
                                        <span class="d-inline d-md-none">Near</span>
                                    </button>
                                    <button type="button" class="btn btn-outline-warning control-btn" onclick="toggleMapViewDashboard()">
                                        <i class="fas fa-satellite me-1"></i>
                                        <span class="d-none d-md-inline">Satellite</span>
                                        <span class="d-inline d-md-none">Sat</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-5">
                            <div class="status-display">
                                <div id="statusText" class="status-text">
                                    <i class="fas fa-info-circle me-1"></i>
                                    <span>Find your location...</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body p-0">
                    <div class="row g-0">
                        <!-- Legend Panel -->
                        <div class="col-lg-3 col-md-4 d-none d-md-block" id="legendContainer">
                            <div class="legend-panel">
                                <div class="legend-header">
                                    <h6 class="legend-title">
                                        <i class="fas fa-list me-2"></i>LEGEND
                                    </h6>
                                </div>
                                <div class="legend-content" id="legendContent">
                                
                                <!-- Evacuation Centers -->
                                <div class="legend-section">
                                    <h6 class="legend-section-title text-success">
                                        <i class="fas fa-home me-2"></i>Evacuation Centers
                                    </h6>
                                    <div class="legend-items">
                                        <div class="legend-item">
                                            <span class="legend-icon" style="color: green;">🏠</span>
                                            <span class="legend-text">Open Centers</span>
                                        </div>
                                        <div class="legend-item">
                                            <span class="legend-icon" style="color: orange;">🏠</span>
                                            <span class="legend-text">Full Centers</span>
                                        </div>
                                        <div class="legend-item">
                                            <span class="legend-icon" style="color: red;">🏠</span>
                                            <span class="legend-text">Closed Centers</span>
                                        </div>
                                        <div class="legend-item">
                                            <span class="legend-icon" style="color: blue;">🏫</span>
                                            <span class="legend-text">Schools</span>
                                        </div>
                                        <div class="legend-item">
                                            <span class="legend-icon" style="color: purple;">🏛️</span>
                                            <span class="legend-text">Government Buildings</span>
                                        </div>
                                        <div class="legend-item">
                                            <span class="legend-icon" style="color: brown;">🏘️</span>
                                            <span class="legend-text">Private Homes (MOU/MOA)</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Evacuation Routes -->
                                <div class="legend-section">
                                    <h6 class="legend-section-title text-info">
                                        <i class="fas fa-route me-2"></i>Evacuation Routes
                                    </h6>
                                    <div class="legend-items">
                                        <div class="legend-item">
                                            <span class="legend-line" style="color: #00FF00; font-weight: bold;">——</span>
                                            <span class="legend-text">Primary Routes</span>
                                        </div>
                                        <div class="legend-item">
                                            <span class="legend-line" style="color: #FFD700; font-weight: bold;">- - -</span>
                                            <span class="legend-text">Secondary Routes</span>
                                        </div>
                                        <div class="legend-item">
                                            <span class="legend-line" style="color: #FF4500; font-weight: bold;">••••</span>
                                            <span class="legend-text">Emergency Routes</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Risk Levels -->
                                <div class="legend-section">
                                    <h6 class="legend-section-title text-danger">
                                        <i class="fas fa-exclamation-triangle me-2"></i>Risk Levels
                                    </h6>
                                    <div class="legend-items">
                                        <div class="legend-item">
                                            <span class="legend-square high-risk"></span>
                                            <span class="legend-text">High Risk</span>
                                        </div>
                                        <div class="legend-item">
                                            <span class="legend-square medium-risk"></span>
                                            <span class="legend-text">Medium Risk</span>
                                        </div>
                                        <div class="legend-item">
                                            <span class="legend-square low-risk"></span>
                                            <span class="legend-text">Low Risk</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Purok Markers -->
                                <div class="legend-section">
                                    <h6 class="legend-section-title text-success">
                                        <i class="fas fa-map-marker-alt me-2"></i>Purok Markers
                                    </h6>
                                    <div class="legend-items">
                                        <div class="legend-item">
                                            <span class="legend-icon" style="color: black;">🏠</span>
                                            <span class="legend-text">Purok 1</span>
                                        </div>
                                        <div class="legend-item">
                                            <span class="legend-icon" style="color: orange;">🏠</span>
                                            <span class="legend-text">Purok 2</span>
                                        </div>
                                        <div class="legend-item">
                                            <span class="legend-icon" style="color: blue;">🏠</span>
                                            <span class="legend-text">Purok 3</span>
                                        </div>
                                        <div class="legend-item">
                                            <span class="legend-icon" style="color: purple;">🏠</span>
                                            <span class="legend-text">Purok 4</span>
                                        </div>
                                        <div class="legend-item">
                                            <span class="legend-icon" style="color: green;">🏠</span>
                                            <span class="legend-text">Purok 5</span>
                                        </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>

                        <!-- Map Container -->
                        <div class="col-lg-9 col-md-8 col-12" id="mapContainer">
                            <div class="map-header">
                                <h6 class="map-title">
                                    <i class="fas fa-map me-2"></i>Disaster Risk Map
                                </h6>
                            </div>
                            <div id="disaster-map" class="disaster-map"></div>
                        </div>
                    </div>
                </div>

                <!-- Map Footer with Emergency Status -->
                <div class="card-footer">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="footer-section">
                                <h6 class="footer-title">
                                    <i class="fas fa-info-circle me-2"></i>Map Information
                                </h6>
                                <p class="text-muted small mb-0">Interactive disaster risk map showing hazard zones, evacuation centers, and safe routes for Barangay Ilawod.</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="footer-section">
                                <h6 class="footer-title">
                                    <i class="fas fa-shield-alt me-2"></i>Emergency Status
                                </h6>
                                <div class="emergency-status">
                                    <div class="status-item">
                                        <span class="status-indicator bg-success"></span>
                                        <span class="status-label">All Routes Clear</span>
                                    </div>
                                    <div class="status-item">
                                        <span class="status-indicator bg-info"></span>
                                        <span class="status-label">Centers Available</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Evacuation Centers Tab -->
        <div class="tab-pane fade" id="evacuation" role="tabpanel">
            <div class="card disaster-card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-home me-2"></i>Evacuation Centers
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="evacuation-centers-list">
                                <!-- Evacuation Center Cards -->
                                <div class="center-card mb-3 p-3 border rounded">
                                    <div class="row align-items-center">
                                        <div class="col-md-8">
                                            <h6 class="mb-1"><i class="fas fa-school me-2 text-primary"></i>Barangay Ilawod Elementary School</h6>
                                            <p class="mb-1 text-muted small">Capacity: 200 people | Currently: 45 people</p>
                                            <p class="mb-0 text-muted small"><i class="fas fa-map-marker-alt me-1"></i>Main Road, Purok 2</p>
                                        </div>
                                        <div class="col-md-4 text-end">
                                            <span class="badge bg-success mb-2">OPEN</span><br>
                                            <button class="btn btn-sm btn-outline-primary">View Details</button>
                                        </div>
                                    </div>
                                </div>

                                <div class="center-card mb-3 p-3 border rounded">
                                    <div class="row align-items-center">
                                        <div class="col-md-8">
                                            <h6 class="mb-1"><i class="fas fa-building me-2 text-primary"></i>Barangay Hall</h6>
                                            <p class="mb-1 text-muted small">Capacity: 100 people | Currently: 25 people</p>
                                            <p class="mb-0 text-muted small"><i class="fas fa-map-marker-alt me-1"></i>Government Center, Purok 3</p>
                                        </div>
                                        <div class="col-md-4 text-end">
                                            <span class="badge bg-success mb-2">OPEN</span><br>
                                            <button class="btn btn-sm btn-outline-primary">View Details</button>
                                        </div>
                                    </div>
                                </div>

                                <div class="center-card mb-3 p-3 border rounded">
                                    <div class="row align-items-center">
                                        <div class="col-md-8">
                                            <h6 class="mb-1"><i class="fas fa-church me-2 text-primary"></i>Community Chapel</h6>
                                            <p class="mb-1 text-muted small">Capacity: 150 people | Currently: 120 people</p>
                                            <p class="mb-0 text-muted small"><i class="fas fa-map-marker-alt me-1"></i>Central Area, Purok 4</p>
                                        </div>
                                        <div class="col-md-4 text-end">
                                            <span class="badge bg-warning mb-2">NEAR FULL</span><br>
                                            <button class="btn btn-sm btn-outline-primary">View Details</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="evacuation-summary p-3 bg-light rounded">
                                <h6><i class="fas fa-chart-pie me-2"></i>Centers Summary</h6>
                                <div class="summary-item d-flex justify-content-between mb-2">
                                    <span>Total Centers:</span>
                                    <strong>3</strong>
                                </div>
                                <div class="summary-item d-flex justify-content-between mb-2">
                                    <span>Available Capacity:</span>
                                    <strong>260 people</strong>
                                </div>
                                <div class="summary-item d-flex justify-content-between mb-2">
                                    <span>Currently Occupied:</span>
                                    <strong>190 people</strong>
                                </div>
                                <hr>
                                <div class="status-indicators">
                                    <div class="mb-2"><span class="badge bg-success me-2">2</span>Open Centers</div>
                                    <div class="mb-2"><span class="badge bg-warning me-2">1</span>Near Full</div>
                                    <div class="mb-2"><span class="badge bg-danger me-2">0</span>Full Centers</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- MOU/MOA Private Home Evacuation Centers -->
        <div class="tab-pane fade" id="evacuation-request" role="tabpanel">
            <div class="card disaster-card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-home me-2"></i>Private Home Evacuation Centers (MOU/MOA)
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="alert alert-info mb-4">
                                <h6 class="alert-heading"><i class="fas fa-info-circle me-2"></i>MOU/MOA Program</h6>
                                <p class="mb-0">Large, sturdy homes can serve as potential evacuation centers through a Memorandum of Agreement (MOU/MOA) between the household member and the Barangay. This system provides decision support only.</p>
                            </div>
                            
                            <form id="mouRequestForm">
                                <h6 class="mb-3"><i class="fas fa-user-circle me-2"></i>Homeowner Information</h6>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label"><i class="fas fa-user me-1"></i>Homeowner Full Name</label>
                                        <input type="text" class="form-control" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label"><i class="fas fa-phone me-1"></i>Contact Number</label>
                                        <input type="tel" class="form-control" required>
                                    </div>
                                </div>
                                
                                <h6 class="mb-3 mt-4"><i class="fas fa-home me-2"></i>Property Information</h6>
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label"><i class="fas fa-map-marker-alt me-1"></i>Complete Property Address</label>
                                        <input type="text" class="form-control" required placeholder="House number, street, purok, barangay">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label"><i class="fas fa-building me-1"></i>House Type/Structure</label>
                                        <select class="form-control" required>
                                            <option value="">Select house type...</option>
                                            <option value="concrete">Concrete/Solid Structure</option>
                                            <option value="mixed">Mixed Materials (Concrete & Wood)</option>
                                            <option value="reinforced">Reinforced Concrete</option>
                                            <option value="multi-story">Multi-Story Building</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label"><i class="fas fa-users me-1"></i>Estimated Capacity</label>
                                        <select class="form-control" required>
                                            <option value="">Select capacity...</option>
                                            <option value="10-20">10-20 people</option>
                                            <option value="21-50">21-50 people</option>
                                            <option value="51-100">51-100 people</option>
                                            <option value="100+">100+ people</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <h6 class="mb-3 mt-4"><i class="fas fa-clipboard-check me-2"></i>Facilities Available</h6>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="toilet">
                                            <label class="form-check-label" for="toilet">Toilet/Restroom Facilities</label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="water">
                                            <label class="form-check-label" for="water">Clean Water Access</label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="electricity">
                                            <label class="form-check-label" for="electricity">Electricity/Generator</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="kitchen">
                                            <label class="form-check-label" for="kitchen">Kitchen/Cooking Area</label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="parking">
                                            <label class="form-check-label" for="parking">Parking/Vehicle Access</label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="firstaid">
                                            <label class="form-check-label" for="firstaid">First Aid Supplies</label>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="mb-3 mt-4">
                                    <label class="form-label"><i class="fas fa-comment me-1"></i>Additional Information</label>
                                    <textarea class="form-control" rows="3" placeholder="Any additional facilities, special features, or important notes about the property..."></textarea>
                                </div>
                                
                                <div class="mb-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="agreement" required>
                                        <label class="form-check-label" for="agreement">
                                            <strong>I agree to participate in the MOU/MOA program and understand that this is for decision support purposes only. Actual implementation requires proper barangay inspection and formal agreement.</strong>
                                        </label>
                                    </div>
                                </div>
                                
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-file-contract me-1"></i>Submit MOU/MOA Application
                                </button>
                            </form>
                        </div>
                        <div class="col-md-4">
                            <div class="mou-requirements p-3 bg-light rounded mb-3">
                                <h6><i class="fas fa-clipboard-list me-2"></i>MOU/MOA Requirements</h6>
                                <ul class="small text-muted mb-0">
                                    <li>Large, sturdy house structure</li>
                                    <li>Safe location (not in high-risk zones)</li>
                                    <li>Basic facilities (toilet, water access)</li>
                                    <li>Willing homeowner participation</li>
                                    <li>Barangay inspection and approval</li>
                                    <li>Formal agreement signing</li>
                                </ul>
                            </div>
                            
                            <div class="mou-process p-3 bg-info bg-opacity-10 border border-info rounded mb-3">
                                <h6><i class="fas fa-list-ol me-2 text-info"></i>Process Steps</h6>
                                <ol class="small text-muted mb-0">
                                    <li>Submit application form</li>
                                    <li>Barangay team inspection</li>
                                    <li>Safety and capacity assessment</li>
                                    <li>Community consultation</li>
                                    <li>MOU/MOA preparation</li>
                                    <li>Agreement signing</li>
                                    <li>Center activation in emergencies</li>
                                </ol>
                            </div>
                            
                            <div class="emergency-contacts p-3 bg-warning bg-opacity-10 border border-warning rounded">
                                <h6><i class="fas fa-phone me-2 text-warning"></i>For Inquiries</h6>
                                <div class="small">
                                    <div class="mb-2">
                                        <strong>Barangay Office:</strong><br>
                                        <a href="tel:+631234567890" class="text-decoration-none">
                                            <i class="fas fa-phone me-1"></i>(+63) 123-456-7890
                                        </a>
                                    </div>
                                    <div class="mb-0">
                                        <strong>Emergency Management:</strong><br>
                                        <a href="tel:+631234567891" class="text-decoration-none">
                                            <i class="fas fa-phone me-1"></i>(+63) 123-456-7891
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Support Tickets Tab -->
        <div class="tab-pane fade" id="tickets" role="tabpanel">
            <div class="card disaster-card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-ticket-alt me-2"></i>Support Tickets
                            </h5>
                        </div>
                        <div class="col-auto">
                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#newTicketModal">
                                <i class="fas fa-plus me-1"></i>New Ticket
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="tickets-list">
                                <!-- Support Ticket Items -->
                                <div class="ticket-item p-3 border rounded mb-3">
                                    <div class="row align-items-center">
                                        <div class="col-md-8">
                                            <h6 class="mb-1">Map not loading properly</h6>
                                            <p class="mb-1 text-muted small">Ticket #001 | Created: 2 hours ago</p>
                                            <p class="mb-0 text-muted small">The disaster map is not showing hazard layers correctly...</p>
                                        </div>
                                        <div class="col-md-4 text-end">
                                            <span class="badge bg-warning mb-2">IN PROGRESS</span><br>
                                            <button class="btn btn-sm btn-outline-primary">View</button>
                                        </div>
                                    </div>
                                </div>

                                <div class="ticket-item p-3 border rounded mb-3">
                                    <div class="row align-items-center">
                                        <div class="col-md-8">
                                            <h6 class="mb-1">Location services not working</h6>
                                            <p class="mb-1 text-muted small">Ticket #002 | Created: 1 day ago</p>
                                            <p class="mb-0 text-muted small">Unable to get current location when clicking the Location button...</p>
                                        </div>
                                        <div class="col-md-4 text-end">
                                            <span class="badge bg-success mb-2">RESOLVED</span><br>
                                            <button class="btn btn-sm btn-outline-primary">View</button>
                                        </div>
                                    </div>
                                </div>

                                <div class="ticket-item p-3 border rounded mb-3">
                                    <div class="row align-items-center">
                                        <div class="col-md-8">
                                            <h6 class="mb-1">Add new evacuation center</h6>
                                            <p class="mb-1 text-muted small">Ticket #003 | Created: 3 days ago</p>
                                            <p class="mb-0 text-muted small">Request to add new community center as evacuation facility...</p>
                                        </div>
                                        <div class="col-md-4 text-end">
                                            <span class="badge bg-info mb-2">OPEN</span><br>
                                            <button class="btn btn-sm btn-outline-primary">View</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="tickets-summary p-3 bg-light rounded">
                                <h6><i class="fas fa-chart-bar me-2"></i>Tickets Summary</h6>
                                <div class="summary-item d-flex justify-content-between mb-2">
                                    <span>Total Tickets:</span>
                                    <strong>3</strong>
                                </div>
                                <div class="summary-item d-flex justify-content-between mb-2">
                                    <span>Open:</span>
                                    <strong>1</strong>
                                </div>
                                <div class="summary-item d-flex justify-content-between mb-2">
                                    <span>In Progress:</span>
                                    <strong>1</strong>
                                </div>
                                <div class="summary-item d-flex justify-content-between mb-2">
                                    <span>Resolved:</span>
                                    <strong>1</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Notifications Tab -->
        <div class="tab-pane fade" id="notifications" role="tabpanel">
            <div class="card disaster-card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-bell me-2"></i>Notifications & Alerts
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="notifications-list">
                                <!-- Emergency Alert -->
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <h6 class="alert-heading"><i class="fas fa-exclamation-triangle me-2"></i>Weather Advisory</h6>
                                    <p class="mb-1">Heavy rainfall expected in the next 6 hours. Residents in flood-prone areas are advised to prepare for possible evacuation.</p>
                                    <small class="text-muted">2 hours ago | Provincial Weather Office</small>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>

                                <!-- Information Alert -->
                                <div class="alert alert-info alert-dismissible fade show" role="alert">
                                    <h6 class="alert-heading"><i class="fas fa-info-circle me-2"></i>System Update</h6>
                                    <p class="mb-1">Disaster management dashboard has been updated with new features. Location services are now more accurate.</p>
                                    <small class="text-muted">1 day ago | System Administrator</small>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>

                                <!-- Success Alert -->
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <h6 class="alert-heading"><i class="fas fa-check-circle me-2"></i>Evacuation Update</h6>
                                    <p class="mb-1">Barangay Hall evacuation center is now fully operational with additional supplies and medical staff.</p>
                                    <small class="text-muted">2 days ago | Barangay Emergency Team</small>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>

                                <!-- Regular Notifications -->
                                <div class="notification-item p-3 border rounded mb-3">
                                    <div class="row align-items-center">
                                        <div class="col-md-10">
                                            <h6 class="mb-1"><i class="fas fa-calendar me-2 text-primary"></i>Emergency Preparedness Training</h6>
                                            <p class="mb-1 text-muted small">Community training scheduled for next weekend at the Barangay Hall.</p>
                                            <small class="text-muted">3 days ago</small>
                                        </div>
                                        <div class="col-md-2 text-end">
                                            <span class="badge bg-primary">Event</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="notification-item p-3 border rounded mb-3">
                                    <div class="row align-items-center">
                                        <div class="col-md-10">
                                            <h6 class="mb-1"><i class="fas fa-tools me-2 text-warning"></i>System Maintenance</h6>
                                            <p class="mb-1 text-muted small">Scheduled maintenance on mapping services this Sunday 2:00 AM - 4:00 AM.</p>
                                            <small class="text-muted">1 week ago</small>
                                        </div>
                                        <div class="col-md-2 text-end">
                                            <span class="badge bg-warning">Maintenance</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="emergency-contacts p-3 bg-danger text-white rounded">
                                <h6><i class="fas fa-phone me-2"></i>Emergency Contacts</h6>
                                <div class="contact-item mb-2">
                                    <strong>Barangay Emergency:</strong><br>
                                    <a href="tel:+631234567890" class="text-white text-decoration-none">
                                        <i class="fas fa-phone me-1"></i>(+63) 123-456-7890
                                    </a>
                                </div>
                                <div class="contact-item mb-2">
                                    <strong>Fire Department:</strong><br>
                                    <a href="tel:116" class="text-white text-decoration-none">
                                        <i class="fas fa-phone me-1"></i>116
                                    </a>
                                </div>
                                <div class="contact-item">
                                    <strong>National Emergency:</strong><br>
                                    <a href="tel:911" class="text-white text-decoration-none">
                                        <i class="fas fa-phone me-1"></i>911
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- New Ticket Modal -->
<div class="modal fade" id="newTicketModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-plus me-2"></i>Create New Support Ticket</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="newTicketForm">
                    <div class="mb-3">
                        <label class="form-label">Subject</label>
                        <input type="text" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Category</label>
                        <select class="form-control" required>
                            <option value="">Select category...</option>
                            <option value="technical">Technical Issue</option>
                            <option value="feature">Feature Request</option>
                            <option value="bug">Bug Report</option>
                            <option value="general">General Inquiry</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Priority</label>
                        <select class="form-control" required>
                            <option value="low">Low</option>
                            <option value="medium" selected>Medium</option>
                            <option value="high">High</option>
                            <option value="urgent">Urgent</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" rows="4" required placeholder="Please describe your issue or request in detail..."></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" form="newTicketForm" class="btn btn-primary">Submit Ticket</button>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<!-- Custom JavaScript for dashboard functionality -->
<script>
// Global variables
let map;
let currentLocation = null;
let evacuationCenters = [];
let routesVisible = true;
let hazardLayers = {};
let evacuationRoutes = {};
let purokMarkers = {};

// Initialize routes visibility
window.routesVisible = true;

// Initialize the map when the page loads
document.addEventListener('DOMContentLoaded', function() {
    // Ensure DOM is fully loaded before initialization
    setTimeout(function() {
        initializeMap();
        initializeEventListeners();
    }, 500);
});

// Initialize the Leaflet map
function initializeMap() {
    // Barangay Ilawod approximate coordinates (Legazpi City, Albay)
    const ilawodCoords = [13.1391, 123.7436];
    
    map = L.map('disaster-map').setView(ilawodCoords, 15);
    
    // Add tile layer
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);
    
    // Add sample evacuation centers
    addEvacuationCenters();
    
    // Add sample risk areas
    addRiskAreas();
    
    // Add Purok markers
    addPurokMarkers();
    
    // Add evacuation routes
    addEvacuationRoutes();
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
    
    // Check if geolocation is available
    if (!navigator.geolocation) {
        updateStatus('Geolocation is not supported by this browser');
        // Set a default location (Barangay Ilawod center) if geolocation fails
        const defaultLocation = [13.1391, 123.7436];
        currentLocation = defaultLocation;
        addCurrentLocationMarker(defaultLocation, 'Default Location (Barangay Ilawod Center)');
        return;
    }
    
    // Request geolocation with improved error handling
    navigator.geolocation.getCurrentPosition(
        function(position) {
            const lat = position.coords.latitude;
            const lng = position.coords.longitude;
            const accuracy = position.coords.accuracy;
            
            currentLocation = [lat, lng];
            addCurrentLocationMarker([lat, lng], 'Your Current Location');
            
            map.setView([lat, lng], 16);
            
            // Get readable location name using reverse geocoding
            fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&zoom=18&addressdetails=1`)
                .then(response => response.json())
                .then(data => {
                    let locationText = '';
                    if (data && data.display_name) {
                        // Extract useful parts of the address
                        const address = data.address || {};
                        const parts = [];
                        
                        if (address.house_number) parts.push(address.house_number);
                        if (address.road) parts.push(address.road);
                        if (address.village || address.suburb || address.neighbourhood) {
                            parts.push(address.village || address.suburb || address.neighbourhood);
                        }
                        if (address.city || address.town || address.municipality) {
                            parts.push(address.city || address.town || address.municipality);
                        }
                        
                        locationText = parts.length > 0 ? parts.join(', ') : data.display_name.split(',')[0];
                    } else {
                        locationText = `${lat.toFixed(4)}, ${lng.toFixed(4)}`;
                    }
                    
                    updateStatus(`Location found: ${locationText} (±${accuracy.toFixed(0)}m)`);
                })
                .catch(error => {
                    console.warn('Reverse geocoding failed:', error);
                    updateStatus(`Location found: ${lat.toFixed(4)}, ${lng.toFixed(4)} (±${accuracy.toFixed(0)}m)`);
                });
        },
        function(error) {
            let errorMsg = 'Location error: ';
            let fallbackLocation = [13.1391, 123.7436]; // Barangay Ilawod center
            
            switch(error.code) {
                case error.PERMISSION_DENIED:
                    errorMsg += 'Please allow location access and try again';
                    break;
                case error.POSITION_UNAVAILABLE:
                    errorMsg += 'Location service unavailable, using default location';
                    break;
                case error.TIMEOUT:
                    errorMsg += 'Location request timed out, using default location';
                    break;
                default:
                    errorMsg += 'Using default location';
                    break;
            }
            
            updateStatus(errorMsg);
            console.warn('Geolocation error:', error);
            
            // Set fallback location
            currentLocation = fallbackLocation;
            addCurrentLocationMarker(fallbackLocation, 'Default Location (Barangay Ilawod)');
            map.setView(fallbackLocation, 15);
        },
        {
            enableHighAccuracy: false, // Changed to false for better compatibility
            timeout: 15000, // Increased timeout
            maximumAge: 300000 // 5 minutes cache
        }
    );
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
        getCurrentLocationDashboard();
        return;
    }
    
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
        map.setView(nearest.coords, 17);
        nearest.marker.openPopup();
        updateStatus(`Nearest center: ${nearest.name} (${minDistance.toFixed(0)}m away)`);
        
        // Show route with visual line
        showRouteToCenter(nearest.coords, nearest.name);
    } else {
        updateStatus('No evacuation centers found');
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
                // Show everything except routes (routes have their own control)
                Object.values(hazardLayers).forEach(layer => map.addLayer(layer));
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
                if (hazardLayers[type]) {
                    map.addLayer(hazardLayers[type]);
                }
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
</script>
</body>
</html>