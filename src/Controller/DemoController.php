<?php

namespace App\Controller;

use App\Messenger\Dispatcher;
use App\Messenger\Message\FailedOdometerRequestMessage;
use App\Messenger\Message\OdometerRequestMessage;
use App\Messenger\MessageStatus;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Routing\Annotation\Route;

class DemoController extends AbstractController
{
    protected $dispatcher;

    public function __construct(Dispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    /**
     * @Route("/dispatchMessage")
     */
    public function dispatch()
    {
        $message = new OdometerRequestMessage('1234567890');

        $messageId = $this->dispatcher->dispatch($message);

        return $this->json([
            'id' => $messageId,
        ]);
    }

    /**
     * @Route("/dispatchFailedMessage")
     */
    public function dispatchFailed()
    {
        $message = new FailedOdometerRequestMessage('0987654321');

        $messageId = $this->dispatcher->dispatch($message);

        return $this->json([
            'id' => $messageId,
        ]);
    }

    /**
     * @Route("/checkStatus/{messageId}")
     */
    public function checkStatus(string $messageId, MessageStatus $messageStatus)
    {
        return $messageStatus->getStatus($messageId);
    }

    /**
     * @Route("/consume/{limit}")
     */
    public function consume(int $limit, KernelInterface $kernel)
    {
       $content = $this->consumeMessages('async', $limit, $kernel);

        return new JsonResponse([]);
    }

    /**
     * @Route("/consumeFailed/{limit}")
     */
    public function consumeFailed(int $limit, KernelInterface $kernel)
    {
       $content = $this->consumeMessages('failed', $limit, $kernel);

        return new JsonResponse([]);
    }

    protected function consumeMessages($transport, $limit, KernelInterface $kernel)
    {
        $application = new Application($kernel);
        $application->setAutoExit(false);

        $input = new ArrayInput([
            'command' => 'messenger:consume',
            'receivers' => [$transport],
            '--limit' => $limit,
            '--time-limit' => 4,
        ]);

        $output = new BufferedOutput();
        $application->run($input, $output);

        $content = $output->fetch();
        dump($content);

        return $content;
    }
}
