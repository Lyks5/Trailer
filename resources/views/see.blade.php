@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <h2 class="text-2xl font-bold mb-4">Не знаете что посмотреть?</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-4">
            @foreach ($posts as $post)
                <div class="bg-white shadow rounded overflow-hidden">
                <a href="{{ route('Post', ['post_id' => $post->id]) }}">
                        <img src="{{ asset($post->image) }}" alt="Movie 1" class="w-full h-auto object-cover">
                    </a>
                    <div class="p-4">
                        <h3 class="text-lg font-bold">{{ $post->name }}</h3>
                        <a href="{{ route('Post', ['post_id' => $post->id]) }}">Подробнее</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
