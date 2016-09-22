<?php

namespace Shouze\ParkedLife\Domain;

class Vehicle
{
    private $platenumber;

    private $currentLocation;

    private $parkedAt;

    public function __construct(string $platenumber)
    {
        $this->platenumber = $platenumber;
    }

    public static function register(string $platenumber)
    {
        return new Vehicle($platenumber);
    }

    public function hasPlatenumber(string $platenumber)
    {
        return $platenumber === $this->platenumber;
    }

    public function park(Location $where, \DateTimeInterface $when)
    {
        $this->currentLocation = $where;
        $this->parkedAt = $when;
    }

    public function isLocatedAt(Location $location)
    {
        return $this->currentLocation->isEqualTo($location);
    }
}

