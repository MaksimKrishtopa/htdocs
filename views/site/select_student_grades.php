<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Student Grades</title>
</head>
<body>
    <h1>Select Student Grades</h1>
    <form method="POST" action="<?= app()->route->getUrl('/save_student_grades') ?>">
        <label for="student">Select Student:</label><br>
        <select id="student" name="student">
            <?php foreach ($students as $student): ?>
                <option value="<?= $student->id_student ?>"><?= $student->surname ?> <?= $student->name ?></option>
            <?php endforeach; ?>
        </select><br><br>
        <label for="discipline">Select Discipline:</label><br>
        <select id="discipline" name="discipline">
            <?php foreach ($disciplines as $discipline): ?>
                <option value="<?= $discipline->id_discipline ?>"><?= $discipline->discipline_name ?></option>
            <?php endforeach; ?>
        </select><br><br>
        <label for="grade">Grade:</label><br>
        <input type="text" id="grade" name="grade"><br><br>
        <input type="submit" value="Save Grades">
    </form>
</body>
</html>
