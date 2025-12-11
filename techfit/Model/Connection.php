<?php

namespace techfit;

use PDO;
use PDOException;

class Connection {
    private static $instancia = null;

    public static function getInstacia(){
        if(!self::$instancia) {
            try{
                $host = "localhost";
                $db = "techfit_academy";
                $user = "root";
                $pass = "senaisp";

                $dsn = "mysql:host=$host;charset=utf8";

                self::$instancia = new PDO(
                    $dsn,
                    $user,
                    $pass
                );
                self::$instancia->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

                self::$instancia->exec("CREATE DATABASE IF NOT EXISTS $db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
                self::$instancia->exec("USE $db");

                self::$instancia->exec("CREATE TABLE IF NOT EXISTS teste (
                teste_nome varchar(100)
                )");
                self::$instancia->exec("insert into teste (teste_nome) values (HEHEHEHEHEHEHEHEHEHEHEHEHEHEHEHE)");


            }
            catch (PDOException $e) {
                die("Erro ao conectar ao MySQL: " . $e->getMessage());
            }
        } 
        return self::$instancia;
    }
}

?>