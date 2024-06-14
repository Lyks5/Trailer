@extends('layouts.app')

@section('content')
    <div class="max-w-screen-2xl w-full h-auto mx-auto my-0 mb-20">
        <div class="flex justify-between pt-20">
            <div class="product-main_info flex">
                <div class="flex gap-5 h-full">
                    <img src="{{ asset($post->image) }}" alt="Product Image" style="width: full">
                    <div class="flex flex-col">
                        <div class="title text-start color-root-grey-light">
                            <h3 class="font-semibold">{{ $post->name }}</h3>
                            <p>Дата создания: {{ $post->created_at->format('M. j, Y h:m') }}</p>
                            <div class="desc mb-40">
                                <div class="title color-root-grey-light mt-5">
                                    <h2>Описание</h2>
                                </div>
                                <div class="color-root-grey-light mb-5">
                                    <p class="font-semibold">
                                        {{ $post->description }}
                                    </p>
                                </div>
                                @if ($like)
                                    <a href="{{ route('ToLike', ['product_id' => $post->id]) }}"
                                        class="w-full md:w-[260px] px-4 py-1 rounded-xl border border-black border-dashed text-center">
                                        В избранном
                                    </a>
                                @else
                                    <a href="{{ route('ToLike', ['product_id' => $post->id]) }}"
                                        class="bg-orange-500 hover:bg-orange-700 text-white font-bold py-2 px-4 rounded-full transition duration-300 ease-in-out">Добавить
                                        в избранное
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="p-6 text-gray-900 h-auto w-3/6">
            <div class="flex justify-between items-start">
                <section class="py-8 lg:py-16 w-screen">
                    <div class="mx-auto">
                        <div class="flex justify-between items-start mb-6">
                            <h2 class="text-lg lg:text-2xl font-bold text-gray-900">Комментарии
                                ({{ count($comments) }})
                            </h2>
                        </div>
                        <form class="mb-6" method="POST" action="{{ route('newComment', ['id' => $post->id]) }}">
                            @csrf
                            <div class="py-2 px-4 mb-4 bg-white rounded-lg rounded-t-lg border border-gray-200">
                                <label for="comment" class="sr-only">Ваш комментарий</label>
                                <textarea id="comment" rows="6" name="message"
                                    class="px-0 w-full text-sm text-gray-900 border-0 focus:ring-0 focus:outline-none" placeholder="Ваш комментарий"
                                    required></textarea>
                            </div>
                            <button type="submit"
                                class="inline-flex items-center py-2.5 px-4 text-xs font-medium text-center border text-gray-500 bg-primary-900 rounded-lg focus:ring-4 focus:ring-primary-200 hover:bg-primary-800">
                                Опубликовать
                            </button>
                        </form>
                        @foreach ($comments as $comment)
                            <article class="p-6 mb-5 text-base bg-gray-200 rounded-lg">
                                <footer class="flex justify-between items-center mb-2 w-max">
                                    <div class="flex items-center">
                                        <p class="inline-flex items-center mr-3 text-sm text-gray-900">
                                            {{ $comment->user->name }}
                                        </p>
                                        <p class="text-sm text-gray-600"><time pubdate datetime="2022-02-08"
                                                title="February 8th, 2022">{{ $comment->created_at->format('M. j, Y h:m') }}</time>
                                        </p>
                                    </div>

                                </footer>
                                <p class="text-gray-500">{{ $comment->message }}</p>
                            </article>
                        @endforeach
                    </div>
                </section>
            </div>
        </div>
    </div>
@endsection
