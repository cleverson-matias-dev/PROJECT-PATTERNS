<?php
declare(strict_types=1);

// Flyweight
# a fábrica de arvores só cria um tipo de arvóre um vez e armazena
# se eu precisar de uma igual ela não cria outro, retorna a referencia da mesma árvore
# então eu tenho o árvore[a] e árvore[b] referenciando o mesmo [pinheiro] na memória

class TreeType {
    private string $name;
    private string $color;
    private $texture;

    public function __construct(string $name, string $color, string $texture) {
        $this->name = $name;
        $this->color = $color;
        $this->texture = $texture;
    }

    public function draw(int $x, int $y) {
        echo "Desenhando {$this->name} na posição ($x, $y) com cor {$this->color}.\n";
    }
}

class TreeFactory {
    private static array $treeTypes = [];

    public static function getTreeType(string $name, string $color, string $texture): TreeType {
        $key = md5($name . $color . $texture);
        if (!isset(self::$treeTypes[$key])) {
            self::$treeTypes[$key] = new TreeType($name, $color, $texture);
            echo "--- Criando novo tipo de árvore: $name ---\n";
        }
        return self::$treeTypes[$key];
    }
}

class Tree {
    private int $x;
    private int $y;
    private TreeType $type;

    public function __construct(int $x, int $y, TreeType $type) {
        $this->x = $x;
        $this->y = $y;
        $this->type = $type;
    }

    public function render() {
        $this->type->draw($this->x, $this->y);
    }
}

$trees = [];

// Criando 5 Carvalhos em locais diferentes
for ($i = 0; $i < 5; $i++) {
    $type = TreeFactory::getTreeType("Carvalho", "Verde", "Rugosa");
    $trees[] = new Tree(rand(0, 100), rand(0, 100), $type);
}

// Criando 5 Pinheiros em locais diferentes
for ($i = 0; $i < 5; $i++) {
    $type = TreeFactory::getTreeType("Pinheiro", "Verde Escuro", "Lisa");
    $trees[] = new Tree(rand(0, 100), rand(0, 100), $type);
}

// Renderizando todos
foreach ($trees as $tree) {
    $tree->render();
}


