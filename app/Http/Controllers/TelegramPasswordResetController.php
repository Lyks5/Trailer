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
        $this->telegram = new Api('YOUR_BOT_TOKEN'); // Замените на ваш токен бота
    }

    /**
     * Обработка вебхука от Telegram.
     */
    public function handleWebhook(Request $request)
    {
        $update = $request->all(); // Получаем данные от Telegram

        // Проверяем, что это текстовое сообщение
        if (isset($update['message']['text'])) {
            $chatId = $update['message']['chat']['id']; // ID чата
            $text = $update['message']['text']; // Текст сообщения

            // Обрабатываем команду /start
            if ($text === '/start') {
                $this->sendMessage($chatId, 'Привет! Введите вашу почту для сброса пароля.');
            } elseif (filter_var($text, FILTER_VALIDATE_EMAIL)) {
                // Если пользователь ввел email
                $this->processEmail($chatId, $text);
            } else {
                // Если введено что-то другое
                $this->sendMessage($chatId, 'Пожалуйста, введите корректный email.');
            }
        }

        return response()->json(['status' => 'ok']);
    }

    /**
     * Обработка email и отправка кода.
     */
    private function processEmail($chatId, $email)
    {
        // Проверяем, существует ли пользователь с таким email
        $user = User::where('email', $email)->first();

        if (!$user) {
            $this->sendMessage($chatId, 'Пользователь с таким email не найден.');
            return;
        }

        // Генерируем код для сброса пароля
        $code = rand(100000, 999999);

        // Сохраняем код в базе данных
        $user->reset_code = $code;
        $user->save();

        // Отправляем код пользователю через Telegram
        $this->sendMessage($chatId, "Ваш код для сброса пароля: $code");
    }

    /**
     * Отправка сообщения через Telegram.
     */
    private function sendMessage($chatId, $text)
    {
        $this->telegram->sendMessage([
            'chat_id' => $chatId,
            'text' => $text,
        ]);
    }

    /**
     * Проверка кода для сброса пароля.
     */
    public function verifyCode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $code = $request->input('code');

        // Проверяем, существует ли пользователь с таким кодом
        $user = User::where('reset_code', $code)->first();

        if (!$user) {
            return back()->withErrors(['code' => 'Неверный код'])->withInput();
        }

        // Удаляем код из базы данных
        $user->reset_code = null;
        $user->save();

        // Сохраняем email в сессии для дальнейшего использования
        $request->session()->put('reset_email', $user->email);

        // Перенаправляем на страницу для ввода нового пароля
        return back()->with('status', 'Код подтвержден. Введите новый пароль.');
    }

    /**
     * Сброс пароля.
     */
    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required|confirmed|min:8',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $email = $request->session()->get('reset_email');
        $user = User::where('email', $email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Пользователь не найден'])->withInput();
        }

        // Обновляем пароль
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        // Удаляем email из сессии
        $request->session()->forget('reset_email');

        return redirect()->route('home')->with('status', 'Пароль успешно изменен.');
    }
}