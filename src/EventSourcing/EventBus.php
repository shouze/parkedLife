<?php
declare(strict_types=1);

namespace Shouze\ParkedLife\EventSourcing;

interface EventBus
{
    public function publish(Change $change);
}
