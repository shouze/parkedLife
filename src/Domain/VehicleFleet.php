<?php

namespace Shouze\ParkedLife\Domain;

class VehicleFleet
{
    private $userId;

    private $vehicles = [];

    public function __construct(UserId $userId)
    {
        $this->userId = $userId;
    }

    public static function ofUser(UserId $userId)
    {
        return new VehicleFleet($userId);
    }

    public function registerVehicle(string $platenumber)
    {
        $vehicle = Vehicle::register($platenumber);

        $this->vehicles[] = $vehicle;

        return $vehicle;
    }

    public function parkVehicle(string $platenumber, Location $where, \DateTimeInterface $when)
    {
        $vehicle = $this->vehicleWithPlatenumber($platenumber);

        if (null === $vehicle) {
            throw new \LogicException(sprintf('Cannot park unknown vehicle %s', $platenumber));
        }

        $vehicle->park($where, $when);
    }

    public function isVehiclePartOf(string $platenumber)
    {
        return null !== $this->vehicleWithPlatenumber($platenumber);
    }

    public function isVehicleLocated(string $platenumber, Location $location)
    {
        $vehicle = $this->vehicleWithPlatenumber($platenumber);

        if (null === $vehicle) {
            throw new \LogicException(sprintf('Cannot locate unknown vehicle %s', $platenumber));
        }

        return $vehicle->isLocatedAt($location);
    }

    private function vehicleWithPlatenumber(string $platenumber)
    {
        return array_reduce(
            $this->vehicles,
            function ($carry, Vehicle $e) use ($platenumber) {
                if ($e->hasPlatenumber($platenumber)) {
                    return $e;
                }
            },
            null
        );
    }
}
