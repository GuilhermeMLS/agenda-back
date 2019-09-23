<?php

class Database
{
    private static $bdd = null;

    /**
     * @return PDO|null
     */
    public static function getBdd() {
        if (is_null(self::$bdd)) {
            self::$bdd = new PDO(
                "mysql:host=localhost;dbname=agenda",
                'root',
                'password'
            );
        }
        return self::$bdd;
    }
}
