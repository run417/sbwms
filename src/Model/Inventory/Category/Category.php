<?php

namespace sbwms\Model\Inventory\Category;

class Category {
    private $categoryId;
    private $name;

    public function __construct(array $args) {
        $this->categoryId = $args['categoryId'] ?? null;
        $this->name = $args['name'];
    }

    /**
     * Get the value of category id
     */
    public function getCategoryId()
    {
        return $this->categoryId;
    }

    /**
     * Alias of getCategoryId
     */
    public function getId()
    {
        return $this->getCategoryId();
    }

    /**
     * Get the value of category name
     */
    public function getName()
    {
        return $this->name;
    }

}