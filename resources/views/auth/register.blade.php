<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
<div class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="flex w-4/5 max-w-4xl h-96 shadow-lg">
        <div class="flex flex-col justify-center w-1/2 p-10 bg-black text-white">
            <h1 class="text-4xl font-bold">Киноафиша</h1>
            <p class="mt-4">Вы можете войти в систему, используя свою учетную запись администратора, адрес электронной почты и пароль, чтобы настроить и продать свой магазин!</p>
            <a href="{{ route('login') }}"><button class="px-4 py-2 mt-6 text-black bg-white rounded">Войти</button></a>
        </div>
        <div class="flex flex-col justify-center w-1/2 p-10 bg-white">
            <h2 class="text-3xl font-bold">Регистрация</h2>
            <p class="mt-2">Открой справочник кинофильмов</p>
            <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class=" mb-4">
                                <input id="name" placeholder="Имя" type="text" class=" w-full px-4 py-2 border rounded form-control" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus >
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                        <div class=" mb-4">
                                <input id="email" type="email" placeholder="Email" class="w-full px-4 py-2 border rounded form-control" name="email" value="{{ old('email') }}" required autocomplete="email">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <input id="password" type="password" placeholder="Пароль" class=" w-full px-4 py-2 border rounded form-control" name="password" required autocomplete="new-password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <input id="password-confirm"  type="password" placeholder="Пароль подтвердите" class=" w-full px-4 py-2  border rounded form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                            <div class="mb-4">
                                <button type="submit" class="w-full px-4 py-2 text-white bg-black rounded">
                                    {{ __('Register') }}
                                </button>
                            </div>
                    </form>
        </div>
    </div>
</div>
                   