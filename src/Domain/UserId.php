<?php
declare(strict_types=1);

namespace Shouze\ParkedLife\Domain;

class UserId
{
    private $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
