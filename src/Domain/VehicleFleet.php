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

    public function isVehiclePartOf(string $platenumber)
    {
        return array_reduce(
            $this->vehicles,
            function ($carry, Vehicle $e) use ($platenumber) {
                return $e->hasPlatenumber($platenumber);
            },
            false
        );
    }
}
