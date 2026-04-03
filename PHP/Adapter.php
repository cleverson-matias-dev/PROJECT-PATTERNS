<?php
declare(strict_types=1);


// Adapter
# O cliente pode usar Diferent Notifier através do Adapter porque implementa INotifier

interface INofifier {
    public function notify(string $addr): void;
}

class MailNotifier implements INofifier {
    public function notify(string $addr): void {
        echo 'MailNotifier: enviando email...';
    }
}

class DiferentNotifier {
    private $address;

    public function __construct(string $address) {
        $this->address = $address;
    }

    public function sendEmail() {
        echo 'DiferentNotifier: inviando notificação';
    }
}

class DiferentNotifierAdapter implements INofifier{

    public function notify(string $addr): void {
        $notifier = new DiferentNotifier($addr);
        $notifier->sendEmail();
    }
}


class Client {
    private INofifier $notifier;

    public function __construct(INofifier $notifier) {
        $this->notifier = $notifier;
    }

    public function sendNotification(string $addr) {
        $this->notifier->notify($addr);
    }
}

$client = new Client(new DiferentNotifierAdapter());
$client->sendNotification('email@email.com');
