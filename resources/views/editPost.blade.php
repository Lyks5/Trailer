@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="container">
        <div class="container mx-5 mb-5">
            <div class="flex justify-center">
                <div class="w-full md:w-full">
                    <div class="bg-white shadow-md rounded px-5 py-5 flex">
                        <img src="{{ asset($poster->image) }}" alt="" class="rounded w-48 h-48 float-left" width="200"
                            height="200">
                        <div class="ml-5 w-full">
                            <form action="{{ route('save_posts', ['poster_id' => $poster->id]) }}" method="POST">
                                @csrf
                                <input type="text" name="name" id="name" value="{{ $poster->name }}"
                                    class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                    required />
                                <textarea id="description" name="description" rows="4"
                                    class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                    placeholder="Введите описание" required>{{ $poster->description }}</textarea>
                                <button type="submit"
                                    class="mt-3 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Сохранить</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection