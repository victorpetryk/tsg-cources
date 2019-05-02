<!doctype html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Задача 2 - Розіл 3 - Основи програмування на PHP</title>
</head>
<body>

<?php

// Задаємо коли був перший Чемпіонат Світу з футболу
$firstWorldCup = 1930;

/**
 * Робимо посилання на змінну $firstWorldCup
 * щоб у циклі було зрозуміло що виводиться
 * не перший рік проведення, а потрібний з діапазону
 * (можливо то робиться якось не так :) )
 */
$worldCup      = &$firstWorldCup;

// Потрібний діапазон років проведення чемпіонату
$fromYear      = 2000;
$toYear        = 2100;

/**
 * Перебираємо всі роки від першого до останнього з діапазону
 * і виводимо лише ті що входіть в діапазон
 */
while ( $firstWorldCup <= $toYear ) {

	if ( $firstWorldCup >= $fromYear ) {
		echo $worldCup . "<br>";
	}

	$firstWorldCup += 4;
}

?>

</body>
</html>