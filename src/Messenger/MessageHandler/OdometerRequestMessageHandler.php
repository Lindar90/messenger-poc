<?php

namespace App\Messenger\MessageHandler;

use App\Messenger\Message\OdometerRequestMessage;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class OdometerRequestMessageHandler implements MessageHandlerInterface
{
    public function __invoke(OdometerRequestMessage $odometerRequestMessage)
    {
        dump('Handling ' . self::class);
    }
}
