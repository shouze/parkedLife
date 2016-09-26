<?php

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
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

    public function __construct(RestApiBrowser $restApiBrowser)
    {
        $serializer = new EventSourcing\EventSerializer(
            new Domain\EventMapping,
            new Symfony\Component\Serializer\Serializer(
                [
                    new Symfony\Component\Serializer\Normalizer\PropertyNormalizer(
                        null,
                        new Symfony\Component\Serializer\NameConverter\CamelCaseToSnakeCaseNameConverter
                    )
                ],
                [ new Symfony\Component\Serializer\Encoder\JsonEncoder ]
            )
        );
        $this->eventStore = new Adapters\FilesystemEventStore(
            __DIR__.'/../../var/eventstore',
            $serializer,
            new Ports\FileHelper
        );
        $this->restApiBrowser = $restApiBrowser;
        $this->restApiBrowser->setRequestHeader('Content-Type', 'application/json');
        $this->restApiBrowser->setRequestHeader('X-Show-Exception-Token', 't0kt0k');
        $this->userId = ShortUuid::uuid4();
    }

    /**
     * @Given I registred my vehicle with platenumber :platenumber
     */
    public function iRegistredMyVehicleWithPlatenumber($platenumber)
    {
        $this->eventStore->commit(
            new EventSourcing\EventStream(
                new EventSourcing\EventStreamId('vehicle-fleet_'.$this->userId),
                new \ArrayIterator([
                    new Domain\VehicleWasRegistered($platenumber, $this->userId)
                ])
            )
        );
    }

    /**
     * @When I park my vehicle with platenumber :platenumber at location :location
     */
    public function iParkMyVehicleWithPlatenumberAtLocation($platenumber, $location)
    {
        throw new PendingException();
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
     * @Then the vehicle with platenumber :arg1 should be part of my vehicle fleet
     */
    public function theVehicleWithPlatenumberShouldBePartOfMyVehicleFleet($arg1)
    {
        throw new PendingException();
    }

    /**
     * @Then the known location of my vehicle :arg1 should be :arg2
     */
    public function theKnownLocationOfMyVehicleShouldBe($arg1, $arg2)
    {
        throw new PendingException();
    }
}
