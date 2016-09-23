<?php

namespace spec\Shouze\ParkedLife\Domain;

use Shouze\ParkedLife\Domain\Location;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class LocationSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedThrough('fromString', ['3.14,2.72']);
    }

    function it_is_initializable_from_string()
    {
        $this->getLatitude()->shouldBe('3.14');
        $this->getLongitude()->shouldBe('2.72');
    }

    function it_should_be_equal_to_same_location()
    {
        $this->isEqualTo(Location::fromString('3.14,2.72'))->shouldBe(true);
    }

    function it_should_not_be_equal_to_different_location()
    {
        $this->isEqualTo(Location::fromString('3.14,1.82'))->shouldBe(false);
    }
}
