<?php

namespace Shouze\ParkedLife\Domain\ReadModel;

class VehicleFleetProjection implements Projection, \JsonSerializable
{
    private $vehicles = [];

    private $aggregateId;

    public function __construct(string $aggregateId)
    {
        $this->aggregateId = $aggregateId;
    }

    public function addVehicle(string $vehicle)
    {
        $this->vehicles[] = ['platenumber' => $vehicle];
    }

    public function locateVehicle(string $platenumber, array $location)
    {
        $this->vehicles = array_map(
            function ($vehicle) use ($platenumber, $location) {
                if ($vehicle['platenumber'] == $platenumber) {
                    $vehicle['location'] = $location;
                }

                return $vehicle;
            },
            $this->vehicles
        );
    }

    public function jsonSerialize()
    {
        return [
            'vehicles' => $this->vehicles
        ];
    }

    public function getAggregateId()
    {
        return $this->aggregateId;
    }
}
