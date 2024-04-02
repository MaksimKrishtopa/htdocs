<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Успеваемость студентов</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .grade__container {
            display: flex;
            justify-content: start;
            flex-direction: column;
        }

        form {
            display: flex;
            flex-direction: column;
        }
        
        .info__grades-table {
            display: flex;
            flex-direction: column;
            font-size: 14px;
        }
    </style>
</head>
<body>

<div class="grade__container">

<h1>Успеваемость</h1>

<form action="/grades" method="post">
    <label for="grup">Выберите группу:</label>
    <select name="grup" id="grup">
        <option value="">Выберите группу</option>
        <?php foreach ($grups as $grup): ?>
            <option value="<?= $grup->id_grupa ?>"><?= $grup->grup_number ?></option>
        <?php endforeach; ?>
    </select>
    
    <label for="discipline">Выберите дисциплину:</label>
    <select name="discipline" id="discipline">
        <option value="">Выберите дисциплину</option>
        <?php foreach ($disciplines as $discipline): ?>
            <option value="<?= $discipline->id_discipline ?>"><?= $discipline->discipline_name ?></option>
        <?php endforeach; ?>
    </select>

    <label for="student">Выберите студента:</label>
    <select name="student" id="student">
        <option value="">Выберите студента</option>
        <?php foreach ($students as $student): ?>
            <option value="<?= $student->id_student ?>"><?= $student->name ?></option>
        <?php endforeach; ?>
    </select>
    
    <input style="margin-top: 15px" type="submit" value="Показать">
</form>
</div>
<div class="info__grades-table">
    <!-- сделать множественный выбор в списках, чтоы отображать несколько разом -->
    <!-- связать вид контроля с опредленными дисциплинами -->
    <h2>Информация: </h2>
    <select style="margin-bottom: 10px" name="control" id="control">
    <option value="">Выберите вид контроля</option>
    <?php foreach ($controlTypes as $controlType): ?>
        <option value="<?= $controlType ?>"><?= $controlType ?></option>
    <?php endforeach; ?>
</select>

    <table>
        <thead>
            <tr>
                <th>Студент</th>
                <th>Дисциплина</th>
                <th>Группа</th>
                <th>Оценки</th>
                <th>Часы</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($grades as $grade): ?>
                <?php $discipline = $grade->grupDisc->discipline; ?>
                <tr>
                    <td><?= $discipline->discipline_name ?></td>
                    <td><?= $grade->grades ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>