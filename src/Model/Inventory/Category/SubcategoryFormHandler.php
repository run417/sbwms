<?php

namespace sbwms\Model\Inventory\Category;

use sbwms\Model\FormHandlerInterface;
use sbwms\Model\Validator;
use sbwms\Model\Inventory\Category\Subcategory;

class SubcategoryFormHandler implements FormHandlerInterface{
    private $validator;
    private $entityManager;

    public function __construct(Validator $_v, SubcategoryEntityManager $_scatem) {
        $this->validator = $_v;
        $this->entityManager = $_scatem;
    }

    public function validate(array $data) {
        $errors = [];
        $name = $data['subcategoryName'] ?? '';
        if ($name === '') {
            $errors[] = 'Subcategory Name cannot be empty';
        }
        if (!empty($errors)) { $errors['validationError'] = true; }
        return $errors;
    }

    public function createEntity(array $data) {
        return $this->entityManager->createEntity($data);
    }

    public function serialize(Subcategory $subcategory) {
        $data = [
            'subcategoryId' => $subcategory->getSubcategoryId(),
            'subcategoryName' => $subcategory->getSubcategoryName(),
            'category' => $subcategory->getCategory()->getCategoryId(),
        ];
        return \json_encode($data);
    }
}

