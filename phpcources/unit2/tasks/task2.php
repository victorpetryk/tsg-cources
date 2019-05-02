<!doctype html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Задача 2 - Розіл 2 - Основи програмування на PHP</title>
</head>
<body>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
    <label for="email">Введіть e-mail користувача:</label><br>
    <input type="text" name="email" id="email"><br>
    <input type="submit">
</form>

<hr>

<?php

if ( isset( $_POST['email'] ) ) {

	// Якщо поле email порожнє, виводимо відповідне повідомлення
	if ( $_POST['email'] == "" ) {
		echo "Поле не може бути порожнім!";
	} else {
		// Знищуємо пробіли на початку і вкінці рядка
		$email = trim($_POST['email']);

		/**
		 * 1. В рядку немає символа "@"
		 * 2. Символ "@" знаходиться на початку рядка
		 * 3. Символ "@" знаходиться в кінці рядка
		 */
		if (
			strpos( $email, '@' ) == false ||
			strpos( $email, '@' ) == 0 ||
			substr( $email, -1 ) == '@'
		) {
			echo "Електронна адреса введена неправильно.";

			/**
			 * 1. В рядку немає символа "."
			 * 2. Символ "." знаходиться на початку рядка
			 * 3. Символа "." немає після сивола "@"
			 * 4. Символ "." знаходиться відразу після сивола "@"
			 * 5. Символ "." знаходиться в кінці рядка
			 */
		} elseif (
			strpos( $email, '.' ) == false ||
			strpos( $email, '.' ) == 0 ||
			strpos( $email, '.', strpos( $email, '@' ) ) == false ||
			strpos( $email, '.', strpos( $email, '@' ) ) == ( strpos( $email, '@' ) + 1 ) ||
			substr( $email, -1 ) == '.'
		) {
			echo "Електронна адреса введена неправильно.";
		} else {
			echo "Електронна адреса введена правильно.";
        }

	}
}

?>

</body>
</html>