<?php

namespace sbwms\Model\Inventory\Category;

use sbwms\Model\Inventory\Category\Category;
use sbwms\Model\Inventory\Category\CategoryRepository;
use sbwms\Model\Inventory\Category\Subcategory;

class SubcategoryEntityManager {
    private $categoryRepository;

    public function __construct(CategoryRepository $_catrepo) {
        $this->categoryRepository = $_catrepo;
    }

    public function createEntity($data) {
        if (!isset($data['_origin'])) exit('data source not set');

        $subcategory = null;

        if ($data['_origin'] === 'user') {
            $subcategory = $this->createFromUserData($data);
        }

        if ($data['_origin'] === 'database') {
            $subcategory = $this->createFromDbRecord($data);
        }

        return $subcategory;
    }

    private function createFromUserData(array $data) {
        $arguments = [
            'subcategoryId' => $data['subcategoryId'] ?? null,
            'subcategoryName' => $data['subcategoryName'],
        ];
        // the key 'category' is actually 'categoryId'
        $category = $this->categoryRepository->findById($data['category']);
        $subcategory = new Subcategory($arguments, $category);
        return $subcategory;
    }

    private function createFromDbRecord(array $data) {
        $arguments = [
            'subcategoryId' => $data['subcategory_id'],
            'subcategoryName' => $data['subcategory_name'],
        ];
        $category = $this->categoryRepository->findById($data['category_id']);
        $subcategory = new Subcategory($arguments, $category);
        return $subcategory;
    }
}
