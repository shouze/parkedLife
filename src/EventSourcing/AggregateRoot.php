<?php
declare(strict_types=1);

namespace Shouze\ParkedLife\EventSourcing;

abstract class AggregateRoot
{
    private $aggregateId;

    private $recordedChanges = [];

    protected function __construct(IdentifiesAggregate $aggregateId)
    {
        // Use named constructor as it made event sourcing and ubiquitous language easier
        $this->aggregateId = $aggregateId;
    }

    public function getAggregateId(): IdentifiesAggregate
    {
        return $this->aggregateId;
    }

    public static function reconstituteFromHistory(AggregateHistory $history)
    {
        $aggregateRoot = new static($history->getAggregateId());

        foreach ($history as $change) {
            $aggregateRoot->apply($change);
        }

        return $aggregateRoot;
    }

    public function popRecordedChanges(): AggregateHistory
    {
        $pendingChanges = $this->recordedChanges;

        $this->recordedChanges = [];

        return AggregateHistory::fromEvents($pendingChanges);
    }

    protected function record(Change $change)
    {
        $this->recordedChanges[] = $change;
        $this->apply($change);
    }

    private function apply(Change $change)
    {
        $handler = $this->resolveEventHandlerMethodFor($change);

        if (false === method_exists($this, $handler)) {
            throw new \RuntimeException(sprintf(
                "Missing event handler method %s for aggregate root %s",
                $handler,
                get_class($this)
            ));
        }

        $this->{$handler}($change);
    }

    /**
     * For an event named ProductWasRegistered will look for method `whenProductWasRegistered`
     */
    private function resolveEventHandlerMethodFor(Change $change)
    {
        return 'when' . implode('', array_slice(explode('\\', get_class($change)), -1));
    }
}
