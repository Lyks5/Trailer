<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Киноафиша</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.3/min/tiny-slider.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.3/tiny-slider.css" rel="stylesheet">
    <style>
        .tns-controls {
            position: absolute;
            width: 100%;
            top: 50%;
            transform: translateY(-50%);
            display: flex;
            justify-content: space-between;
            z-index: 10;
        }

        .tns-controls button {
            background: rgba(255, 255, 255, 0.7);
            border: none;
            padding: 10px;
            border-radius: 50%;
        }
    </style>
</head>

<body class="bg-gray-100">

    <!-- Header -->
    <header class="bg-white shadow">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <div class="flex items-center">
                {{-- <button class="text-orange-600 text-2xl mr-4">☰ Меню</button> --}}
                <h1 class="text-orange-600 text-3xl font-bold">КИНОАФИША</h1>
            </div>
            <nav class="flex-grow">
                <ul class="flex justify-center space-x-8">
                    <li><a href="#" class="text-black">Афиша</a></li>
                    <li><a href="#" class="text-black">Что посмотреть</a></li>
                    <li><a href="#" class="text-black">Сериалы</a></li>
                    <li><a href="#" class="text-black">Новости</a></li>
                    @if (Auth::user() and Auth::user()->is_admin == 1)
                        <li><a href="{{ route('admin') }}" class="text-black">Админка</a></li>
                    @endif
                </ul>
            </nav>
            <div class="flex items-center space-x-4">
                <form action="{{ route('Search') }}" method="POST">
                    @csrf
                    <input type="text" name="word" placeholder="Поиск" class="border rounded px-3 py-1">
                    <button type="submit" class="text-black">🔍</button>
                </form>
                @if (Auth::user())
                    <a href="home" class="text-black">{{ Auth::user()->name }}</a>
                @else
                    <a href="{{ route('register') }}">Вход</a>
                @endif
                {{-- <a href="{{ route('register') }}"><button class="text-black">{{Auth::user()->name}}</button></a> --}}
            </div>
        </div>
    </header>

    <!-- Main Slider -->
    <div class="container mx-auto my-6">
        <div class="relative">
            <div class="tns-controls">
                <button class="tns-prev"></button>
                <button class="tns-next"></button>
            </div>
            <div class="my-slider">
                <div><img src="https://2022-god.com/wp-content/uploads/2021/08/dyuna-dune.jpeg" alt="Slide 1"
                        class="w-full h-96 object-cover"></div>
                <div><img src="https://2022-god.com/wp-content/uploads/2021/08/dyuna-dune.jpeg" alt="Slide 2"
                        class="w-full h-96 object-cover"></div>
                <div><img src="https://2022-god.com/wp-content/uploads/2021/08/dyuna-dune.jpeg" alt="Slide 3"
                        class="w-full h-96 object-cover"></div>
                <div><img src="https://2022-god.com/wp-content/uploads/2021/08/dyuna-dune.jpeg" alt="Slide 4"
                        class="w-full h-96 object-cover"></div>
            </div>
        </div>
    </div>

    <!-- Movies Grid -->
    <div class="container mx-auto px-4 py-8">
        <h2 class="text-2xl font-bold mb-4">Что смотреть в мае: 10 главных премьер в кинотеатрах и на стримингах</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-4">
            <!-- Movie Card -->
            @foreach ($posts as $post)
                <div class="bg-white shadow rounded overflow-hidden">
                    <img src="{{ asset($post->image) }}" alt="Movie 1" class="w-full h-70 object-cover">
                    <div class="p-4">
                        <h3 class="text-lg font-bold">{{ $post->name }}</h3>
                        <a href="{{ route('Post', ['post_id' => $post->id]) }}">Подробнее</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-white py-6">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
                <div>
                    <h4 class="font-bold mb-2">Афиша</h4>
                    <ul>
                        <li><a href="#" class="text-gray-600">Кинотеатры</a></li>
                        <li><a href="#" class="text-gray-600">Премьеры</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold mb-2">Онлайн</h4>
                    <ul>
                        <li><a href="#" class="text-gray-600">Фильмы</a></li>
                        <li><a href="#" class="text-gray-600">Мультфильмы</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold mb-2">Что посмотреть</h4>
                    <ul>
                        <li><a href="#" class="text-gray-600">Премьеры</a></li>
                        <li><a href="#" class="text-gray-600">Рейтинги</a></li>
                        <li><a href="#" class="text-gray-600">Трейлеры</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold mb-2">Сериалы</h4>
                    <ul>
                        <li><a href="#" class="text-gray-600">Новости</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold mb-2">Media</h4>
                    <ul>
                        <li><a href="#" class="text-gray-600">Новости</a></li>
                        <li><a href="#" class="text-gray-600">Трейлеры</a></li>
                        <li><a href="#" class="text-gray-600">Персоны</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold mb-2">Мое</h4>
                    <ul>
                        <li><a href="#" class="text-gray-600">Избранное</a></li>
                        <li><a href="#" class="text-gray-600">Расписание</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var slider = tns({
                container: '.my-slider',
                items: 1,
                slideBy: 'page',
                autoplay: true,
                controls: true,
                nav: true,
                navPosition: 'bottom',
                controlsPosition: 'top',
                controlsContainer: '.tns-controls'
            });
        });
    </script>
</body>

</html>
