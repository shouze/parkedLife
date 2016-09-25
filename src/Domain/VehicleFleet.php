<?php
declare(strict_types=1);

namespace Shouze\ParkedLife\Domain;

use Shouze\ParkedLife\EventSourcing\AggregateRoot;
use Shouze\ParkedLife\EventSourcing\Change;

final class VehicleFleet extends AggregateRoot
{
    private $vehicles = [];

    public function __construct(UserId $userId)
    {
        parent::__construct((string)$userId);
    }

    public static function ofUser(UserId $userId): VehicleFleet
    {
        return new VehicleFleet($userId);
    }

    public function registerVehicle(string $platenumber, string $description)
    {
        $this->record(new VehicleWasRegistered($this->getAggregateId(), $platenumber));
        $this->record(new VehicleWasDescribed($this->getAggregateId(), $platenumber, $description));

        return $this->vehicleWithPlatenumber($platenumber);
    }

    public function whenVehicleWasRegistered(VehicleWasRegistered $change)
    {
        $this->vehicles[] = Vehicle::register($change->getPlatenumber(), new UserId($change->getAggregateId()));
    }

    public function describeVehicle(string $platenumber, string $description)
    {
        $this->record(new VehicleWasDescribed($this->getAggregateId(), $platenumber, $description));
    }

    public function whenVehicleWasDescribed(VehicleWasDescribed $change)
    {
        $vehicle = $this->vehicleWithPlatenumber($change->getPlatenumber());
        $vehicle->describe($change->getDescription());
    }

    public function parkVehicle(string $platenumber, Location $where, \DateTimeInterface $when)
    {
        $this->record(new VehicleWasParked($this->getAggregateId(), $platenumber, $where->getLatitude(), $where->getLongitude(), $when->getTimestamp()));
    }

    public function whenVehicleWasParked(VehicleWasParked $change)
    {
        try {
            $vehicle = $this->vehicleWithPlatenumber($change->getPlatenumber());
        } catch (\LogicException $e) {
            throw new \LogicException(sprintf('Cannot park unknown vehicle %s', $change->getPlatenumber(), 0, $e));
        }

        $where = new Location($change->getLatitude(), $change->getLongitude());
        $when = new \DateTimeImmutable(sprintf('@%ld', $change->getTimestamp()));
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
            throw new \LogicException(sprintf('Vehicle with plate number %s is unknown in fleet #%s', $platenumber, $this->getAggregateId()));
        }

        return $vehicle;
    }
}
