@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h2 class="text-2xl font-bold mb-4">Рейтинг фильмов</h2>

    <!-- Кнопки сортировки -->
    <div class="mb-8">
        <a href="{{ route('rating', ['sort' => 'views']) }}"
            class="bg-blue-500 text-white px-4 py-2 rounded mr-2 {{ $sortBy === 'views' ? 'font-bold' : '' }}">
            По количеству просмотров
        </a>
        <a href="{{ route('rating', ['sort' => 'rank']) }}"
            class="bg-blue-500 text-white px-4 py-2 rounded {{ $sortBy === 'rank' ? 'font-bold' : '' }}">
            По рейтингу
        </a>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
        @foreach ($posts as $post)
            <div class="bg-white shadow-lg rounded-lg overflow-hidden transform transition-transform hover:scale-105">
                <a href="{{ route('Post', ['post_id' => $post->id]) }}">
                    <img src="{{ asset($post->image) }}" alt="{{ $post->name }}" class="w-full h-96 object-cover">
                </a>
                <div class="p-4">
                    <h3 class="text-lg font-bold mb-2">{{ $post->name }}</h3>
                    <div class="text-sm text-gray-500 mb-2">
                        @foreach ($post->genres as $genre)
                            {{ $genre->name }}@if (!$loop->last), @endif
                        @endforeach
                    </div>
                    <p class="text-sm text-gray-700">Просмотры: {{ $post->views }}</p>
                    @if ($post->ratings_avg_rank)
                        <p class="text-sm text-gray-700">Средний рейтинг: {{ number_format($post->ratings_avg_rank, 1) }}</p>
                    @endif
                    <a href="{{ route('Post', ['post_id' => $post->id]) }}"
                        class="text-blue-500 hover:underline">Подробнее</a>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection