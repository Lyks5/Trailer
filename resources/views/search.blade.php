@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h2 class="text-2xl font-bold mb-4">Результаты поиска: </h2>
    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-8">
        @if (count($posts))
            @foreach ($posts as $post)
                <div
                    class="bg-white shadow-lg rounded-lg overflow-hidden transform transition-all duration-300 hover:scale-105 hover:shadow-xl">
                    <a href="{{ route('Post', ['post_id' => $post->id]) }}">
                        <img src="{{ asset($post->image) }}" alt="Movie 1" class="w-full h-96 object-cover">
                    </a>
                    <div class="p-4">
                        <h3 class="text-lg font-bold mb-2">{{ $post->name }}</h3>
                        <a href="{{ route('Post', ['post_id' => $post->id]) }}"
                            class="text-blue-500 hover:underline">Подробнее</a>
                    </div>
                </div>
            @endforeach
        @else
            <h2 class="text-2xl font-bold mb-4">Ничего не найдено</h2>
        @endif
    </div>
</div>
@endsection