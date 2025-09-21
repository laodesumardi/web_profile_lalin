@extends('layouts.app')

@section('title', 'Berita Saya - BPTD')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-900">Berita Saya</h1>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
            <p class="font-bold">Sukses!</p>
            <p>{{ session('success') }}</p>
        </div>
    @endif

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        @if($news->count() > 0)
            <div class="divide-y divide-gray-200">
                @foreach($news as $item)
                    <div class="p-6 hover:bg-gray-50 transition-colors duration-200">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                            <div class="flex-1">
                                <h3 class="text-lg font-medium text-gray-900">
                                    {{ $item->title }}
                                </h3>
                                <div class="mt-1 flex items-center text-sm text-gray-500">
                                    <span>{{ $item->created_at->format('d M Y') }}</span>
                                    <span class="mx-2">•</span>
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $item->is_published ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                        {{ $item->is_published ? 'Diterbitkan' : 'Draft' }}
                                    </span>
                                </div>
                            </div>
                            <div class="mt-4 md:mt-0 flex space-x-2">
                                <a href="{{ route('news.show', $item->slug) }}" 
                                   class="text-blue-600 hover:text-blue-800 font-medium text-sm"
                                   target="_blank">
                                    Lihat
                                </a>
                                <a href="{{ route('my.news.edit', $item->id) }}" 
                                   class="text-indigo-600 hover:text-indigo-900 font-medium text-sm">
                                    Edit
                                </a>
                                @if(!$item->is_published)
                                    <form action="{{ route('admin.news.update', $item->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="is_published" value="1">
                                        <button type="submit" class="text-green-600 hover:text-green-900 font-medium text-sm">
                                            Minta Publikasi
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                {{ $news->links() }}
            </div>
        @else
            <div class="p-8 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada berita</h3>
                <p class="mt-1 text-sm text-gray-500">Mulai dengan membuat berita baru.</p>
                <div class="mt-6">
                    <a href="{{ route('news.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Buat Berita Baru
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
