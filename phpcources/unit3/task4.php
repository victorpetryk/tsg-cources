<!doctype html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Задача 4 - Розіл 3 - Основи програмування на PHP</title>
	<style>
		span {
			line-height: 1.5rem;
			background-color: red;
		}
	</style>
</head>
<body>

<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
    Введіть числа від 1 до 100 розділених комою:<br>
    <input type="text" name="numbers"><br>
    <input type="submit">
</form>

<hr>

<?php

if ( ! empty( $_POST['numbers'] ) ) {

	// Чистимо введений рядок від крайніх пробілів і ком
	$numbers = trim( $_POST['numbers'], ' ,' );

	// Перевіряємо введений рядок на відповідність умові
	if ( ! preg_match( '/^(\b([1-9]|[1-9][0-9]|100)\b\s*\,?\s*)+$/', $numbers ) ) {
		echo "Числа мають бути цілі додатні від 1 до 100 розділені комою";
	} else {

		// Розбиваємо рядок по комі на масив
		$numbers = explode( ',', $numbers );

		// Перебираэмо масив і виводимо результат
		foreach ( $numbers as $number ) {
			// Чистимо кожен елемент масиву від зайвих пробілів
			$number = preg_replace( '/\s+/', '', $number );

			$count = 0;

			// Виводимо діаграму
			while ($count < $number) {
				echo "<span>&nbsp;</span>";
				$count++;
			}

			// Виводимо число
			echo "&nbsp;" . $number . "<br>";
		}

	}
	
}

?>

</body>
</html>