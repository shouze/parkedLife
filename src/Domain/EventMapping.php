<?php
declare(strict_types=1);

namespace Shouze\ParkedLife\Domain;

use Shouze\ParkedLife\EventSourcing\EventMapping as AbstractEventMapping;

final class EventMapping extends AbstractEventMapping
{
    public function __construct()
    {
        $this->mapping = [
            'vehicle_was_registered.fleet.parkedlife' => VehicleWasRegistered::class,
            'vehicle_was_described.fleet.parkedlife' => VehicleWasDescribed::class,
            'vehicle_was_parked.fleet.parkedlife' => VehicleWasParked::class,
        ];
    }
}
