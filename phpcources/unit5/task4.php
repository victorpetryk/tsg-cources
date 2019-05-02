<!doctype html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Задача 4 - Розіл 5 - Основи програмування на PHP</title>
</head>
<body>

Числа Фібоначі:<br>
<?php echo fibonacci( 20 ); ?>

<hr>

Числа Фібоначі (рекурсія):<br>
<?php echo rfibonacci( 20 ); ?>

<?php

// Функції

// Без рекурсії
function fibonacci( $n ) {

	// Задаємо початкові елементи масиву з числами
	$numbers = [ 1, 1 ];

	/*
	 * Якщо параметр функції $n < 3,
	 * виводимо необхідні значення
	 * */
	switch ( $n ) {
		case $n < 0:
		case 0:
			return 0;
			break;
		case 1:
			return 1;
			break;
		case 2:
			return $numbers = implode( ', ', $numbers );
			break;
	}

	for ( $i = 1; $i < ( $n - 1 ); $i++ ) {
		$numbers[] = $numbers[$i] + $numbers[$i - 1];
	}

	$numbers = implode( ', ', $numbers );

	return $numbers;
}

// З рекурсією
function rfibonacci( $n, $numbers = array() ) {

	// Задаємо початкові елементи масиву з числами
	$numbers[0] = 1;
	$numbers[1] = 1;

	/*
	 * Якщо параметр функції $n < 3,
	 * виводимо необхідні значення
	 * */
	switch ( $n ) {
		case $n < 0:
		case 0:
			return 0;
			break;
		case 1:
			return 1;
			break;
		case 2:
			return $numbers = implode( ', ', $numbers );
			break;
	}

	$count = count( $numbers );

	$numbers[] = $numbers[ $count - 1 ] + $numbers[ $count - 2 ];

	if ( $n > ( $count + 1 ) ) {
		return rfibonacci( $n, $numbers );
	}

	return $numbers = implode( ', ', $numbers );
}

?>

</body>
</html>