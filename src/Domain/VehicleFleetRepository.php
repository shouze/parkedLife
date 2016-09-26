<?php 

namespace Shouze\ParkedLife\Domain;

interface VehicleFleetRepository
{
    public function save(VehicleFleet $vehicleFleet);
}
