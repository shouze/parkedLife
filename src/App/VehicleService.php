<?php

namespace Shouze\ParkedLife\App;

use Shouze\ParkedLife\Domain;

class VehicleService
{
    private $vehicleFleetRepository;

    public function __construct(Domain\VehicleFleetRepository $vehicleFleetRepository)
    {
        $this->vehicleFleetRepository = $vehicleFleetRepository;
    }

    public function registerVehicle(Command\RegisterVehicle $command)
    {
        $vehicleFleet = Domain\VehicleFleet::ofUser(Domain\UserId::fromString($command->getUserId()));
        $vehicleFleet->registerVehicle($command->getPlatenumber(), $command->getDescription());
        $this->vehicleFleetRepository->save($vehicleFleet);
    }
}
