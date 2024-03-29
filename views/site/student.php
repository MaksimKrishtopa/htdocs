<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
</head>
<body>

<style>
    .block__container {
        margin-top: 50px;
        background: #343434;
        display: flex;
        flex-direction: column;
        width: 300px;
    }

    h1 {
        color: #fff;
        font-size: 22px;
        display: flex;
        justify-content: center;
    }

    ul, li {
       list-style: none;
       color: #fff; 
    }

    ul {
        display: flex;
        flex-direction: column;
        gap: 15px;
        padding: 20px;
    }

    .details {
        display: none; 
    }

    .show-details {
        cursor: pointer;
        text-decoration: underline;
    }
</style>

<div class="block__container">
    <h1>Студенты</h1>
    
    <ul>
        <?php foreach ($students as $student): ?>
            <li>
                <?= $student->surname ?> <?= $student->name ?> <?= $student->patronymic ?>
                <span class="show-details">Подробнее</span>
                <div class="details">
                    Группа: <?= $student->getGroupNumber() ?><br>
                    Пол: <?= $student->gender ?><br>
                    Дата рождения: <?= $student->birthday ?><br>
                    Адрес: <?= $student->address ?><br>
                    
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
</div>

<div class="block__container">
    <h1>Группы</h1>
    
    <ul>
        <?php foreach ($groups as $group): ?>
            <li><?= $group->grup_number ?>, Курс: <?= $group->course ?>, Семестр: <?= $group->semester ?></li>
        <?php endforeach; ?>
    </ul>
    
</div>

<div class="block__container">
    <h1>Дисциплины</h1>
    <ul>
        <?php foreach ($disciplines as $discipline): ?>
            <li><?= $discipline->discipline_name ?></li>
        <?php endforeach; ?>
    </ul>
</div>


<script>
    const showButtons = document.querySelectorAll('.show-details');
    showButtons.forEach(button => {
        button.addEventListener('click', () => {
            const details = button.nextElementSibling;
            details.style.display = details.style.display === 'none' ? 'block' : 'none';
        });
    });
</script>

</body>
</html>