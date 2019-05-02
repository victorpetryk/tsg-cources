<?php

class DB {

    private static $pdo = null;

    public function getConnection() {
        if (!self::$pdo) {
            $dsn = 'mysql:host='. MYSQL_HOST .';port='. MYSQL_PORT .';dbname='. DB_NAME . ';charset=utf8';
            $options = array(
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'",
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES => false
            );
            try {
                self::$pdo = new PDO($dsn, DB_USERNAME , DB_PASSWORD, $options);
            } catch (PDOException $e) {
                echo "Connection failed: ".$e->getMessage();
                exit();
            }
        }
        return self::$pdo;
    }

    public function query($sql, $parameters = []) {
        $dbh = $this->getConnection();
        $stmt = $dbh->prepare($sql);
        $result = $stmt->execute($parameters);

        if ($result !== false)
        {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        else
        {
            return false;
        }

    }

    /**
     * Повертаємо останній внесений ID
     *
     * @return string
     */
    public function lastInsertID()
    {
        $dbh = $this->getConnection();
        return $dbh->lastInsertId();
    }
   
}