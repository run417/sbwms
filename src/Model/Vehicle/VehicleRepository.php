<?php

namespace sbwms\Model\Vehicle;

use sbwms\Model\Vehicle\VehicleMapper;

class VehicleRepository {
        /** @var VehicleMapper */
        private $mapper;

        public function __construct(VehicleMapper $_mapper) {
            $this->mapper = $_mapper;
        }

        /**
         * Get a Vehicle instance from the database by id
         *
         * @param string The vehicleId in the form of 'V0001'
         * @return Vehicle An instance of Vehicle
         */
        public function findById(string $vehicleId) {
            $sql = "SELECT vehicle.*, customer.* FROM customer, vehicle WHERE vehicle.customer_id = customer.customer_id AND vehicle_id = :vehicle_id";
            $vehicle = $this->mapper->find(['vehicle_id' => $vehicleId], $sql);
            return $vehicle;
        }

        /**
         * @return array
         */
        public function findAllActive() {
            $vehicles = $this->mapper->find();
            return $vehicles;
        }

        public function save(Vehicle $vehicle) {
            if ($vehicle->getOwnerId() === null) {
                exit('Dev Error - No customer VehicleRepository 37');
            }
            if ($vehicle->getVehicleId() === null) {
                return $this->mapper->insert($vehicle);
            } else {
                return $this->mapper->update($vehicle);
            }
        }
}
