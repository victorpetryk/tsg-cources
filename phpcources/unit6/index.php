<html>
<head>
    <title>Форма завантаження файла</title>
    <meta charset="UTF-8">
</head>
<body>

<form enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
    <input type="hidden" name="MAX_FILE_SIZE" value="10000000">
    Завантажити файл: <br><br>
    <input name="filename" type="file"><br><br>
    <input type="submit" value="Завантажити"><br><br>
</form>

<?php

$upload_dir = "upload";

if ( isset( $_FILES['filename'] ) ) {
	$filename     = $_FILES['filename']['name'];
	$tmp_filename = $_FILES['filename']['tmp_name'];
	move_uploaded_file( $tmp_filename, "$upload_dir/$filename" );
}

$upload_files = scandir( $upload_dir );

foreach ( $upload_files as $filename ) {
	if ( $filename !== "." && $filename !== ".." && getimagesize( "$upload_dir/$filename" ) > 0 ) {
		echo '<img src="' . "$upload_dir/$filename" . '">';
		// echo date('r',filectime("$upload_dir/$filename"));
	}
}

/*
 * Задача 1
 * */

$backup_dir = "backup";

// Якщо каталог backup не існує, то створюємо його
if ( ! file_exists( $backup_dir ) ) {
	mkdir( $backup_dir );
}

// Перебираємо всі файли, що завантажені в каталог upload
foreach ( $upload_files as $filename ) {
	if ( $filename !== "." && $filename !== ".." ) {

		// Дата створення файлу
		$fileCreateDate = date_create( date( "d.m.Y", filectime( "$upload_dir/$filename" ) ) );

		// Поточна дата
		$nowDate = date_create( date( "d.m.Y" ) );

		// Різниця між датами
		$dateDiff = date_diff( $nowDate, $fileCreateDate );

		/*
		 * Якщо різниця між датами більша за 3,
		 * переміщаємо ці файли в каталог backup
		 * */
		if ( $dateDiff->format( '%d' ) > 3 ) {
			rename( "$upload_dir/$filename", "$backup_dir/$filename" );
		}
	}
}

/*
 * Задача 2
 * */

foreach ($upload_files as $filename) {
    if ($filename !== "." && $filename !== ".." && substr($filename, '-4') === ".txt") {

        $file = "$upload_dir/$filename";

        $fileContent = file_get_contents($file);

        if (mb_strpos($fileContent, 'тест')) {
            echo $fileContent . "<br><br>";
        }
    }
}

?>

</body>
</html>