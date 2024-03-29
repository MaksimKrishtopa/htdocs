<?php

use Src\Route;

Route::add('GET', '/hello', [Controller\Site::class, 'hello'])
   ->middleware('auth');
Route::add(['GET', 'POST'], '/signup', [Controller\Site::class, 'signup']);
Route::add(['GET', 'POST'], '/login', [Controller\Site::class, 'login']);
Route::add('GET', '/logout', [Controller\Site::class, 'logout']);
// Маршрут для страницы добавления студента
Route::add('GET', '/add_student', [Controller\Site::class, 'add_student'])
    ->middleware('auth');

// Маршрут для страницы добавления группы
Route::add('GET', '/addGroup', [Controller\Site::class, 'addGroup'])
    ->middleware('auth');

// Маршрут для страницы добавления дисциплины
Route::add('GET', '/addDiscipline', [Controller\Site::class, 'addDiscipline'])
    ->middleware('auth');

// Маршрут для страницы добавления сотрудника (декана)
Route::add('GET', '/addEmployee', [Controller\Site::class, 'addEmployee'])
    ->middleware('auth');
