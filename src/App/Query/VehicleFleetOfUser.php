<?php
declare(strict_types=1);

namespace Shouze\ParkedLife\App\Query;

class VehicleFleetOfUser
{
    private $userId;

    public function __construct($userId)
    {
        $this->userId = $userId;
    }

    public function getUserId()
    {
        return $this->userId;
    }
}
