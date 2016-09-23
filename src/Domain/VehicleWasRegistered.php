<?php
declare(strict_types=1);

namespace Shouze\ParkedLife\Domain;

final class VehicleWasRegistered
{
    private $platenumber;

    private $userId;

    public function __construct(string $platenumber, string $userId)
    {
        $this->platenumber = $platenumber;
        $this->userId = $userId;
    }

    public function getPlatenumber(): string
    {
        return $this->platenumber;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }
}
