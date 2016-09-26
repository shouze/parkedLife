<?php

namespace Shouze\ParkedLife\App\Command;

class ParkVehicle
{
    private $userId;

    private $platenumber;

    private $location;

    public function __construct($userId, $platenumber, $location)
    {
        $this->userId = $userId;
        $this->platenumber = $platenumber;
        $this->location = $location;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function getPlatenumber()
    {
        return $this->platenumber;
    }

    public function getLocation()
    {
        return $this->location;
    }
}
