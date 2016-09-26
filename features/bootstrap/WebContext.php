<?php

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Behat\Gherkin\Node\TableNode;
use PascalDeVink\ShortUuid\ShortUuid;
use Rezzza\RestApiBehatExtension\Rest\RestApiBrowser;

use Shouze\ParkedLife\Ports;
use Shouze\ParkedLife\Adapters;
use Shouze\ParkedLife\Domain;
use Shouze\ParkedLife\EventSourcing;

class WebContext implements Context
{
    private $eventStore;

    private $userId;

    private $restApiBrowser;

    private $jsonContext;

    public function __construct(EventSourcing\EventStore $eventStore, RestApiBrowser $restApiBrowser)
    {
        $this->eventStore = $eventStore;
        $this->restApiBrowser = $restApiBrowser;
        $this->restApiBrowser->setRequestHeader('Content-Type', 'application/json');
        $this->restApiBrowser->setRequestHeader('X-Show-Exception-Token', 't0kt0k');
        $this->userId = ShortUuid::uuid4();
    }

    /**
     * @BeforeScenario
     */
    public function gatherContexts(BeforeScenarioScope $scope)
    {
        $environment = $scope->getEnvironment();

        $this->jsonContext = $environment->getContext('Rezzza\RestApiBehatExtension\Json\JsonContext');
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
        $this->eventStore->commit(
            new EventSourcing\Stream(
                new EventSourcing\StreamName('vehicle_fleet-'.$this->userId),
                new \ArrayIterator([
                    new Domain\VehicleWasRegistered($this->userId, $platenumber)
                ])
            )
        );
    }

    /**
     * @When I park my vehicle with platenumber :platenumber at location :location
     */
    public function iParkMyVehicleWithPlatenumberAtLocation($platenumber, Domain\Location $location)
    {
        // Endpoint should be improve to follow REST
        $this->restApiBrowser->sendRequest(
            'POST',
            sprintf('/users/%s/vehicles/location', $this->userId),
            json_encode([
                'platenumber' => $platenumber,
                'location' => $location,
            ])
        );
    }

    /**
     * @When I register my vehicle with platenumber :platenumber described as :description in my vehicle fleet
     */
    public function iRegisterMyVehicleWithPlatenumberDescribedAsInMyVehicleFleet($platenumber, $description)
    {
        $this->restApiBrowser->sendRequest(
            'POST',
            sprintf('/users/%s/vehicles', $this->userId),
            json_encode([
                'platenumber' => $platenumber,
                'description' => $description,
            ])
        );
    }

    /**
     * @Then the vehicle with platenumber :platenumber should be part of my vehicle fleet
     */
    public function theVehicleWithPlatenumberShouldBePartOfMyVehicleFleet($platenumber)
    {
        $this->restApiBrowser->sendRequest(
            'GET',
            sprintf('/users/%s/vehicles', $this->userId)
        );
        // Shoud iterate to be a better assertion
        $this->jsonContext->theJsonNodeShouldBeEqualTo('vehicles[0].platenumber', $platenumber);
    }

    /**
     * @Then the known location of my vehicle :platenumber should be :location
     */
    public function theKnownLocationOfMyVehicleShouldBe($platenumber, Domain\Location $location)
    {
        $this->restApiBrowser->sendRequest(
            'GET',
            sprintf('/users/%s/vehicles', $this->userId)
        );
        $this->jsonContext->theJsonNodeShouldBeEqualTo('vehicles[0].location.latitude', $location->getLatitude());
        $this->jsonContext->theJsonNodeShouldBeEqualTo('vehicles[0].location.longitude', $location->getLongitude());
    }
}
