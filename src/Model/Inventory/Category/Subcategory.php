<?php

namespace sbwms\Model\Inventory\Category;

use sbwms\Model\Inventory\Category\Category;

class Subcategory {
    private $subcategoryId;
    private $subcategoryName;

    /** @var Category */
    private $category;

    public function __construct(array $args, Category $_category) {
        $this->subcategoryId = $args['subcategoryId'] ?? null;
        $this->subcategoryName = $args['subcategoryName'];
        $this->setCategory($_category);
    }

    /**
     * Get the value of subcategoryId
     */
    public function getSubcategoryId()
    {
        return $this->subcategoryId;
    }

    /**
     * Get the value of subcategoryId Alias of getSubcategoryId()
     */
    public function getId()
    {
        return $this->getSubcategoryId();
    }

    /**
     * Get the value of subcategoryName
     */
    public function getSubcategoryName()
    {
        return $this->subcategoryName;
    }

    /**
     * Get the value of category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set the value of category
     */
    public function setCategory(Category $category) {
        $this->category = $category;
    }
}