<!doctype html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Задача 1 - Розіл 2 - Основи програмування на PHP</title>
</head>
<body>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
    <label for="names">Введіть список імен через кому:</label><br>
    <input type="text" name="names" id="names"><br>
    <input type="submit">
</form>

<hr>

<?php

if ( isset( $_POST['names'] ) ) {

	// Якщо поле з іменами порожнє, виводимо відповідне повідомлення
	if ( $_POST['names'] == '' ) {
		echo "Поле не може бути порожнім!";
	} else {
		// Знищуємо пробіли на початку і вкінці рядка
		$names = trim( $_POST['names'] );

		// Заміняємо в рядку символи , на ;
		$names = str_replace( ',', ';', $names );

		// Виводимо імена
		echo $names;
	}

}

?>

</body>
</html>