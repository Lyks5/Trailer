@extends('layouts.app')
@section('title')
Профиль
@endsection

@section('content')
<div class="py-8">
    <div class="max-w-9xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Левая колонка: Данные пользователя (четверть экрана) -->
                <div class="user_info flex flex-col">
                    <div class="info">
                        <div class="font-bold text-2xl mb-5">
                            <p>{{ Auth::user()->name }}</p>
                        </div>
                        <div class="text-1xl mb-5">
                            <p class="mb-5">{{ Auth::user()->email }}</p>
                            <p class="mb-5">Дата регистрации: {{ Auth::user()->created_at->format('M. j, Y') }}</p>
                            <p class="mb-5">
                                Последний вход:
                                @if(Auth::user()->last_login_at)
                                    {{ Auth::user()->last_login_at->timezone(config('app.timezone'))->format('M. j, Y H:i') }}
                                @else
                                    Информация недоступна
                                @endif
                            </p>
                        </div>
                        <a href="{{ route('logout') }}" onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();"
                            class="bg-transparent hover:bg-black text-black-700 font-semibold hover:text-white py-2 px-4 border border-black hover:border-transparent rounded">
                            Выйти
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST">
                            @csrf
                        </form>

                        <!-- Кнопка сброса пароля -->
                        <button id="resetPasswordButton" class="bg-transparent hover:bg-black text-black-700 font-semibold hover:text-white py-2 px-4 border border-black hover:border-transparent rounded mt-4">
                            Сбросить пароль
                        </button>

                        <!-- Форма для ввода кода сброса пароля -->
                        <form id="resetPasswordForm" style="display: none;" method="POST" action="{{ route('password.code.verify') }}">
                            @csrf
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="code">
                                    Код
                                </label>
                                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="code" type="text" name="code" required autofocus>
                            </div>
                            <div class="flex items-center justify-between">
                                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                                    Подтвердить код
                                </button>
                            </div>
                        </form>

                        <!-- Форма для ввода нового пароля -->
                        @if (session('status') && session('status') === 'Код подтвержден. Введите новый пароль.')
                            <form method="POST" action="{{ route('password.reset') }}">
                                @csrf
                                <div class="mb-4">
                                    <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                                        Новый пароль
                                    </label>
                                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="password" type="password" name="password" required>
                                </div>
                                <div class="mb-4">
                                    <label class="block text-gray-700 text-sm font-bold mb-2" for="password_confirmation">
                                        Подтвердите пароль
                                    </label>
                                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="password_confirmation" type="password" name="password_confirmation" required>
                                </div>
                                <div class="flex items-center justify-between">
                                    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                                        Сбросить пароль
                                    </button>
                                </div>
                            </form>
                        @endif

                        <!-- Ссылка на Telegram бота -->
                        <a href="https://t.me/Afisha_Reset_Password_bot" target="_blank" class="text-blue-500 hover:underline mt-4 block">
                            Перейти к Telegram боту
                        </a>
                    </div>
                </div>

                <!-- Правая колонка: Грид с постерами (три четверти экрана) -->
                <div class="posters-grid col-span-3">
                    <div class="bg-white shadow-md rounded px-4 py-3 mb-3">
                        <h5 class="text-lg font-bold">Избранное</h5>
                        <div class="gap-2 mb-2">
                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6 py-4">
                                @foreach ($like as $name)
                                    @if (is_object($name->poster))
                                        <div class="bg-white shadow-lg rounded-lg overflow-hidden transform transition-transform hover:scale-105">
                                            <a href="{{ route('Post', ['post_id' => $name->poster->id]) }}">
                                                <img src="{{ asset($name->poster->image) }}" alt="{{ $name->poster->name }}" class="w-full h-96 object-cover">
                                            </a>
                                            <div class="p-4">
                                                <h3 class="text-lg font-bold mb-2">{{ $name->poster->name }}</h3>
                                                <div class="text-sm text-gray-500 mb-2">
                                                    @foreach ($name->poster->genres as $genre)
                                                        {{ $genre->name }}@if (!$loop->last), @endif
                                                    @endforeach
                                                </div>
                                                <a href="{{ route('Post', ['post_id' => $name->poster->id]) }}"
                                                    class="text-blue-500 hover:underline">Подробнее</a>
                                                <form action="{{ route('removeFromFavorites', ['like_id' => $name->id]) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="bg-white hover:bg-black text-black-700 font-semibold hover:text-white py-2 px-4 border border-black hover:border-transparent rounded mt-2">
                                                        Удалить из избранных
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    @else
                                        <p>Некорректные данные</p>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('resetPasswordButton').addEventListener('click', function() {
        document.getElementById('resetPasswordForm').style.display = 'block';
    });
</script>
@endsection