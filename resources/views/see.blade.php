@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8" x-data="{ showSortModal: false, selectedGenres: @json($selectedGenres) }">
    <h2 class="text-2xl font-bold mb-4">Не знаете что посмотреть?</h2>

    <!-- Кнопка для открытия окна сортировки -->
    <button @click="showSortModal = !showSortModal" class="bg-blue-500 text-white px-4 py-2 rounded-lg mb-4">Сортировать по жанру</button>

    <!-- Окно сортировки -->
    <div x-show="showSortModal" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 transform scale-100" x-transition:leave-end="opacity-0 transform scale-95" class="mt-4 bg-white p-6 rounded-lg shadow-lg">
        <h3 class="text-lg font-bold mb-4">Выберите жанры</h3>
        <div class="flex flex-wrap mb-4">
            @foreach ($genres as $genre)
                <button @click="
                    if (selectedGenres.includes('{{ $genre }}')) {
                        selectedGenres = selectedGenres.filter(g => g !== '{{ $genre }}');
                    } else {
                        selectedGenres.push('{{ $genre }}');
                    }"
                    :class="{ 'bg-blue-500 text-white': selectedGenres.includes('{{ $genre }}'), 'bg-gray-200': !selectedGenres.includes('{{ $genre }}') }"
                    class="m-1 px-4 py-2 rounded-lg transition-colors duration-200">
                    {{ $genre }}
                </button>
            @endforeach
        </div>
        <form action="{{ route('see') }}" method="GET" @submit.prevent="
            showSortModal = false; // Закрываем окно выбора жанров
            $event.target.submit(); // Отправляем форму
        ">
            <input type="hidden" name="genres" :value="JSON.stringify(selectedGenres)">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg mt-4">Применить</button>
        </form>
    </div>

    <!-- Отображение выбранных жанров отдельно -->
    <div x-show="selectedGenres.length > 0" class="mb-4">
        <h3 class="text-lg font-bold">Выбранные жанры:</h3>
        <div class="flex flex-wrap">
            <template x-for="genre in selectedGenres" :key="genre">
                <span class="bg-blue-500 text-white rounded-full px-3 py-1 mr-2 mb-2 cursor-default" x-text="genre"></span>
            </template>
        </div>
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