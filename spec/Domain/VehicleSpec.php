<?php

namespace spec\Shouze\ParkedLife\Domain;

use Shouze\ParkedLife\Domain\Location;
use Shouze\ParkedLife\Domain\Vehicle;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class VehicleSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedThrough('register', ['123 DE 456']);
    }

    function it_has_platenumber()
    {
        $this->hasPlatenumber('123 DE 456')->shouldBe(true);
    }

    function it_knows_where_it_is_parked()
    {
        $this->park(Location::fromString('3.14,5.67'), new \DateTime);
        $this->isLocatedAt(Location::fromString('3.14,5.67'))->shouldBe(true);
    }
}
