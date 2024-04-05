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
use Src\Validator\Validator;
use Model\Grade;
class Site
{


    public function signup(Request $request): string
    {
        if ($request->method === 'POST') {
            $validator = new Validator($request->all(), [
                'name' => ['required'],
                'login' => ['required', 'unique:users,login'],
                'password' => ['required'],
                'role' => ['required', 'in:administrator,dekan'] 
            ], [
                'required' => 'Поле :field пусто',
                'unique' => 'Поле :field должно быть уникально',
                'in' => 'Выбрана недопустимая роль'
            ]);
    
            if ($validator->fails()) {
                return new View('site.signup', ['message' => json_encode($validator->errors(), JSON_UNESCAPED_UNICODE)]);
            }
    
            if (User::create($request->all())) {
                app()->route->redirect('/login');
            }
        }
        return new View('site.signup');
    }
    
    public function attachDiscipline(Request $request): string
    {
        // Проверяем, был ли отправлен POST-запрос
        if ($request->method === 'POST') {
            // Получаем данные из запроса
            $requestData = $request->all();
            $groupNumber = $requestData['grup_number'] ?? null; // Получаем номер группы
            $disciplineId = $requestData['id_discipline'] ?? null;
            $hours = $requestData['hours'] ?? null;
            $controlType = $requestData['control_type'] ?? null;
           
            // Проверяем, что все необходимые данные переданы
            if ($groupNumber !== null && $disciplineId !== null && $hours !== null && $controlType !== null) {
                
                    // Находим id группы по номеру группы
                    $group = Grupa::where('grup_number', $groupNumber)->first();
                    
                    // Проверяем, найдена ли группа
                    if ($group) {
                        // Создаем новую запись в таблице grup-disc
                        GrupDisc::create([
                            'id_grupa' => $group->id_grupa, // Используем найденный id группы
                            'id_discipline' => $disciplineId,
                            'hours' => $hours,
                            'control_type' => $controlType
                        ]);
    
                        // Перенаправляем пользователя после успешного добавления
                        app()->route->redirect('/hello');
                    }

            } else {
                echo "Ошибка: Не все данные переданы";
            }
        }
        
        // Возвращаем пустую строку в случае ошибки
        return '';
    }
    


