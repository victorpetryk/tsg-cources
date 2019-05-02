<!doctype html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Задача 2 - Регулярні вирази - Основи програмування на PHP</title>
</head>
<body>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
    <label for="full_name">Введіть прізвище ім'я та по-батькові:</label><br>
    <input type="text" name="full_name" id="full_name"><br>
    <input type="submit">
</form>

<hr>

<?php

if ( ! empty( $_POST['full_name'] ) ) {

	$full_name = trim( $_POST['full_name'] );

	$pattern = '/^[а-яіїєґ\'\-\s]+$/iu';

	if ( preg_match( $pattern, $full_name ) ) {
		echo $full_name;
	} else {
		echo "Прізвище ім'я та по-батькові введене невірно.";
	}
}

?>

</body>
</html>