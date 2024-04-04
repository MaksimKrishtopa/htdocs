<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Details</title>
</head>
<body>
    <?php if (!empty($student)): ?>
        <h1>Информация о студенте</h1>
        <p>Фотография: <img src="<?= $student->photo ?>" alt="avatar"></p>
        <p>Фамилия: <?= $student->surname ?></p>
        <p>Имя: <?= $student->name ?></p>
        <p>Отчество: <?= $student->patronymic ?></p>
        <!-- Добавьте другие поля, такие как группа, пол и т. д. -->
    <?php else: ?>
        <p>Студент не найден</p>
    <?php endif; ?>
</body>
</html>