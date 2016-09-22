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

    function it_is_comparable_with_other_location(Location $otherLocation)
    {
        $otherLocation = Location::fromString('3.14,2.72');
        $this->isEqualTo($otherLocation)->shouldBe(true);
    }
}
