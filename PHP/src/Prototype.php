<?php
declare(strict_types=1);

// Prototype
# Depois de criar uma página é possível clonar e somente alterar o que precisa
# o método __clone serve para clonar objetos internos deep clone

class Author {
    public string $name;
    public function __construct(string $name) { $this->name = $name; }
}

class Page {
    public string $title;
    public string $body;
    public Author $author;
    public \DateTime $date;

    public function __construct(string $title, string $body, Author $author) {
        $this->title = $title;
        $this->body = $body;
        $this->author = $author;
        $this->date = new \DateTime();
    }

    // O método mágico __clone garante que objetos internos também sejam clonados (deep copy)
    public function __clone() {
        $this->title = "Cópia de " . $this->title;
        $this->date = new \DateTime(); // Atualiza a data da cópia
    }
}

$author = new Author("João Silva");
$prototypePage = new Page("Modelo de Relatório", "Conteúdo base...", $author);

$reportJan = clone $prototypePage;
$reportJan->body = "Dados de Janeiro...";

$reportFeb = clone $prototypePage;
$reportFeb->body = "Dados de Fevereiro...";

echo $reportJan->title;
