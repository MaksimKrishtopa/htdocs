<?php

return [
   //Класс аутентификации
   'auth' => \Src\Auth\Auth::class,
   //Класс пользователя
   'identity' => \Model\User::class,
   //Классы для middleware
   'routeMiddleware' => [
       'auth' => \Middlewares\AuthMiddleware::class,
       'dekan' => \Middlewares\DekanMiddleware::class, // Добавляем middleware для декана
       'administrator' => \Middlewares\AdministratorMiddleware::class, // Добавляем middleware для администратора
   ]
];
