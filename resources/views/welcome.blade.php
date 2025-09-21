@extends('layouts.app')

@section('title', 'BPTD - Balai Pengelolaan Transportasi Darat')

@section('content')
    <!-- Hero Section -->
    <section class="hero-gradient text-white py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl md:text-6xl font-bold mb-6">
                Balai Pengelolaan<br>
                <span class="text-blue-200">Transportasi Darat</span>
            </h1>
            <p class="text-xl md:text-2xl mb-8 text-blue-100 max-w-3xl mx-auto">
                Melayani masyarakat dengan profesional dalam pengelolaan transportasi darat yang aman, nyaman, dan berkelanjutan
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('news.index') }}" class="bg-white text-primary px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition duration-200">
                    Lihat Berita Terbaru
                </a>
                <a href="{{ route('register') }}" class="border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-primary transition duration-200">
                    Bergabung Sebagai Pegawai
                </a>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Layanan Kami</h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">Berbagai layanan transportasi darat yang kami sediakan untuk masyarakat</p>
            </div>
            <div class="grid md:grid-cols-3 gap-8">
                <div class="text-center p-6 rounded-lg border border-gray-200 hover:shadow-lg transition duration-200">
                    <div class="w-16 h-16 bg-primary rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Perizinan Transportasi</h3>
                    <p class="text-gray-600">Pengurusan izin operasional kendaraan transportasi umum dan barang</p>
                </div>
                <div class="text-center p-6 rounded-lg border border-gray-200 hover:shadow-lg transition duration-200">
                    <div class="w-16 h-16 bg-primary rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Pengawasan Lalu Lintas</h3>
                    <p class="text-gray-600">Monitoring dan pengawasan kelancaran lalu lintas transportasi darat</p>
                </div>
                <div class="text-center p-6 rounded-lg border border-gray-200 hover:shadow-lg transition duration-200">
                    <div class="w-16 h-16 bg-primary rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Pembinaan & Pelatihan</h3>
                    <p class="text-gray-600">Program pembinaan dan pelatihan untuk operator transportasi</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Employees Section -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Tim Kami</h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">Pegawai profesional yang siap melayani masyarakat</p>
            </div>
            @if($featuredEmployees->count() > 0)
                <div class="grid md:grid-cols-3 lg:grid-cols-6 gap-6">
                    @foreach($featuredEmployees as $employee)
                        <div class="text-center bg-white p-6 rounded-lg shadow-sm hover:shadow-md transition duration-200">
                            <div class="w-20 h-20 mx-auto mb-4 rounded-full overflow-hidden bg-gray-200">
                                @if($employee->profile && $employee->profile->photo)
                                    <img src="{{ asset('storage/' . $employee->profile->photo) }}" alt="{{ $employee->name }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full bg-primary flex items-center justify-center text-white text-xl font-bold">
                                        {{ substr($employee->name, 0, 1) }}
                                    </div>
                                @endif
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-1">{{ $employee->name }}</h3>
                            <p class="text-sm text-gray-600 mb-2">{{ $employee->profile->position ?? 'Pegawai' }}</p>
                            <p class="text-xs text-gray-500">{{ $employee->profile->nip ?? '' }}</p>
                            <a href="{{ route('employees.show', $employee->id) }}" class="inline-block mt-3 text-primary hover:text-opacity-80 text-sm font-medium">Lihat Profile</a>
                        </div>
                    @endforeach
                </div>
                <div class="text-center mt-8">
                    <a href="{{ route('employees.index') }}" class="bg-primary text-white px-6 py-3 rounded-lg font-semibold hover:bg-opacity-90 transition duration-200">
                        Lihat Semua Pegawai
                    </a>
                </div>
            @else
                <div class="text-center py-12">
                    <p class="text-gray-500">Belum ada data pegawai yang tersedia.</p>
                </div>
            @endif
        </div>
    </section>

    <!-- Latest News Section -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Berita Terbaru</h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">Informasi terkini seputar transportasi darat</p>
            </div>
            @if($latestNews->count() > 0)
                <div class="grid md:grid-cols-3 gap-8">
                    @foreach($latestNews as $news)
                        <article class="bg-white rounded-lg shadow-sm hover:shadow-md transition duration-200 overflow-hidden border border-gray-200">
                            @if($news->image)
                                <div class="h-48 bg-gray-200 overflow-hidden">
                                    <img src="{{ asset('storage/' . $news->image) }}" alt="{{ $news->title }}" class="w-full h-full object-cover">
                                </div>
                            @else
                                <div class="h-48 bg-gradient-to-br from-primary to-blue-600 flex items-center justify-center">
                                    <svg class="w-16 h-16 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                            @endif
                            <div class="p-6">
                                <h3 class="text-xl font-semibold text-gray-900 mb-2 line-clamp-2">{{ $news->title }}</h3>
                                <p class="text-gray-600 mb-4 line-clamp-3">{{ $news->excerpt }}</p>
                                <div class="flex items-center justify-between text-sm text-gray-500">
                                    <div class="flex items-center">
                                        @if($news->user && $news->user->profile && $news->user->profile->photo)
                                            <img src="{{ asset('storage/' . $news->user->profile->photo) }}" alt="{{ $news->user->name }}" class="w-6 h-6 rounded-full mr-2">
                                        @else
                                            <div class="w-6 h-6 bg-gray-300 rounded-full mr-2 flex items-center justify-center text-xs text-gray-600">
                                                {{ $news->user ? substr($news->user->name, 0, 1) : 'A' }}
                                            </div>
                                        @endif
                                        <span>{{ $news->user->name ?? 'Admin' }}</span>
                                    </div>
                                    <span>{{ $news->created_at->diffForHumans() }}</span>
                                </div>
                                <a href="{{ route('news.show', $news->id) }}" class="inline-block mt-4 text-primary hover:text-opacity-80 font-medium">
                                    Baca Selengkapnya →
                                </a>
                            </div>
                        </article>
                    @endforeach
                </div>
                <div class="text-center mt-8">
                    <a href="{{ route('news.index') }}" class="bg-primary text-white px-6 py-3 rounded-lg font-semibold hover:bg-opacity-90 transition duration-200">
                        Lihat Semua Berita
                    </a>
                </div>
            @else
                <div class="text-center py-12">
                    <p class="text-gray-500">Belum ada berita yang tersedia.</p>
                </div>
            @endif
        </div>
    </section>
@endsection
