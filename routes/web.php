<?php

use Src\Route;

Route::add('GET', '/hello', [Controller\Site::class, 'hello'])
   ->middleware('auth');

Route::add(['GET', 'POST'], '/signup', [Controller\Site::class, 'signup']);


Route::add(['GET', 'POST'], '/login', [Controller\Site::class, 'login']);
Route::add(['GET', 'POST'], '/', [Controller\Site::class, 'login']);

Route::add('GET', '/logout', [Controller\Site::class, 'logout']);

Route::add(['GET','POST'], '/add_student', [Controller\Site::class, 'add_student'])
    ->middleware('auth');

Route::add(['GET','POST'], '/add_grup', [Controller\Site::class, 'add_grup'])
    ->middleware('auth', 'dekan');

Route::add(['GET','POST'], '/add_discipline', [Controller\Site::class, 'add_discipline'])
    ->middleware('auth', 'dekan');

Route::add(['GET','POST'], '/add_employee', [Controller\Site::class, 'add_employee'])
    ->middleware('auth', 'administrator');

Route::add(['GET', 'POST'], '/grades', [Controller\Site::class, 'showGrades'])
    ->middleware('auth', 'dekan');


Route::add('POST', '/attach_discipline', [Controller\Site::class, 'attachDiscipline'])
    ->middleware('auth', 'dekan');

Route::add(['GET', 'POST'], '/search', [Controller\Site::class, 'search'])
    ->middleware('auth', 'dekan');

Route::add(['GET', 'POST'], '/add_grade', [Controller\Site::class, 'add_grade'])
    ->middleware('auth', 'dekan');

