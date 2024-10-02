<!-- Header -->
<header class="bg-white shadow">
    <div class="container mx-auto px-4 py-4 flex sm:justify-center md:justify-between items-center max-w-screen-xl">
        <div class="flex sm: items-center">
            <a href="{{ route('welcome') }}">
                <h1 class=" xs:hidden text-black text-3xl sm:justify-center font-bold">КИНОАФИША</h1>
            </a>
        </div>
        <nav class="xs:hidden md:flex flex-grow justify-center space-x-8">
            <ul class="flex space-x-8">
                <li><a href="/" class="text-black">Афиша</a></li>
                <li><a href="{{ route('see') }}" class="text-black">Что посмотреть</a></li>
                <li><a href="{{ route('rating') }}" class="text-black">Рейтинг</a></li>
                @if (Auth::user() and Auth::user()->is_admin == 1)
                    <li><a href="{{ route('admin') }}" class="text-black">Админка</a></li>
                @endif
            </ul>
        </nav>
        <div class="xs:hidden md:flex items-center space-x-4">
            <form action="{{ route('Search') }}" method="POST">
                @csrf
                <input type="text" name="word" placeholder="Поиск" class="border rounded px-3 py-1">
                <button type="submit" class="text-black">🔍</button>
            </form>
            @if (Auth::user())
                <a href="{{ route('home') }}" class="text-black">{{ Auth::user()->name }}</a>
            @else
                <a href="{{ route('register') }}" class="text-black">Вход</a>
            @endif
        </div>
    </div>


    <div class=" fixed bg-white top-0 left-0 md:hidden container mx-auto px-4 py-4 flex flex-col items-center max-w-screen-xl">
        <nav class="grid grid-cols-5 gap-10" id="nav-links">
            <a href="/" class="flex flex-col items-center">
                <img class="w-16" src="{{ asset('sait/afisha.svg') }}" alt="Афиша">
            </a>
            <a href="{{ route('see') }}" class="flex flex-col items-center">
                <img class="w-16" src="{{ asset('sait/question.svg') }}" alt="Что посмотреть">
            </a>
            <a href="{{ route('rating') }}" class="flex flex-col items-center">
                <img class="w-16" src="{{ asset('sait/star.svg') }}" alt="Рейтинг">
            </a>
            @if (Auth::user())
                <a href="{{ route('home') }}" class="text-black">
                    <img class="w-16" src="{{ asset('sait/person.svg') }}" alt="Личный кабинет">
                </a>
            @else
                <a href="/" class="flex flex-col items-center">
                    <img class="w-16" src="{{ asset('sait/login.svg') }}" alt="Личный кабинет">
                </a>
            @endif

            <button id="search-button" class="flex flex-col items-center" onclick="toggleSearch()">
                <img class="w-16" src="{{ asset('sait/search.svg') }}" alt="Поиск">
            </button>
        </nav>

        <div id="search-form" class="hidden w-10/12 flex items-center justify-center">
            <form action="{{ route('Search') }}" method="POST" class="flex w-10/12 items-center">
                @csrf
                <input type="text" name="word" placeholder="Поиск" class="border rounded  w-10/12 px-3 py-2">
                <button type="submit" class="text-black px-3 py-2">
                    <img class="w-10" src="{{ asset('sait/search.svg') }}" alt="Поиск">
                </button>
            </form>
        </div>
    </div>

    <script>
        function toggleSearch() {
            const searchForm = document.getElementById('search-form');
            const navLinks = document.getElementById('nav-links');

            if (searchForm.classList.contains('hidden')) {
                searchForm.classList.remove('hidden');
                navLinks.classList.add('hidden');
                // Устанавливаем фокус на инпут поиска
                setTimeout(() => {
                    searchForm.querySelector('input').focus();
                }, 0);
            } else {
                searchForm.classList.add('hidden');
                navLinks.classList.remove('hidden');
            }
        }

        // Закрытие инпута при клике вне его
        document.addEventListener('click', (event) => {
            const searchForm = document.getElementById('search-form');
            const searchButton = document.getElementById('search-button');

            if (!searchButton.contains(event.target) && !searchForm.contains(event.target)) {
                if (!searchForm.classList.contains('hidden')) {
                    searchForm.classList.add('hidden');
                    document.getElementById('nav-links').classList.remove('hidden');
                }
            }
        });
    </script>

    </div>
    </div>
</header>