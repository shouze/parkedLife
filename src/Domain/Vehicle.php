<?php
declare(strict_types=1);

namespace Shouze\ParkedLife\Domain;

class Vehicle
{
    private $platenumber;

    private $userId;

    private $description;

    private $currentLocation;

    private $parkedAt;

    public function __construct(string $platenumber, UserId $userId, string $description)
    {
        $this->platenumber = $platenumber;
        $this->userId = $userId;
        $this->description = $description;
    }

    public static function register(string $platenumber, UserId $userId, string $description): Vehicle
    {
        return new static($platenumber, $userId, $description);
    }

    public function park(Location $where, \DateTimeInterface $when)
    {
        $this->currentLocation = $where;
        $this->parkedAt = $when;
    }

    public function hasPlatenumber(string $platenumber): bool
    {
        return $platenumber === $this->platenumber;
    }

    public function isLocatedAt(Location $location): bool
    {
        return $this->currentLocation->isEqualTo($location);
    }
}
