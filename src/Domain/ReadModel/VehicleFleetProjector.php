<?php

namespace Shouze\ParkedLife\Domain\ReadModel;

use Shouze\ParkedLife\Domain\VehicleWasRegistered;

class VehicleFleetProjector
{
    private $projector;

    public function __construct(Projector $projector)
    {
        $this->projector = $projector;
    }

    public function projectVehicleWasRegistred(VehicleWasRegistered $change)
    {
        $vehicleFleet = new VehicleFleetProjection($change->getAggregateId());
        $vehicleFleet->addVehicle($change->getPlatenumber());
        $this->projector->saveProjection($vehicleFleet);
    }
}
