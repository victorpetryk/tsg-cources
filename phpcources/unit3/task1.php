<!doctype html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Задача 1 - Розіл 3 - Основи програмування на PHP</title>
</head>
<body>

<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
    Введіть суму покупок:<br>
    <input type="text" name="total-price"><br>
    <input type="submit">
</form>

<hr>

<?php
if ( ! empty( $_POST['total-price'] ) ) {
	$totalPrice = trim( $_POST['total-price'] );
	$totalPrice = round( $totalPrice, 2 );

	printf( "Сума покупок: %.2f грн. <br>", $totalPrice );

	if ( $totalPrice >= 1000 && $totalPrice <= 4999.99 ) {
		$discount = ( $totalPrice * 3 ) / 100;
	} elseif ( $totalPrice >= 5000 ) {
		$discount = ( $totalPrice * 5 ) / 100;
	} else {
		$discount = 0;
	}

	$discount = round( $discount, 2 );

	printf( "Ваша знижка: %.2f грн.", $discount );
}
?>

</body>
</html>