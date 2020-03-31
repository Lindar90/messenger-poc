<?php

namespace App\Messenger;

use App\Entity\MessengerMessageLog;
use App\Repository\MessengerMessageLogRepository;

class MessageStatus
{
    protected $messageLogRepo;

    public function __construct(MessengerMessageLogRepository $messageLogRepo)
    {
        $this->messageLogRepo = $messageLogRepo;
    }

    public function getStatus($messageId): string
    {
        /** @var MessengerMessageLog $message */
        $message = $this->messageLogRepo->findOneBy(['messengerMessageId' => $messageId]);

        return $message->getStatus();
    }
}
