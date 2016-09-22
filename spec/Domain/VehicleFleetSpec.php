<?php

namespace spec\Shouze\ParkedLife\Domain;

use Shouze\ParkedLife\Domain\UserId;
use Shouze\ParkedLife\Domain\Vehicle;
use Shouze\ParkedLife\Domain\VehicleFleet;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class VehicleFleetSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(new UserId('123'));
    }

    function it_register_new_vehicle()
    {
        $this->registerVehicle('123 DE 45')->shouldReturnAnInstanceOf(Vehicle::class);
    }

    function it_ensure_registred_vehicle_is_part_of_fleet()
    {
        $this->registerVehicle('123 DE 45');
        $this->shouldBeVehiclePartOf('123 DE 45');
    }
}
