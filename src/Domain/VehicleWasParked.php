<?php
declare(strict_types=1);

namespace Shouze\ParkedLife\Domain;

use Shouze\ParkedLife\EventSourcing\Change;

final class VehicleWasParked implements Change
{
    private $userId;

    private $platenumber;

    private $latitude;

    private $longitude;

    private $timestamp;

    public function __construct(string $userId, string $platenumber, float $latitude, float $longitude, int $timestamp)
    {
        $this->userId = $userId;
        $this->platenumber = $platenumber;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->timestamp = $timestamp;
    }

    public function getAggregateId(): string
    {
        return $this->userId;
    }

    public function getPlatenumber(): string
    {
        return $this->platenumber;
    }

    public function getLatitude(): float
    {
        return $this->latitude;
    }

    public function getLongitude(): float
    {
        return $this->longitude;
    }

    public function getTimestamp(): int
    {
        return $this->timestamp;
    }
}
