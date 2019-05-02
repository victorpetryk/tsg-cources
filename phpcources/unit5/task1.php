<!doctype html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Задача 1 - Розіл 5 - Основи програмування на PHP</title>
</head>
<body>

<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
    Введіть список імен, розділених комами:<br>
    <input type="text" name="names"><br>
    <input type="submit">
</form>

<hr>

<?php

if ( ! empty( $_POST['names'] ) ) {

	$names = $_POST['names'];

	/*
	 * Забираємо пробіли та коми на початку і в кінці рядка,
	 * а також пробіли всередині рядка з іменами
	 * */
	$names = trim( preg_replace( '/\s+/', '', $names ), ', ' );

	// Розбиваємо рядок на масив по комі
	$names = explode( ',', $names );

	/**
	 * Корректне сортування український літер
	 * (використовується як callback для usort)
	 *
	 * @param $a
	 * @param $b
	 *
	 * @return int
	 */
	function sortByUkrainianAlphabet( $a, $b ) {
		// Масив літер українського алфавіту
		$alphabet = array(
			1  => 'а',
			2  => 'б',
			3  => 'в',
			4  => 'г',
			5  => 'ґ',
			6  => 'д',
			7  => 'е',
			8  => 'є',
			9  => 'ж',
			10 => 'з',
			11 => 'и',
			12 => 'і',
			13 => 'ї',
			14 => 'й',
			15 => 'к',
			16 => 'л',
			17 => 'м',
			18 => 'н',
			19 => 'о',
			20 => 'п',
			21 => 'р',
			22 => 'с',
			23 => 'т',
			24 => 'у',
			25 => 'ф',
			26 => 'х',
			27 => 'ц',
			28 => 'ч',
			29 => 'ш',
			30 => 'щ',
			31 => 'ь',
			32 => 'ю',
			33 => 'я'
		);

		$status = 0;

		// Робимо літери маленькими в рядках, що порівнюються
		$a = mb_strtolower( $a );
		$b = mb_strtolower( $b );

		// Визначаємо довжину рядків (слів)
		$lengthA = mb_strlen( $a );
		$lengthB = mb_strlen( $b );

		/*
		 * Проходимо циклом по рядках, що порівнюються
		 * (цикл виконується по довжині меншого з двох рядків)
		 * */
		for ( $i = 0; $i < ( $lengthA < $lengthB ? $lengthA : $lengthB ); $i ++ ) {
			/*
			 * Визначаємо номер позиції (індекс) в алфавіті
			 * кожної букви з двох рядків, що порівнюються
			 * */
			$letPosInAlphabetA = array_search( mb_substr( $a, $i, 1 ), $alphabet );
			$letPosInAlphabetB = array_search( mb_substr( $b, $i, 1 ), $alphabet );

            /*
             * Порівнюємо позиції (індекси)
             * та задаємо відповідний status
             * */
			if ( $letPosInAlphabetA < $letPosInAlphabetB ) {
				$status = -1;
				break;
			} elseif ( $letPosInAlphabetA > $letPosInAlphabetB ) {
				$status = 1;
				break;
			} else {
				$status = 0;
			}
		}

		return $status;
	}

	// Сортуємо масив імен по алфавіту
	usort( $names, 'sortByUkrainianAlphabet' );

	// Склеюємо елементи масиву в рядок з використанням коми і пробілу
	$names = implode( ', ', $names );

	echo $names;

}
?>

</body>
</html>