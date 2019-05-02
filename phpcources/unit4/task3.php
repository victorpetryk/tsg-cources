<!doctype html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Задача 3 - Розіл 4 - Основи програмування на PHP</title>
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

	// Чистимо текст від початкових і кінцевих пробілів
	$text = trim( $_POST['text'] );

	// Розбиваємо текст на масив слів
	$words = explode( ' ', $text );

	// Перше слово
	$word = $words[0];

	// Масив рядків, який ми будемо формувати в циклі
	$lines = [];

	/*
	 * В циклі створюємо рядки з словами
	 * */
	for ( $i = 1; $i < count( $words ); $i ++ ) {

		/*
		 * Об'єднуємо слова в рядок
		 * */
		$line = $word . ' ' . $words[ $i ];

		/*
		 * Якщо дожвина рядка зі словами більша за 40,
		 * то додаємо в масив рядків попередній рядок
		 * як елемент масиву.
		 *
		 * Також змінюємо змінну першого слова на наступне слово
		 * для формування слідуючого рядка
		 *
		 * Якщо довжина рядка менша за 40 символів,
		 * продовжуємо додавати до рядка слідуюче слово
		 *
		 * */
		if ( mb_strlen( $line ) > 40 ) {
			$lines[] = $word;
			$word    = $words[ $i ];
		} else {
			$word = $line;
		}
	}

	// Додаємо до масиву з рядками останній рядок
	$lines[] = $word;

	/*
	 * Об'єднуємо масив в рядок з додаванням між ними
	 * переносу рядка
	 * */
	$textWithBrakes = implode( '<br>', $lines );

	echo $textWithBrakes;

}

?>

</body>
</html>