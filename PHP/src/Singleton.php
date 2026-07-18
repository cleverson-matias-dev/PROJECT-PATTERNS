<?php
declare(strict_types=1);

// Singleton
# Existe somente uma instância da conexão com o banco de dados acessível para a aplicação.


class Database {

    private static Database $instance;
    private PDO $connetion;

    private function __construct(){
        $this->connetion = new PDO("mysql:host=localhost;dbname=teste", "usuario", "senha");
    }
    private function __clone(){}

    public static function getInstance(): self {
        if(isset(self::$instance)) {
            return self::$instance;
        }

        return new self();
    }

    public function getConnection(): PDO {
        return $this->connetion;
    }
}

$db = Database::getInstance()->getConnection();