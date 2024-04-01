<?php

use Src\Route;

Route::add('GET', '/hello', [Controller\Site::class, 'hello'])
   ->middleware('auth'); 
Route::add(['GET', 'POST'], '/signup', [Controller\Site::class, 'signup']);
Route::add(['GET', 'POST'], '/login', [Controller\Site::class, 'login']);
Route::add('GET', '/logout', [Controller\Site::class, 'logout']);

Route::add(['GET', 'POST'], '/add_student', [Controller\Site::class, 'add_student'])
    ->middleware('auth');

    
Route::add(['GET','POST'], '/add_grup', [Controller\Site::class, 'add_grup'])
    ->middleware('auth');


Route::add(['GET','POST'], '/add_discipline', [Controller\Site::class, 'add_discipline'])
    ->middleware('auth');


Route::add(['GET','POST'], '/add_employee', [Controller\Site::class, 'add_employee'])
    ->middleware('auth');

Route::add('GET', '/grades', [Controller\Site::class, 'showGrades'])
    ->middleware('auth');

