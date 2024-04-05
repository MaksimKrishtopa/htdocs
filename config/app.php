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
   ],
   
   'routeAppMiddleware' => [
    'csrf' => \Middlewares\CSRFMiddleware::class,
    'trim' => \Middlewares\TrimMiddleware::class,
    'specialChars' => \Middlewares\SpecialCharsMiddleware::class,
 ],
 
 

   'validators' => [
    'required' => \Validators\RequireValidator::class,
    'unique' => \Validators\UniqueValidator::class,
    'gender' => Validators\GenderValidator::class,
    'date_of_birth' => Validators\DateOfBirthValidator::class,
    'uppercase' => Validators\UppercaseValidator::class,
    'group_number' => Validators\GroupNumberValidator::class
    ]
];
