<?php
declare(strict_types=1);

namespace Shouze\ParkedLife\EventSourcing;

use Symfony\Component\Serializer\Serializer;

class EventSerializer
{
    private $serializer;

    private $eventMapping;

    public function __construct(EventMapping $eventMapping, Serializer $serializer)
    {
        $this->serializer = $serializer;
        $this->eventMapping = $eventMapping;
    }

    public function serialize(Change $change): string
    {
        return $this->serializer->serialize($this->normalize($change), 'json');
    }

    public function deserialize(string $payload): Change
    {
        $eventSerialized = $this->serializer->decode($payload, 'json');

        return $this->serializer->denormalize(
            $eventSerialized['data'],
            $this->eventMapping->getEventClassNameFor($eventSerialized['event_name']),
            'json'
        );
    }

    public function normalize(Change $change): array
    {
        return [
            'event_name' => $this->eventMapping->getEventNameFor($change),
            'data'      => $this->serializer->normalize($change)
        ];
    }
}
