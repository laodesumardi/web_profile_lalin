@extends('layouts.user-dashboard')

@section('title', 'Dashboard Pegawai - LALIN')

@section('content')
<!-- Welcome Header -->
<div class="bg-primary text-white py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div class="flex-1">
                <h1 class="text-2xl md:text-3xl font-bold">Selamat Datang, {{ Auth::user()->name }}!</h1>
                <p class="mt-2 text-blue-50">Senang melihat Anda kembali di Sistem Informasi LALIN</p>
            </div>
            <div class="mt-4 md:mt-0">
                <span class="inline-flex items-center px-4 py-2 bg-opacity-25 bg-primary rounded-full text-sm font-medium text-white">
                    <svg class="mr-2 h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                    </svg>
                    {{ now()->format('l, d F Y') }}
                </span>
            </div>
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Profile Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-shadow duration-200">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-blue-50 p-3 rounded-lg">
                        <svg class="h-8 w-8 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-gray-900">Profil Saya</h3>
                        <p class="text-sm text-gray-500">Kelola data pribadi Anda</p>
                    </div>
                </div>
                <div class="mt-6">
                    <a href="{{ route('profile.edit') }}" class="text-sm font-medium text-primary hover:opacity-80 transition-opacity duration-150">
                        Edit Profil <span aria-hidden="true">→</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Password Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-shadow duration-200">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-green-100 p-3 rounded-lg">
                        <svg class="h-8 w-8 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-gray-900">Keamanan Akun</h3>
                        <p class="text-sm text-gray-500">Perbarui kata sandi Anda</p>
                    </div>
                </div>
                <div class="mt-6">
                    <a href="{{ route('password.change') }}" class="text-sm font-medium text-blue-600 hover:text-blue-500">
                        Ubah Password <span aria-hidden="true">→</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Schedule Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-shadow duration-200">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-purple-100 p-3 rounded-lg">
                        <svg class="h-8 w-8 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-gray-900">Jadwal Kerja</h3>
                        <p class="text-sm text-gray-500">Lihat jadwal kegiatan</p>
                    </div>
                </div>
                <div class="mt-6">
                    <a href="#" class="text-sm font-medium text-blue-600 hover:text-blue-500">
                        Lihat Jadwal <span aria-hidden="true">→</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Profile Information -->
        <div class="lg:col-span-2">
            <div class="bg-white overflow-hidden shadow-xl rounded-xl">
                <div class="px-6 py-5 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Informasi Profil</h3>
                    <p class="mt-1 text-sm text-gray-500">Detail informasi pribadi Anda di LALIN</p>
                </div>
                <div class="px-6 py-5">
                    <div class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                                <div class="text-gray-900 font-medium">{{ Auth::user()->name }}</div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                <div class="text-gray-900">{{ Auth::user()->email }}</div>
                            </div>
                            @if(Auth::user()->profile)
                                @if(Auth::user()->profile->nip)
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">NIP</label>
                                        <div class="text-gray-900">{{ Auth::user()->profile->nip }}</div>
                                    </div>
                                @endif
                                @if(Auth::user()->profile->position)
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Jabatan</label>
                                        <div class="text-gray-900">{{ Auth::user()->profile->position }}</div>
                                    </div>
                                @endif
                                @if(Auth::user()->profile->phone)
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Telepon</label>
                                        <div class="text-gray-900">{{ Auth::user()->profile->phone }}</div>
                                    </div>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Links -->
        <div class="space-y-6">
            <!-- Announcements -->
            <div class="bg-white overflow-hidden shadow-xl rounded-xl">
                <div class="px-6 py-5 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Pengumuman</h3>
                </div>
                <div class="px-6 py-4">
                    <div class="text-center py-8 text-gray-500">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p class="mt-2">Tidak ada pengumuman terbaru</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection