<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Analytic;

class TrackPageViews
{
    public function handle(Request $request, Closure $next)
    {
        // Регистрируем событие просмотра страницы
        if (auth()->check()) {
            // Регистрируем событие просмотра страницы
            Analytic::create([
                'event_type' => 'page_view',
                'url' => $request->fullUrl(),
                'user_id' => auth()->id(), // ID аутентифицированного пользователя
            ]);
        }
        return $next($request);
    }
}

