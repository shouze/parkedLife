<?php
declare(strict_types=1);

namespace Shouze\ParkedLife\EventSourcing;

class Stream
{
    private $streamName;

    private $changes;

    public function __construct(StreamName $streamName, \Iterator $changes)
    {
        $this->streamName = $streamName;
        $this->changes = $changes;
    }
    public function getStreamName(): StreamName
    {
        return $this->streamName;
    }

    public function getChanges(): \Iterator
    {
        return $this->changes;
    }
}
