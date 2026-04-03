<?php
declare(strict_types=1);

// Abstract Factory
# cada fábrica cria um conjunto de móveis distintos
# se eu trocar de fábrica eu troco o estilo de todos os móveis
# se precisar de outra combinação crio uma nova fábrica sem alterar o código existente

interface ICadeira {
    public function descricao(): void;
}

interface IMesa {
    public function descricao(): void;
}

class CadeiraVitoriana implements ICadeira {
    
    public function descricao(): void
    {
        echo 'Cadeira estilo vitoriana';
    }
}

class CadeiraModerna implements ICadeira {
    
    public function descricao(): void
    {
        echo 'Cadeira estilo moderna';
    }
}

class MesaVitoriana implements IMesa {
    
    public function descricao(): void
    {
        echo "Mesa estilo vitoriana\n";
    }
}

class MesaModerna implements IMesa {
    
    public function descricao(): void
    {
        echo "Mesa estilo moderna\n";
    }
}

interface IFabricaDeMoveis {
    public function criarCadeira(): ICadeira;
    public function criarMesa(): IMesa;
}

class FabricaDeMoveisVitorianos implements IFabricaDeMoveis {
    public function criarCadeira(): ICadeira {
        return new CadeiraVitoriana();
    }

     public function criarMesa(): IMesa {
        return new MesaVitoriana();
    }
}

class FabricaDeMoveisModernos implements IFabricaDeMoveis {
    public function criarCadeira(): ICadeira {
        return new CadeiraModerna();
    }

     public function criarMesa(): IMesa {
        return new MesaModerna();
    }
}

class LojaDeMoveis {
    private IFabricaDeMoveis $fabrica;
    private ICadeira $cadeira;
    private IMesa $mesa;

    public function __construct(IFabricaDeMoveis $fabrica)
    {
        $this->fabrica = $fabrica;
        $this->criarMoveis();
    }

    private function criarMoveis() {
        $this->cadeira = $this->fabrica->criarCadeira();
        $this->mesa = $this->fabrica->criarMesa();
    }

    public function apresentar() {
        $this->cadeira->descricao();
        echo ' e ';
        $this->mesa->descricao();
    }
}

$loja = new LojaDeMoveis(new FabricaDeMoveisVitorianos());
$loja->apresentar();

$loja = new LojaDeMoveis(new FabricaDeMoveisModernos());
$loja->apresentar();