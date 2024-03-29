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
        // Создаем новый объект студента
        $student = new Student();
    
        // Устанавливаем данные студента из запроса
        $data = $request->all();
        $student->surname = $data['surname'] ?? '';
        $student->name = $data['name'] ?? '';
        $student->patronymic = $data['patronymic'] ?? '';
        $student->gender = $data['gender'] ?? '';
        $student->birthday = $data['birthday'] ?? '';
        $student->address = $data['address'] ?? '';
        $student->grupa = $data['grupa'] ?? '';
    
        // Сохраняем студента в базе данных
        $student->save();
    
        // Возвращаем сообщение об успешном добавлении
        return new View('site.add_student');
    }

    // Метод для добавления группы
    public function addGroup(Request $request): string
    {
        // Создаем новый объект группы
        $group = new Grupa();

        // Устанавливаем данные группы из запроса
        $group->grup_number = $request->get('grup_number');
        $group->course = $request->get('course');
        $group->semester = $request->get('semester');

        // Сохраняем группу в базе данных
        $group->save();

        // Возвращаем сообщение об успешном добавлении
        return 'Группа успешно добавлена.';
    }

    // Метод для добавления дисциплины
    public function addDiscipline(Request $request): string
    {
        // Создаем новый объект дисциплины
        $discipline = new Discipline();

        // Устанавливаем данные дисциплины из запроса
        $discipline->discipline_name = $request->get('discipline_name');

        // Сохраняем дисциплину в базе данных
        $discipline->save();

        // Возвращаем сообщение об успешном добавлении
        return 'Дисциплина успешно добавлена.';
    }

    // Метод для добавления сотрудника (декана)
    public function addEmployee(Request $request): string
    {
        // Создаем новый объект сотрудника
        $employee = new User();

        // Устанавливаем данные сотрудника из запроса
        $employee->name = $request->get('name');
        $employee->login = $request->get('login');
        $employee->password = $request->get('password');
        $employee->role = 'dekan'; // Устанавливаем роль "декан"

        // Сохраняем сотрудника в базе данных
        $employee->save();

        // Возвращаем сообщение об успешном добавлении
        return 'Сотрудник (декан) успешно добавлен.';
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
