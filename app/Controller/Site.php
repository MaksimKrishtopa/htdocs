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
        
        if ($request->method === 'POST') {
           
            $requestData = $request->all();
            $groupNumber = $requestData['grup_number'] ?? null; 
            $disciplineId = $requestData['id_discipline'] ?? null;
            $hours = $requestData['hours'] ?? null;
            $controlType = $requestData['control_type'] ?? null;
           
           
            if ($groupNumber !== null && $disciplineId !== null && $hours !== null && $controlType !== null) {
                
                   
                    $group = Grupa::where('grup_number', $groupNumber)->first();
                    
                   
                    if ($group) {
                        
                        GrupDisc::create([
                            'id_grupa' => $group->id_grupa, 
                            'id_discipline' => $disciplineId,
                            'hours' => $hours,
                            'control_type' => $controlType
                        ]);
    
                        
                        app()->route->redirect('/hello');
                    }

            } else {
                echo "Ошибка: Не все данные переданы";
            }
        }
        
        
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
    
           
            $gradesQuery = Grade::query();
            $gradesQuery->select('grade.*', 'grup-disc.hours', 'discipline.discipline_name')
                        ->join('grup-disc', 'grade.Id_grup-disc', '=', 'grup-disc.Id_grup-disc')
                        ->join('discipline', 'grup-disc.id_discipline', '=', 'discipline.id_discipline');
    
            if (!empty($selectedGrupIds)) {
                
                $gradesQuery->whereIn('grup-disc.id_grupa', $selectedGrupIds);
            }
            if (!empty($selectedDisciplineIds)) {
                
                $gradesQuery->whereIn('grup-disc.Id_grup-disc', function ($query) use ($selectedDisciplineIds) {
                    $query->select('grup-disc.Id_grup-disc')
                          ->from('grup-disc')
                          ->whereIn('grup-disc.id_discipline', $selectedDisciplineIds);
                });
            }
            if (!empty($selectedStudentIds)) {
                
                $gradesQuery->whereIn('id_student', $selectedStudentIds);
            }
            if (!empty($selectedControlType)) {
               
                $gradesQuery->whereIn('grup-disc.Id_grup-disc', function ($query) use ($selectedControlType) {
                    $query->select('grup-disc.Id_grup-disc')
                          ->from('grup-disc')
                          ->where('grup-disc.control_type', $selectedControlType);
                });
            }
            if (!empty($selectedCourse)) {

                $gradesQuery->whereHas('student.group', function ($query) use ($selectedCourse) {
                    $query->where('course', $selectedCourse);
                });
            }
            if (!empty($selectedSemester)) {

                $gradesQuery->whereHas('student.group', function ($query) use ($selectedSemester) {
                    $query->where('semester', $selectedSemester);
                });
            }
    

            $grades = $gradesQuery->get();

            $disciplineData = GrupDisc::whereIn('Id_grup-disc', $grades->pluck('Id_grup-disc'))->get();
    

            return new View('site.grades', [
                'grups' => $grups,
                'disciplines' => $disciplines,
                'students' => $students,
                'grades' => $grades,
                'controlTypes' => $controlTypes,
                'disciplineData' => $disciplineData,
            ]);
        }
    

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
    if ($request->method === 'POST') {
        


        $requestData = $request->all();
        $disciplineId = $requestData['id_discipline'] ?? null;
        
        if (isset($requestData['id_student'], $requestData['id_discipline'], $requestData['grades'])) {
            
            $discipline = Discipline::find($requestData['id_discipline']);

           
            
            
            if ($discipline) {
                
                $grupDisc = GrupDisc::where('id_discipline', $requestData['id_discipline'])
                ->where('id_grupa', $requestData['id_grupa']) 
                ->first();
            
                if ($grupDisc) {
                
                    if (Grade::create([
                        'id_student' => $requestData['id_student'],
                        'Id_grup-disc' => $grupDisc->{'Id_grup-disc'},
                        'grades' => $requestData['grades']
                    ])) {
                        app()->route->redirect('/hello');
                    } else {
                        return 'Ошибка: Не удалось добавить оценку';
                    }
                } else {
                    return 'Ошибка: Не удалось найти запись о дисциплине в группе';
                }
            } else {
                return 'Ошибка: Не удалось найти дисциплину';
            }
        } else {
            return 'Ошибка: Не все данные переданы';
        }
    }
    return '';
}

