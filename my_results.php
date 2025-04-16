<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

$user_id = $_SESSION['user_id'];

$stmt = $pdo->prepare("
    SELECT results.id AS result_id, tests.test_name, results.result, results.status, results.date 
    FROM results 
    JOIN tests ON results.test_id = tests.id 
    WHERE results.user_id = ?
    ORDER BY results.date DESC
");
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
        <th>Действие</th>
    </tr>
    <?php foreach ($results as $result): ?>
        <tr>
            <td><?= htmlspecialchars($result['test_name']) ?></td>
            <td><?= htmlspecialchars($result['result']) ?></td>
            <td><?= htmlspecialchars($result['status']) ?></td>
            <td><?= htmlspecialchars($result['date']) ?></td>
            <td>
                <form action="delete_result.php" method="post" onsubmit="return confirm('Удалить этот результат?');">
                    <input type="hidden" name="result_id" value="<?= $result['result_id'] ?>">
                    <button type="submit">Удалить</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
<br>
<a href="profile.php">Назад</a>
</body>
</html>
