@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="text-center mb-12">
        <h1 class="text-4xl font-bold text-gray-900 mb-4">Our Gallery</h1>
        <p class="text-lg text-gray-600">Discover our most beautiful moments in images</p>
    </div>

    @if($galleries->isEmpty())
        <div class="text-center py-12">
            <p class="text-gray-600 text-lg">No images available at the moment.</p>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($galleries as $gallery)
                <div class="bg-white rounded-lg shadow-md overflow-hidden transition-transform duration-300 hover:scale-105">
                    @if($gallery->image)
                        <a href="{{ route('gallery.show', $gallery) }}" class="block aspect-w-4 aspect-h-3">
                            <img src="{{ asset('storage/' . $gallery->image->path) }}" 
                                 alt="{{ $gallery->title }}" 
                                 class="w-full h-full object-cover">
                        </a>
                    @endif
                    <div class="p-4">
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ $gallery->title }}</h3>
                        @if($gallery->description)
                            <p class="text-gray-600 text-sm line-clamp-2">{{ $gallery->description }}</p>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $galleries->links() }}
        </div>
    @endif
</div>
@endsection