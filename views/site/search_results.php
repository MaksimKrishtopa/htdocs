<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Результаты поиска</title>
    <!-- Ваши стили CSS -->
</head>
<body>
    <div class="card-list">
        <h2 class="page-title">Результаты поиска</h2>
        
        <?php if (isset($students) && $students->isNotEmpty()): ?>
            <h3 class="page-title">Студенты</h3>
            <?php foreach ($students as $student): ?>
                <div class="student-card">
                    <img src="<?= $student->avatar ?>" alt="Фотография студента">
                    <p class="card-item"><?= $student->surname . ' ' . $student->name . ' ' . $student->patronymic ?></p>

                    <!-- Форма добавления оценки -->
                    <form method="post" action="/add_grade">
                        <input name="csrf_token" type="hidden" value="<?= app()->auth::generateCSRF() ?>"/>
                        <input type="hidden" name="id_student" value="<?= $student->id ?>">
                        <label for="discipline">Выберите дисциплину:</label>
                        <select name="Id_grup-disc" id="discipline">
                            <?php foreach ($disciplines as $discipline): ?>
                                <option value="<?= $discipline->id_discipline ?>"><?= $discipline->discipline_name ?></option>
                            <?php endforeach; ?>
                        </select>
                        <label for="grade">Оценка:</label>
                        <input type="number" name="grades" id="grade" min="2" max="5">
                        <button type="submit">Добавить оценку</button>
                    </form>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="message">Студент не найден или введены некорректные данные</p>
        <?php endif; ?>
    </div>
</body>
</html>