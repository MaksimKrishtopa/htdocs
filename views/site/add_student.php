<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Student</title>
</head>
<body>
    <h1>Add Student</h1>
    <form method="post">
        <label for="surname">Surname:</label><br>
        <input type="text" id="surname" name="surname"><br>
        <label for="name">Name:</label><br>
        <input type="text" id="name" name="name"><br>
        <label for="patronymic">Patronymic:</label><br>
        <input type="text" id="patronymic" name="patronymic"><br>
        <label for="gender">Gender:</label><br>
        <input type="text" id="gender" name="gender"><br>
        <label for="birthday">Birthday:</label><br>
        <input type="text" id="birthday" name="birthday"><br>
        <label for="address">Address:</label><br>
        <input type="text" id="address" name="address"><br>
        <label for="grupa">Group:</label><br>
        <select id="grupa" name="grupa">
            <?php foreach ($groups as $group): ?>
                <option value="<?= $group->id_grupa ?>"><?= $group->grup_number ?></option>
            <?php endforeach; ?>
        </select><br><br>
        <input type="submit" value="Submit">
    </form>
</body>
</html>
