@extends('layouts.app')

@section('content')
<section class="relative">
        <div class="hero-image h-64 md:h-96 bg-cover bg-center bg-[#16a34a]" 
        {{-- style="background-image: url('{{ asset('assets/images/circuits-hero.jpg') }}')" --}}
        >
            <div class="absolute inset-0 bg-black opacity-50"></div>
            <div class="container mx-auto px-4 h-full flex items-center justify-center relative z-10">
                <div class="text-center text-white mt-20">
                    <h1 class="text-3xl md:text-5xl font-bold mb-2">Notre Gallerie</h1>
                    <p class="text-lg md:text-xl">Découvrez nos plus beaux moments en images</p>
                </div>
            </div>
        </div>
    </section>
<div class="container mx-auto px-4 py-8">
    {{-- <div class="text-center mb-12">
        <h1 class="text-4xl font-bold text-gray-900 mb-4">Notre Galerie</h1>
        <p class="text-lg text-gray-600">Découvrez nos plus beaux moments en images</p>
    </div> --}}

    @if($galleries->isEmpty())
        <div class="text-center py-12">
            <p class="text-gray-600 text-lg">Aucune image n'est disponible pour le moment.</p>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($galleries as $gallery)
                <div class="bg-white rounded-lg shadow-md overflow-hidden transition-transform duration-300 hover:scale-105">
                    @if($gallery->image)
                        <a href="{{ route('galerie.show', $gallery) }}" class="block aspect-w-4 aspect-h-3">
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