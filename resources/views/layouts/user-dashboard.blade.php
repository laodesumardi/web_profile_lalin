<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Dashboard User Lalin - Balai Pengelolaan Transportasi Darat">
    <meta name="keywords" content="Lalin, user, dashboard, transportasi, darat">
    <meta name="author" content="Lalin">
    <meta name="robots" content="noindex, nofollow">

    <title>@yield('title', 'Dashboard User - Lalin')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .primary { color: #001d3d; }
        .bg-primary { background-color: #001d3d; }
        .border-primary { border-color: #001d3d; }
        .hover\:bg-primary:hover { background-color: #00152e; }
        .text-primary { color: #001d3d; }
        .hover\:text-primary:hover { color: #001d3d; }

        /* User dashboard specific styles */
        .user-nav {
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            border-bottom: 1px solid #e2e8f0;
        }

        .user-nav-item {
            transition: all 0.2s ease-in-out;
            position: relative;
        }

        .user-nav-item:hover {
            color: #2563eb;
        }

        .user-nav-item.active {
            color: #2563eb;
        }

        .user-nav-item.active::after {
            content: '';
            position: absolute;
            bottom: -1px;
            left: 0;
            right: 0;
            height: 2px;
            background-color: #2563eb;
        }

        .user-content {
            min-height: calc(100vh - 8rem);
        }

        .user-card {
            background: white;
            border-radius: 0.75rem;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            transition: all 0.2s ease-in-out;
        }

        .user-card:hover {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            transform: translateY(-2px);
        }

        .stat-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .stat-card.blue {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
        }

        .stat-card.green {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        }

        .stat-card.purple {
            background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
        }

        /* Dashboard specific animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .animate-fade-in-up {
            animation: fadeInUp 0.6s ease-out;
        }

        .animate-slide-in-left {
            animation: slideInLeft 0.6s ease-out;
        }

        .animate-slide-in-right {
            animation: slideInRight 0.6s ease-out;
        }

        /* Stagger animations */
        .animate-delay-100 { animation-delay: 0.1s; }
        .animate-delay-200 { animation-delay: 0.2s; }
        .animate-delay-300 { animation-delay: 0.3s; }
        .animate-delay-400 { animation-delay: 0.4s; }

        /* Hover effects */
        .hover-lift {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .hover-lift:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        /* Gradient text */
        .gradient-text {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Custom scrollbar */
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, #5a67d8 0%, #6b46c1 100%);
        }

        /* Loading animation */
        .loading-dots {
            display: inline-block;
        }

        .loading-dots::after {
            content: '';
            animation: loading 1.4s infinite ease-in-out;
        }

        @keyframes loading {
            0%, 80%, 100% {
                transform: scale(0);
            }
            40% {
                transform: scale(1);
            }
        }
    </style>
</head>
<body class="bg-gray-50 font-sans antialiased">
    <!-- Skip to main content -->
    <a href="#main-content" class="sr-only focus:not-sr-only focus:absolute focus:top-4 focus:left-4 bg-primary text-white px-4 py-2 rounded-md z-50">
        Skip to main content
    </a>

    <!-- Navigation -->
    <nav class="user-nav shadow-sm" role="navigation" aria-label="Main navigation">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <!-- Logo and Main Navigation -->
                <div class="flex items-center">
                    <div class="flex-shrink-0 flex items-center">
                        <a href="{{ route('home') }}" class="flex items-center space-x-2">
                            <div class="w-10 h-10 bg-gradient-to-r from-blue-600 to-blue-800 rounded-lg flex items-center justify-center">
                                <span class="text-white font-bold text-lg">L</span>
                            </div>
                            <h1 class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-blue-800 bg-clip-text text-transparent">Lalin</h1>
                        </a>
                    </div>
                    <div class="hidden md:ml-8 md:flex md:space-x-8">
                        <a href="{{ route('home') }}" class="user-nav-item text-gray-500 hover:text-primary border-b-2 border-transparent px-1 pt-1 pb-4 text-sm font-medium">
                            Beranda
                        </a>
                        <a href="{{ route('news.index') }}" class="user-nav-item text-gray-500 hover:text-primary border-b-2 border-transparent px-1 pt-1 pb-4 text-sm font-medium">
                            Berita
                        </a>
                        <a href="{{ route('employees.index') }}" class="user-nav-item text-gray-500 hover:text-primary border-b-2 border-transparent px-1 pt-1 pb-4 text-sm font-medium">
                            Pegawai
                        </a>
                    </div>
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden flex items-center">
                    <button class="p-2 rounded-md text-gray-600 hover:text-primary focus:outline-none focus:ring-2 focus:ring-primary focus:ring-opacity-50" id="mobile-menu-button" aria-expanded="false" aria-controls="mobile-menu" aria-label="Toggle navigation menu">
                        <span class="sr-only">Toggle main menu</span>
                        <svg id="icon-menu" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                        <svg id="icon-close" class="h-6 w-6 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <!-- User menu -->
                <div class="hidden md:flex md:items-center md:space-x-4">
                    @auth
                        <div class="relative">
                            <button class="flex items-center text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary" id="user-menu-button" aria-haspopup="true" aria-expanded="false" aria-controls="user-menu" aria-label="User menu">
                                @if($profile && $profile->photo)
                                    <img class="h-8 w-8 rounded-full object-cover" src="{{ asset('storage/' . $profile->photo) }}" alt="Profile photo of {{ Auth::user()->name }}">
                                @else
                                    <div class="h-8 w-8 rounded-full bg-primary flex items-center justify-center">
                                        <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                    </div>
                                @endif
                                <span class="ml-2 text-gray-700 font-medium">{{ Auth::user()->name }}</span>
                                <svg class="ml-1 h-4 w-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                            </button>
                            <div class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 hidden" id="user-menu" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button">
                                <div class="py-1">
                                    <a href="{{ route('profile.show') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Profile</a>
                                    <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Edit Profile</a>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Logout</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-500 hover:text-primary px-3 py-2 text-sm font-medium">Login</a>
                        <a href="{{ route('register') }}" class="bg-primary text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-blue-700 transition duration-200">Daftar</a>
                    @endauth
                </div>
            </div>
        </div>

        <!-- Mobile menu -->
        <div class="md:hidden hidden fixed inset-x-0 z-[60]" id="mobile-menu">
            <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3 bg-white border-t">
                <a href="{{ route('home') }}" class="text-gray-500 hover:text-primary block px-3 py-2 text-base font-medium">Beranda</a>
                <a href="{{ route('news.index') }}" class="text-gray-500 hover:text-primary block px-3 py-2 text-base font-medium">Berita</a>
                <a href="{{ route('employees.index') }}" class="text-gray-500 hover:text-primary block px-3 py-2 text-base font-medium">Pegawai</a>
                <a href="{{ route('dashboard') }}" class="text-primary block px-3 py-2 text-base font-medium" aria-current="page">Dashboard</a>
                @auth
                    <div class="border-t border-gray-200 pt-4">
                        <div class="flex items-center px-3 py-2">
                            @if($profile && $profile->photo)
                                <img class="h-8 w-8 rounded-full object-cover" src="{{ asset('storage/' . $profile->photo) }}" alt="Profile">
                            @else
                                <div class="h-8 w-8 rounded-full bg-primary flex items-center justify-center">
                                    <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                            @endif
                            <span class="ml-2 text-gray-700 font-medium">{{ Auth::user()->name }}</span>
                        </div>
                        <a href="{{ route('profile.show') }}" class="text-gray-500 hover:text-primary block px-3 py-2 text-base font-medium">Profile</a>
                        <a href="{{ route('profile.edit') }}" class="text-gray-500 hover:text-primary block px-3 py-2 text-base font-medium">Edit Profile</a>
                        <form method="POST" action="{{ route('logout') }}" class="block">
                            @csrf
                            <button type="submit" class="text-gray-500 hover:text-primary block px-3 py-2 text-base font-medium w-full text-left">Logout</button>
                        </form>
                    </div>
                @else
                    <div class="border-t border-gray-200 pt-4">
                        <a href="{{ route('login') }}" class="text-gray-500 hover:text-primary block px-3 py-2 text-base font-medium">Login</a>
                        <a href="{{ route('register') }}" class="bg-primary text-white block px-3 py-2 text-base font-medium rounded-md mx-3">Daftar</a>
                    </div>
                @endauth
            </div>
        </div>
        <div id="mobile-menu-overlay" class="fixed inset-0 bg-black/40 md:hidden hidden z-[50]"></div>
    </nav>

    <!-- Page Header -->
    <header class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">@yield('page-title', 'Dashboard User')</h1>
                    <p class="mt-2 text-gray-600">@yield('page-description', 'Selamat datang, ' . Auth::user()->name . '!')</p>
                </div>
                <div class="flex items-center space-x-4">
                    <!-- Quick Actions -->
                    <a href="{{ route('profile.edit') }}" class="bg-primary text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-blue-700 transition duration-200">
                        Edit Profile
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main id="main-content" class="user-content max-w-7xl mx-auto py-6 sm:px-6 lg:px-8" role="main">
        @if(session('success'))
            <div class="mb-6">
                <x-alert type="success" :message="session('success')" dismissible />
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6">
                <x-alert type="error" :message="session('error')" dismissible />
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 mt-12">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between">
                <p class="text-sm text-gray-500">
                    © {{ date('Y') }} BPTD. All rights reserved.
                </p>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('home') }}" class="text-sm text-gray-500 hover:text-primary">Kembali ke Website</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Navigation scripts handled globally in resources/js/app.js -->
</body>
</html>