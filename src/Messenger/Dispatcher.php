<?php

namespace App\Messenger;

use App\Messenger\Stamp\LogMessageStamp;
use Symfony\Component\Messenger\MessageBusInterface;

class Dispatcher
{
    protected $messageBus;

    public function __construct(MessageBusInterface $messageBus)
    {
        $this->messageBus = $messageBus;
    }

    public function dispatch(object $message): string
    {
        $envelope = $this->messageBus->dispatch($message, [new LogMessageStamp()]);

        /** @var LogMessageStamp $logMessageStamp */
        $logMessageStamp = $envelope->last(LogMessageStamp::class);

        return $logMessageStamp->getUniqueId();
    }
}
