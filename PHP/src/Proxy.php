<?php
declare(strict_types=1);

# Quando eu uso o proxy a busca no banco de dados só é realizada quando chamo
# o método complete() explicitamente.

interface IReport {
    public function sintetic(): string;
    public function complete(): string;
}

class FinancialReport implements IReport {

    private string $dados;

    public function __construct(string $id) {
        // Consulta demorada ao banco de dados...
        $this->dados = "Dados do relatório";
    }

    #[Override]
    public function sintetic(): string
    {
        echo 'dados sintetizados.';
        return $this->dados;
    }

    #[Override]
    public function complete(): string
    {
        echo 'relatório completo';
        return $this->dados;
    }
}

class ReportProxy implements IReport {
    private IReport $realReport;
    private string $id;

    public function __construct(string $id) {
        $this->id = $id;
    }

    #[Override]
    public function sintetic(): string
    {
        return "resumo rápido sem consulta ao banco.";
    }

    #[Override]
    public function complete(): string
    {
        if($this->realReport === null) {
            $this->realReport = new FinancialReport($this->id);
        }
        return $this->realReport->complete();
    }
}

$proxy = new ReportProxy('123');
$proxy->sintetic(); // simples
$proxy->complete(); // busca no banco
$proxy->complete(); // busca no cache