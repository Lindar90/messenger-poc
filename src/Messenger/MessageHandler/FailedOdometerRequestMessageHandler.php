<?php

namespace App\Messenger\MessageHandler;

use App\Messenger\Message\FailedOdometerRequestMessage;
use Exception;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class FailedOdometerRequestMessageHandler implements MessageHandlerInterface
{
    public function __invoke(FailedOdometerRequestMessage $failedOdometerRequestMessage)
    {
        dump('Handling ' . self::class);
        // throw new Exception('Failed odometer request');
    }
}
