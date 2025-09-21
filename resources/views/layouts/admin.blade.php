<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Dashboard Admin BPTD - Balai Pengelolaan Transportasi Darat">
    <meta name="keywords" content="BPTD, admin, dashboard, transportasi, darat">
    <meta name="author" content="BPTD">
    <meta name="robots" content="noindex, nofollow">

    <title>@yield('title', 'Dashboard Admin - BPTD')</title>

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

        /* Admin specific styles */
        .admin-sidebar {
            background: linear-gradient(135deg, #001d3d 0%, #002851 100%);
            border-right: 1px solid rgba(255, 255, 255, 0.1);
        }

        .admin-nav-item {
            transition: all 0.2s ease-in-out;
        }

        .admin-nav-item:hover {
            background-color: rgba(255, 255, 255, 0.1);
            transform: translateX(4px);
        }

        .admin-nav-item.active {
            background-color: rgba(255, 255, 255, 0.15);
            border-left: 3px solid #fff;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .admin-content {
            min-height: calc(100vh - 4rem);
        }

        /* Responsive sidebar */
        @media (max-width: 1024px) {
            .sidebar-overlay {
                background-color: rgba(0, 0, 0, 0.5);
                backdrop-filter: blur(4px);
            }
        }
    </style>
</head>
<body class="bg-gray-50 font-sans antialiased">
    <!-- Skip to main content -->
    <a href="#main-content" class="sr-only focus:not-sr-only focus:absolute focus:top-4 focus:left-4 bg-primary text-white px-4 py-2 rounded-md z-50">
        Skip to main content
    </a>

    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <div id="sidebar" class="admin-sidebar text-white w-64 min-h-screen transition-transform duration-300 ease-in-out transform lg:translate-x-0 -translate-x-full fixed lg:relative z-30">
            <!-- Sidebar Header -->
            <div class="flex items-center justify-between p-6 border-b border-blue-700">
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 bg-white rounded-lg flex items-center justify-center">
                        <span class="text-primary font-bold text-sm">L</span>
                    </div>
                    <h2 class="text-xl font-bold">Admin Lalin</h2>
                </div>
                <button id="closeSidebar" class="lg:hidden text-white hover:text-gray-300 focus:outline-none focus:ring-2 focus:ring-white focus:ring-opacity-50 rounded" aria-label="Close sidebar">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- Navigation -->
            <nav class="p-4 space-y-2" role="navigation" aria-label="Admin navigation">
                <a href="{{ route('admin.dashboard') }}" class="admin-nav-item flex items-center space-x-3 p-3 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" aria-current="{{ request()->routeIs('admin.dashboard') ? 'page' : 'false' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v6H8V5z"></path>
                    </svg>
                    <span>Dashboard</span>
                </a>

                <a href="{{ route('admin.news.index') }}" class="admin-nav-item flex items-center space-x-3 p-3 rounded-lg {{ request()->routeIs('admin.news.*') ? 'active' : '' }}" aria-current="{{ request()->routeIs('admin.news.*') ? 'page' : 'false' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                    </svg>
                    <span>Kelola Berita</span>
                </a>

                <a href="{{ route('admin.employees.index') }}" class="admin-nav-item flex items-center space-x-3 p-3 rounded-lg {{ request()->routeIs('admin.employees.*') ? 'active' : '' }}" aria-current="{{ request()->routeIs('admin.employees.*') ? 'page' : 'false' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                    </svg>
                    <span>Kelola Pegawai</span>
                </a>
            </nav>

            <!-- User Info & Logout -->
            <div class="absolute bottom-0 left-0 right-0 p-4 border-t border-blue-700">
                <div class="flex items-center space-x-3 mb-4 p-3 bg-blue-800 bg-opacity-50 rounded-lg">
                    @if(Auth::user()->photo)
                        <div class="w-10 h-10 rounded-full overflow-hidden flex-shrink-0 border-2 border-white">
                            <img src="{{ Auth::user()->profile_photo_url }}" 
                                 alt="{{ Auth::user()->name }}" 
                                 class="w-full h-full object-cover"
                                 onerror="this.onerror=null; this.parentElement.outerHTML = '\
                                 <div class=\'w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center flex-shrink-0\'>\
                                     <span class=\'text-white font-semibold text-lg\'>{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>\
                                 </div>';">
                        </div>
                    @else
                        <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center flex-shrink-0">
                            <span class="text-white font-semibold text-lg">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                        </div>
                    @endif
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-white truncate">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-blue-200 truncate">{{ Auth::user()->position ?? 'Administrator' }}</p>
                        @if(Auth::user()->nip)
                            <p class="text-xs text-blue-300 truncate">NIP: {{ Auth::user()->nip }}</p>
                        @endif
                        <p class="text-xs text-blue-300 truncate">{{ Auth::user()->email }}</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="admin-nav-item flex items-center space-x-3 p-3 rounded-lg hover:bg-red-600 transition-colors w-full text-left">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </div>

        <!-- Sidebar Overlay for Mobile -->
        <div id="sidebarOverlay" class="fixed inset-0 bg-black bg-opacity-50 z-20 lg:hidden hidden sidebar-overlay"></div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Navigation -->
            <header class="bg-white shadow-sm border-b border-gray-200">
                <div class="flex items-center justify-between px-6 py-4">
                    <div class="flex items-center space-x-4">
                        <button id="openSidebar" class="lg:hidden text-gray-500 hover:text-gray-700 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-opacity-50 rounded" aria-label="Open sidebar">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>
                        <div>
                            <h1 class="text-xl font-semibold text-gray-900">@yield('page-title', 'Dashboard Admin')</h1>
                            <p class="text-sm text-gray-500">@yield('page-description', 'Kelola sistem BPTD')</p>
                        </div>
                    </div>

                    <div class="flex items-center space-x-4">
                        <!-- Back to Website -->
                        <a href="{{ route('home') }}" class="text-gray-500 hover:text-gray-700 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-opacity-50 rounded px-3 py-2 text-sm font-medium" title="Kembali ke Website">
                            <svg class="w-5 h-5 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Website
                        </a>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main id="main-content" class="flex-1 overflow-auto admin-content p-6" role="main">
                @if(session('success'))
                    <x-alert type="success" :message="session('success')" dismissible />
                @endif

                @if(session('error'))
                    <x-alert type="error" :message="session('error')" dismissible />
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <!-- JavaScript for Sidebar Toggle -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const sidebarOverlay = document.getElementById('sidebarOverlay');
            const openSidebar = document.getElementById('openSidebar');
            const closeSidebar = document.getElementById('closeSidebar');

            function showSidebar() {
                sidebar.classList.remove('-translate-x-full');
                sidebarOverlay.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            }

            function hideSidebar() {
                sidebar.classList.add('-translate-x-full');
                sidebarOverlay.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }

            openSidebar?.addEventListener('click', showSidebar);
            closeSidebar?.addEventListener('click', hideSidebar);
            sidebarOverlay?.addEventListener('click', hideSidebar);

            // Close sidebar on escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && !sidebar.classList.contains('-translate-x-full')) {
                    hideSidebar();
                }
            });

            // Handle window resize
            window.addEventListener('resize', function() {
                if (window.innerWidth >= 1024) {
                    hideSidebar();
                }
            });
        });
    </script>
