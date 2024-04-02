<?php

namespace Middlewares;

use Src\Auth\Auth;
use Src\Request;

class DekanMiddleware
{
    public function handle(Request $request)
    {
        $user = Auth::user();

        // Проверяем, является ли пользователь деканом
        if ($user && $user->role === 'dekan') {
            // Декан имеет доступ к страницам добавления студента, группы, дисциплины и успеваемости
            return;
        }

        // Если пользователь не декан, перенаправляем его на главную страницу
        app()->route->redirect('/hello');
    }
}