    public function showGrades(Request $request): string
    {
        $grups = Grupa::all();
        $disciplines = Discipline::all();
        $students = Student::all();
        $controlTypes = GrupDisc::distinct('control_type')->pluck('control_type')->toArray();
    
        
        if ($request->method === 'POST') {
            
            $requestData = $request->all();
    
            
            $selectedGrupIds = $requestData['grup'] ?? [];
            $selectedDisciplineIds = $requestData['discipline'] ?? [];
            $selectedStudentIds = $requestData['student'] ?? [];
            $selectedControlType = $requestData['control'] ?? '';
            $selectedCourse = $requestData['course'] ?? '';
            $selectedSemester = $requestData['semester'] ?? '';
    
            // Фильтрация по выбранным критериям
            $gradesQuery = Grade::query();
            $gradesQuery->select('grade.*', 'grup-disc.hours', 'discipline.discipline_name')
                        ->join('grup-disc', 'grade.Id_grup-disc', '=', 'grup-disc.Id_grup-disc')
                        ->join('discipline', 'grup-disc.id_discipline', '=', 'discipline.id_discipline');
    
            if (!empty($selectedGrupIds)) {
                // Добавляем условие фильтрации по выбранным группам
                $gradesQuery->whereIn('grup-disc.id_grupa', $selectedGrupIds);
            }
            if (!empty($selectedDisciplineIds)) {
                // Добавляем условие фильтрации по выбранным дисциплинам
                $gradesQuery->whereIn('grup-disc.Id_grup-disc', function ($query) use ($selectedDisciplineIds) {
                    $query->select('grup-disc.Id_grup-disc')
                          ->from('grup-disc')
                          ->whereIn('grup-disc.id_discipline', $selectedDisciplineIds);
                });
            }
            if (!empty($selectedStudentIds)) {
                // Добавляем условие фильтрации по выбранным студентам
                $gradesQuery->whereIn('id_student', $selectedStudentIds);
            }
            if (!empty($selectedControlType)) {
                // Добавляем условие фильтрации по выбранному виду контроля
                $gradesQuery->whereIn('grup-disc.Id_grup-disc', function ($query) use ($selectedControlType) {
                    $query->select('grup-disc.Id_grup-disc')
                          ->from('grup-disc')
                          ->where('grup-disc.control_type', $selectedControlType);
                });
            }
            if (!empty($selectedCourse)) {
                // Добавляем условие фильтрации по выбранному курсу
                // (предположим, что курс указывается в таблице grupa)
                $gradesQuery->whereHas('student.group', function ($query) use ($selectedCourse) {
                    $query->where('course', $selectedCourse);
                });
            }
            if (!empty($selectedSemester)) {
                // Добавляем условие фильтрации по выбранному семестру
                // (предположим, что семестр указывается в таблице grupa)
                $gradesQuery->whereHas('student.group', function ($query) use ($selectedSemester) {
                    $query->where('semester', $selectedSemester);
                });
            }
    
            // Получаем оценки с учетом фильтров
            $grades = $gradesQuery->get();
    
            // Получаем данные о дисциплине (или массив данных) из таблицы grup-disc
            $disciplineData = GrupDisc::whereIn('Id_grup-disc', $grades->pluck('Id_grup-disc'))->get();
    
            // Передаем данные о дисциплине (или массив данных) в представление
            return new View('site.grades', [
                'grups' => $grups,
                'disciplines' => $disciplines,
                'students' => $students,
                'grades' => $grades,
                'controlTypes' => $controlTypes,
                'disciplineData' => $disciplineData,
            ]);
        }
    
        // Если запрос не был отправлен методом POST, просто возвращаем пустое представление с фильтрами
        return new View('site.grades', [
            'grups' => $grups,
            'disciplines' => $disciplines,
            'students' => $students,
            'grades' => [],
            'controlTypes' => $controlTypes,
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
    public function add_grade(Request $request): string
    {
        // Проверяем, был ли отправлен POST-запрос
        if ($request->method === 'POST') {
            // Получаем данные из запроса
            $requestData = $request->all();
    
            // Проверяем, есть ли обязательные данные
            if (isset($requestData['id_student'], $requestData['Id_grup-disc'], $requestData['grades'])) {
                // Создаем запись оценки в таблице grade
                if (Grade::create($requestData)) {
                    // Перенаправляем пользователя после успешного добавления оценки
                    app()->route->redirect('/search');
                }
            } else {
                // Возвращаем сообщение об ошибке, если не все данные были переданы
                return 'Ошибка: Не все данные переданы';
            }
        }
    
        // Возвращаем пустую строку в случае ошибки
        return '';
    }
    public function add_student(Request $request): string
    {
        $groups = Grupa::all();
        
        if ($request->method === 'POST') {
           
            if (!empty($_FILES['avatar'])) {
                
                $avatar = $_FILES['avatar'];
                
                
                if ($avatar['error'] === UPLOAD_ERR_OK) {
                    
                    $tmpFilePath = $avatar['tmp_name'];
                    
                   
                    $avatarFileName = uniqid() . '_' . $avatar['name'];
                    
                    
                    $targetFilePath = 'images/' . $avatarFileName;
                    move_uploaded_file($tmpFilePath, $targetFilePath);
                    

                } else {
                   
                    return "Ошибка при загрузке файла: " . $avatar['error'];
                }
            } else {
                
                return "Ошибка: Файл изображения не был загружен.";
            }
            
            
            $requestData = [
                'surname' => $request->get('surname'),
                'name' => $request->get('name'),
                'patronymic' => $request->get('patronymic'),
                'gender' => $request->get('gender'),
                'birthday' => $request->get('birthday'),
                'address' => $request->get('address'),
                'grupa' => $request->get('grupa'),
                'avatar' => $targetFilePath, 
            ];
    
           
            if (Student::create($requestData)) {
                
                app()->route->redirect('/hello');
            }
        }
        
        return new View('site.add_student', ['groups' => $groups]);
    }

    public function search(): string
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $query = $_POST['name'] ?? '';
    
            
            $students = Student::where('name', '=', $query)
                                ->orWhere('surname', '=', $query)
                                ->orWhere('patronymic', '=', $query)
                                ->get();
    
            if ($students->isNotEmpty()) {
                return (new View())->render('site.search_results', ['students' => $students]);
            } else {
                return (new View())->render('site.search_results', ['message' => 'Студент отсутствует или введены некорректные данные']);
            }
        }
    
        return '';
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

    


    public function hello(Request $request): string
    {
        $students = Student::all();
        $groups = Grupa::all();
        $disciplines = Discipline::all();
        
        
        if ($request->method === 'POST' && $request->input('search') === '1') {
            
            $query = $request->input('query');
            $searchedStudents = Student::where('name', 'like', "%$query%")
                                        ->orWhere('surname', 'like', "%$query%")
                                        ->orWhere('patronymic', 'like', "%$query%")
                                        ->get();
            
            return (new View())->render('site.search_results', ['students' => $searchedStudents]);
        }
        
       
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
