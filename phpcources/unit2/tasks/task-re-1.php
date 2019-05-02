<!doctype html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Задача 1 - Регулярні вирази - Основи програмування на PHP</title>
</head>
<body>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
    <label for="email">Введіть e-mail користувача:</label><br>
    <input type="text" name="email" id="email"><br>
    <input type="submit">
</form>

<hr>

<?php

if ( ! empty( $_POST['email'] ) ) {

	$email   = trim( $_POST['email'] );

	$pattern = '/^(?!\.)([a-z0-9_-]+)\.?([a-z0-9_-]+)(?!\.)@([a-z0-9]+\.)+([a-z]{2,4})$/i';

	if ( preg_match( $pattern, $email ) ) {
		echo "Електронна адреса введена правильно.";
	} else {
		echo "Електронна адреса введена неправильно.";
	}
}

?>

</body>
</html>