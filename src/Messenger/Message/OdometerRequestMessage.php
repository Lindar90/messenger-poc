<?php

namespace App\Messenger\Message;

class OdometerRequestMessage
{
    protected $vehicleId;

    public function __construct(string $vehicleId)
    {
        $this->vehicleId = $vehicleId;
    }

    public function getVehicleId(): ?string
    {
        return $this->vehicleId;
    }
}
