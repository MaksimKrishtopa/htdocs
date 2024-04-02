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
        $grups = Grupa::all();
        $disciplines = Discipline::all();
        $students = Student::all();
    
        
        $controlTypes = GrupDisc::distinct('control_type')->pluck('control_type')->toArray();
    
        if ($request->method === 'POST') {
            $selectedGrupId = $request->body['grup'];
            $selectedDisciplineId = $request->body['discipline'];
            $selectedStudentId = $request->body['student'];
    
            $selectedStudent = Student::find($selectedStudentId);
    
            $grades = Grade::where('id_student', $selectedStudentId)
                           ->where('id_grup-disc', $selectedDisciplineId)
                           ->get();
    
            return new View('site.grades', [
                'grups' => $grups,
                'disciplines' => $disciplines,
                'students' => $students,
                'selectedStudent' => $selectedStudent,
                'grades' => $grades,
                'controlTypes' => $controlTypes  
            ]);
        }
    
        return new View('site.grades', [
            'grups' => $grups,
            'disciplines' => $disciplines,
            'students' => $students,
            'selectedStudent' => null,
            'grades' => [],
            'controlTypes' => $controlTypes  
        ]);
    }


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


   
    public function login(Request $request): string
    {

    if ($request->method === 'GET') {
        return new View('site.login');
    }

    if (Auth::attempt($request->all())) {
        app()->route->redirect('/hello');
    }

    return new View('site.login', ['message' => 'Неправильные логин или пароль']);
    }

    public function logout(): void
    {
    Auth::logout();
    app()->route->redirect('/hello');
    }


}
