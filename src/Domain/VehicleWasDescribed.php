<?php
declare(strict_types=1);

namespace Shouze\ParkedLife\Domain;

use Shouze\ParkedLife\EventSourcing\Change;

final class VehicleWasDescribed implements Change
{
    private $userId;

    private $platenumber;

    private $description;

    public function __construct(string $userId, string $platenumber, string $description)
    {
        $this->userId = $userId;
        $this->platenumber = $platenumber;
        $this->description = $description;
    }

    public function getAggregateId(): string
    {
        return $this->userId;
    }

    public function getPlatenumber(): string
    {
        return $this->platenumber;
    }

    public function getDescription(): string
    {
        return $this->description;
    }
}
