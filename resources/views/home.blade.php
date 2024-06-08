@extends('layouts.app')

@section('content')
    <div class="py-8">
        <div class="max-w-9xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100 grid grid-cols-4 gap-4">
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
                                    class="bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded">
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
                                    <div class="flex flex-wrap gap-2 mb-2">
                                        <div>
                                            <a href=""
                                                class="text-primary hover:text-primary-dark transition duration-300 ease-in-out text-lg">name</a>
                                        </div>
                                    </div>
                                    <div class="flex flex-wrap gap-2 mb-2">
                                        <div>
                                            <a href=""
                                                class="text-primary hover:text-primary-dark transition duration-300 ease-in-out text-lg">name</a>
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
