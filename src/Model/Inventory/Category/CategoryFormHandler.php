<?php

namespace sbwms\Model\Inventory\Category;

use sbwms\Model\FormHandlerInterface;
use sbwms\Model\Validator;
use sbwms\Model\Inventory\Category\Category;

class CategoryFormHandler implements FormHandlerInterface{
    private $validator;
    private $entityManager;

    public function __construct(Validator $_v, CategoryEntityManager $_catem) {
        $this->validator = $_v;
        $this->entityManager = $_catem;
    }

    public function validate(array $data) {
        $errors = [];
        $name = $data['name'] ?? '';
        if ($name === '') {
            $errors[] = 'Category Name cannot be empty';
        }
        if (!empty($errors)) { $errors['validationError'] = true; }
        return $errors;
    }

    public function createEntity(array $data) {
        return $this->entityManager->createEntity($data);
    }

    public function serialize(Category $category) {
        $data = [
            'categoryId' => $category->getCategoryId(),
            'name' => $category->getName(),
        ];
        return \json_encode($data);
    }
}

