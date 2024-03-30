<?php

namespace Controller;

use Model\Post;
use Src\View;
use Src\Request;
use Model\User;
use Src\Auth\Auth;
use Model\Grupa;
use Model\Student;
use Model\Discipline;


class Site
{

    private function checkUserRole(): string
    {
        $role = Auth::user()->role;

        switch ($role) {
            case 'dekan':
                return 'dekan';
            case 'administrator':
                return 'administrator';
            default:
                return 'default';
        }
    }

    public function add_student(Request $request): string
    {
        if ($request->method === 'POST' && Student::create($request->all())) {
            app()->route->redirect('/hello');
    
        }
       
        return new View('site.add_student');
    }
    
    
    public function add_grup(Request $request): string
    {
        if ($request->method === 'POST' && Grupa::create($request->all())) {
            app()->route->redirect('/hello');
        }
       
        return new View('site.add_grup');
    }
    
    public function add_discipline(Request $request): string
    {
        if ($request->method === 'POST' && Discipline::create($request->all())) {
            app()->route->redirect('/hello');
        }
       
        return new View('site.add_discipline');
    }

    public function add_employee(Request $request): string
    {
        if ($this->checkUserRole() !== 'administrator') {
            return 'Доступ запрещен';
        }
    
        if ($request->method === 'POST' && User::create($request->all())) {
            app()->route->redirect('/hello');
        }
    
   
        return new View('site.add_employee');
    }

    


    public function hello(): string
    {
        
        $students = Student::all();
    
       
        $groups = Grupa::all();

        $disciplines = Discipline::all();
    
        
        return (new View())->render('site.student', ['students' => $students, 'groups' => $groups, 'disciplines' => $disciplines]);
    }

   
//    public function signup(Request $request): string
//    {
//       if ($request->method === 'POST' && User::create($request->all())) {
//           app()->route->redirect('/go');
//       }
//       return new View('site.signup');
//    }
   
    public function login(Request $request): string
    {
    //Если просто обращение к странице, то отобразить форму
    if ($request->method === 'GET') {
        return new View('site.login');
    }
    //Если удалось аутентифицировать пользователя, то редирект
    if (Auth::attempt($request->all())) {
        app()->route->redirect('/hello');
    }
    //Если аутентификация не удалась, то сообщение об ошибке
    return new View('site.login', ['message' => 'Неправильные логин или пароль']);
    }

    public function logout(): void
    {
    Auth::logout();
    app()->route->redirect('/hello');
    }


}
