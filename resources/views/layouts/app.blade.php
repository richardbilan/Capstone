<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Camaligtas - Disaster Risk Mapping System')</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Lobster&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="/assets/css/app.css" rel="stylesheet">
    
    @stack('styles')
</head>
<body>
    <!-- Navigation -->
    @include('components.navbar')
    
    <div class="main-wrapper">
        <!-- Sidebar -->
        @unless(View::hasSection('hideSidebar'))
            @include('components.sidebar')
        @endunless
        
        <!-- Main Content -->
        <div class="content-area @if(View::hasSection('hideSidebar')) full-width @endif">
            @yield('content')
        </div>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script src="/assets/js/app.js"></script>
    
    @stack('scripts')
</body>
</html>