<!-- Navigation Component -->
<nav class="bg-white shadow-lg sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <a href="{{ route('home') }}" class="text-2xl font-bold text-primary hover:text-opacity-80 transition duration-150">Lalin</a>
                </div>
                <div class="hidden md:ml-6 md:flex md:space-x-8">
                    <a href="{{ route('home') }}" 
                       class="{{ request()->routeIs('home') ? 'text-primary border-primary border-b-2' : 'text-gray-500 hover:text-primary hover:border-gray-300 border-b-2 border-transparent' }} px-1 pt-1 pb-4 text-sm font-medium transition duration-150">
                        Beranda
                    </a>
                    <a href="{{ route('news.index') }}" 
                       class="{{ request()->routeIs('news.*') ? 'text-primary border-primary border-b-2' : 'text-gray-500 hover:text-primary hover:border-gray-300 border-b-2 border-transparent' }} px-1 pt-1 pb-4 text-sm font-medium transition duration-150">
                        Berita
                    </a>
                    <a href="{{ route('employees.index') }}" 
                       class="{{ request()->routeIs('employees.*') ? 'text-primary border-primary border-b-2' : 'text-gray-500 hover:text-primary hover:border-gray-300 border-b-2 border-transparent' }} px-1 pt-1 pb-4 text-sm font-medium transition duration-150">
                        Pegawai
                    </a>
                    @auth
                    <!-- Dashboard link moved to user dropdown -->
                    @endauth
                </div>
            </div>
            
            <!-- Mobile menu button -->
            <div class="md:hidden">
                <button class="text-gray-500 hover:text-primary focus:outline-none focus:text-primary" id="mobile-menu-button" type="button" aria-expanded="false" aria-controls="mobile-menu" aria-label="Toggle navigation menu">
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
            <div class="hidden md:flex items-center space-x-4">
                @auth
                    @if(Auth::user()->role === 'admin')
                        <a href="{{ route('admin.news.create') }}" class="bg-green-600 text-white hover:bg-green-700 px-4 py-2 rounded-md text-sm font-medium transition duration-150">
                            <i class="fas fa-plus mr-1"></i> Buat Berita
                        </a>
                    @endif

                    <div class="relative group" data-dropdown="user">
                        <button type="button" data-dropdown-button class="flex items-center space-x-2 px-2 py-1 rounded-full border border-gray-200 hover:border-gray-300 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary/30">
                            @if(Auth::user()->profile && Auth::user()->profile->photo)
                                <img class="h-8 w-8 rounded-full object-cover" src="{{ asset('storage/' . Auth::user()->profile->photo) }}" alt="Profile">
                            @else
                                <div class="h-8 w-8 rounded-full bg-primary text-white flex items-center justify-center text-xs font-semibold">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </div>
                            @endif
                            <span class="text-sm font-medium text-gray-700">{{ Str::limit(Auth::user()->name, 18) }}</span>
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <!-- Dropdown panel -->
                        <div data-dropdown-panel class="absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-lg ring-1 ring-black/5 py-1 opacity-0 pointer-events-none translate-y-1
                                    group-hover:opacity-100 group-hover:pointer-events-auto group-hover:translate-y-0
                                    focus-within:opacity-100 focus-within:pointer-events-auto focus-within:translate-y-0 transition z-[70]">
                            @if(Auth::user()->role === 'admin')
                                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-3 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M13 5v6h6"/></svg>
                                    Dashboard Admin
                                </a>
                            @else
                                <a href="{{ route('dashboard') }}" class="flex items-center px-3 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M13 5v6h6"/></svg>
                                    Dashboard Saya
                                </a>
                                <a href="{{ route('my.news.index') }}" class="flex items-center px-3 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V7a2 2 0 012-2h14a2 2 0 012 2v11a2 2 0 01-2 2z"/></svg>
                                    Berita Saya
                                </a>
                            @endif
                            <a href="{{ route('profile.show') }}" class="flex items-center px-3 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A7 7 0 0112 15a7 7 0 016.879 2.804M15 11a3 3 0 10-6 0 3 3 0 006 0z"/></svg>
                                Profil
                            </a>
                            <form method="POST" action="{{ route('logout') }}" class="mt-1">
                                @csrf
                                <button type="submit" class="w-full text-left flex items-center px-3 py-2 text-sm text-red-600 hover:bg-red-50">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7"/></svg>
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="text-primary hover:text-opacity-80 px-3 py-2 text-sm font-medium transition duration-150">
                        Login
                    </a>
                    <a href="{{ route('register') }}" class="bg-primary text-white hover:bg-opacity-90 px-4 py-2 rounded-md text-sm font-medium transition duration-150">
                        Daftar
                    </a>
                @endauth
            </div>
        </div>
    </div>
    
    <!-- Mobile menu -->
    <div class="md:hidden hidden fixed top-16 inset-x-0 z-[60]" id="mobile-menu">
        <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3 bg-white border-t">
            <a href="{{ route('home') }}" 
               class="{{ request()->routeIs('home') ? 'text-primary bg-blue-50' : 'text-gray-500 hover:text-primary hover:bg-gray-50' }} block px-3 py-2 text-base font-medium rounded-md transition duration-150">
                <i class="fas fa-home mr-2"></i>Beranda
            </a>
            <a href="{{ route('news.index') }}" 
               class="{{ request()->routeIs('news.*') ? 'text-primary bg-blue-50' : 'text-gray-500 hover:text-primary hover:bg-gray-50' }} block px-3 py-2 text-base font-medium rounded-md transition duration-150">
                <i class="fas fa-newspaper mr-2"></i>Berita
            </a>
            <a href="{{ route('employees.index') }}" 
               class="{{ request()->routeIs('employees.*') ? 'text-primary bg-blue-50' : 'text-gray-500 hover:text-primary hover:bg-gray-50' }} block px-3 py-2 text-base font-medium rounded-md transition duration-150">
                <i class="fas fa-users mr-2"></i>Pegawai
            </a>
            @auth
            <a href="{{ route('dashboard') }}" 
               class="{{ request()->routeIs('dashboard') ? 'text-primary bg-blue-50' : 'text-gray-500 hover:text-primary hover:bg-gray-50' }} block px-3 py-2 text-base font-medium rounded-md transition duration-150">
                <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
            </a>
            @endauth
            @auth
                <div class="border-t border-gray-200 pt-2 mt-2">
                    <div class="flex items-center px-3 py-2">
                        @if(Auth::user()->profile && Auth::user()->profile->photo)
                            <img class="h-8 w-8 rounded-full object-cover" src="{{ asset('storage/' . Auth::user()->profile->photo) }}" alt="Profile">
                        @else
                            <div class="h-8 w-8 rounded-full bg-primary text-white flex items-center justify-center text-sm font-medium">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                        @endif
                        <span class="ml-3 text-gray-700 font-medium">{{ Auth::user()->name }}</span>
                    </div>
                    @if(Auth::user()->role !== 'admin')
                        <a href="{{ route('my.news.index') }}" class="text-gray-500 hover:text-primary hover:bg-gray-50 block px-3 py-2 text-base font-medium rounded-md transition duration-150">
                            <i class="fas fa-newspaper mr-2"></i>Kelola Berita Saya
                        </a>
                    @endif
                    <a href="{{ route('profile.show') }}" class="text-gray-500 hover:text-primary hover:bg-gray-50 block px-3 py-2 text-base font-medium rounded-md transition duration-150">
                        <i class="fas fa-user mr-2"></i>Profile
                    </a>
                    @if(Auth::user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="text-gray-500 hover:text-primary hover:bg-gray-50 block px-3 py-2 text-base font-medium rounded-md transition duration-150">
                            <i class="fas fa-cog mr-2"></i>Dashboard Admin
                        </a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}" class="block">
                        @csrf
                        <button type="submit" class="text-gray-500 hover:text-primary hover:bg-gray-50 block px-3 py-2 text-base font-medium w-full text-left rounded-md transition duration-150">
                            <i class="fas fa-sign-out-alt mr-2"></i>Logout
                        </button>
                    </form>
                </div>
            @else
                <div class="border-t border-gray-200 pt-2 mt-2">
                    <a href="{{ route('login') }}" class="text-gray-500 hover:text-primary hover:bg-gray-50 block px-3 py-2 text-base font-medium rounded-md transition duration-150">
                        <i class="fas fa-sign-in-alt mr-2"></i>Login
                    </a>
                    <a href="{{ route('register') }}" class="bg-primary text-white hover:bg-opacity-90 block px-3 py-2 text-base font-medium rounded-md transition duration-150">
                        <i class="fas fa-user-plus mr-2"></i>Daftar
                    </a>
                </div>
            @endauth
        </div>
    </div>
    <div id="mobile-menu-overlay" class="fixed inset-0 bg-black/40 md:hidden hidden z-[50]"></div>
</nav>
