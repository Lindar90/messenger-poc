<?php

namespace App\Messenger\Middleware;

use App\Entity\MessengerMessageLog;
use App\Messenger\Stamp\LogMessageStamp;
use App\Repository\MessengerMessageLogRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Middleware\MiddlewareInterface;
use Symfony\Component\Messenger\Middleware\StackInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Messenger\Stamp\SentStamp;

class LogMessageMiddleware implements MiddlewareInterface
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

    public function handle(Envelope $envelope, StackInterface $stack): Envelope
    {
        $envelope = $stack->next()->handle($envelope, $stack);

        /** @var LogMessageStamp $logMessageStamp */
        $logMessageStamp = $envelope->last(LogMessageStamp::class);

        if (!$logMessageStamp) {
            return $envelope;
        }

        if ($envelope->last(SentStamp::class)) {
            $messageLog = new MessengerMessageLog();
            $messageLog->setStatus(MessengerMessageLog::PENDING_STATUS)
                ->setMessengerMessageId($logMessageStamp->getUniqueId())
                ->setCreatedAt(new \DateTime())
            ;

            $this->em->persist($messageLog);
            $this->em->flush();
        } else if ($envelope->last(HandledStamp::class)) {
            $messageLog = $this->messageLogRepo->findOneBy(['messengerMessageId' => $logMessageStamp->getUniqueId()]);
            $messageLog->setStatus(MessengerMessageLog::HANDLED_STATUS);

            $this->em->flush();
        }

        return $envelope;
    }

}
