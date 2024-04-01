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
use Model\GrupDisc; 


class Site
{

    public function showGrades(Request $request): string
    {
        // Получаем список всех групп, дисциплин и студентов
        $grups = Grupa::all();
        $disciplines = Discipline::all();
        $students = Student::all();
    
        // Если была отправлена форма с выбранными параметрами
        if ($request->method === 'POST') {
            // Получаем выбранные параметры из формы
            $selectedGrupId = $request->body['grup']; // Исправлено
            $selectedDisciplineId = $request->body['discipline']; // Исправлено
            $selectedStudentId = $request->body['student']; // Исправлено
    
            // Получаем информацию о выбранном студенте
            $selectedStudent = Student::find($selectedStudentId);
    
            // Получаем оценки выбранного студента по выбранной дисциплине
            $grades = Grade::where('id_student', $selectedStudentId)
                           ->where('id_grup-disc', $selectedDisciplineId)
                           ->get();
    
            // Возвращаем представление для отображения успеваемости студента
            return new View('site.grades', [
                'grups' => $grups,
                'disciplines' => $disciplines,
                'students' => $students,
                'selectedStudent' => $selectedStudent,
                'grades' => $grades
            ]);
        }
    
        // Если запрос не был отправлен методом POST или если не были выбраны параметры,
        // возвращаем представление с пустыми данными
        return new View('site.grades', [
            'grups' => $grups,
            'disciplines' => $disciplines,
            'students' => $students,
            'selectedStudent' => null,
            'grades' => []
        ]);
    }

    // public function selectStudentGrades(Request $request): string
    // {
    //     $students = Student::all();
    //     $disciplines = Discipline::all();

    //     return (new View())->render('site.select_student_grades', ['students' => $students, 'disciplines' => $disciplines]);
    // }

    // // Метод для сохранения успеваемости студентов по дисциплинам
    // public function saveStudentGrades(Request $request): string
    // {
    //     $data = $request->all();

    //     // Ваша логика сохранения успеваемости студентов по дисциплинам

    //     return "Успеваемость студентов успешно сохранена.";
    // }

    // // Метод для отображения формы выбора успеваемости студентов по группам и дисциплинам
    // public function selectGroupGrades(Request $request): string
    // {
    //     $grupDiscs = GrupDisc::all();
    //     $disciplines = Discipline::all();

    //     return (new View())->render('site.select_group_grades', ['grupDiscs' => $grupDiscs, 'disciplines' => $disciplines]);
    // }

    // // Метод для сохранения успеваемости студентов по группам и дисциплинам
    // public function saveGroupGrades(Request $request): string
    // {
    //     $data = $request->all();

    //     // Ваша логика сохранения успеваемости студентов по группам и дисциплинам

    //     return "Успеваемость студентов по группам и дисциплинам успешно сохранена.";
    // }


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
        $groups = Grupa::all();
        if ($request->method === 'POST' && Student::create($request->all())) {
            app()->route->redirect('/hello');
    
        }
       
        
        // Возвращаем представление для добавления студента, передавая список существующих групп
        return new View('site.add_student', ['groups' => $groups]);
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
