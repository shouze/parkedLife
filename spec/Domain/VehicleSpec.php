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
        $this->beConstructedThrough('register', ['123 DE 456', 'user', 'Some car description']);
    }

    public function it_knows_its_platenumber()
    {
        $this->hasPlatenumber('123 DE 456')->shouldBe(true);
    }

    public function it_knows_it_is_not_its_platenumber()
    {
        $this->hasPlatenumber('123 FR 456')->shouldBe(false);
    }

    public function it_knows_where_it_is_parked()
    {
        $this->park(Location::fromString('3.14,5.67'), new \DateTime);
        $this->isLocatedAt(Location::fromString('3.14,5.67'))->shouldBe(true);
    }

    public function it_knows_where_it_is_not_parked()
    {
        $this->park(Location::fromString('3.14,5.67'), new \DateTime);
        $this->isLocatedAt(Location::fromString('3.14,4.12'))->shouldBe(false);
    }
}
