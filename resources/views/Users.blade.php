@extends('layouts.app')

@section('content')
<section class="py-1 bg-gray-50">
    <div class="w-full xl:w-8/12 mb-12 xl:mb-0 px-4 mx-auto mt-24">
        <div class="relative flex flex-col min-w-0 break-words bg-white w-full mb-6 shadow-lg rounded">
            <div class="rounded-t mb-0 px-4 py-3 border-0">
                <div class="flex flex-wrap items-center">
                    <div class="relative w-full px-4 max-w-full flex-grow flex-1">
                        <h3 class="font-semibold text-lg text-gray-700">User Management</h3>
                    </div>
                </div>
            </div>
            <div class="block w-full overflow-x-auto">
                <table class="items-center bg-transparent w-full border-collapse">
                    <thead>
                        <tr>
                            <th class="px-6 bg-gray-50 text-gray-500 align-middle border border-solid border-gray-100 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                                ID
                            </th>
                            <th class="px-6 bg-gray-50 text-gray-500 align-middle border border-solid border-gray-100 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                                Name
                            </th>
                            <th class="px-6 bg-gray-50 text-gray-500 align-middle border border-solid border-gray-100 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                                Email
                            </th>
                            <th class="px-6 bg-gray-50 text-gray-500 align-middle border border-solid border-gray-100 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                                Actions
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        @if($users->count() > 0)
                            @foreach($users as $user)
                            <tr class="border-b border-gray-200">
                                <th class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-lg whitespace-nowrap p-4 text-left text-gray-700 font-bold">
                                    {{ $user->id }}
                                </th>
                                <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-lg whitespace-nowrap p-4 font-bold">
                                    {{ $user->name }}
                                </td>
                                <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-lg whitespace-nowrap p-4 font-bold">
                                    {{ $user->email }}
                                </td>
                                <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-lg whitespace-nowrap p-4">
                                    <div class="flex justify-center gap-3">
                                        <a href="{{ route('users.edit', $user->id) }}" type="button"
                                            class="text-yellow-400 hover:text-white border border-yellow-400 hover:bg-yellow-500 focus:ring-4 focus:outline-none focus:ring-yellow-300 font-medium rounded-lg text-sm px-3 py-2.5 text-center">Редактировать</a>
                                        <form action="{{ route('users.block', $user->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            <button type="submit"
                                                class="text-red-700 hover:text-white border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-3 py-2.5 text-center">Заблокировать</button>
                                        </form>
                                        <button @click="showUserDetails{{ $user->id }} = !showUserDetails{{ $user->id }}"
                                            class="text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-3 py-2.5 text-center">
                                            Детали
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4">
                                    <div x-data="{ showUserDetails{{ $user->id }}: false }">
                                        <div x-show="showUserDetails{{ $user->id }}" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 transform scale-100" x-transition:leave-end="opacity-0 transform scale-95" class="mt-4 bg-white p-6 rounded-lg shadow-lg mb-6">
                                            <h3 class="text-lg font-bold mb-4">User Details</h3>
                                            <p><strong>Email:</strong> {{ $user->email }}</p>
                                            <p><strong>Last Login:</strong> {{ $user->last_login ?? 'N/A' }}</p>
                                            <p><strong>Comments:</strong></p>
                                            <ul>
                                                @foreach($user->comments as $comment)
                                                    <li>{{ $comment->message }}</li>
                                                @endforeach
                                            </ul>
                                            <p><strong>Favorites:</strong></p>
                                            <ul>
                                                @foreach($user->likes as $like)
                                                    <li>{{ $like->title }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="4" class="text-center p-4">No users found.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <footer class="relative pt-8 pb-6 mt-16">
        <div class="container mx-auto px-4">
            <div class="flex flex-wrap items-center md:justify-between justify-center">
            </div>
        </div>
    </footer>
</section>
@endsection