public function add_student(Request $request): string
{
    $groups = Grupa::all();
    
    if ($request->method === 'POST') {

        $validator = new Validator($request->all(), [
            'name' => ['required'],
            'gender' => ['required', 'gender'],
            'birthday' => ['required', 'birthday']

        ], [
            'required' => 'Поле :field пусто',
            'gender' => ':должен быть только М или Ж',
            'birthday' => ':дата рождения должна быть в формате гггг-мм-дд'
        ]);

        // Проверяем, прошла ли валидация успешно
        if ($validator->fails()) {
            // Если валидация не удалась, возвращаем представление с сообщениями об ошибках
            return new View('site.add_student', [
                'groups' => $groups,
                'message' => json_encode($validator->errors(), JSON_UNESCAPED_UNICODE)
            ]);
        }
       
        // После успешной валидации продолжаем обработку данных и добавление студента

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

        // Добавляем студента в базу данных
        if (Student::create($requestData)) {
            
            app()->route->redirect('/hello');
        } else {
            // В случае ошибки при добавлении студента, возвращаем сообщение об ошибке
            return 'Ошибка: Не удалось добавить студента';
        }
    }
    
    // Возвращаем представление с формой добавления студента
    return new View('site.add_student', ['groups' => $groups]);
}

    public function search(): string
    {
        $disciplines = Discipline::all(); 
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $query = $_POST['name'] ?? '';
        
            $students = Student::where('name', '=', $query)
                                ->orWhere('surname', '=', $query)
                                ->orWhere('patronymic', '=', $query)
                                ->get();
        
            if ($students->isNotEmpty()) {
                return (new View())->render('site.search_results', [
                    'students' => $students,
                    'disciplines' => $disciplines,
                ]);
            } else {
                return (new View())->render('site.search_results', [
                    'students' => $students,
                    'disciplines' => $disciplines,
                ]);
            }
        }
    
        return '';
    }
        
    
    public function add_grup(Request $request): string
    {
        if ($request->method === 'POST') {
            // Создаем валидатор для проверки номера группы
            $validator = new Validator($request->all(), [
                'grup_number' => ['required', 'grup_number'], // Используем новый валидатор для проверки номера группы
            ], [
                'required' => 'Поле :field пусто',
                'grup_number' => 'Номер группы должен содержать ровно 3 цифры',
            ]);
    
            // Проверяем, прошла ли валидация успешно
            if ($validator->fails()) {
                // Если валидация не удалась, возвращаем представление с сообщениями об ошибках
                return new View('site.add_grup', [
                    'message' => json_encode($validator->errors(), JSON_UNESCAPED_UNICODE)
                ]);
            }
            
            // Добавляем валидацию на уникальность номера группы
            $uniqueValidator = new Validator($request->all(), [
                'grup_number' => ['unique:grupa,grup_number'], // Используем ваш валидатор для проверки уникальности номера группы в таблице 
            ], [
                'unique' => 'Номер группы уже существует', // Сообщение об ошибке, если номер группы не уникален
            ]);
    
            // Проверяем, прошла ли валидация успешно
            if ($uniqueValidator->fails()) {
                // Если валидация не удалась, возвращаем представление с сообщениями об ошибках
                return new View('site.add_grup', [
                    'message' => json_encode($uniqueValidator->errors(), JSON_UNESCAPED_UNICODE)
                ]);
            }
            
            // Если валидация прошла успешно и создание группы также успешно, перенаправляем на страницу приветствия
            if (Grupa::create($request->all())) {
                app()->route->redirect('/hello');
            }
        }
    
        // Если запрос не POST или создание группы не удалось, возвращаем представление для добавления группы
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
