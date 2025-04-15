<?php
session_start();
require 'config.php';

$stmt = $pdo->query("SELECT * FROM tests");
$tests = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Список испытаний</title>
</head>
<body>
<h2>Испытания ГТО</h2>
<table border="1">
    <tr>
        <th>Название испытания</th>
        <th>Возрастная группа</th>
        <th>Пол</th>
        <th>Норматив</th>
    </tr>
    <?php foreach ($tests as $test): ?>
        <tr>
            <td><?= htmlspecialchars($test['test_name']) ?></td>
            <td><?= htmlspecialchars($test['age_group']) ?></td>
            <td><?= htmlspecialchars($test['gender']) ?></td>
            <td><?= htmlspecialchars($test['norm']) ?></td>
        </tr>
    <?php endforeach; ?>
</table>
<a href="profile.php">Назад</a>
</body>
</html>
