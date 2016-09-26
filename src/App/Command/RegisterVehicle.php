<?php

namespace Shouze\ParkedLife\App\Command;

class RegisterVehicle
{
    private $userId;

    private $platenumber;

    private $description;

    public function __construct($userId, $platenumber, $description)
    {
        $this->userId = $userId;
        $this->platenumber = $platenumber;
        $this->description = $description;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function getPlatenumber()
    {
        return $this->platenumber;
    }

    public function getDescription()
    {
        return $this->description;
    }
}
