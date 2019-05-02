<?php

class FileSystemClass
{

    // Директорія для завантаження файлів
    public $uploadDirectory = 'upload';

    // Директорія для резервування файлів
    public $backupDirectory = 'backup';

    // Розділювач директорій
    protected $ds = DIRECTORY_SEPARATOR;

    /**
     * Завантаження файлу
     *
     * @param $file
     */
    public function uploadFile($file)
    {
        $this->createDirectory($this->uploadDirectory);

        $filename     = $file['name'];
        $tmp_filename = $file['tmp_name'];

        $filePath = $this->getDirectoryPath($this->uploadDirectory) . $filename;

        move_uploaded_file($tmp_filename, $filePath);
    }

    /**
     * Резервування файлів
     *
     * Формат введення періоду, за який треба резервувати файли:
     * 1h - кількість годин
     * 3d - кількість днів
     *
     * @param string $backupPeriod
     */
    public function backupFiles($backupPeriod = "1h")
    {

        // Виясняємо, в якому форматі введений період резервування
        $backupPeriodFormat = substr($backupPeriod, -1);

        // Якщо період резервування не в годинах або не в днях,
        // то по-замовчуванню ставимо в годинах
        if ($backupPeriodFormat !== 'h' || $backupPeriodFormat !== 'd') {
            $backupPeriodFormat = 'h';
        }

        // Записуємо в змінну числове значення періоду резервування
        $backupPeriod = (int)$backupPeriod;

        // В залежності від введеного формату резервування
        // вираховуємо зміщення
        if ($backupPeriodFormat === 'h') {
            $backupPeriodOffset = $backupPeriod * 3600;
        } else {
            $backupPeriodOffset = $backupPeriod * 24 * 3600;
        }

        // Визначаємо поточний час
        $currentTime = time();

        // Створюємо директорію для резервування
        $this->createDirectory($this->backupDirectory);

        // Отримуємо перелік файлів в директорії для завантаження
        $files = $this->getFilesFromDirectory($this->uploadDirectory);

        foreach ($files as $filename) {

            // Визначаємо шляхи до завантаженого і зарезервованого файлу
            $fileUploadPath = $this->getDirectoryPath($this->uploadDirectory) . $filename;
            $fileBackupPath = $this->getDirectoryPath($this->backupDirectory) . $filename;

            if ($filename !== "." && $filename !== "..") {

                // Час створення файлу
                $fileCreateTime = filectime($fileUploadPath);

                // Якщо час створення файлів з урахуванням зміщення менший
                // за поточний час, то переміщуємо ці файли в директорію для резервування
                if ($currentTime > ($fileCreateTime + $backupPeriodOffset)) {
                    rename($fileUploadPath, $fileBackupPath);
                }
            }
        }
    }

    /**
     * Видалення файлів з заданим розширенням,
     * в яких міститься заданий рядок,
     * в заданій директорії
     *
     * @param $fileExtension
     * @param $stringInFile
     * @param $directoryName
     */
    public function deleteFilesWithString($fileExtension, $stringInFile, $directoryName)
    {
        $files = $this->getFilesFromDirectory($directoryName);

        foreach ($files as $filename) {

            if ($filename !== "." && $filename !== "..") {
                if (preg_match("/.*{$fileExtension}/", $filename)) {

                    $filePath    = $this->getDirectoryPath($directoryName) . $filename;
                    $fileContent = file_get_contents($filePath);

                    if (preg_match("/\b({$stringInFile})\b/iu", $fileContent)) {
                        unlink($filePath);
                    }
                }
            }
        }
    }

    /**
     * Зчитуємо з одного файлу,
     * і перевернувши слова, записуємо в інший
     *
     * @param $sourceFile
     * @param $destinationFile
     */
    public function sourceToDestination($sourceFile, $destinationFile)
    {
        // Визначаємо шляхи файлів
        $sourceFilePath      = $this->getDirectoryPath($this->uploadDirectory) . $sourceFile;
        $destinationFilePath = $this->getDirectoryPath($this->uploadDirectory) . $destinationFile;

        if ( ! file_exists($sourceFilePath)) {
            echo "Будь-ласка, завантажте файл source.txt";
        } else {
            // Отримуємо вміст файлу source
            $sourceFileContent = file_get_contents($sourceFilePath);

            // Модифікуємо вміст файлу.
            // Слова, що розділені пробілами та переносами рядків
            // перевертаємо ззаду на перед
            $destinationFileContent = preg_replace_callback('/\w+(\s|\n\r)+\w+/u', function ($matches) {
                $reverted = '';

                for ($i = 1; $i <= mb_strlen($matches[0]); $i++) {
                    $reverted .= mb_substr($matches[0], $i * -1, 1);
                }

                return $reverted;

            }, $sourceFileContent);

            // Записуємо модифікований вміст у новий файл
            file_put_contents($destinationFilePath, $destinationFileContent);
        }
    }

    /**
     * Відобрадення файлів з директорії
     *
     * @param $directoryName
     */
    public function displayFiles($directoryName)
    {
        $files = $this->getFilesFromDirectory($directoryName);

        foreach ($files as $filename) {
            $filePath = $this->getDirectoryPath($directoryName) . $filename;

            if ($filename !== "." && $filename !== "..") {

                // Помітив таку особливість, що якщо текстовий файл
                // порожній, або в ньому не багато тексту
                // Виникає Notice: getimagesize(): Read error!
                if (getimagesize($filePath) > 0) {
                    echo "<img src=" . $filePath . " />";
                } else {
                    echo "<a href=\"$filePath\">" . $filename . "</a>";
                }
            }
        }
    }

    /**
     * Створення директорії,
     * якщо вона не існує
     *
     * @param $directoryName
     */
    public function createDirectory($directoryName)
    {
        if ( ! file_exists($directoryName)) {
            mkdir($directoryName);
        }
    }

    /**
     * Отримання шляху до директорії
     * з розділювачем
     *
     * @param $directoryName
     *
     * @return string
     */
    public function getDirectoryPath($directoryName)
    {
        return $directoryName . $this->ds;
    }

    /**
     * Перелік файлів в директорії
     *
     * @param $directoryName
     *
     * @return array
     */
    public function getFilesFromDirectory($directoryName)
    {
        $files = scandir($directoryName);

        return $files;
    }
}