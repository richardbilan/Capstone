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

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
    @stack('styles')

    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            color: #333;
        }
        .container-fluid {
            max-width: 1400px;
            margin: 0 auto;
            padding: 20px;
        }
        h2, h3, h4, h5, h6 { font-weight: 600; }

        /* Dashboard Header */
        .dashboard-header {
            background-color: #fff;
            border-radius: 10px;
            padding: 20px 25px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }
        .dashboard-title { font-size: 1.8rem; margin-bottom: 5px; color: #0d6efd; }
        .dashboard-subtitle { font-size: 0.95rem; color: #6c757d; }

        /* Logout Button */
        #logoutForm button {
            color: #495057; font-size: 1.2rem; transition: color 0.2s;
        }
        #logoutForm button:hover { color: #dc3545; }

        /* Navigation Tabs */
        .disaster-nav-tabs {
            border-bottom: none; margin-bottom: 30px;
        }
        .disaster-nav-tabs .nav-link {
            background-color: #fff;
            color: #495057;
            border: 1px solid #dee2e6;
            border-radius: 8px 8px 0 0;
            margin-right: 5px;
            transition: all 0.2s ease-in-out;
            padding: 10px 15px;
            display: flex; align-items: center;
        }
        .disaster-nav-tabs .nav-link i { margin-right: 6px; }
        .disaster-nav-tabs .nav-link.active {
            background-color: #0d6efd; color: #fff; border-color: #0d6efd;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }
        .disaster-nav-tabs .nav-link:hover {
            background-color: #e7f1ff; color: #0d6efd;
        }

        /* Tab Content */
        .tab-content {
            background-color: #fff;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.05);
            min-height: 400px;
        }

        /* Cards */
        .card { border-radius: 10px; box-shadow: 0 2px 6px rgba(0,0,0,0.05); }

        /* Media Queries */
        @media (max-width: 768px) {
            .dashboard-header { text-align: center; }
            .dashboard-header .col-md-4 { margin-top: 15px; }
            .disaster-nav-tabs .nav-link { font-size: 0.9rem; padding: 8px 10px; }
        }
    </style>
</head>
<body>
<div class="container-fluid mt-4">
    <!-- Header -->
    <div class="dashboard-header">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h2 class="dashboard-title">
                    <i class="fas fa-shield-alt me-2"></i>
                    Welcome, {{ auth()->user()->first_name ?? 'User' }}!
                </h2>
                <p class="dashboard-subtitle mb-0">
                    <i class="fas fa-map-marker-alt me-2"></i>
                    Barangay Ilawod Disaster Risk Management Dashboard
                </p>
            </div>
            <div class="col-md-4 d-flex justify-content-end align-items-center">
                <form id="logoutForm" action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-link p-0" title="Logout">
                        <i class="fas fa-sign-out-alt fa-lg"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Navigation Tabs -->
    <ul class="nav nav-tabs disaster-nav-tabs" id="userTabs" role="tablist">
        <li class="nav-item"><a href="{{ route('disaster.maps') }}" class="nav-link {{ request()->routeIs('disaster.maps') ? 'active' : '' }}"><i class="fas fa-map-marked-alt"></i> Disaster Maps</a></li>
        <li class="nav-item"><a href="{{ route('evacuation.centers') }}" class="nav-link {{ request()->routeIs('evacuation.centers') ? 'active' : '' }}"><i class="fas fa-home"></i> Evacuation Centers</a></li>
        <li class="nav-item"><a href="{{ route('mou.homes') }}" class="nav-link {{ request()->routeIs('mou.homes') ? 'active' : '' }}"><i class="fas fa-file-contract"></i> MOU/MOA Homes</a></li>
        <li class="nav-item"><a href="{{ route('support.tickets') }}" class="nav-link {{ request()->routeIs('support.tickets') ? 'active' : '' }}"><i class="fas fa-ticket-alt"></i> Support Tickets</a></li>
        <li class="nav-item"><a href="{{ route('notifications') }}" class="nav-link {{ request()->routeIs('notifications') ? 'active' : '' }}"><i class="fas fa-bell"></i> Notifications</a></li>
    </ul>

    <!-- Page Content -->
    <div class="tab-content">
        @yield('content')
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
@stack('scripts')
</body>
</html>
