<?php
declare(strict_types=1);

namespace Shouze\ParkedLife\Adapters;

use Shouze\ParkedLife\Domain\VehicleFleet;
use Shouze\ParkedLife\Domain\VehicleFleetRepository;
use Shouze\ParkedLife\EventSourcing\EventStore;
use Shouze\ParkedLife\EventSourcing\Stream;
use Shouze\ParkedLife\EventSourcing\StreamName;

class EventStoreVehicleFleetRepository implements VehicleFleetRepository
{
    private $eventStore;

    public function __construct(EventStore $eventStore)
    {
        $this->eventStore = $eventStore;
    }

    public function save(VehicleFleet $vehicleFleet)
    {
        $historyToSave = $vehicleFleet->popRecordedChanges();

        $this->eventStore->commit(
            new Stream(
                new StreamName('vehicle_fleet-'.$vehicleFleet->getAggregateId()),
                $historyToSave
            )
        );
    }
}
