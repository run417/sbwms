<?php

namespace sbwms\Model\Inventory\Item;

use sbwms\Model\Inventory\Item\Item;
use sbwms\Model\Inventory\Item\ItemMapper;

class ItemRepository {
    private $itemMapper;

    public function __construct(ItemMapper $_im) {
        $this->itemMapper = $_im;
    }

    public function findAll() {
        $sql = "SELECT * FROM item";
        $bindings = [];
        $Items = $this->itemMapper->find($bindings, $sql);
        return $Items;
    }

    public function findAllActive() {
        $sql = "SELECT * FROM item WHERE state=:state";
        $bindings = ['state' => 1];
        $Items = $this->itemMapper->find($bindings, $sql);
        return $Items;
    }

    public function findById($id) {
        $sql = "SELECT * FROM item WHERE item_id=:item_id AND state=:state";
        $bindings = ['item_id' => $id, 'state' => 1];
        $Items = $this->itemMapper->find($bindings, $sql);
        return array_shift($Items);
    }

    public function save(Item $item) {
        if ($item->getItemId() === null) {
            return $this->itemMapper->insert($item);
        }
        return $this->itemMapper->update($item);
    }


}