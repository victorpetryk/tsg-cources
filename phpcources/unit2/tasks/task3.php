<!doctype html>
<html lang="uk">
<head>
	<meta charset="UTF-8">
	<title>Задача 3 - Розіл 2 - Основи програмування на PHP</title>
</head>
<body>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
	<label for="full_name">Введіть прізвище імен'я та по-батькові:</label><br>
	<input type="text" name="full_name" id="full_name"><br>
	<input type="submit">
</form>

<hr>

<?php

if ( isset( $_POST['full_name'] ) ) {

	// Якщо поле з ПІБ порожнє, виводимо відповідне повідомлення
	if ( $_POST['full_name'] == '' ) {
		echo "Поле не може бути порожнім!";
	} else {
		// Знищуємо пробіли на початку і вкінці рядка
		$full_name = trim( $_POST['full_name'] );

		// Розбиваємо рядок на масив по пробілах
		$full_name = explode(' ', $full_name);

		// Проходимо по масиву
		foreach ($full_name as $initial) {
			// Якщо значення елементу масиву не пустий рядок
			if ($initial != '') {
				// Виводимо перші літери слів (великими літерами)
				echo mb_strtoupper(mb_substr($initial, 0, 1)) . '.';
			}
		}
	}

}

?>

</body>
</html>