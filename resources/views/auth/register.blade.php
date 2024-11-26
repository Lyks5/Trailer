<!DOCTYPE html>
<html lang="ru">
<head>
    <!-- Устанавливаем кодировку и метаданные -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация</title>
    <!-- Подключаем Tailwind CSS через CDN -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <!-- Основной контейнер с центрированием содержимого -->
    <div class="flex items-center justify-center min-h-screen">
        <!-- Контейнер для формы регистрации -->
        <div class="flex w-4/5 max-w-4xl h-96 shadow-lg">
            <!-- Левая часть: информация о сайте -->
            <div class="flex flex-col justify-center w-1/2 p-10 bg-black text-white">
                <h1 class="text-4xl font-bold">Киноафиша</h1>
                <p class="mt-4">Приглашаем вас на премьеру нового фильма, который изменит ваше представление о кино.</p>
                <!-- Ссылка на страницу входа -->
                <a href="{{ route('login') }}">
                    <button class="px-4 py-2 mt-6 text-black bg-white rounded">Войти</button>
                </a>
            </div>
            <!-- Правая часть: форма регистрации -->
            <div class="flex flex-col justify-center w-1/2 p-10 bg-white">
                <h2 class="text-3xl font-bold">Регистрация</h2>
                <p class="mt-2">Открой справочник кинофильмов</p>
                <!-- Форма регистрации -->
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <!-- Поле для ввода имени -->
                    <div class="mb-4">
                        <input id="name" placeholder="Имя" type="text" class="w-full px-4 py-2 border rounded form-control @error('name') border-red-500 @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                        <!-- Сообщение об ошибке для имени -->
                        @error('name')
                            <span class="text-red-500 text-sm" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <!-- Поле для ввода email -->
                    <div class="mb-4">
                        <input id="email" type="email" placeholder="Email" class="w-full px-4 py-2 border rounded form-control @error('email') border-red-500 @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                        <!-- Сообщение об ошибке для email -->
                        @error('email')
                            <span class="text-red-500 text-sm" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <!-- Поле для ввода пароля -->
                    <div class="mb-4">
                        <input id="password" type="password" placeholder="Пароль" class="w-full px-4 py-2 border rounded form-control @error('password') border-red-500 @enderror" name="password" required autocomplete="new-password">
                        <!-- Сообщение об ошибке для пароля -->
                        @error('password')
                            <span class="text-red-500 text-sm" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <!-- Поле для подтверждения пароля -->
                    <div class="mb-4">
                        <input id="password-confirm" type="password" placeholder="Подтвердите пароль" class="w-full px-4 py-2 border rounded form-control" name="password_confirmation" required autocomplete="new-password">
                    </div>
                    <!-- Кнопка отправки формы -->
                    <div class="mb-4">
                        <button type="submit" class="w-full px-4 py-2 text-white bg-black rounded">
                            {{ __('Зарегистрироваться') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>