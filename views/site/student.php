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
        display: none; /* Скрыть подробную информацию по умолчанию */
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
                <!-- Добавляем кнопку "подробнее" и скрытую подробную информацию -->
                <span class="show-details">Подробнее</span>
                <div class="details">
                    Группа: <?= $student->grupa ?><br>
                    Пол: <?= $student->gender ?><br>
                    Дата рождения: <?= $student->birthday ?><br>
                    Адрес: <?= $student->address ?><br>
                    <!-- Добавьте остальные поля, если необходимо -->
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
</div>

<script>
    // Получаем все элементы с классом "show-details"
    const showButtons = document.querySelectorAll('.show-details');

    // Для каждой кнопки добавляем обработчик события клика
    showButtons.forEach(button => {
        button.addEventListener('click', () => {
            // Находим следующий элемент после кнопки, который содержит подробную информацию
            const details = button.nextElementSibling;
            // Переключаем видимость подробной информации
            details.style.display = details.style.display === 'none' ? 'block' : 'none';
        });
    });
</script>

</body>
</html>