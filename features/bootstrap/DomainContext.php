<?php

use mageekguy\atoum\asserter;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use PascalDeVink\ShortUuid\ShortUuid;

use Shouze\ParkedLife\Domain;
use Shouze\ParkedLife\EventSourcing;

class DomainContext implements Context
{
    private $vehicleFleet;

    private $userId;

    private $pastChanges = [];

    private $vehicleFleetHistory;

    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
        $this->userId = ShortUuid::uuid4();
        $this->asserter = new asserter\generator;
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
        $this->pastChanges[] = new Domain\VehicleWasRegistered($this->userId, $platenumber);
    }

    /**
     * @When I register my vehicle with platenumber :platenumber described as :description in my vehicle fleet
     */
    public function iRegisterMyVehicleInMyVehicleFleet($platenumber, $description)
    {
        $this->vehicleFleet = $this->reconstituteVehicleFleetFromHistory();
        $this->vehicleFleet->registerVehicle($platenumber, $description);
    }

    /**
     * @When I park my vehicle with platenumber :platenumber at location :location
     */
    public function iParkMyVehicleWithPlatenumberAtLocation($platenumber, Domain\Location $location)
    {
        $this->vehicleFleet = $this->reconstituteVehicleFleetFromHistory();
        $this->parkedAt = new \DateTimeImmutable;
        $this->vehicleFleet->parkVehicle($platenumber, $location, $this->parkedAt);
    }

    /**
     * @Then the vehicle with platenumber :platenumber should be part of my vehicle fleet
     */
    public function theVehicleShouldBePartOfMyVehicleFleet($platenumber)
    {
        $this->vehicleFleetShouldHaveRecordedChanges([
            new Domain\VehicleWasRegistered($this->userId, $platenumber)
        ]);
    }

    /**
     * @Then the known location of my vehicle :platenumber should be :location
     */
    public function theKnownLocationOfMyVehicleShouldBe($platenumber, Domain\Location $location)
    {
        $this->vehicleFleetShouldHaveRecordedChanges([
            new Domain\VehicleWasParked($this->userId, $platenumber, $location->getLatitude(), $location->getLongitude(), $this->parkedAt->getTimestamp())
        ]);
    }

    private function reconstituteVehicleFleetFromHistory()
    {
        if (count($this->pastChanges) <= 0) {
            return Domain\VehicleFleet::ofUser($this->userId);
        }

        return Domain\VehicleFleet::reconstituteFromHistory(EventSourcing\AggregateHistory::fromEvents($this->pastChanges));
    }

    private function vehicleFleetShouldHaveRecordedChanges(array $changes)
    {
        if (null === $this->vehicleFleetHistory) {
            $this->vehicleFleetHistory = $this->vehicleFleet->popRecordedChanges()->getArrayCopy();
        }
        $this->asserter
            ->phpArray($this->vehicleFleetHistory)
            ->containsValues($changes)
        ;
    }
}
