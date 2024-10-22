<?php
// Загрузка задач из файла
$tasksFile = 'tasks.json';
$tasks = file_exists($tasksFile) ? json_decode(file_get_contents($tasksFile), true) : [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['task'])) {
        // Добавление новой задачи
        $tasks[] = ['task' => $_POST['task'], 'completed' => false];
        file_put_contents($tasksFile, json_encode($tasks));
    } elseif (isset($_POST['complete'])) {
        // Отметка задачи как выполненной
        $taskIndex = $_POST['complete'];
        $tasks[$taskIndex]['completed'] = true;
        file_put_contents($tasksFile, json_encode($tasks));
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h1>Список дел</h1>
    <form method="POST" class="task-form">
        <input type="text" name="task" placeholder="Введите задачу" required>
        <button type="submit">Добавить</button>
    </form>
    <ul class="task-list">
        <?php foreach ($tasks as $index => $task): ?>
            <li class="<?= $task['completed'] ? 'completed' : '' ?>">
                <?= htmlspecialchars($task['task']) ?>
                <?php if (!$task['completed']): ?>
                    <form method="POST" class="complete-form" style="display:inline;">
                        <input type="hidden" name="complete" value="<?= $index ?>">
                        <button type="submit">Выполнено</button>
                    </form>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
</body>
</html>