<?php

namespace sbwms\Model\Inventory\Category;

use sbwms\Model\Inventory\Category\Category;

class CategoryEntityManager {

    public function createEntity($data) {
        if (!isset($data['dataSource'])) exit('data source not set');

        $category = null;

        if ($data['dataSource'] === 'user') {
            $category = $this->createFromUserData($data);
        }

        if ($data['dataSource'] === 'database') {
            $category = $this->createFromDbRecord($data);
        }

        return $category;
    }

    private function createFromUserData(array $data) {
        $arguments = [
            'categoryId' => $data['categoryId'] ?? null,
            'name' => $data['name'],
        ];
        return new Category($arguments);
    }

    private function createFromDbRecord(array $data) {
        $arguments = [
            'categoryId' => $data['category_id'],
            'name' => $data['category_name'],
        ];
        return new Category($arguments);
    }
}