@extends('layouts.app')

@section('title', 'Daftar Pegawai - BPTD')

@section('content')
<!-- Header Section -->
<section class="hero-gradient text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">
                Daftar Pegawai
            </h1>
            <p class="text-xl text-blue-100 max-w-2xl mx-auto">
                Tim profesional BPTD yang siap melayani masyarakat
            </p>
        </div>
    </section>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <!-- Search and Filter -->
        <div class="mb-8 bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <form method="GET" action="{{ route('employees.index') }}" class="space-y-4">
                <div class="flex flex-col md:flex-row gap-4">
                    <!-- Search Input -->
                    <div class="flex-1 relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input 
                            type="text" 
                            name="search" 
                            value="{{ request('search') }}" 
                            placeholder="Cari nama pegawai..." 
                            class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition duration-150"
                        >
                    </div>
                    
                    <!-- Position Filter -->
                    <div class="md:w-56 relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                        <select 
                            name="position" 
                            class="w-full pl-10 pr-4 py-2.5 appearance-none border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition duration-150"
                        >
                            <option value="">Semua Jabatan</option>
                            @foreach($positions as $position)
                                <option value="{{ $position }}" {{ request('position') == $position ? 'selected' : '' }}>
                                    {{ $position }}
                                </option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>
                    
                    <!-- Submit Button -->
                    <button 
                        type="submit" 
                        class="w-full md:w-auto bg-primary text-white px-6 py-2.5 rounded-lg hover:bg-opacity-90 transition duration-150 flex items-center justify-center gap-2"
                    >
                        <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                        </svg>
                        <span>Cari</span>
                    </button>
                </div>
                
                @if(request('search') || request('position'))
                    <div class="flex items-center justify-between bg-blue-50 px-4 py-2 rounded-lg">
                        <span class="text-sm text-gray-600">
                            @if(request('search') && request('position'))
                                Menampilkan hasil untuk "{{ request('search') }}" dengan jabatan {{ request('position') }}
                            @elseif(request('search'))
                                Menampilkan hasil untuk "{{ request('search') }}"
                            @elseif(request('position'))
                                Menampilkan jabatan: {{ request('position') }}
                            @endif
                        </span>
                        <a 
                            href="{{ route('employees.index') }}" 
                            class="text-sm font-medium text-primary hover:text-opacity-80 transition duration-150 flex items-center gap-1"
                        >
                            <span>Reset</span>
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </a>
                    </div>
                @endif
            </form>
        </div>

        <!-- Employee Grid -->
        @if($employees->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-8">
                @foreach($employees as $employee)
                    <div class="bg-white rounded-lg shadow-sm hover:shadow-md transition duration-200 overflow-hidden">
                        <div class="p-6">
                            <!-- Photo -->
                            <div class="w-24 h-24 mx-auto mb-4 rounded-full overflow-hidden bg-gray-200">
                                @if($employee->profile && $employee->profile->photo)
                                    <img src="{{ asset('storage/' . $employee->profile->photo) }}" alt="{{ $employee->name }}" class="w-full h-full object-cover">
                                @elseif($employee->role === 'admin')
                                    <div class="w-full h-full bg-primary flex items-center justify-center text-white">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                    </div>
                                @else
                                    <div class="w-full h-full bg-primary flex items-center justify-center text-white text-2xl font-bold">
                                        {{ substr($employee->name, 0, 1) }}
                                    </div>
                                @endif
                            </div>

                            <!-- Info -->
                            <div class="text-center">
                                <h3 class="text-lg font-semibold text-gray-900 mb-1">{{ $employee->name }}</h3>
                                <p class="text-sm text-gray-600 mb-2">
                                    @if($employee->role === 'admin')
                                        Administrator
                                    @else
                                        {{ $employee->position ?? ($employee->profile->position ?? 'Pegawai') }}
                                    @endif
                                </p>
                                @if($employee->nip ?? ($employee->profile && $employee->profile->nip))
                                    <p class="text-xs text-gray-500 mb-3">NIP: {{ $employee->nip ?? $employee->profile->nip }}</p>
                                @endif

                                <!-- Contact Info -->
                                @if($employee->profile)
                                    <div class="text-xs text-gray-500 space-y-1 mb-4">
                                        @if($employee->profile->phone)
                                            <p class="flex items-center justify-center">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                                </svg>
                                                {{ $employee->profile->phone }}
                                            </p>
                                        @endif
                                        @if($employee->email)
                                            <p class="flex items-center justify-center">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                                </svg>
                                                {{ $employee->email }}
                                            </p>
                                        @endif
                                    </div>
                                @endif

                                <!-- Action Button -->
                                <a href="{{ route('employees.show', $employee->id) }}" class="inline-block bg-primary text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-opacity-90 transition duration-150">
                                    Lihat Detail
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="flex justify-center">
                {{ $employees->appends(request()->query())->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada pegawai ditemukan</h3>
                <p class="mt-1 text-sm text-gray-500">Coba ubah kriteria pencarian Anda.</p>
            </div>
        @endif
    </div>

@endsection