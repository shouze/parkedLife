<?php

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Assert\Assertion;

use Shouze\ParkedLife\Domain;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context
{
    private $vehicleFleet;

    private $vehicle;

    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
        $this->vehicleFleet = Domain\VehicleFleet::ofUser(new Domain\UserId('user'));
    }

    /**
     * @Transform :location
     */
    public function castLocation($location)
    {
        return Domain\Location::fromString($location);
    }

    /**
     * @Given I registred my vehicle with platenumber :platenumber
     */
    public function iRegistredMyVehicleWithPlatenumber($platenumber)
    {
        // should be an event newt
        $this->vehicleFleet->registerVehicle($platenumber);
    }

    /**
     * @When I register my vehicle with platenumber :platenumber in my vehicle fleet
     */
    public function iRegisterMyVehicleInMyVehicleFleet($platenumber)
    {
        $this->vehicleFleet->registerVehicle($platenumber);
    }

    /**
     * @When I park my vehicle with platenumber :platenumber at location :location
     */
    public function iParkMyVehicleWithPlatenumberAtLocation($platenumber, Domain\Location $location)
    {
        $this->vehicleFleet->parkVehicle($platenumber, $location, new \DateTimeImmutable);
    }

    /**
     * @Then the vehicle with platenumber :platenumber should be part of my vehicle fleet
     */
    public function theVehicleShouldBePartOfMyVehicleFleet($platenumber)
    {
        $this->vehicleFleet->isVehiclePartOf($platenumber);
    }

    /**
     * @Then the known location of my vehicle :platenumber should be :location
     */
    public function theKnownLocationOfMyVehicleShouldBe($platenumber, Domain\Location $location)
    {
        Assertion::true($this->vehicleFleet->isVehicleLocated($platenumber, $location));
    }
}
