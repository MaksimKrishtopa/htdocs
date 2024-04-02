<?php

namespace Middlewares;

use Src\Auth\Auth;
use Src\Request;

class AdministratorMiddleware
{
    public function handle(Request $request)
    {
        $user = Auth::user();

        // Проверяем, является ли пользователь администратором
        if ($user && $user->role === 'administrator') {
            // Администратор имеет доступ только к главной странице и странице добавления декана
            return;
        }

        // Если пользователь не администратор, перенаправляем его на главную страницу
        app()->route->redirect('/hello');
    }
}
