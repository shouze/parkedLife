<?php
declare(strict_types=1);

namespace Shouze\ParkedLife\Domain;

class Location
{
    private $latitude;

    private $longitude;

    public function __construct(float $latitude, float $longitude)
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }

    public static function fromString(string $locationAsString): Location
    {
        list($latitude, $longitude) = sscanf($locationAsString, '%f,%f');

        return new Location($latitude, $longitude);
    }

    public function isEqualTo(Location $location): bool
    {
        return
            $this->getLatitude() === $location->getLatitude() &&
            $this->getLongitude() === $location->getLongitude()
        ;
    }

    public function getLatitude(): float
    {
        return $this->latitude;
    }

    public function getLongitude(): float
    {
        return $this->longitude;
    }
}
