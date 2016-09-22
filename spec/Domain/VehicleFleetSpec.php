<?php

namespace spec\Shouze\ParkedLife\Domain;

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
}
