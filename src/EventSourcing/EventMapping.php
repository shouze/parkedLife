<?php
declare(strict_types=1);

namespace Shouze\ParkedLife\EventSourcing;

abstract class EventMapping
{
    protected static $mapping = [];

    public function getEventNameFor(Change $change): string
    {
        return $this->valueOfKeyIfExist(get_class($change), array_flip(self::$mapping));
    }

    private function valueOfKeyIfExist($key, array $array): string
    {
        if (false === array_key_exists($key, $array)) {
            throw new \LogicException(sprintf('Missing key %s in the event mapping', $key));
        }

        return $array[$key];
    }
}
