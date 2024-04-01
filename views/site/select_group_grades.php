<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Group Grades</title>
</head>
<body>
    <h1>Select Group Grades</h1>
    <form method="POST" action="<?= app()->route->getUrl('/save_group_grades') ?>">
        <label for="grup_disc">Select Group and Discipline:</label><br>
        <select id="grup_disc" name="grup_disc">
            <?php foreach ($grupDiscs as $grupDisc): ?>
                <option value="<?= $grupDisc->Id_grup-disc ?>"><?= $grupDisc->id_grup ?> - <?= $grupDisc->id_discipline ?></option>
            <?php endforeach; ?>
        </select><br><br>
        <label for="grade">Grade:</label><br>
        <input type="text" id="grade" name="grade"><br><br>
        <input type="submit" value="Save Grades">
    </form>
</body>
</html>
