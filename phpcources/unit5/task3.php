<!doctype html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Задача 3 - Розіл 5 - Основи програмування на PHP</title>
</head>
<body>

<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
    Введіть список цілих чисел, розділених комами:<br>
    <input type="text" name="numbers"><br>
    <input type="submit">
</form>

<hr>

<?php

if ( ! empty( $_POST['numbers'] ) ) {

	$numbers = $_POST['numbers'];

	/*
	 * Перевіряємо чи користувач правильно ввів числа.
	 * Можуть бути лише цілі числа, розділені комою.
	 * Максимальне число - 999999999
	 * */
	if ( ! preg_match( '/^(-?\b(0|[1-9][0-9]{0,8})\b\s*\,?\s*)+$/', $numbers ) ) {
		echo "Числа можуть бути лише цілими, та розділені комою.";
	} else {
		/*
		 * Чистимо рядок від крайніх пробілів і ком,
		 * а також від пробілів всередині рядка
		 * */
		$numbers = trim( preg_replace( '/\s+/', '', $numbers ), ', ' );

		// Розбиваємо рядок на масив чисел
		$arrayOfNumbers = explode( ',', $numbers );

		// Виводимо, числа, які ввів користувач
		echo "Ви ввели наступні числа: " . "<br>" . str_replace( ',', ', ', $numbers );

		echo "<hr>";

		$sum         = sum( $arrayOfNumbers );
		$mean        = mean( $arrayOfNumbers );
		$countPaired = countPaired( $arrayOfNumbers );
		$unpaired    = unpaired( $arrayOfNumbers );

		$result = <<<EOT
        <ol>
            <li>Сума чисел: <strong>$sum</strong></li>
            <li>Середнє значення: <strong>$mean</strong></li>
            <li>Кількість парних чисел: <strong>$countPaired</strong></li>
            <li>Непарні числа: <strong>$unpaired</strong></li>
        </ol>
EOT;

		echo $result;

	}
}

// Функції

/**
 * Сума чисел
 *
 * @param array $numbers
 *
 * @return int
 */
function sum( $numbers = array() ) {
	$sum = 0;

	foreach ( $numbers as $number ) {
		$sum += $number;
	}

	return $sum;
}

/**
 * Середнє значення
 *
 * @param array $numbers
 *
 * @return float|int|string
 */
function mean( $numbers = array() ) {
	$sum   = 0;
	$count = count( $numbers );

	foreach ( $numbers as $number ) {
		$sum += $number;
	}

	$mean = $sum / $count;

	if ( is_float( $mean ) ) {
		$mean = sprintf( '%.2f', $mean );
	}

	return $mean;
}

/**
 * Кількість парних чисел
 *
 * @param array $numbers
 *
 * @return int
 */
function countPaired( $numbers = array() ) {
	$pairedNumbers = array();

	foreach ( $numbers as $number ) {
		if ( $number % 2 == 0 ) {
			$pairedNumbers[] = $number;
		}
	}

	return count( $pairedNumbers );
}

/**
 * Непарні числа
 *
 * @param array $numbers
 *
 * @return string
 */
function unpaired( $numbers = array() ) {
	$unpairedNumbers = array();

	foreach ( $numbers as $number ) {
		if ( ( $number % 2 ) != 0 ) {
			$unpairedNumbers[] = $number;
		}
	}

	$unpairedNumbers = implode( ', ', $unpairedNumbers );

	return $unpairedNumbers;
}

?>

</body>
</html>