<?php
declare(strict_types=1);

namespace Shouze\ParkedLife\EventSourcing;

interface EventStore
{
    public function commit(Stream $eventStream);

    public function fetch(StreamName $streamName): Stream;
}
