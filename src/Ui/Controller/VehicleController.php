<?php

namespace Shouze\ParkedLife\Ui\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use League\Tactician\CommandBus;
use Shouze\ParkedLife\App\VehicleQueryService;
use Shouze\ParkedLife\App\Command;
use Shouze\ParkedLife\App\Query;

class VehicleController
{
    private $commandBus;

    private $vehicleQueryService;

    public function __construct(CommandBus $commandBus, VehicleQueryService $vehicleQueryService)
    {
        $this->commandBus = $commandBus;
        // Wait tactician let us handle 2 bus differently
        $this->vehicleQueryService = $vehicleQueryService;
    }

    public function registerVehicle(Request $request)
    {
        $this->commandBus->handle(
            new Command\RegisterVehicle(
                $request->get('userId'),
                $request->get('platenumber'),
                $request->get('description')
            )
        );

        return new JsonResponse(['status' => 'ok']);
    }

    public function parkVehicle(Request $request)
    {
        $this->commandBus->handle(
            new Command\ParkVehicle(
                $request->get('userId'),
                $request->get('platenumber'),
                $request->get('location')
            )
        );

        return new JsonResponse(['status' => 'ok']);
    }

    public function listVehicles(Request $request)
    {
        // wait Symfony 3.2 and new JsonReponse::fromJsonString
        return new JsonResponse(
            $this->vehicleQueryService->vehicleFleetOfUser(new Query\VehicleFleetOfUser($request->get('userId'))),
            Response::HTTP_OK,
            [],
            true
        );
    }
}
