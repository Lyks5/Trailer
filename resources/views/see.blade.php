@extends('layouts.app')
<script src="{{ asset('js/app.js') }}" defer></script>
<link href="{{ asset('css/app.css') }}" rel="stylesheet">
@section('content')
<div class="container mx-auto px-4 py-8">
    <h2 class="text-2xl font-bold mb-4">Не знаете что посмотреть?</h2>

    <!-- Кнопка для открытия окна сортировки -->
    <button id="sortButton" class="bg-blue-500 text-white px-4 py-2 rounded-lg mb-4">Сортировать по жанру</button>

    <!-- Окно сортировки -->
    <div id="sortModal" class="overflow-hidden transition-all duration-300 ease-in-out max-h-0">
        <div class="bg-white p-6 rounded-lg shadow-lg">
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
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
        @foreach ($posts as $post)
            <div class="bg-white shadow-lg rounded-lg overflow-hidden transform transition-transform hover:scale-105">
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
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('sortButton').addEventListener('click', function() {
            var sortModal = document.getElementById('sortModal');
            if (sortModal.style.maxHeight === '0px' || sortModal.style.maxHeight === '') {
                sortModal.style.maxHeight = sortModal.scrollHeight + 'px';
            } else {
                sortModal.style.maxHeight = '0px';
            }
        });
    });
</script>
@endpush

<style>
    #sortModal {
        transition: max-height 0.3s ease-in-out;
        overflow: hidden;
    }
</style>