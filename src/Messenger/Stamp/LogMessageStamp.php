<?php

namespace App\Messenger\Stamp;

use Symfony\Component\Messenger\Stamp\StampInterface;

class LogMessageStamp implements StampInterface
{
    private $uniqueId;

    public function __construct()
    {
        $this->uniqueId = uniqid();
    }

    public function getUniqueId(): string
    {
        return $this->uniqueId;
    }
}
