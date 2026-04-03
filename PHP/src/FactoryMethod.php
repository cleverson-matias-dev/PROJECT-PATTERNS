<?php
declare(strict_types=1);

// Factory Method
# O tipo de transporte é escolhido na criação da logística
# posso alterar o tipo de transporte ou adicionar mais um sem alterar o código cliente
# o cliente não entende e não precisa entender de transportar.

interface ITransporte {
    public function transportar(): void;
}

class Carreta implements ITransporte {
    
    public function transportar(): void
    {
        echo "Carreta iniciando transporte...\n";
    }
}

class Trem implements ITransporte {
    
    public function transportar(): void
    {
        echo "Trem iniciando transporte...\n";
    }
}

class Navio implements ITransporte {
    
    public function transportar(): void
    {
        echo "Navio iniciando transporte...\n";
    }
}

class TransporteFactory {

    private static array $transports = [
        'terrestre' => Carreta::class,
        'ferroviario' => Trem::class,
        'maritimo' => Navio::class
    ];

    public static function createTransport(string $tipo) {
        return match ($tipo) {
            'terrestre' => new self::$transports[$tipo](),
            'ferroviario' => new self::$transports[$tipo](),
            'maritimo' => new self::$transports[$tipo](),
            default => throw new Error('Transporte não encontrado')
        };
    }

}

class Logistica {
    private ITransporte $transporte;

    public function __construct(string $tipoTransporte)
    {
        $this->transporte = TransporteFactory::createTransport($tipoTransporte);
    }

    public function entregarProduto() {
        // Código anterior...
        $this->transporte->transportar();
    }
}

$logistica = new Logistica('maritimo');
$logistica->entregarProduto();

$logistica = new Logistica('ferroviario');
$logistica->entregarProduto();

$logistica = new Logistica('terrestre');
$logistica->entregarProduto();