<?php

namespace spec\Shouze\ParkedLife\Domain;

use Shouze\ParkedLife\Domain\Location;
use Shouze\ParkedLife\Domain\UserId;
use Shouze\ParkedLife\Domain\Vehicle;
use Shouze\ParkedLife\Domain\VehicleFleet;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class VehicleFleetSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith(new UserId('123'));
    }

    public function it_register_new_vehicle()
    {
        $this->registerVehicle('123 DE 45', 'My sport car')->shouldReturnAnInstanceOf(Vehicle::class);
    }

    public function it_ensure_registred_vehicle_is_part_of_fleet()
    {
        $this->registerVehicle('123 DE 45', 'My sport car');
        $this->shouldBeVehiclePartOf('123 DE 45');
    }

    public function it_ensure_unregistred_vehicle_is_not_part_of_fleet()
    {
        $this->shouldNotBeVehiclePartOf('123 DE 45');
    }

    public function it_should_park_known_vehicle()
    {
        $this->registerVehicle('123 DE 45', 'My sport car');
        $this->parkVehicle('123 DE 45', Location::fromString('3.14,5.67'), new \DateTime);
        $this->isVehicleLocated('123 DE 45', Location::fromString('3.14,5.67'))->shouldBe(true);
    }

    public function it_should_not_park_unknown_vehicle()
    {
        $this->shouldThrow(\LogicException::class)->duringParkVehicle('123 DE 45', Location::fromString('3.14,5.67'), new \DateTime);
    }

    public function it_should_know_where_vehicle_is_not_located()
    {
        $this->registerVehicle('123 DE 45', 'My sport car');
        $this->parkVehicle('123 DE 45', Location::fromString('3.14,5.67'), new \DateTime);
        $this->isVehicleLocated('123 DE 45', Location::fromString('3.14,4.67'))->shouldBe(false);
    }
}
