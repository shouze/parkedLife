<?php
declare(strict_types=1);

namespace Shouze\ParkedLife\Domain;

use Shouze\ParkedLife\EventSourcing\Change;

final class VehicleWasRegistered implements Change
{
    private $userId;

    private $platenumber;

    public function __construct(string $userId, string $platenumber)
    {
        $this->userId = $userId;
        $this->platenumber = $platenumber;
    }

    public function getAggregateId(): string
    {
        return $this->userId;
    }

    public function getPlatenumber(): string
    {
        return $this->platenumber;
    }
}
