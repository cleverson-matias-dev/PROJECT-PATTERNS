<?php
declare(strict_types=1);

// Bridge
# Posso adicionar novos driver ex. SQLServer e evoluir ApiUserRepository separadamente sem afetar 
# o código cliente existente. Repare como ProductRepository pode salvar registro e tem Driver diferente.

interface IDbDriver {
    public function connect(): void;
    public function query(string $query): void;
}

class MysqlDriver implements IDbDriver {
    public function connect(): void  {}
    public function query(string $query): void {}
}

class PostgresDriver implements IDbDriver {
    public function connect(): void  {}
    public function query(string $query): void {}
}

abstract class Repository {
    protected IDbDriver $driver;

    public function __construct(IDbDriver $driver)
    {
        $this->driver = $driver;
    }

}

class UserRepository extends Repository {
    public function getAllUsers(): array
    {
        $arr = $this->driver->query('SELECT * FROM users');
        return [$arr];
    }
}

class ProductRepository extends Repository {
    public function getAllProducts(): array
    {
        $arr = $this->driver->query('SELECT * FROM products');
        return [$arr];
    }

    public function save() {
        // Using driver to save user...
    }
}

$products = new ProductRepository(new PostgresDriver());
$products->getAllProducts();
$products->save();

$users = new UserRepository(new MysqlDriver());
$users->getAllUsers();