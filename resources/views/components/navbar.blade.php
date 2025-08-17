<style>
    .compact-navbar {
        padding-top: 0.2rem !important;
        padding-bottom: 0.2rem !important;
        min-height: 48px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* subtle shadow */
        width: 100%;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        z-index: 1030;
    }

    .compact-navbar .navbar-brand {
        cursor: default !important;
        pointer-events: none !important;
    }

    .compact-navbar .navbar-brand img {
        width: 30px;
        height: auto;
        pointer-events: none;
    }

    .compact-navbar .navbar-brand span {
        font-size: 1.5rem;
        pointer-events: none;
    }

    .compact-navbar .nav-link {
        font-size: 0.875rem;
        padding: 0.25rem 0.5rem;
        text-align: center;
    }

    .compact-navbar .btn {
        padding: 0.2rem 0.5rem;
        font-size: 1rem;
    }

    .compact-navbar ul.navbar-nav {
        gap: 2.5rem !important;
    }

    /* Center navigation items */
    .center-nav {
        display: flex;
        align-items: center;
        margin-left: auto;
        margin-right: auto;
    }

    .center-nav .nav-item {
        white-space: nowrap;
    }

    /* Adjust logo and brand positioning */
    .compact-navbar .navbar-brand {
        margin-left: 0;
        display: flex;
        align-items: center;
    }

    /* Remove explicit width for side-nav-space as flex will handle spacing */
    .compact-navbar .side-nav-space {
        width: auto;
        margin-right: auto;
    }

    /* Responsive Styles */
    @media (max-width: 1400px) {
        .compact-navbar ul.navbar-nav {
            gap: 1.5rem !important;
        }
        .compact-navbar .nav-link {
            font-size: 0.85rem;
        }
    }

    @media (max-width: 1200px) {
        .compact-navbar ul.navbar-nav {
            gap: 1rem !important;
        }
    }

    /* Hide entire navbar on screens smaller than large (lg) breakpoint */
    /* REMOVED: @media (max-width: 991.98px) { .compact-navbar { display: none !important; } } */

    @media (max-width: 768px) {
        .compact-navbar .navbar-brand span {
            font-size: 1.2rem;
        }
        .compact-navbar .navbar-brand img {
            width: 25px;
        }
    }

    @media (max-width: 576px) {
        .compact-navbar {
            padding: 0.3rem 0.5rem !important;
        }
        .compact-navbar .navbar-brand {
            margin-left: 0.5rem;
        }
        .compact-navbar .navbar-brand span {
            font-size: 1rem;
        }
        .compact-navbar .navbar-brand img {
            width: 20px;
        }
        .compact-navbar .navbar-toggler {
            padding: 0.25rem;
        }
        .container-fluid {
            padding-left: 10px;
            padding-right: 10px;
        }
    }

    /* Prevent horizontal scroll */
    body {
        overflow-x: hidden;
        width: 100%;
    }

    .container-fluid {
        padding-left: 15px;
        padding-right: 15px;
        max-width: 100%;
    }
</style>

<nav class="navbar navbar-dark fixed-top shadow-sm compact-navbar" style="background-color:rgb(247, 247, 247);">
    <div class="container-fluid d-flex align-items-center justify-content-between">
        <!-- Left: Sidebar Toggle + Logo + Brand -->
        <div class="d-flex align-items-center">
            <!-- Sidebar Toggle Button -->
            @unless(View::hasSection('hideSidebar'))
            <button class="navbar-toggler me-3" type="button" id="sidebarToggle" style="border: none; background: none; color: #333; font-size: 1.2rem; padding: 0.25rem 0.5rem; cursor: pointer;">
                <i class="fas fa-bars" title="Toggle Sidebar"></i>
            </button>
            @endunless
            
            <!-- Logo + Brand (Non-clickable) -->
            <div class="navbar-brand d-flex align-items-center" style="cursor: default; pointer-events: none;">
                <div style="width: 30px; height: 30px; background: #ff6b35; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 0.5rem;">
                    <i class="fas fa-map-marked-alt" style="color: white; font-size: 14px;"></i>
                </div>
                <span style="font-family: 'Lobster', cursive;">
                    <span style="color:rgb(252, 122, 46);">Camalig</span><span style="color:rgb(12, 207, 22);">tas</span>
                </span>
            </div>
        </div>

        <!-- Navigation Links: Hidden on small screens, visible on large screens -->
        <div class="center-nav d-none d-lg-flex">
            @if (!View::hasSection('hideNavbarLinks'))
            <ul class="navbar-nav flex-row align-items-center mb-0">
                <li class="nav-item">
                    <a class="nav-link text-dark" href="{{ route('home') }}">
                        <i class="fas fa-home me-1"></i>Home
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" href="{{ route('hazard.map') }}">
                        <i class="fas fa-map-marked-alt me-1"></i>Barangay Hazard Map
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" href="{{ route('sms') }}">
                        <i class="fas fa-sms me-1"></i>SMS
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" href="{{ route('contacts') }}">
                        <i class="fas fa-address-book me-1"></i>Contacts
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" href="{{ route('evacuation') }}">
                        <i class="fas fa-running me-1"></i>Evacuation
                    </a>
                </li>
            </ul>
            @endif
        </div>

        <!-- Right: Profile + Logout -->
        <div class="d-flex align-items-center">
            <ul class="navbar-nav flex-row align-items-center mb-0 gap-3">
                @if(request()->route()->getName() == 'superadmin.manage_users')
                <li class="nav-item">
                    <a class="nav-link text-dark d-flex align-items-center" href="{{ route('dashboard') }}" title="Go to Dashboard">
                        <i class="fas fa-home"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark d-flex align-items-center" href="{{ route('hazard.profile') }}" title="Manage Profile">
                        <i class="fas fa-user-circle fa-lg"></i>
                    </a>
                </li>
                @endif
                <li class="nav-item">
                    <form id="logoutForm" action="{{ route('logout') }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn btn-link nav-link text-dark p-0" title="Logout">
                            <i class="fas fa-sign-out-alt fa-lg"></i>
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>
