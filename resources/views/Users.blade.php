@extends('layouts.app')

@section('content')
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
                            @if($user->blocked)
                                <span class="text-red-500">Заблокирован</span>
                            @else
                                <span class="text-green-500">Активен</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <button
                                class="text-yellow-400 hover:text-white border border-yellow-400 hover:bg-yellow-500 focus:ring-4 focus:outline-none focus:ring-yellow-300 font-medium rounded-lg text-sm px-3 py-2.5 text-center"
                                data-user-id="{{ $user->id }}" data-modal-target="edit-modal"
                                data-modal-toggle="edit-modal">Редактировать</button>
                            <form action="{{ route('users.toggleBlock', $user->id) }}" method="POST" class="inline">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="text-red-600 hover:text-red-900">
                                    @if($user->blocked)
                                        Разблокировать
                                    @else
                                        Заблокировать
                                    @endif
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Модальное окно для редактирования пользователя -->
<div style="background-color: rgba(0, 0, 0, 0.4);" id="edit-modal" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] h-screen">
    <div class="relative p-4 w-full max-w-4xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                <h3 class="text-xl font-semibold text-gray-900">
                    Редактирование пользователя
                </h3>
                <button type="button"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                    data-modal-hide="edit-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Закрыт</span>
                </button>
            </div>

            <!-- Modal body -->
            <div class="p-4 md:p-5 space-y-4 z-50">
                <form id="edit-user-form" action="#" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="relative z-0 w-full mb-5 group">
                        <input type="text" name="name" id="name"
                            class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-black peer"
                            required />
                        <label for="name"
                            class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-black peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Имя</label>
                    </div>
                    <div class="relative z-0 w-full mb-5 group">
                        <input type="email" name="email" id="email"
                            class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-black peer"
                            required />
                        <label for="email"
                            class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-black peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Email</label>
                    </div>
                    <button type="submit"
                        class="text-white bg-black hover:bg-slate-400 focus:ring-4 focus:outline-none focus:ring-slate-200 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Сохранить</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('search').addEventListener('input', function () {
        const query = this.value.toLowerCase();
        const rows = document.querySelectorAll('tbody tr');

        rows.forEach(row => {
            const name = row.children[1].textContent.toLowerCase();
            const email = row.children[2].textContent.toLowerCase();
            const id = row.children[0].textContent.toLowerCase();

            if (name.includes(query) || email.includes(query) || id.includes(query)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });

    document.getElementById('sortByName').addEventListener('click', function () {
        sortTable(1);
    });

    document.getElementById('sortByEmail').addEventListener('click', function () {
        sortTable(2);
    });

    let showBlocked = false;

    document.getElementById('showBlocked').addEventListener('click', function () {
        const rows = document.querySelectorAll('tbody tr');
        showBlocked = !showBlocked;

        if (showBlocked) {
            this.textContent = 'Показать все';
            this.classList.remove('bg-red-500');
            this.classList.add('bg-blue-500');

            rows.forEach(row => {
                const blocked = row.children[3].textContent.toLowerCase().includes('заблокирован');
                if (!blocked) {
                    row.style.display = 'none';
                } else {
                    row.style.display = '';
                }
            });
        } else {
            this.textContent = 'Показать заблокированных';
            this.classList.remove('bg-blue-500');
            this.classList.add('bg-red-500');

            rows.forEach(row => {
                row.style.display = '';
            });
        }
    });

    function sortTable(column) {
        const table = document.querySelector('table');
        const rows = Array.from(table.querySelectorAll('tbody tr'));

        rows.sort((a, b) => {
            const aText = a.children[column].textContent.toLowerCase();
            const bText = b.children[column].textContent.toLowerCase();

            if (aText < bText) return -1;
            if (aText > bText) return 1;
            return 0;
        });

        const tbody = table.querySelector('tbody');
        rows.forEach(row => tbody.appendChild(row));
    }

    // Модальное окно
    document.querySelectorAll('[data-modal-toggle="edit-modal"]').forEach(button => {
        button.addEventListener('click', function (event) {
            event.preventDefault();
            const userId = this.getAttribute('data-user-id');
            fetch(`/users/${userId}/edit`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('name').value = data.name;
                    document.getElementById('email').value = data.email;
                    document.getElementById('edit-user-form').action = `/users/${userId}`;
                    document.getElementById('edit-modal').classList.remove('hidden');
                });
        });
    });

    document.querySelectorAll('[data-modal-hide="edit-modal"]').forEach(button => {
        button.addEventListener('click', function () {
            document.getElementById('edit-modal').classList.add('hidden');
        });
    });
</script>
@endsection