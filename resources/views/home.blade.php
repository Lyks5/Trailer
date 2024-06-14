@extends('layouts.app')

@section('content')
    <div class="py-8">
        <div class="max-w-9xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 grid grid-cols-4 gap-4">
                    <div class="max-w-6xl w-full mx-auto my-0 mb-32">
                        <div class="user_info flex mb-14">
                            <div class="info ml-8">
                                <div class="font-bold text-2xl mb-5">
                                    <p>{{ Auth::user()->name }}</p>
                                </div>
                                <div class="text-1xl mb-5">
                                    <p class="mb-5">{{ Auth::user()->email }}</p>
                                    <p class="mb-5">Дата регистрации: {{ Auth::user()->created_at->format('M. j, Y') }}
                                    </p>
                                </div>
                                <a href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();"
                                    class="bg-transparent hover:bg-black text-black-700 font-semibold hover:text-white py-2 px-4 border border-black hover:border-transparent rounded">
                                    Выйти
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                    @csrf
                                </form>
                            </div>
                        </div>
                        <div class="container flex flex-col md:flex-row items-start">
                            <div class="md:w-full">
                                <div class="bg-white shadow-md rounded px-4 py-3 mb-3">
                                    <h5 class="text-lg font-bold">Избранное</h5>
                                    <div class="gap-2 mb-2">
                                        <div class="flex flex-wrap flex-col mb-2">
                                            @foreach ($like as $name)
                                                @foreach ($name->poster as $item)
                                                    <div class="flex align-center border p-5">
                                                        <img src="{{ asset($item->image) }}" alt=""
                                                            style="width: 75px">
                                                        <a href="{{ route('Post', ['post_id' => $item->id]) }}"
                                                            class="text-primary hover:text-primary-dark transition duration-300 ease-in-out text-lg">{{ $item->name }}</a>
                                                    </div>
                                                @endforeach
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
