<?php
declare(strict_types=1);

namespace Shouze\ParkedLife\Domain;

use Shouze\ParkedLife\EventSourcing\Change;
use Shouze\ParkedLife\EventSourcing\IdentifiesAggregate;

final class VehicleWasRegistered implements Change
{
    private $userId;

    private $platenumber;

    public function __construct(UserId $userId, string $platenumber)
    {
        $this->userId = $userId;
        $this->platenumber = $platenumber;
    }

    public function getAggregateId(): IdentifiesAggregate
    {
        return $this->userId;
    }

    public function getPlatenumber(): string
    {
        return $this->platenumber;
    }
}
