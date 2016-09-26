<?php
declare(strict_types=1);

namespace Shouze\ParkedLife\EventSourcing;

interface Change
{
    public function getAggregateId(): IdentifiesAggregate;
}
