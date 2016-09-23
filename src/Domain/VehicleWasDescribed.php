<?php
declare(strict_types=1);

namespace Shouze\ParkedLife\Domain;

final class VehicleWasDescribed
{
    private $platenumber;

    private $description;

    public function __construct(string $platenumber, string $description)
    {
        $this->platenumber = $platenumber;
        $this->description = $description;
    }

    public function getPlatenumber(): string
    {
        return $this->platenumber;
    }

    public function getDescription(): string
    {
        return $this->description;
    }
}
