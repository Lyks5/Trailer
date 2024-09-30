<header class="bg-white shadow">
    <div class="container mx-auto px-4 py-4 flex justify-between items-center">
        <div class="flex items-center">
            <a href="{{ route('welcome') }}">
                <h1 class="text-black text-3xl font-bold">КИНОАФИША</h1>
            </a>
        </div>
        <nav class="flex-grow">
            <ul class="flex justify-center space-x-8">
                <li><a href="/" class="text-black">Афиша</a></li>
                <li><a href="{{ route('see') }}" class="text-black">Что посмотреть</a></li>
                <li><a href="{{ route('rating') }}" class="text-black">Рейтинг</a></li>
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
                <a href="{{ route('home') }}" class="text-black">{{ Auth::user()->name }}</a>
            @else
                <a href="{{ route('register') }}">Вход</a>
            @endif
        </div>
    </div>
</header>
