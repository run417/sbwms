<?php

namespace sbwms\Model\Inventory\Supplier;

use sbwms\Model\Inventory\Supplier\Supplier;

class SupplierEntityManager {
    public function createEntity($data) {
        if (!isset($data['dataSource'])) exit('data source not set');

        $supplier = null;

        if ($data['dataSource'] === 'user') {
            $supplier = $this->createFromUserData($data);
        }

        if ($data['dataSource'] === 'database') {
            $supplier = $this->createFromDbRecord($data);
        }

        return $supplier;
    }

    private function createFromUserData(array $data) {
        $arguments = [
            'supplierId' => $data['supplierId'] ?? null,
            'supplierName' => $data['supplierName'],
            'companyName' => $data['companyName'],
            'telephone' => $data['telephone'],
            'email' => $data['email'],
        ];
        return new Supplier($arguments);
    }

    private function createFromDbRecord(array $data) {
        $arguments = [
            'supplierId' => $data['supplier_id'],
            'supplierName' => $data['supplier_name'],
            'companyName' => $data['company_name'],
            'telephone' => $data['telephone'],
            'email' => $data['email'],
        ];
        return new Supplier($arguments);
    }
}