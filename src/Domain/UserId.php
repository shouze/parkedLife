<?php

namespace Shouze\ParkedLife\Domain;

class UserId
{
    private $value;

    public function __construct($value)
    {
        $this->value = $value;
    }
}
