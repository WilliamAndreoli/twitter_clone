<?php

namespace App;
use PDO;

class Connection {

    public static function getDb() {

        try {

            $conn = new PDO(
                "mysql:host=localhost;dbname=twitter_clone;charset=utf8",
                "root",
                ""
            );

            return $conn; 

        } catch (\PDOException $e) {
            echo 'Erro: '.$e;
        }

    }

}

?>