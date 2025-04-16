<?php
session_start();
require 'config.php';

// Проверка авторизации
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

$user_id = $_SESSION['user_id'];

// Получаем пол пользователя
$user_stmt = $pdo->prepare("SELECT gender FROM users WHERE id = ?");
$user_stmt->execute([$user_id]);
$user = $user_stmt->fetch(PDO::FETCH_ASSOC);
$gender = $user['gender'];

// Получаем список испытаний по полу
if ($gender == 'М') {
    $test_stmt = $pdo->query("SELECT id, test_name FROM tests WHERE gender = 'М' OR gender = 'Все'");
} else {
    $test_stmt = $pdo->query("SELECT id, test_name FROM tests WHERE gender = 'Ж' OR gender = 'Все'");
}
$tests = $test_stmt->fetchAll(PDO::FETCH_ASSOC);

// Обработка добавления результата
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $test_id = $_POST['test_id'];
    $result = $_POST['result'];
    $date = date("Y-m-d");

    // Получаем информацию об испытании
    $test_info_stmt = $pdo->prepare("SELECT norm, test_name FROM tests WHERE id = ?");
    $test_info_stmt->execute([$test_id]);
    $test = $test_info_stmt->fetch(PDO::FETCH_ASSOC);

    $norm = $test['norm'];
    $test_name = $test['test_name'];

    // Определяем статус: сдано или нет
    $running_tests = [
        'Бег на короткие дистанции — 30 метров',
        'Бег на короткие дистанции — 60 метров',
        'Бег на короткие дистанции — 100 метров',
        'Бег на длинную дистанцию (более километра)',
        'Челночный бег 3x10 м',
        'Плавание 50 м'
    ];

    if (in_array($test_name, $running_tests)) {
        // Время меньше нормы — успешно
        $status = ($result < $norm) ? 'сдано' : 'не сдано';
    } else {
        // Результат больше нормы — успешно
        $status = ($result > $norm) ? 'сдано' : 'не сдано';
    }

    // Сохраняем результат
    $insert_stmt = $pdo->prepare("INSERT INTO results (user_id, test_id, result, status, date) VALUES (?, ?, ?, ?, ?)");
    if ($insert_stmt->execute([$user_id, $test_id, $result, $status, $date])) {
        echo "Результат добавлен!<br><br>";
    } else {
        echo "Ошибка записи результата.<br><br>";
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Добавление результата</title>
</head>
<body>
<h2>Добавить результат</h2>
<form action="add_result.php" method="post">
    <label>Испытание:</label>
    <select name="test_id" required>
        <?php foreach ($tests as $test): ?>
            <option value="<?= $test['id'] ?>"><?= htmlspecialchars($test['test_name']) ?></option>
        <?php endforeach; ?>
    </select><br><br>

    <label>Результат:</label>
    <input type="number" name="result" step="0.01" required><br><br>

    <button type="submit">Сохранить</button>
</form>

<br>
<a href="profile.php">Назад в профиль</a>
</body>
</html>
