<?php

namespace Shouze\ParkedLife\Ui\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use League\Tactician\CommandBus;
use Shouze\ParkedLife\App\Command;

class VehicleController
{
    private $commandBus;

    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
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
}
