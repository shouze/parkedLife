<?php
declare(strict_types=1);

namespace Shouze\ParkedLife\App;

use Shouze\ParkedLife\Domain\ReadModel;

class VehicleQueryService
{
    private $projector;

    public function __construct(ReadModel\Projector $projector)
    {
        $this->projector = $projector;
    }

    public function vehicleFleetOfUser(Query\VehicleFleetOfUser $query)
    {
        $projection = $this->projector->readProjection(ReadModel\VehicleFleetProjection::class, $query->getUserId());

        if (null === $projection) {
            throw Exception\NotFoundResource::ofType(ReadModel\VehicleFleetProjection::class, $query->getUserId());
        }

        return json_encode($projection);
    }
}
