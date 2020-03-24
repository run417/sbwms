<?php

namespace sbwms\Model\Vehicle;

use sbwms\Model\Vehicle\Vehicle;

class VehicleSerializerService {

    public function json(Vehicle $v) {
        $vehicle = [];
        $vehicle['vehicleId'] = $v->getVehicleId();
        $vehicle['make'] = $v->getMake();
        $vehicle['model'] = $v->getModel();
        $vehicle['year'] = $v->getYear();
        $vehicle['regNo'] = $v->getRegNo();
        $vehicle['type'] = $v->getType();
        $vehicle['vin'] = $v->getVin();
        $vehicle['customerId'] = $v->getOwnerId();
        return \json_encode($vehicle);
    }
}