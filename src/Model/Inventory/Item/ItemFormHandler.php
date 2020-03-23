<?php

namespace sbwms\Model\Inventory\Item;

use sbwms\Model\FormHandlerInterface;
use sbwms\Model\Validator;
use sbwms\Model\Inventory\Item\Item;

class ItemFormHandler implements FormHandlerInterface{
    private $validator;
    private $entityManager;

    public function __construct(Validator $_v, ItemEntityManager $_iem) {
        $this->validator = $_v;
        $this->entityManager = $_iem;
    }

    public function validate(array $data) {
        $errors = [];
        $name = $data['name'] ?? '';
        if ($name === '') {
            $errors[] = 'Item Name cannot be empty';
        }
        if (!empty($errors)) { $errors['validationError'] = true; }
        return $errors;
    }

    public function createEntity(array $data) {
        return $this->entityManager->createEntity($data);
    }

    public function serialize(Item $item) {
        $data = [
            'itemId' => $item->getItemId() ?? $this->generateItemId(),
            'name' => $item->getName(),
            'description' => $item->getDescription(),
            'make' => $item->getMake(),
            'model' => $item->getModel(),
            'brand' => $item->getBrand(),
            'quantity' => $item->getQuantity(),
            'sellingPrice' => $item->getSellingPrice(),
            'reorderLevel' => $item->getReorderLevel(),
            'category' => $item->getSubcategory()->getCategory()->getId(),
            'subcategory' => $item->getSubcategory()->getId(),
            'supplier' => $item->getSupplier()->getId(),
        ];
        return \json_encode($data);
    }
}