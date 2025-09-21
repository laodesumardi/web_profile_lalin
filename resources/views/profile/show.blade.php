<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - Lalin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .bg-primary { background-color: #001d3d; }
        .text-primary { color: #001d3d; }
        .border-primary { border-color: #001d3d; }
        .hover\:bg-primary:hover { background-color: #001d3d; }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <h1 class="text-2xl font-bold text-primary">Lalin</h1>
                    </div>
                    <div class="hidden md:ml-6 md:flex md:space-x-8">
                        <a href="{{ route('home') }}" class="text-gray-500 hover:text-primary hover:border-gray-300 border-b-2 border-transparent px-1 pt-1 pb-4 text-sm font-medium transition duration-150">Beranda</a>
                        <a href="{{ route('news.index') }}" class="text-gray-500 hover:text-primary hover:border-gray-300 border-b-2 border-transparent px-1 pt-1 pb-4 text-sm font-medium transition duration-150">Berita</a>
                    </div>
                </div>
                <div class="md:hidden">
                    <button class="text-gray-500 hover:text-primary focus:outline-none focus:text-primary" id="mobile-menu-button">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
                <div class="flex items-center space-x-4">
                    @auth
                        <div class="relative">
                            <button class="flex items-center text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary" id="user-menu-button">
                                <span class="text-gray-700">{{ Auth::user()->name }}</span>
                                <svg class="ml-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50" id="user-menu">
                                <a href="{{ route('profile.show') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 bg-gray-50">Profile</a>
                                @if(Auth::user()->role === 'admin')
                                    <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Dashboard Admin</a>
                                @endif
                                <form method="POST" action="{{ route('logout') }}" class="block">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Logout</button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="text-primary hover:text-opacity-80 px-3 py-2 text-sm font-medium">Login</a>
                        <a href="{{ route('register') }}" class="bg-primary text-white hover:bg-opacity-90 px-4 py-2 rounded-md text-sm font-medium transition duration-150">Daftar</a>
                    @endauth
                </div>
            </div>
        </div>
        <!-- Mobile menu -->
        <div class="md:hidden hidden" id="mobile-menu">
            <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3 bg-white border-t">
                <a href="{{ route('home') }}" class="text-gray-500 hover:text-primary block px-3 py-2 text-base font-medium">Beranda</a>
                <a href="{{ route('news.index') }}" class="text-gray-500 hover:text-primary block px-3 py-2 text-base font-medium">Berita</a>
                @auth
                    <a href="{{ route('profile.show') }}" class="text-primary block px-3 py-2 text-base font-medium">Profile</a>
                    @if(Auth::user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="text-gray-500 hover:text-primary block px-3 py-2 text-base font-medium">Dashboard Admin</a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}" class="block">
                        @csrf
                        <button type="submit" class="text-gray-500 hover:text-primary block px-3 py-2 text-base font-medium w-full text-left">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-gray-500 hover:text-primary block px-3 py-2 text-base font-medium">Login</a>
                    <a href="{{ route('register') }}" class="text-gray-500 hover:text-primary block px-3 py-2 text-base font-medium">Daftar</a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Profile Content -->
    <div class="py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Profile Header -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-8">
                <div class="bg-primary h-32 relative">
                    <div class="absolute -bottom-16 left-8">
                        <div class="w-32 h-32 rounded-full border-4 border-white bg-gray-200 overflow-hidden">
                            @if($profile && $profile->photo)
                                <img src="{{ asset('storage/' . $profile->photo) }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full bg-gray-300 flex items-center justify-center">
                                    <svg class="w-16 h-16 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                
                <div class="pt-20 pb-8 px-8">
                    <div class="flex justify-between items-start">
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $user->name }}</h1>
                            <p class="text-lg text-gray-600 mb-1">{{ $user->position }}</p>
                            <p class="text-sm text-gray-500">NIP: {{ $user->nip }}</p>
                        </div>
                        <a href="{{ route('profile.edit') }}" class="bg-primary text-white px-6 py-2 rounded-lg hover:bg-blue-800 transition duration-200">
                            <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Edit Profile
                        </a>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-6">Informasi Profil</h2>
                
                <div class="space-y-4">
                    <div class="flex items-center">
                        <div class="w-1/3 text-sm font-medium text-gray-700">Nama</div>
                        <div class="w-2/3 text-gray-900">{{ $user->name }}</div>
                    </div>
                    
                    <div class="flex items-center">
                        <div class="w-1/3 text-sm font-medium text-gray-700">Email</div>
                        <div class="w-2/3 text-gray-900">{{ $user->email }}</div>
                    </div>
                    
                    @if($profile && $profile->phone)
                    <div class="flex items-center">
                        <div class="w-1/3 text-sm font-medium text-gray-700">Nomor Telepon</div>
                        <div class="w-2/3 text-gray-900">{{ $profile->phone }}</div>
                    </div>
                    @endif
                    
                    @if($profile && $profile->address)
                    <div class="flex items-start">
                        <div class="w-1/3 text-sm font-medium text-gray-700">Alamat</div>
                        <div class="w-2/3 text-gray-900">{{ $profile->address }}</div>
                    </div>
                    @endif
                    
                    <div class="flex items-center">
                        <div class="w-1/3 text-sm font-medium text-gray-700">Tanggal Bergabung</div>
                        <div class="w-2/3 text-gray-900">{{ $user->created_at->format('d F Y') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-primary text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-3 gap-8">
                <div>
                    <h3 class="text-2xl font-bold mb-4">Lalin</h3>
                    <p class="text-blue-200 mb-4">Balai Pengelolaan Transportasi Darat yang melayani masyarakat dengan profesional.</p>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-4">Menu</h4>
                    <ul class="space-y-2">
                        <li><a href="{{ route('home') }}" class="text-blue-200 hover:text-white transition duration-150">Beranda</a></li>
                        <li><a href="{{ route('news.index') }}" class="text-blue-200 hover:text-white transition duration-150">Berita</a></li>
                        <li><a href="{{ route('register') }}" class="text-blue-200 hover:text-white transition duration-150">Bergabung</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-4">Kontak</h4>
                    <div class="space-y-2 text-blue-200">
                        <p>📧 info@bptd.go.id</p>
                        <p>📞 (021) 1234-5678</p>
                        <p>📍 Jakarta, Indonesia</p>
                    </div>
                </div>
            </div>
            <div class="border-t border-blue-800 mt-8 pt-8 text-center">
                <p class="text-blue-200">&copy; {{ date('Y') }} BPTD. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        // Toggle user menu
        document.getElementById('user-menu-button')?.addEventListener('click', function() {
            const menu = document.getElementById('user-menu');
            menu.classList.toggle('hidden');
        });

        // Toggle mobile menu
        document.getElementById('mobile-menu-button')?.addEventListener('click', function() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        });

        // Close menu when clicking outside
        document.addEventListener('click', function(event) {
            const userButton = document.getElementById('user-menu-button');
            const userMenu = document.getElementById('user-menu');
            const mobileButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');
            
            if (userButton && userMenu && !userButton.contains(event.target) && !userMenu.contains(event.target)) {
                userMenu.classList.add('hidden');
            }
            
            if (mobileButton && mobileMenu && !mobileButton.contains(event.target) && !mobileMenu.contains(event.target)) {
                mobileMenu.classList.add('hidden');
            }
        });
    </script>
</body>
</html>