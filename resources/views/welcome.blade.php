@extends('layouts.app')

@section('content')
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
        <h2 class="text-2xl font-bold mb-4">10 главных премьер в кинотеатрах и на стримингах</h2>
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
@endsection
