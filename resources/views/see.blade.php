@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8" x-data="{ showSortModal: false }">
    <h2 class="text-2xl font-bold mb-4">Не знаете что посмотреть?</h2>

    <!-- Кнопка для открытия окна сортировки -->
    <button @click="showSortModal = !showSortModal" class="bg-blue-500 text-white px-4 py-2 rounded-lg mb-4">Сортировать по жанру</button>

    <!-- Окно сортировки -->
    <div x-show="showSortModal" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 transform scale-100" x-transition:leave-end="opacity-0 transform scale-95" class="mt-4 bg-white p-6 rounded-lg shadow-lg">
        <h3 class="text-lg font-bold mb-4">Выберите жанр</h3>
        <form action="{{ route('see') }}" method="GET">
            <select name="genre" class="w-full p-2 border rounded-lg">
                <option value="">Все жанры</option>
                @foreach ($genres as $genre)
                    <option value="{{ $genre }}">{{ $genre }}</option>
                @endforeach
            </select>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg mt-4">Применить</button>
        </form>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
        @foreach ($posts as $post)
            <div class="bg-white shadow-lg rounded-lg overflow-hidden transform transition-transform hover:scale-105">
                <a href="{{ route('Post', ['post_id' => $post->id]) }}">
                    <img src="{{ asset($post->image) }}" alt="Movie 1" class="w-full h-96 object-cover">
                </a>
                <div class="p-4">
                    <h3 class="text-lg font-bold mb-2">{{ $post->name }}</h3>
                    <div class="text-sm text-gray-500 mb-2">
                        @foreach ($post->genres as $genre)
                            {{ $genre->name }}@if (!$loop->last), @endif
                        @endforeach
                    </div>
                    <a href="{{ route('Post', ['post_id' => $post->id]) }}"
                        class="text-blue-500 hover:underline">Подробнее</a>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection

<style>
    [x-cloak] { display: none !important; }
</style>