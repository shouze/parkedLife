<?php
declare(strict_types=1);

namespace Shouze\ParkedLife\EventSourcing;

class CorruptedAggregateHistory extends \Exception
{
    public static function byEventNotMatchingAggregateId(string $aggregateId, Change $change)
    {
        return new static(
            sprintf('Aggregate history for id "%s" is corrupted by event : %s.', $aggregateId, var_export($change, true))
        );
    }
}
