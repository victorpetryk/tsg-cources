<!doctype html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Задача 1 - Розіл 4 - Основи програмування на PHP</title>
</head>
<body>

<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
    Введіть список імен, розділених комами:<br>
    <input type="text" name="names"><br>
    <input type="submit">
</form>

<hr>

<?php

/*
 * Встановлюємо настройки локалі
 * uk_UA.utf8 - для Unix
 * ukrainian - для Windows (перетворюється на Ukrainian_Ukraine.1251)
 * */
$locale = setlocale( LC_ALL, 'uk_UA.utf8', 'ukrainian' );

if ( ! empty( $_POST['names'] ) ) {

	$names = $_POST['names'];

	/*
	 * У Windows працює лише з кодуванням 1251,
	 * тому якщо скрипт запускається на Windows,
	 * мусимо кодвання рядку з іменами перетворити
	 * з utf-8 на windows-1251
	 * */
	if ( strpos( $locale, '1251' ) ) {
		$names = iconv( "utf-8", "windows-1251", $names );
	}

	/*
	 * Забираємо пробіли та коми на початку і в кінці рядка,
	 * а також пробіли всередині рядка з іменами
	 * */
	$names = trim( preg_replace( '/\s+/', '', $names ), ', ' );

	// Розбиваємо рядок на масив по комі
	$names = explode( ',', $names );

	// Сортуємо масив імен по алфавіту
	sort( $names, SORT_LOCALE_STRING );

	// Склеюємо елементи масиву в рядок з використанням коми і пробілу
	$names = implode( ', ', $names );

	/*
	 * Якщо запускаємо у Windows,
	 * то перед відображенням відсортованого списку імен,
	 * знову перетворюємо кодування
	 * */
	if ( strpos( $locale, '1251' ) ) {
		echo iconv( "windows-1251", "utf-8", $names );
	} else {
		echo $names;
	}

}
?>

</body>
</html>