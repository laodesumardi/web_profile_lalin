<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="@yield('description', 'Balai Pengelolaan Transportasi Darat - Melayani masyarakat dalam bidang transportasi darat dengan profesional dan terpercaya.')">
    <meta name="keywords" content="@yield('keywords', 'Lalin, transportasi darat, pelayanan publik, infrastruktur transportasi')">
    <meta name="author" content="Lalin">
    <meta name="robots" content="index, follow">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('title', 'Lalin - Balai Pengelolaan Transportasi Darat')">
    <meta property="og:description" content="@yield('description', 'Balai Pengelolaan Transportasi Darat - Melayani masyarakat dalam bidang transportasi darat dengan profesional dan terpercaya.')">
    <meta property="og:image" content="@yield('og_image', asset('images/bptd-logo.png'))">
    
    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="@yield('title', 'Lalin - Balai Pengelolaan Transportasi Darat')">
    <meta property="twitter:description" content="@yield('description', 'Balai Pengelolaan Transportasi Darat - Melayani masyarakat dalam bidang transportasi darat dengan profesional dan terpercaya.')">
    <meta property="twitter:image" content="@yield('og_image', asset('images/bptd-logo.png'))">
    
    <title>@yield('title', 'Lalin - Balai Pengelolaan Transportasi Darat')</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    
    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Custom Styles -->
    <style>
        :root {
            --primary-color: #001d3d;
            --primary-light: #003566;
            --primary-dark: #000814;
            --secondary-color: #ffd60a;
            --accent-color: #003566;
            --text-primary: #1f2937;
            --text-secondary: #6b7280;
            --border-color: #e5e7eb;
            --success-color: #10b981;
            --warning-color: #f59e0b;
            --error-color: #ef4444;
        }
        
        .bg-primary { background-color: var(--primary-color); }
        .text-primary { color: var(--primary-color); }
        .border-primary { border-color: var(--primary-color); }
        .hover\:bg-primary:hover { background-color: var(--primary-color); }
        .hover\:text-primary:hover { color: var(--primary-color); }
        
        .hero-gradient {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-light) 100%);
        }
        
        .card-shadow {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
        
        .card-shadow-lg {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }
        
        .transition-all {
            transition: all 0.3s ease;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            font-weight: 500;
            transition: all 0.15s ease;
        }
        
        .btn-primary:hover {
            background-color: var(--primary-light);
            transform: translateY(-1px);
        }
        
        .btn-secondary {
            background-color: white;
            color: var(--primary-color);
            border: 2px solid var(--primary-color);
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            font-weight: 500;
            transition: all 0.15s ease;
        }
        
        .btn-secondary:hover {
            background-color: var(--primary-color);
            color: white;
            transform: translateY(-1px);
        }
        
        .form-input {
            border: 1px solid var(--border-color);
            border-radius: 0.375rem;
            padding: 0.5rem 0.75rem;
            transition: all 0.15s ease;
        }
        
        .form-input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(0, 29, 61, 0.1);
        }
        
        .alert {
            padding: 1rem;
            border-radius: 0.375rem;
            margin-bottom: 1rem;
        }
        
        .alert-success {
            background-color: #d1fae5;
            border: 1px solid #a7f3d0;
            color: #065f46;
        }
        
        .alert-error {
            background-color: #fee2e2;
            border: 1px solid #fecaca;
            color: #991b1b;
        }
        
        .alert-warning {
            background-color: #fef3c7;
            border: 1px solid #fde68a;
            color: #92400e;
        }
        
        .alert-info {
            background-color: #dbeafe;
            border: 1px solid #bfdbfe;
            color: #1e40af;
        }
        
        /* Loading Animation */
        .loading {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255,255,255,.3);
            border-radius: 50%;
            border-top-color: #fff;
            animation: spin 1s ease-in-out infinite;
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        
        .fade-in {
            animation: fadeIn 0.5s ease-in;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .slide-down {
            animation: slideDown 0.3s ease-out;
        }
        
        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        /* Smooth scrolling */
        html {
            scroll-behavior: smooth;
        }
        
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        
        ::-webkit-scrollbar-thumb {
            background: var(--primary-color);
            border-radius: 4px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: var(--primary-light);
        }
        
        /* Enhanced Responsive Design */
        @media (max-width: 640px) {
            .container {
                padding-left: 1rem;
                padding-right: 1rem;
            }
            
            .text-4xl { font-size: 2rem; }
            .text-5xl { font-size: 2.5rem; }
            .text-6xl { font-size: 3rem; }
            
            .py-16 { padding-top: 3rem; padding-bottom: 3rem; }
            .py-20 { padding-top: 4rem; padding-bottom: 4rem; }
            
            .space-y-8 > * + * { margin-top: 1.5rem; }
            .space-y-12 > * + * { margin-top: 2rem; }
            
            .grid-cols-2 { grid-template-columns: repeat(1, minmax(0, 1fr)); }
            .grid-cols-3 { grid-template-columns: repeat(1, minmax(0, 1fr)); }
            .grid-cols-4 { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        }
        
        @media (min-width: 641px) and (max-width: 768px) {
            .container {
                padding-left: 1.5rem;
                padding-right: 1.5rem;
            }
            
            .grid-cols-3 { grid-template-columns: repeat(2, minmax(0, 1fr)); }
            .grid-cols-4 { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        }
        
        @media (min-width: 769px) and (max-width: 1024px) {
            .container {
                padding-left: 2rem;
                padding-right: 2rem;
            }
        }
        
        /* Touch-friendly interactions */
        @media (hover: none) and (pointer: coarse) {
            .hover\:scale-105:hover {
                transform: none;
            }
            
            button, .btn-primary, .btn-secondary {
                min-height: 44px;
                min-width: 44px;
            }
            
            a {
                min-height: 44px;
                display: flex;
                align-items: center;
            }
        }
        
        /* Improved focus states for accessibility */
        .focus-visible {
            outline: 2px solid var(--primary-color);
            outline-offset: 2px;
        }
        
        /* Better text readability */
        .text-balance {
            text-wrap: balance;
        }
        
        /* Line clamp utilities */
        .line-clamp-1 {
            overflow: hidden;
            display: -webkit-box;
            -webkit-box-orient: vertical;
            -webkit-line-clamp: 1;
        }
        
        .line-clamp-2 {
            overflow: hidden;
            display: -webkit-box;
            -webkit-box-orient: vertical;
            -webkit-line-clamp: 2;
        }
        
        .line-clamp-3 {
            overflow: hidden;
            display: -webkit-box;
            -webkit-box-orient: vertical;
            -webkit-line-clamp: 3;
        }
        
        /* Smooth transitions for all interactive elements */
        button, a, input, select, textarea {
            transition: all 0.2s ease;
        }
        
        /* Skip link for accessibility */
        .skip-link {
            position: absolute;
            top: -40px;
            left: 6px;
            background: var(--primary-color);
            color: white;
            padding: 8px;
            text-decoration: none;
            border-radius: 4px;
            z-index: 1000;
        }
        
        .skip-link:focus {
            top: 6px;
        }
    /* Global responsive fixes */
        *, *::before, *::after { box-sizing: border-box; }
        body { overflow-x: hidden; }
        img, video, canvas, svg { max-width: 100%; height: auto; }
        iframe { max-width: 100%; border: 0; }
        .responsive-embed { position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden; }
        .responsive-embed iframe, .responsive-embed object, .responsive-embed embed { position: absolute; top:0; left:0; width:100%; height:100%; }
        pre, code { white-space: pre-wrap; word-wrap: break-word; }
        main, header, footer { width: 100%; }

        /* Make tables scrollable on small screens */
        @media (max-width: 640px) {
            table { display: block; width: 100%; overflow-x: auto; -webkit-overflow-scrolling: touch; }
            .table { display: block; width: 100%; overflow-x: auto; -webkit-overflow-scrolling: touch; }
        }
    </style>
    
    @stack('styles')
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">
    <!-- Skip to main content link for accessibility -->
    <a href="#main-content" class="skip-link focus:outline-none focus:ring-2 focus:ring-white">
        Skip to main content
    </a>
    
    <!-- Navigation -->
    @include('components.navigation')
    
    <!-- Flash Messages -->
    @if(session('success'))
        <div class="alert alert-success mx-4 mt-4" id="flash-message">
            <div class="flex items-center">
                <i class="fas fa-check-circle mr-2"></i>
                {{ session('success') }}
            </div>
        </div>
    @endif
    
    @if(session('error'))
        <div class="alert alert-error mx-4 mt-4" id="flash-message">
            <div class="flex items-center">
                <i class="fas fa-exclamation-circle mr-2"></i>
                {{ session('error') }}
            </div>
        </div>
    @endif
    
    @if(session('warning'))
        <div class="alert alert-warning mx-4 mt-4" id="flash-message">
            <div class="flex items-center">
                <i class="fas fa-exclamation-triangle mr-2"></i>
                {{ session('warning') }}
            </div>
        </div>
    @endif
    
    @if(session('info'))
        <div class="alert alert-info mx-4 mt-4" id="flash-message">
            <div class="flex items-center">
                <i class="fas fa-info-circle mr-2"></i>
                {{ session('info') }}
            </div>
        </div>
    @endif
    
    <!-- Main Content -->
        <main id="main-content" class="flex-1" role="main">
            @yield('content')
        </main>
    
    <!-- Footer -->
    @include('components.footer')
    
    <!-- Scripts -->
    <script>
        // Auto-hide flash messages
        document.addEventListener('DOMContentLoaded', function() {
            const flashMessage = document.getElementById('flash-message');
            if (flashMessage) {
                setTimeout(function() {
                    flashMessage.style.opacity = '0';
                    flashMessage.style.transform = 'translateY(-10px)';
                    setTimeout(function() {
                        flashMessage.remove();
                    }, 300);
                }, 5000);
            }
        });
        
        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
        
        // Loading state for forms
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', function() {
                const submitBtn = form.querySelector('button[type="submit"]');
                if (submitBtn) {
                    submitBtn.disabled = true;
                    const originalText = submitBtn.innerHTML;
                    submitBtn.innerHTML = '<span class="loading"></span> Memproses...';
                    
                    // Re-enable after 10 seconds as fallback
                    setTimeout(() => {
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = originalText;
                    }, 10000);
                }
            });
        });
    </script>
    
    @stack('scripts')
</body>
</html>