<?php
declare(strict_types=1);

// Builder 
# As queries do Mysql são diferentes do Postgres mas o código clinte é o mesmo.
# O builder constroi um objeto diferente para cada caso

interface SqlQueryBuilder {
    public function select(string $table, array $fields): SqlQueryBuilder;
    public function where(string $field, string $value, string $operator = '='): SqlQueryBuilder;
    public function limit(int $start, int $offset = 0): SqlQueryBuilder;

    public function getSql(): string;
}

class MysqlQueryBuilder implements SqlQueryBuilder {

    protected stdClass $query;

    public function reset() {
        $this->query = new stdClass();
    }

    #[Override]
    public function select(string $table, array $fields): SqlQueryBuilder
    {
        $this->reset();
        $this->query->base = "SELECT " . implode(', ', $fields) . " FROM " . $table;
        $this->query->type = "select";
        return $this;
    }

    #[Override]
    public function where(string $field, string $value, string $operator = '='): SqlQueryBuilder
    {
        if(!in_array($this->query->type, ['select', 'update', 'delete'])) {
            throw new Exception("Where só pode ser usado com select update ou delete");
        }

        $this->query->where[] = "$field $operator '$value'";

        return $this;
    }

    public function limit(int $start, int $offset = 0): SqlQueryBuilder
    {
        if(!in_array($this->query->type, ['select'])) {
            throw new Exception('Limit só é usado com select');
        }

        $this->query->limit = " LIMIT " . $start . ", " . $offset;
        return $this;
    }

    #[Override]
    public function getSql(): string
    {
        $query = $this->query;
        $sql = $query->base;
        if(!empty($query->where)){
            $sql .= " WHERE " . implode(' AND ', $query->where);
        }
        if(isset($query->limit)) {
            $sql .= $query->limit;
        }
        $sql .= ";";
        return $sql;
    }
}

class PostgresQueryBuilder extends MysqlQueryBuilder
{
    
    public function limit(int $start, int $offset = 0): SqlQueryBuilder
    {
        parent::limit($start, $offset);
        $this->query->limit = " LIMIT " . $start . " OFFSET " . $offset;
        return $this;
    }

}

function clientCode(SQLQueryBuilder $queryBuilder)
{
    $query = $queryBuilder
        ->select("users", ["name", "email", "password"])
        ->where("age", "18", ">")
        ->where("age", "30", "<")
        ->limit(10, 20)
        ->getSQL();

    echo $query;
}


echo "Mysql\n";
clientCode(new MysqlQueryBuilder());

echo "\n\nPostgres\n";
clientCode(new PostgresQueryBuilder());