@extends('layouts.app')
<!-- Подключение JavaScript-файла -->
@vite('resources/js/users.js')
@section('content')

<script src="{{ ('../js/users.js') }}"></script>
<div class="max-w-screen-2xl w-full h-auto mx-auto my-0 mb-20">
    <div class="flex justify-between pt-20">
        <h1 class="text-3xl font-bold text-gray-900">Пользователи</h1>
    </div>

    <!-- Поисковая строка -->
    <div class="mt-6">
        <input type="text" id="search" class="w-full p-2 border border-gray-300 rounded-lg"
            placeholder="Поиск по имени, email или ID">
    </div>

    <!-- Кнопки сортировки -->
    <div class="mt-4 flex space-x-4">
        <button id="sortByName" class="bg-blue-500 text-white px-4 py-2 rounded-lg">Сортировать по имени</button>
        <button id="sortByEmail" class="bg-blue-500 text-white px-4 py-2 rounded-lg">Сортировать по email</button>
        <button id="showBlocked" class="bg-red-500 text-white px-4 py-2 rounded-lg">Показать заблокированных</button>
    </div>

    <!-- Таблица пользователей -->
    <div class="mt-6">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Имя</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Статус
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Действия
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($users as $user)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $user->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $user->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $user->email }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="{{ $user->blocked ? 'text-red-500' : 'text-green-500' }}">
                                {{ $user->blocked ? 'Заблокирован' : 'Активен' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <a href="{{ route('UsersEdit', $user->id) }}"
                                class="text-yellow-400 hover:text-white border border-yellow-400 hover:bg-yellow-500 focus:ring-4 
                                focus:outline-none focus:ring-yellow-300 font-medium rounded-lg text-sm px-3 py-2.5 text-center">Редактировать</a>
                            <form action="{{ route('users.toggleBlock', $user->id) }}" method="POST" class="inline">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="text-red-600 hover:text-red-900">
                                    {{ $user->blocked ? 'Разблокировать' : 'Заблокировать' }}
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>



@endsection