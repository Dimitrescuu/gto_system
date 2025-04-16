<?php
session_start();
require 'config.php';

// Проверяем, что пользователь авторизован
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

// Получаем ID результата для удаления
if (isset($_POST['result_id'])) {
    $result_id = $_POST['result_id'];
    $user_id = $_SESSION['user_id'];

    // Проверяем, что этот результат принадлежит текущему пользователю
    $stmt = $pdo->prepare("SELECT * FROM results WHERE id = ? AND user_id = ?");
    $stmt->execute([$result_id, $user_id]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        // Удаляем результат
        $stmt = $pdo->prepare("DELETE FROM results WHERE id = ?");
        if ($stmt->execute([$result_id])) {
            echo "Результат удален!";
        } else {
            echo "Ошибка удаления результата.";
        }
    } else {
        echo "Этот результат не найден или не принадлежит вам.";
    }
} else {
    echo "Ошибка: не был указан ID результата.";
}

?>
<a href="my_results.php">Назад к результатам</a>
