<?php
declare(strict_types=1);

// Composite
# Composição de arvore de elementos onde você pode tratar o conjunto da mesma forma que o individual.
# Repare que tanto o kit de produtos quanto um produto individual retornam o preço total.

interface Precificavel {
    public function getpreco() : int;
}

readonly class Produto implements Precificavel {

    public function __construct(
        private string $name,
        private int $price,
    ) {}

    public function getpreco(): int
    {
        return $this->price;
    }
}

class KitPromocional implements Precificavel {

    /** @var Precificavel[] */
    private array $items = [];

    public function __construct(private string $nome) {}

    public function adicionar(Precificavel $item) {
        $this->items[] = $item;
    }

    public function getpreco(): int
    {
        $total = 0;
        foreach ($this->items as $item) {
            $total += $item->getpreco();
        }

        return $total;
    }
}

// Código Cliente
$teclado = new Produto('teclado', 4250);
$mouse = new Produto('mouse', 2530);
$monitor = new Produto('monitor', 25000);

$kitBasico = new KitPromocional('kit Básico');
$kitBasico->adicionar($teclado);
$kitBasico->adicionar($mouse);

$kitMaster = new KitPromocional('kit master');
$kitMaster->adicionar($kitBasico);
$kitMaster->adicionar($monitor);

echo $teclado->getpreco() . "\n";
echo $kitBasico->getpreco() . "\n";
echo $kitMaster->getpreco();