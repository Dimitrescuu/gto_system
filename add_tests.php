<?php
require 'config.php';

$tests = [
    ['test_name' => 'Бег на короткие дистанции — 30 метров', 'age_group' => 'Все', 'gender' => 'М', 'norm' => 4.0],
    ['test_name' => 'Бег на короткие дистанции — 30 метров', 'age_group' => 'Все', 'gender' => 'Ж', 'norm' => 5.0],
    ['test_name' => 'Бег на короткие дистанции — 60 метров', 'age_group' => 'Все', 'gender' => 'М', 'norm' => 7.0],
    ['test_name' => 'Бег на короткие дистанции — 60 метров', 'age_group' => 'Все', 'gender' => 'Ж', 'norm' => 8.0],
    ['test_name' => 'Бег на короткие дистанции — 100 метров', 'age_group' => 'Все', 'gender' => 'М', 'norm' => 12.0],
    ['test_name' => 'Бег на короткие дистанции — 100 метров', 'age_group' => 'Все', 'gender' => 'Ж', 'norm' => 14.0],
    ['test_name' => 'Бег на длинную дистанцию (более километра)', 'age_group' => 'Все', 'gender' => 'М', 'norm' => 4.5],
    ['test_name' => 'Бег на длинную дистанцию (более километра)', 'age_group' => 'Все', 'gender' => 'Ж', 'norm' => 5.5],
    ['test_name' => 'Прыжок в длину с разбега', 'age_group' => 'Все', 'gender' => 'М', 'norm' => 3.0],
    ['test_name' => 'Прыжок в длину с разбега', 'age_group' => 'Все', 'gender' => 'Ж', 'norm' => 2.5],
    ['test_name' => 'Упражнения в подтягивании из виса на перекладине', 'age_group' => 'Все', 'gender' => 'М', 'norm' => 12],
    ['test_name' => 'Упражнения в подтягивании из виса на перекладине', 'age_group' => 'Все', 'gender' => 'Ж', 'norm' => 5],
    ['test_name' => 'Наклон вперёд из положения стоя на гимнастической скамье', 'age_group' => 'Все', 'gender' => 'М', 'norm' => 15],
    ['test_name' => 'Наклон вперёд из положения стоя на гимнастической скамье', 'age_group' => 'Все', 'gender' => 'Ж', 'norm' => 18],
    ['test_name' => 'Челночный бег 3x10 м', 'age_group' => 'Все', 'gender' => 'М', 'norm' => 9.5],
    ['test_name' => 'Челночный бег 3x10 м', 'age_group' => 'Все', 'gender' => 'Ж', 'norm' => 10.5],
    ['test_name' => 'Метание спортивного снаряда на дальность', 'age_group' => 'Все', 'gender' => 'М', 'norm' => 10],
    ['test_name' => 'Метание спортивного снаряда на дальность', 'age_group' => 'Все', 'gender' => 'Ж', 'norm' => 7],
    ['test_name' => 'Прыжок в длину с места', 'age_group' => 'Все', 'gender' => 'М', 'norm' => 2.5],
    ['test_name' => 'Прыжок в длину с места', 'age_group' => 'Все', 'gender' => 'Ж', 'norm' => 2.0],
    ['test_name' => 'Плавание 50 м', 'age_group' => 'Все', 'gender' => 'М', 'norm' => 35],
    ['test_name' => 'Плавание 50 м', 'age_group' => 'Все', 'gender' => 'Ж', 'norm' => 40],
];

foreach ($tests as $test) {
    $stmt = $pdo->prepare("INSERT INTO tests (test_name, age_group, gender, norm) VALUES (?, ?, ?, ?)");
    $stmt->execute([$test['test_name'], $test['age_group'], $test['gender'], $test['norm']]);
}

echo "Испытания успешно добавлены!";
?>
