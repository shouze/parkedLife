<?php
declare(strict_types=1);

namespace Shouze\ParkedLife\Domain;

class UserId
{
    private $value;

    public function __construct($value)
    {
        $this->value = $value;
    }
}
