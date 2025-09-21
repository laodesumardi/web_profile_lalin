@extends('layouts.admin')

@section('title', 'Dashboard Admin - Website Profile BPTD')
@section('page-title', 'Dashboard Admin')
@section('page-description', 'Kelola sistem BPTD dengan mudah')

@section('content')
    <!-- Dashboard Content -->
    <div class="space-y-6">
                <!-- Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600">Total Berita</p>
                                <p class="text-2xl font-bold text-gray-900">{{ $totalNews }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-green-100 text-green-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600">Total Pegawai</p>
                                <p class="text-2xl font-bold text-gray-900">{{ $totalUsers }}</p>
                                <p class="text-xs text-gray-500 mt-1">{{ Auth::user()->name }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Content -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Recent News -->
                    <div class="bg-white rounded-lg shadow">
                        <div class="p-6 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900">Berita Terbaru</h3>
                        </div>
                        <div class="p-6">
                            @if($recentNews->count() > 0)
                                <div class="space-y-4">
                                    @foreach($recentNews as $news)
                                        <div class="flex items-start space-x-3">
                                            <div class="flex-1">
                                                <h4 class="text-sm font-medium text-gray-900">{{ $news->title }}</h4>
                                                <p class="text-xs text-gray-500 mt-1">{{ $news->created_at->format('d M Y') }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-gray-500 text-sm">Belum ada berita</p>
                            @endif
                        </div>
                    </div>

                    <!-- Recent Users -->
                    <div class="bg-white rounded-lg shadow">
                        <div class="p-6 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900">Pegawai Terbaru</h3>
                        </div>
                        <div class="p-6">
                            @if($recentUsers->count() > 0)
                                <div class="space-y-4">
                                    @foreach($recentUsers as $user)
                                        <div class="flex items-start space-x-3">
                                            <div class="flex-1">
                                                <h4 class="text-sm font-medium text-gray-900">{{ $user->name }}</h4>
                                                <p class="text-xs text-gray-500 mt-1">{{ $user->position }} - {{ $user->created_at->format('d M Y') }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-gray-500 text-sm">Belum ada pegawai terdaftar</p>
                            @endif
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script>
        // Sidebar toggle functionality
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');
        const openSidebar = document.getElementById('openSidebar');
        const closeSidebar = document.getElementById('closeSidebar');

        openSidebar.addEventListener('click', () => {
            sidebar.classList.remove('-translate-x-full');
            overlay.classList.remove('hidden');
        });

        closeSidebar.addEventListener('click', () => {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
        });

        overlay.addEventListener('click', () => {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
        });
    </script>
@endsection