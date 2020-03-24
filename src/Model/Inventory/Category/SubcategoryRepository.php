<?php

namespace sbwms\Model\Inventory\Category;

use sbwms\Model\Inventory\Category\Subcategory;
use sbwms\Model\Inventory\Category\SubcategoryMapper;

class SubcategoryRepository {
    private $subcategoryMapper;

    public function __construct(SubcategoryMapper $_scatm) {
        $this->subcategoryMapper = $_scatm;
    }

    public function findAll() {
        $sql = "SELECT * FROM subcategory";
        $bindings = [];
        $subcategories = $this->subcategoryMapper->find($bindings, $sql);
        return $subcategories;
    }

    public function findAllActive() {
        $sql = "SELECT * FROM subcategory WHERE state=:state";
        $bindings = ['state' => 1];
        $subcategories = $this->subcategoryMapper->find($bindings, $sql);
        return $subcategories;
    }

    public function findById(string $id) {
        $sql = "SELECT * FROM subcategory WHERE subcategory_id=:subcategory_id AND state=:state";
        $bindings = ['subcategory_id' => $id, 'state' => 1];
        $subcategories = $this->subcategoryMapper->find($bindings, $sql);
        return array_shift($subcategories);
    }

    public function findByCategory(string $id) {
        $sql = "SELECT * FROM subcategory WHERE category_id=:category_id AND state=:state";
        $bindings = ['category_id' => $id, 'state' => 1];
        $subcategories = $this->subcategoryMapper->find($bindings, $sql);
        return $subcategories;
    }

    public function save(Subcategory $subcategory) {
        if ($subcategory->getSubcategoryId() === null) {
            return $this->subcategoryMapper->insert($subcategory);
        }
        return $this->subcategoryMapper->update($subcategory);
    }
}