<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthenticatedSessionController extends Controller
{
    use Laravel\Socialite\Facades\Socialite;
    use Str;   

   public function yandex() // перенаправляем юзера на яндекс Auth
    {
        return Socialite::driver('yandex')->redirect();
    }

    public function yandexRedirect() // принимаем возвращаемые данные и работаем с ними
    {
        $user = Socialite::driver('yandex')->user();

        $user = User::firstOrCreate([ // используем firstOrCreate для проверки есть ли такие пользователи в нашей БД
            'email' => $user->email
        ], [
            'name' => $user->user['display_name'], // display_name - переменаая хранящая полное ФИО пользователя
                                                  // остальные переменные можете посмотреть использовав $dd('$user')
            'password' => Hash::make(Str::random(24)),
        ]);

        Auth::login($user, true);

        redirect()->route('main');
    }
}
