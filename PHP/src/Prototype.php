<?php
declare(strict_types=1);

/**
 * Imagine um sistema onde você precisa gerar centenas de Propostas Comerciais
 * ou Contratos de Prestação de Serviço. Esses documentos possuem uma estrutura 
 * pesada: eles carregam logos, cabeçalhos, rodapés com dados da empresa, 
 * cláusulas contratuais padrão, configurações de fonte e margens definidas.
 * Se você instanciar um novo objeto Proposta do zero toda vez, terá que 
 * reprocessar a carga de layouts, templates e conexões de serviço repetidamente.
 */

class LayoutConfig {
    public function __construct(
        public string $logoPath,
        public string $fontFamily,
        public array $margins
    ) {}
}

class Proposta {
    public string $cliente;
    public float $valor;
    public LayoutConfig $layout;

    public function __construct(string $cliente, float $valor, LayoutConfig $layout) {
        $this->cliente = $cliente;
        $this->valor = $valor;
        $this->layout = $layout;
    }

    public function __clone() {
        // Deep Clone: O layout é um objeto complexo, 
        // clonamos ele para permitir customizações futuras por documento
        $this->layout = clone $this->layout;
    }
}

// 1. O "Objeto Pesado": Criado uma única vez
// Imagina que aqui dentro ele busca o logo no S3, define fontes e estilos
$templateBase = new Proposta(
    "Cliente Padrão", 
    0.0, 
    new LayoutConfig("logo_empresa.png", "Arial", ["top" => 20, "left" => 15])
);

// 2. Uso do Prototype
// Agora, para gerar documentos para 100 clientes, não recriamos o layout
$p1 = clone $templateBase;
$p1->cliente = "Empresa X";
$p1->valor = 5000.00;

$p2 = clone $templateBase;
$p2->cliente = "Empresa Y";
$p2->valor = 7500.00;
// Podemos ajustar uma margem específica para este cliente sem afetar o template
$p2->layout->margins['left'] = 25; 

echo "Proposta gerada para: {$p1->cliente}\n";
echo "Proposta gerada para: {$p2->cliente}";