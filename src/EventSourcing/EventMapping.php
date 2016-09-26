<?php
declare(strict_types=1);

namespace Shouze\ParkedLife\EventSourcing;

abstract class EventMapping
{
    protected $mapping = [];

    public function getEventNameFor(Change $event): string
    {
        return $this->valueOfKeyIfExist(get_class($event), array_flip($this->mapping));
    }

    public function getEventClassNameFor(string $eventName): string
    {
        return $this->valueOfKeyIfExist($eventName, $this->mapping);
    }

    private function valueOfKeyIfExist($key, array $array): string
    {
        if (false === array_key_exists($key, $array)) {
            throw new \LogicException(sprintf('Missing key %s in the event mapping', $key));
        }

        return $array[$key];
    }
}
