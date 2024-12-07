<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Telegram\Bot\Api;

class TelegramPasswordResetController extends Controller
{
    protected $telegram;

    public function __construct()
    {
        $this->telegram = new Api('7905536979:AAHZXb45rHvPkdpOVsj2vIjWb-8f0KEmCkA');
    }

    public function showResetForm()
    {
        return view('dashboard');
    }

    public function sendResetCode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = User::where('email', $request->email)->first();
        $code = rand(100000, 999999); // Генерация случайного кода

        // Отправка кода через Telegram
        $this->telegram->sendMessage([
            'chat_id' => $user->telegram_chat_id, // Предположим, что у вас есть поле telegram_chat_id в таблице users
            'text' => "Ваш код для сброса пароля: $code",
        ]);

        // Сохранение кода в сессии
        $request->session()->put('reset_code', $code);
        $request->session()->put('reset_email', $request->email);

        return back()->with('status', 'Код для сброса пароля отправлен в Telegram.');
    }

    public function verifyCode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $sessionCode = $request->session()->get('reset_code');
        $sessionEmail = $request->session()->get('reset_email');

        if ($request->code == $sessionCode) {
            $request->session()->forget('reset_code');
            $request->session()->forget('reset_email');

            return back()->with('status', 'Код подтвержден. Введите новый пароль.');
        } else {
            return back()->withErrors(['code' => 'Неверный код'])->withInput();
        }
    }

    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required|confirmed|min:8',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = User::where('email', $request->session()->get('reset_email'))->first();

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('home')->with('status', 'Пароль успешно изменен.');
    }
}   