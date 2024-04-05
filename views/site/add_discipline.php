<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Discipline</title>
</head>
<body>
    <h1>Добавление дисциплины</h1>
    <form method="POST">
    <input name="csrf_token" type="hidden" value="<?= app()->auth::generateCSRF() ?>"/>
        <label for="discipline_name">Discipline Name:</label><br>
        <input type="text" id="discipline_name" name="discipline_name"><br><br>
        <input type="submit" value="Submit">
    </form>
</body>
</html>
