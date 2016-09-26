<?php
declare(strict_types=1);

namespace Shouze\ParkedLife\Adapters;

use Shouze\ParkedLife\EventSourcing\EventBus;
use Shouze\ParkedLife\EventSourcing\Change;
use Shouze\ParkedLife\EventSourcing\EventSerializer;

use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\GenericEvent;

class SymfonyEventBus implements EventBus
{
    private $eventDispatcher;

    private $eventSerializer;

    public function __construct(EventDispatcher $eventDispatcher, EventSerializer $eventSerializer)
    {
        $this->eventDispatcher = $eventDispatcher;
        $this->eventSerializer = $eventSerializer;
    }

    public function publish(Change $change)
    {
        $eventNormalized = $this->eventSerializer->normalize($change);

        $this->eventDispatcher->dispatch($eventNormalized['event_name'], new GenericEvent(null, $eventNormalized['data']));
    }
}
