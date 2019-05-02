<!doctype html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Задача 3 - Розіл 3 - Основи програмування на PHP</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="form">
    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
        Введіть висоту піраміди:<br>
        <input type="text" name="pyramid-height"><br>
        <input type="submit">
    </form>

	<?php

	// Змінна, якою контролюється відображення піраміди
	// За замовчуванням піраміду не відображаємо
	$displayPyramid = false;

	if ( ! empty( $_POST['pyramid-height'] ) ) {

		$pyramidHeight  = (int) $_POST['pyramid-height'];

		if ( $pyramidHeight < 1 || $pyramidHeight > 15 ) {
			echo "<p class='notification'>Висота піраміди має бути від 1 до 15</p>";
		} else {
			$displayPyramid = true;
			echo "<p class='notification'>Висота піраміди: <strong>$pyramidHeight</strong></p>";
		}

	}
	
	?>
</div>

<?php if ( $displayPyramid ) : ?>
    <div class="pyramid">
		<?php for ( $i = 1, $w = 64; $i <= $pyramidHeight; $i ++, $w += 32 ) : ?>
            <div class="pyramid-row" style="width: <?php echo $w; ?>px;"></div>
		<?php endfor; ?>
    </div>
<?php endif; ?>

<div class="cloud1"></div>
<div class="cloud2"></div>
<div class="cloud3"></div>

<div class="grass1"></div>
<div class="grass2"></div>

<div class="earth"></div>

</body>
</html>