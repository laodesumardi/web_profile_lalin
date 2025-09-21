@extends('layouts.app')

@section('title', $employee->name . ' - BPTD')

@section('content')
<!-- Breadcrumb -->
<div class="bg-white border-b">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
        <nav class="flex" aria-label="Breadcrumb">
            <ol class="flex items-center space-x-4">
                <li>
                    <a href="{{ route('home') }}" class="text-gray-500 hover:text-primary">Beranda</a>
                </li>
                <li>
                    <svg class="flex-shrink-0 h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                </li>
                <li>
                    <a href="{{ route('employees.index') }}" class="text-gray-500 hover:text-primary">Pegawai</a>
                </li>
                <li>
                    <svg class="flex-shrink-0 h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                </li>
                <li>
                    <span class="text-gray-900 font-medium">{{ $employee->name }}</span>
                </li>
            </ol>
        </nav>
    </div>
</div>

<!-- Main Content -->
<div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-900">{{ $employee->name }}</h1>
            <a href="{{ route('employees.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition duration-150">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali
            </a>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Profile Photo -->
            <div class="md:col-span-1">
                <div class="w-48 h-48 mx-auto rounded-full overflow-hidden bg-gray-200">
                    @if($employee->profile && $employee->profile->photo)
                        <img src="{{ asset('storage/' . $employee->profile->photo) }}" alt="{{ $employee->name }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full bg-primary flex items-center justify-center text-white text-6xl font-bold">
                            {{ substr($employee->name, 0, 1) }}
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Profile Info -->
            <div class="md:col-span-2">
                <div class="space-y-4">
                    <div>
                        <h2 class="text-lg font-medium text-gray-900">Informasi Pribadi</h2>
                        <div class="mt-2 space-y-2">
                            <p class="text-gray-600">
                                <span class="font-medium">Nama:</span> {{ $employee->name }}
                            </p>
                            <p class="text-gray-600">
                                <span class="font-medium">Email:</span> {{ $employee->email }}
                            </p>
                            @if($employee->profile && $employee->profile->nip)
                                <p class="text-gray-600">
                                    <span class="font-medium">NIP:</span> {{ $employee->profile->nip }}
                                </p>
                            @endif
                            @if($employee->profile && $employee->profile->position)
                                <p class="text-gray-600">
                                    <span class="font-medium">Jabatan:</span> {{ $employee->profile->position }}
                                </p>
                            @endif
                            @if($employee->profile && $employee->profile->phone)
                                <p class="text-gray-600">
                                    <span class="font-medium">Telepon:</span> {{ $employee->profile->phone }}
                                </p>
                            @endif
                        </div>
                    </div>
                    
                    @if($employee->profile && $employee->profile->bio)
                        <div class="pt-4 border-t border-gray-200">
                            <h2 class="text-lg font-medium text-gray-900">Tentang</h2>
                            <p class="mt-2 text-gray-600">{{ $employee->profile->bio }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection