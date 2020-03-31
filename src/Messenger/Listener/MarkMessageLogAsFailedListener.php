<?php

namespace App\Messenger\Listener;

use App\Entity\MessengerMessageLog;
use App\Messenger\Stamp\LogMessageStamp;
use App\Repository\MessengerMessageLogRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Messenger\Event\WorkerMessageFailedEvent;

class MarkMessageLogAsFailedListener implements EventSubscriberInterface
{
    protected $messageLogRepo;
    protected $em;

    public function __construct(
        MessengerMessageLogRepository $messageLogRepo,
        EntityManagerInterface $em
    ) {
        $this->messageLogRepo = $messageLogRepo;
        $this->em = $em;
    }

    public function onMessageFailed(WorkerMessageFailedEvent $event)
    {
        $logMessageStamp = $event->getEnvelope()->last(LogMessageStamp::class);

        if (!$logMessageStamp || $event->willRetry()) {
            return;
        }

        $messageLog = $this->messageLogRepo->findOneBy(['messengerMessageId' => $logMessageStamp->getUniqueId()]);
        $messageLog->setStatus(MessengerMessageLog::FAILED_STATUS);

        $this->em->flush();
    }

    public static function getSubscribedEvents()
    {
        return [
            WorkerMessageFailedEvent::class => ['onMessageFailed', -200],
        ];
    }
}
