@extends('layouts.app')
@section('content')
    <div class="py-12 max-w-9xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <h1 class="p-3 font-semibold">Постеры</h1>
                <button type="button" data-modal-target="default-modal" data-modal-toggle="default-modal"
                    class="text-white bg-black hover:bg-slate-400 focus:ring-4 focus:ring-slate-600 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 focus:outline-none">
                    Добавить постер
                </button>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
            <div class="p-6 text-gray-900 grid w-auto grid-cols-5 gap-4 place-items-center">
                @foreach ($posters as $post)
                    <div class="bg-white shadow rounded overflow-hidden w-min">
                        <img src="{{ asset($post->image) }}" alt="Movie 1" class="w-full h-70 object-cover">
                        <div class="p-4">
                            <h3 class="text-lg font-bold">{{ $post->name }}</h3>
                            <a href="{{ route('Post', ['post_id' => $post->id]) }}">Подробнее</a>
                            <div class="flex justify-between gap-3 pt-3">
                                <a href="{{ route('DeletePost', ['post_id' => $post->id]) }}" type="button"
                                    class="text-red-700 hover:text-white border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-3 py-2.5 text-center me-2 mb-2">Удалить</a>
                                <a href="{{ route('editPosts', ['post_id' => $post->id]) }}" type="button"
                                    data-modal-target="edit-modal" data-modal-toggle="edit-modal"
                                    class="text-yellow-400 hover:text-white border border-yellow-400 hover:bg-yellow-500 focus:ring-4 focus:outline-none focus:ring-yellow-300 font-medium rounded-lg text-sm px-3 py-2.5 text-center me-2 mb-2">Редактировать</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    {{-- Модальное окно --}}
    <div style="background-color: rgb(0, 0, 0, 0.4);" id="default-modal" tabindex="-1" aria-hidden="true"
        class=" hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] h-screen">
        <div class="relative p-4 w-1/2 max-w-9xl max-h-9xl">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                    <h3 class="text-xl font-semibold text-gray-900">
                        Добавление постера
                    </h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                        data-modal-hide="default-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Закрыт</span>
                    </button>
                </div>

                <!-- Modal body -->
                <div class="p-4 md:p-5 space-y-4">
                    <form class="max-w-md mx-auto" method="POST" action="{{ route('NewPoster') }}"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="relative z-0 w-full mb-5 group">
                            <input type="text" name="name" id="name"
                                class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-black peer"
                                required />
                            <label for="name"
                                class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-black peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Название</label>
                        </div>
                        <div class="relative z-0 w-full mb-5 group">
                            <label for="description" class="block mb-2 text-sm font-medium text-gray-900">Описание</label>
                            <textarea id="description" name="description" rows="4"
                                class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Введите описание" required></textarea>
                        </div>
                        <div class="relative z-0 w-full mb-5 group">
                            <label class="block mb-2 text-sm font-medium text-gray-900" for="photo">Выберите файл</label>
                            <input
                                class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none"
                                aria-describedby="photo" name="photo" id="photo" type="file" required>
                        </div>
                        <button type="submit"
                            class="text-white bg-black hover:bg-slate-400 focus:ring-4 focus:outline-none focus:ring-slate-200 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Загрузить</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
@endsection