<!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Toast helper
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });

            // Flash messages -> Toast
            const flashSuccess = @json(session('success'));
            const flashError = @json(session('error'));
            if (flashSuccess) {
                Toast.fire({ icon: 'success', title: flashSuccess });
            }
            if (flashError) {
                Toast.fire({ icon: 'error', title: flashError });
            }
            // Validation errors -> show first error as toast
            const validationErrors = @json($errors->all());
            if (validationErrors && validationErrors.length) {
                Toast.fire({ icon: 'error', title: validationErrors[0] });
            }

            // Global delete confirmation for all DELETE forms (override inline onsubmit)
            document.querySelectorAll('form').forEach((form) => {
                const deleteInput = form.querySelector('input[name="_method"][value="DELETE"]');
                if (deleteInput) {
                    form.onsubmit = function(e) {
                        if (form.dataset.swalConfirmed === '1') return true; // already confirmed
                        e.preventDefault();
                        Swal.fire({
                            title: 'Hapus data ini?',
                            text: 'Tindakan ini tidak dapat dibatalkan.',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#dc2626',
                            cancelButtonColor: '#6b7280',
                            confirmButtonText: 'Ya, hapus',
                            cancelButtonText: 'Batal'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                form.dataset.swalConfirmed = '1';
                                form.submit();
                            }
                        });
                        return false;
                    };
                }
            });
        });
    </script>
</body>
</html>