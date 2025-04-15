<?php
session_start();
require 'config.php';

// Проверяем, что пользователь авторизован
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

$user_id = $_SESSION['user_id'];

// Получаем все результаты пользователя
$stmt = $pdo->prepare("SELECT r.id, t.test_name, r.result, r.status, r.date 
                       FROM results r
                       JOIN tests t ON r.test_id = t.id
                       WHERE r.user_id = ?");
$stmt->execute([$user_id]);
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Мои результаты</title>
</head>
<body>
<h2>Мои результаты</h2>
<table border="1">
    <tr>
        <th>Испытание</th>
        <th>Результат</th>
        <th>Статус</th>
        <th>Дата</th>
        <th>Удалить</th>
    </tr>
    <?php foreach ($results as $result): ?>
        <tr>
            <td><?= htmlspecialchars($result['test_name']) ?></td>
            <td><?= htmlspecialchars($result['result']) ?></td>
            <td><?= htmlspecialchars($result['status']) ?></td>
            <td><?= htmlspecialchars($result['date']) ?></td>
            <td>
                <form action="delete_result.php" method="post">
                    <input type="hidden" name="result_id" value="<?= $result['id'] ?>">
                    <button type="submit">Удалить</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
<a href="profile.php">Назад</a>
</body>
</html>
