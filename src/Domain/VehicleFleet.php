<?php
declare(strict_types=1);

namespace Shouze\ParkedLife\Domain;

class VehicleFleet
{
    private $userId;

    private $vehicles = [];

    public function __construct(UserId $userId)
    {
        $this->userId = $userId;
    }

    public static function ofUser(UserId $userId): VehicleFleet
    {
        return new VehicleFleet($userId);
    }

    public function registerVehicle(string $platenumber, string $description)
    {
        $changes = [
            new VehicleWasRegistered($platenumber, (string)$this->userId),
            new VehicleWasDescribed($platenumber, $description)
        ];

        foreach ($changes as $change) {
            $handler = sprintf('when%s', implode('', array_slice(explode('\\', get_class($change)), -1)));
            $this->{$handler}($change);
        }

        return $this->vehicleWithPlatenumber($platenumber);
    }

    public function whenVehicleWasRegistered($change)
    {
        $this->vehicles[] = Vehicle::register($change->getPlatenumber(), new UserId($change->getUserId()));
    }

    public function whenVehicleWasDescribed($change)
    {
        $vehicle = $this->vehicleWithPlatenumber($change->getPlatenumber());
        $vehicle->describe($change->getDescription());

        foreach ($this->vehicles as $position => $v) {
            if ($vehicle->isEqualTo($v)) {
                $vehicles[$position] = $vehicle;
                break;
            }
        }
    }

    public function describeVehicle(string $platenumber, string $description)
    {
        $vehicle = $this->vehicleWithPlatenumber($platenumber);

        $vehicle->describe($description);
    }

    public function parkVehicle(string $platenumber, Location $where, \DateTimeInterface $when)
    {
        try {
            $vehicle = $this->vehicleWithPlatenumber($platenumber);
        } catch (\LogicException $e) {
            throw new \LogicException(sprintf('Cannot park unknown vehicle %s', $platenumber, 0, $e));
        }

        $vehicle->park($where, $when);
    }

    public function isVehiclePartOf(string $platenumber): bool
    {
        try {
            $this->vehicleWithPlatenumber($platenumber);
            return true;
        } catch (\LogicException $e) {
            return false;
        }

        return false;
    }

    public function isVehicleLocated(string $platenumber, Location $location): bool
    {
        $vehicle = $this->vehicleWithPlatenumber($platenumber);

        return $vehicle->isLocatedAt($location);
    }

    private function vehicleWithPlatenumber(string $platenumber): Vehicle
    {
        $vehicle =  array_reduce(
            $this->vehicles,
            function ($carry, Vehicle $v) use ($platenumber) {
                if ($v->hasPlatenumber($platenumber)) {
                    return $v;
                }
            },
            null
        );

        if (null === $vehicle) {
            throw new \LogicException(sprintf('Vehicle with plate number %s is unknown in fleet #%s', $platenumber, $this->userId));
        }

        return $vehicle;
    }
}
