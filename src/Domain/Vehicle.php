<?php

namespace Shouze\ParkedLife\Domain;

class Vehicle
{
    private $platenumber;

    public function __construct(string $platenumber)
    {
        $this->platenumber = $platenumber;
    }

    public static function register(string $platenumber)
    {
        return new Vehicle($platenumber);
    }

    public function hasPlatenumber(string $platenumber)
    {
        return $platenumber === $this->platenumber;
    }
}

