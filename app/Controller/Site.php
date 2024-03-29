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
use Model\Grade;

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

    public function addStudent(Request $request): string
    {
        $student = new Student();
        $student->surname = $request->input('surname');
        $student->name = $request->input('name');
        $student->patronomic = $request->input('patronomic');
        $student->gender = $request->input('gender');
        $student->birthday = $request->input('birthday');
        $student->address = $request->input('address');
        $student->grupa = $request->input('grupa');
        $student->save();

        return 'Студент успешно добавлен.';
    }

    // Метод для добавления группы
    public function addGroup(Request $request): string
    {
        $group = new Grupa();
        $group->grup_number = $request->input('grup_number');
        $group->course = $request->input('course');
        $group->semester = $request->input('semester');
        $group->save();

        return 'Группа успешно добавлена.';
    }

    // Метод для добавления дисциплины
    public function addDiscipline(Request $request): string
    {
        $discipline = new Discipline();
        $discipline->discipline_name = $request->input('discipline_name');
        $discipline->save();

        return 'Дисциплина успешно добавлена.';
    }

    // Метод для добавления сотрудника (декана)
    public function addEmployee(Request $request): string
    {
        $user = new User();
        $user->name = $request->input('name');
        $user->login = $request->input('login');
        $user->password = $request->input('password');
        $user->role = $request->input('role');
        $user->save();

        return 'Сотрудник успешно добавлен.';
    }

    


    public function hello(): string
    {
        // Получаем список всех студентов
        $students = Student::all();
    
        // Получаем список всех групп
        $groups = Grupa::all();

        $disciplines = Discipline::all();
    
        // Возвращаем представление, передавая списки студентов и групп
        return (new View())->render('site.student', ['students' => $students, 'groups' => $groups, 'disciplines' => $disciplines]);
    }

   
   public function signup(Request $request): string
   {
      if ($request->method === 'POST' && User::create($request->all())) {
          app()->route->redirect('/go');
      }
      return new View('site.signup');
   }
   
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
