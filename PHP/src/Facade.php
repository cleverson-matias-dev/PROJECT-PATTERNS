<?php
declare(strict_types=1);

// FACADE
// o cliente não precisa instanciar estoque, pagamento e email para finalizar o pedido

class Estoque {
    public function baixarEstoque(){}
}
class Pagamento {
    public function cobrar(){}
}
class Email {
    public function enviarConfirmacao(){}
}

class PedidoFacade {
    private Estoque $estoque;
    private Pagamento $pagamento;
    private Email $email;

    public function __construct()
    {
        $this->estoque = new Estoque();
        $this->pagamento = new Pagamento();
        $this->email = new Email();
    }

    public static function finalizarPedido() {
        self::$pagamento->cobrar();
        self::$estoque->baixarEstoque();
        self::$email->enviarConfirmacao();
    }
}

PedidoFacade::finalizarPedido();