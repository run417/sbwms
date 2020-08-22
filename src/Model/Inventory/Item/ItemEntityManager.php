<?php

namespace sbwms\Model\Inventory\Item;

use sbwms\Model\Inventory\Item\Item;
use sbwms\Model\Inventory\Category\Subcategory;
use sbwms\Model\Inventory\Category\SubcategoryRepository;
use sbwms\Model\Inventory\Supplier\Supplier;
use sbwms\Model\Inventory\Supplier\SupplierRepository;

class ItemEntityManager {

    private $subcategoryRepository;
    private $supplierRepository;

    public function __construct(
        SubcategoryRepository $_subcatrepo,
        SupplierRepository $_suprepo
    ) {
        $this->subcategoryRepository = $_subcatrepo;
        $this->supplierRepository = $_suprepo;
    }

    public function createEntity($data) {
        if (!isset($data['_origin'])) exit('data source not set');

        $item = null;

        if ($data['_origin'] === 'user') {
            $item = $this->createFromUserData($data);
        }

        if ($data['_origin'] === 'database') {
            $item = $this->createFromDbRecord($data);
        }

        return $item;
    }

    private function createFromUserData(array $data) {
        $arguments = [
            'itemId' => $data['itemId'] ?? null,
            'name' => $data['name'],
            'description' => $data['description'],
            'make' => $data['make'],
            'model' => $data['model'],
            'brand' => $data['brand'],
            'quantity' => $data['quantity'],
            'reorderLevel' => $data['reorderLevel'],
        ];
        // the key 'category' is actually 'categoryId'
        $subcategory = $this->subcategoryRepository->findById($data['subcategory']);
        $supplier = $this->supplierRepository->findById($data['supplier']);
        $item = new Item($arguments, $subcategory, $supplier);
        return $item;
    }

    private function createFromDbRecord(array $data) {
        $arguments = [
            'itemId' => $data['item_id'],
            'name' => $data['item_name'],
            'description' => $data['description'],
            'make' => $data['make'],
            'model' => $data['model'],
            'brand' => $data['brand'],
            'quantity' => $data['quantity'],
            'sellingPrice' => $data['selling_price'],
            'reorderLevel' => $data['reorder_level'],
        ];

        // the repository method goes three trips to the database.
        $subcategory = $this->subcategoryRepository->findById($data['subcategory_id']);
        $supplier = $this->supplierRepository->findById($data['supplier_id']);
        $item = new Item($arguments, $subcategory, $supplier);
        return $item;
    }
}
