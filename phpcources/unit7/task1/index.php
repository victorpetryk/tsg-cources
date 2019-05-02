<!doctype html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Задача 1 - Розділ 7 - Основи програмування на PHP</title>
    <style>
        a, img, label, input {
            display: block;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>

<form enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
    <label for="filename">Завантажити файл:</label>
    <input type="file" name="filename" id="filename">
    <input type="hidden" name="MAX_FILE_SIZE" value="10000000">
    <input type="submit" value="Завантажити">
</form>

<?php

// Підключаємо клас для роботи з файлами
include "FileSystemClass.php";

// Створюємо об'єкт класу
$fileSystem = new FileSystemClass();

/*
 * Якщо файл передано через форму,
 * то виконуємо завантаження цього файлу
 * */
if (isset($_FILES['filename'])) {
    $file = $_FILES['filename'];

    $fileSystem->uploadFile($file);
}

/*
 * Резервуємо файли, що створені раніше ніж годину тому.
 * Формат введення періоду, за який треба резервувати файли:
 * 1h - кількість годин
 * 3d - кількість днів
 * */
$fileSystem->backupFiles("1h");

/*
 * Видаляємо у папці upload всі файли з розширенням ".txt",
 * які містять всередині слово "тест".
 * */
$fileSystem->deleteFilesWithString(".txt", "тест", "upload");

/*
 * Зчитуємо файл source.txt та створить файл dest.txt
 * */
$fileSystem->sourceToDestination('source.txt', 'dest.txt');

// Відображаемо файли з директорії
$fileSystem->displayFiles("upload");

?>

</body>
</html>