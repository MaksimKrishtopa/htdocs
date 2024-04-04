<div class="card-list">
    <h2 class="page-title">Результаты поиска</h2>
    
    <?php if (isset($students) && $students->isNotEmpty()): ?>
        <h3 class="page-title">Студенты</h3>
        <?php foreach ($students as $student): ?>
            <div class="student-card">
                <img src="<?= $student->avatar ?>" alt="Фотография студента">
                <p class="card-item"><?= $student->surname . ' ' . $student->name . ' ' . $student->patronymic ?></p>
                <!-- Здесь вы можете выводить другую информацию о студентах, например, их группы, оценки и т.д. -->
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p class="message">Студент не найден или введены некорректные данные</p>
    <?php endif; ?>
</div>
