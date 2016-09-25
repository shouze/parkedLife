<?php
require_once __DIR__ . '/vendor/autoload.php';

use Shouze\ParkedLife\Domain;
use Shouze\ParkedLife\EventSourcing;
use Shouze\ParkedLife\Adapters;
use Shouze\ParkedLife\Ports;

// 1. We start from pure domain code
$userId = new Domain\UserId('shouze');
$fleet = Domain\VehicleFleet::ofUser($userId);
$platenumber = 'AM 069 GG';
$fleet->registerVehicle($platenumber, 'My benz');
$fleet->parkVehicle($platenumber, Domain\Location::fromString('4.1, 3.12'), new \DateTimeImmutable());

// 2. We build our sourceable stream
$streamName = new EventSourcing\StreamName(sprintf('vehicle_fleet-%s', $userId));
$stream = new EventSourcing\Stream($streamName, $fleet->popRecordedChanges());

// 3. We adapt the domain to the infra through event sourcing
$serializer = new EventSourcing\EventSerializer(
    new Domain\EventMapping,
    new Symfony\Component\Serializer\Serializer(
        [
            new Symfony\Component\Serializer\Normalizer\PropertyNormalizer(
                null,
                new Symfony\Component\Serializer\NameConverter\CamelCaseToSnakeCaseNameConverter
            )
        ],
        [ new Symfony\Component\Serializer\Encoder\JsonEncoder ]
    )
);
$eventStore = new Adapters\FilesystemEventStore(__DIR__.'/var/eventstore', $serializer, new Ports\FileHelper);
$eventStore->commit($stream);
