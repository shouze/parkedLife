<?php
declare(strict_types=1);

namespace Shouze\ParkedLife\EventSourcing;

class AggregateHistory extends \SplFixedArray
{
    private $aggregateId;

    public function __construct($aggregateId, $events)
    {
        parent::__construct(count($events));

        $index = 0;
        foreach ($events as $event) {
            if ($event->getAggregateId() !== $aggregateId) {
                throw CorruptedAggregateHistory::byEventNotMatchingAggregateId($aggregateId, $event);
            }
            parent::offsetSet($index++, $event);
        }

        $this->aggregateId = $aggregateId;
    }

    public static function fromEvents(array $events)
    {
        $aggregateId = $events[0]->getAggregateId();

        return new static($aggregateId, $events);
    }

    public function getAggregateId()
    {
        return $this->aggregateId;
    }
}
