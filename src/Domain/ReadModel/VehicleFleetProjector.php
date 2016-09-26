<?php

namespace Shouze\ParkedLife\Domain\ReadModel;

use Shouze\ParkedLife\Domain\VehicleWasRegistered;

/**
 * Should be decoupled from Symfony
 */
class VehicleFleetProjector
{
    private $projector;

    public function __construct(Projector $projector)
    {
        $this->projector = $projector;
    }

    public function projectVehicleWasRegistred($change)
    {
        $vehicleFleet = new VehicleFleetProjection($change['user_id']);
        $vehicleFleet->addVehicle($change['platenumber']);
        $this->projector->saveProjection($vehicleFleet);
    }

    public function projectVehicleWasParked($change)
    {
        $vehicleFleet = $this->projector->readProjection(VehicleFleetProjection::class, $change['user_id']);

        $vehicleFleet->locateVehicle(
            $change['platenumber'],
            [
                'latitude' => $change['latitude'],
                'longitude' => $change['longitude'],
            ]
        );
        $this->projector->saveProjection($vehicleFleet);
    }
}
