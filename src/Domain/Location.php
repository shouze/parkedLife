<?php
declare(strict_types=1);

namespace Shouze\ParkedLife\Domain;

class Location
{
    private $latitude;

    private $longitude;

    public function __construct($latitude, $longitude)
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }

    public static function fromString(string $locationAsString)
    {
        list($latitude, $longitude) = explode(',', $locationAsString);

        return new Location($latitude, $longitude);
    }

    public function isEqualTo(Location $location)
    {
        return
            $this->getLatitude() === $location->getLatitude() &&
            $this->getLongitude() === $location->getLongitude()
        ;
    }

    public function getLatitude()
    {
        return $this->latitude;
    }

    public function getLongitude()
    {
        return $this->longitude;
    }
}
