<?php
declare(strict_types=1);

namespace Shouze\ParkedLife\Domain;

final class Vehicle
{
    private $platenumber;

    private $userId;

    private $description;

    private $currentLocation;

    private $parkedAt;

    public function __construct(string $platenumber, UserId $userId)
    {
        $this->platenumber = $platenumber;
        $this->userId = $userId;
    }

    public static function register(string $platenumber, UserId $userId): Vehicle
    {
        return new static($platenumber, $userId);
    }

    public function describe(string $description)
    {
        $this->description = $description;
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

    public function isEqualTo(Vehicle $vehicle)
    {
        return $vehicle->platenumber === $this->platenumber;
    }
}
