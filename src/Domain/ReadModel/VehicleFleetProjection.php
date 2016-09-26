<?php

namespace Shouze\ParkedLife\Domain\ReadModel;

class VehicleFleetProjection implements Projection, \JsonSerializable
{
    private $vehicles = [];

    private $aggregateId;

    public function __construct($aggregateId)
    {
        $this->aggregateId = $aggregateId;
    }

    public function addVehicle($vehicle)
    {
        $this->vehicles[] = $vehicle;
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
