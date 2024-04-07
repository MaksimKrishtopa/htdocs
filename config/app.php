<?php

return [

   'auth' => \Src\Auth\Auth::class,

   'identity' => \Model\User::class,

   'routeMiddleware' => [
       'auth' => \Middlewares\AuthMiddleware::class,
       'dekan' => \Middlewares\DekanMiddleware::class, 
       'administrator' => \Middlewares\AdministratorMiddleware::class, 
   ],
   
   'routeAppMiddleware' => [
    'csrf' => \Middlewares\CSRFMiddleware::class,
    'trim' => \Middlewares\TrimMiddleware::class,
    'specialChars' => \Middlewares\SpecialCharsMiddleware::class,
 ],
 
 

 'validators' => [
    'required' => \Validators\RequireValidator::class,
    'unique' => \Validators\UniqueValidator::class,
    'gender' => \Validators\GenderValidator::class,
    'birthday' => \Validators\BirthdayFormatValidator::class,
    'grup_number' => \Validators\GroupNumberValidator::class,
    
]
];
