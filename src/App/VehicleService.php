<?php
declare(strict_types=1);

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
        $vehicleFleet = Domain\VehicleFleet::ofUser($command->getUserId());
        $vehicleFleet->registerVehicle($command->getPlatenumber(), $command->getDescription());
        $this->vehicleFleetRepository->save($vehicleFleet);
    }

    public function parkVehicle(Command\ParkVehicle $command)
    {
        $vehicleFleet = $this->vehicleFleetRepository->find($command->getUserId());

        if (null === $vehicleFleet) {
            throw Exception\NotFoundResource::ofType(Domain\VehicleFleet::class, $command->getUserId());
        }

        $location = $command->getLocation();

        $vehicleFleet->parkVehicle(
            $command->getPlatenumber(),
            new Domain\Location((float) $location['latitude'], (float) $location['longitude']),
            new \DateTimeImmutable
        );

        $this->vehicleFleetRepository->save($vehicleFleet);
    }
}
