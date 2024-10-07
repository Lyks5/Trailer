@extends('layouts.app')
@section('title')
Главная страница
@endsection

@section('content')
<title>Beautiful Slider</title>
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
<style>
    .slider-container {
        position: relative;
        overflow: hidden;
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }

    .slider {
        display: flex;
        transition: transform 0.5s ease-in-out;
    }

    .slider img {
        width: 100%;
        height: 400px;
        object-fit: cover;
        border-radius: 10px;
    }

    .controls {
        position: absolute;
        top: 50%;
        left: 0;
        right: 0;
        display: flex;
        justify-content: space-between;
        transform: translateY(-50%);
        z-index: 10;
    }

    .controls button {
        background: rgba(255, 255, 255, 0.7);
        border: none;
        padding: 10px;
        border-radius: 50%;
        cursor: pointer;
        transition: background 0.3s ease;
    }

    .controls button:hover {
        background: rgba(255, 255, 255, 0.9);
    }

    .controls button:focus {
        outline: none;
    }

    .indicators {
        position: absolute;
        bottom: 10px;
        left: 50%;
        transform: translateX(-50%);
        display: flex;
        gap: 5px;
    }

    .indicator {
        width: 10px;
        height: 10px;
        background: rgba(255, 255, 255, 0.5);
        border-radius: 50%;
        cursor: pointer;
        transition: background 0.3s ease;
    }

    .indicator.active {
        background: rgba(255, 255, 255, 0.9);
    }
</style>

<body class="bg-gray-100">
    <div class="container mx-auto my-6">
        <div class="slider-container relative overflow-hidden rounded-lg shadow-lg">
            <div class="slider flex">
                <div class="w-full flex-shrink-0"><a href="{{route('Post', ['post_id' => 9])}}"><img
                            src="https://www.gf9games.com/dune/wp-content/uploads/2020/09/Dune-Website-Header-1900x475px-1536x384.png"
                            alt="Slide 1"></a></div>
                <div class="w-full flex-shrink-0"><a href="{{route('Post', ['post_id' => 10])}}"><img
                            src="https://www.drcommodore.it/wp-content/uploads/2023/08/one-piece-poster-1536x384.jpg"
                            alt="Slide 2"></a></div>
                <div class="w-full flex-shrink-0"><a href="{{route('Post', ['post_id' => 11])}}"><img
                            src="https://avatars.mds.yandex.net/i?id=db6e8ad51edac8aef851894d65dd8524_l-2743775-images-thumbs&n=13"
                            alt="Slide 3"></a></div>
            </div>
            <div class="controls absolute top-1/2 left-0 right-0 flex justify-between transform -translate-y-1/2 z-10">
                <button class="prev bg-white bg-opacity-70 p-2 rounded-full hover:bg-opacity-90 focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7">
                        </path>
                    </svg>
                </button>
                <button class="next bg-white bg-opacity-70 p-2 rounded-full hover:bg-opacity-90 focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>
            </div>
            <div class="indicators absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-2">
                <div class="indicator active"></div>
                <div class="indicator"></div>
                <div class="indicator"></div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const slider = document.querySelector('.slider');
            const slides = document.querySelectorAll('.slider img');
            const prevButton = document.querySelector('.prev');
            const nextButton = document.querySelector('.next');
            const indicators = document.querySelectorAll('.indicator');
            let currentIndex = 0;

            function showSlide(index) {
                slider.style.transform = `translateX(-${index * 100}%)`;
                indicators.forEach((indicator, i) => {
                    indicator.classList.toggle('active', i === index);
                });
            }

            prevButton.addEventListener('click', () => {
                currentIndex = (currentIndex - 1 + slides.length) % slides.length;
                showSlide(currentIndex);
            });

            nextButton.addEventListener('click', () => {
                currentIndex = (currentIndex + 1) % slides.length;
                showSlide(currentIndex);
            });

            indicators.forEach((indicator, i) => {
                indicator.addEventListener('click', () => {
                    currentIndex = i;
                    showSlide(currentIndex);
                });
            });

            // Autoplay
            setInterval(() => {
                currentIndex = (currentIndex + 1) % slides.length;
                showSlide(currentIndex);
            }, 5000);
        });
    </script>

    <!-- Movies Grid -->
    <div class="container mx-auto px-4 py-8">
        <h2 class="text-2xl font-bold mb-4">10 главных премьер в кинотеатрах и на стримингах</h2>
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