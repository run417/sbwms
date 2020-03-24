<?php

namespace sbwms\Model\Inventory\Category;

use sbwms\Model\Inventory\Category\Category;
use sbwms\Model\Inventory\Category\CategoryMapper;

class CategoryRepository {
    private $categoryMapper;

    public function __construct(CategoryMapper $_catm) {
        $this->categoryMapper = $_catm;
    }

    public function findAll() {
        $sql = "SELECT * FROM category";
        $categories = $this->categoryMapper->find([], $sql);
        return $categories;
    }

    public function findAllActive() {
        $sql = "SELECT * FROM category WHERE state=:state";
        $bindings = ['state' => 1];
        $categories = $this->categoryMapper->find($bindings, $sql);
        return $categories;
    }

    public function findById($id) {
        $sql = "SELECT * FROM category WHERE category_id=:category_id AND state=:state";
        $bindings = ['category_id' => $id, 'state' => 1];
        $categories = $this->categoryMapper->find($bindings, $sql);
        return array_shift($categories);
    }

    public function save(Category $category) {
        if ($category->getCategoryId() === null) {
            return $this->categoryMapper->insert($category);
        }
        return $this->categoryMapper->update($category);
    }
}