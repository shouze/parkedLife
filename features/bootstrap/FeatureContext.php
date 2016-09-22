<?php

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;

use Shouze\ParkedLife\Domain;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context
{
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
     * @When I register my vehicle with platenumber :platenumber in my vehicle fleet
     */
    public function iRegisterMyVehicleInMyVehicleFleet($platenumber)
    {
        $this->vehicleFleet->registerVehicle($platenumber);
    }

    /**
     * @Then the vehicle with platenumber :platenumber should be part of my vehicle fleet
     */
    public function theVehicleShouldBePartOfMyVehicleFleet($platenumber)
    {
        $this->vehicleFleet->isVehiclePartOf($platenumber);
    }
}
