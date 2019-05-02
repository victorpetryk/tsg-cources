<!doctype html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Задача 3 - Регулярні вирази - Основи програмування на PHP</title>
</head>
<body>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
    <label for="text">Введіть текст:</label><br>
    <textarea name="text" id="text" cols="60" rows="10"></textarea><br>
    <input type="submit">
</form>

<hr>

<?php

if ( ! empty( $_POST['text'] ) ) {

	$text = trim( $_POST['text'] );

	$pattern = '/\b((http|https|ftp):\/\/([a-z0-9-]+\.)+([a-z]{2,4})(\/[a-z0-9_-]+)*)\b\/?/i';

	if ( preg_match( $pattern, $text ) ) {
		echo preg_replace( $pattern, '<a href="$0">$0</a>', $text );
	} else {
		echo $text;
	}
}

?>

</body>
</html>