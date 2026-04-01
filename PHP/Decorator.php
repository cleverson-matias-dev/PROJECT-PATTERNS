<?php
declare(strict_types=1);

// Decorator
# A classe Client tem a liberdade de notificar o cliente após o serviço para todos os canais adicionados
# em addNotifier possibilitando tratar cada caso de uma forma diferente

interface INotification {
    public function send(string $message): void;
}

class EmailService implements INotification {
    
    public function send(string $message): void
    {
        echo "enviando a mensagem: \"$message\" por email \n";
    }
}

class NotifierDecorator implements INotification {
    protected INotification $notifier;

    public function __construct(INotification $notifier)
    {
        $this->notifier = $notifier;
    }

    public function send(string $message): void
    {
        $this->notifier->send($message);
    }
}

class SmsDecorator extends NotifierDecorator {
    
    public function send(string $message): void
    {
        echo "enviando a mensagem: \"$message\" por sms \n";
        parent::send($message);
    }
}

class FacebookDecorator extends NotifierDecorator {
    
    public function send(string $message): void
    {
        echo "enviando a mensagem: \"$message\" via facebook \n";
        parent::send($message);
    }
}


class Client {
    private INotification $notifier;

    public function __construct(INotification $notifier)
    {
        $this->notifier = $notifier;
    }

    /** @param class-string<NotifierDecorator> $decoratorClass */
    public  function addNotifier(string $decoratorClass) {
        $this->notifier = new $decoratorClass($this->notifier);
    }

    public function doService() {
        $this->notifier->send('Seu serviço foi concluído com sucesso!');
    }
}

$app = new Client(new EmailService());
$app->addNotifier(FacebookDecorator::class);
$app->addNotifier(SmsDecorator::class);
$app->doService();