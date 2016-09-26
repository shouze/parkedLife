<?php
declare(strict_types=1);

namespace Shouze\ParkedLife\Domain;

use Shouze\ParkedLife\EventSourcing\Change;
use Shouze\ParkedLife\EventSourcing\IdentifiesAggregate;

final class VehicleWasDescribed implements Change
{
    private $userId;

    private $platenumber;

    private $description;

    public function __construct(UserId $userId, string $platenumber, string $description)
    {
        $this->userId = $userId;
        $this->platenumber = $platenumber;
        $this->description = $description;
    }

    public function getAggregateId(): IdentifiesAggregate
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
