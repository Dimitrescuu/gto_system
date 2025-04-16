<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT name, email, role FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Профиль</title>
</head>
<body>
<h2>Профиль пользователя</h2>
<p><strong>Имя:</strong> <?= htmlspecialchars($user['name']) ?></p>
<p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
<p><strong>Роль:</strong> <?= htmlspecialchars($user['role']) ?></p>
<p><a href="my_results.php">Мои результаты</a></p>
<p><a href="add_result.php">Добавить результат</a></p>
<a href="logout.php">Выйти</a>


</body>
</html>
