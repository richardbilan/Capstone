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

    <!-- Global App CSS -->
    <link rel="stylesheet" href="/assets/css/app.css">

    {{-- Page-specific styles --}}
    @yield('additional_styles')
    @stack('styles')
</head>
<body>
    {{-- Navbar --}}
    @include('components.navbar')

    <div class="main-wrapper d-flex">
        {{-- Sidebar (conditionally hidden) --}}
        @unless(View::hasSection('hideSidebar'))
            @include('components.sidebar')
        @endunless

        {{-- Main Content --}}
        <div class="content-area flex-grow-1 @if(View::hasSection('hideSidebar')) full-width @endif">
            @yield('content')
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Global JS -->
    <script src="/assets/js/app.js"></script>

    {{-- Page-specific scripts --}}
    @yield('additional_scripts')
    @stack('scripts')
</body>
</html>
