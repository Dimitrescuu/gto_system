<?php
session_start();
require 'config.php';

// Проверяем, что пользователь авторизован
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $test_id = $_POST['test_id'];
    $result = $_POST['result'];
    $date = date("Y-m-d");

    // Получаем информацию о тесте
    $stmt = $pdo->prepare("SELECT norm, test_name FROM tests WHERE id = ?");
    $stmt->execute([$test_id]);
    $test = $stmt->fetch(PDO::FETCH_ASSOC);

    $norm = $test['norm'];
    $test_name = $test['test_name'];

    // Логика для определения статуса в зависимости от теста
    if (in_array($test_name, ['Бег на короткие дистанции — 30 метров', 'Бег на короткие дистанции — 60 метров',
        'Бег на короткие дистанции — 100 метров', 'Бег на длинную дистанцию (более километра)',
        'Челночный бег 3x10 м', 'Плавание 50 м'])) {
        // Для беговых испытаний и плавания, если результат меньше нормы, то сдано
        $status = ($result < $norm) ? 'сдано' : 'не сдано';
    } else {
        // Для остальных испытаний, если результат больше нормы, то сдано
        $status = ($result > $norm) ? 'сдано' : 'не сдано';
    }

    // Записываем результат в базу данных
    $stmt = $pdo->prepare("INSERT INTO results (user_id, test_id, result, status, date) VALUES (?, ?, ?, ?, ?)");
    if ($stmt->execute([$user_id, $test_id, $result, $status, $date])) {
        echo "Результат добавлен!";
    } else {
        echo "Ошибка записи результата.";
    }
}

// Получаем пол пользователя
$stmt = $pdo->prepare("SELECT gender FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
$gender = $user['gender'];  // Пол пользователя

// Получаем испытания в зависимости от пола
if ($gender == 'М') {
    // Для мужчин
    $stmt = $pdo->query("SELECT id, test_name FROM tests WHERE gender = 'М' OR gender = 'Все'");
} else {
    // Для женщин
    $stmt = $pdo->query("SELECT id, test_name FROM tests WHERE gender = 'Ж' OR gender = 'Все'");
}

$tests = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Добавить результат</title>
</head>
<body>
<h2>Добавить результат</h2>
<form action="add_result.php" method="post">
    <label>Испытание:</label>
    <select name="test_id" required>
        <?php foreach ($tests as $test): ?>
            <option value="<?= $test['id'] ?>"><?= htmlspecialchars($test['test_name']) ?></option>
        <?php endforeach; ?>
    </select><br>

    <label>Результат:</label>
    <input type="number" name="result" step="0.01" required><br>

    <button type="submit">Сохранить</button>
</form>
<a href="profile.php">Назад</a>
</body>
</html>