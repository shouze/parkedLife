<?php
declare(strict_types=1);

namespace Shouze\ParkedLife\EventSourcing;

class StreamName
{
    private $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function __toString(): string
    {
        return $this->name;
    }
}
