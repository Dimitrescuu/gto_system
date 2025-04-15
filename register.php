<?php
require 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $role = "спортсмен"; // По умолчанию
    $gender = $_POST['gender'];

    // Проверка существования email
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);

    if ($stmt->rowCount() > 0) {
        echo "Этот email уже зарегистрирован.";
    } else {
        $stmt = $pdo->prepare("INSERT INTO users (name, email, password, role, gender) VALUES (?, ?, ?, ?, ?)");
        if ($stmt->execute([$name, $email, $password, $role, $gender])) {
            echo "Регистрация успешна!";
        } else {
            echo "Ошибка при регистрации.";
        }
    }

}
?>
