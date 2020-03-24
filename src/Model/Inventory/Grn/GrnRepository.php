<?php

namespace sbwms\Model\Inventory\Grn;

use sbwms\Model\Inventory\Grn\GrnMapper;

class GrnRepository {
    private $grnMapper;

    public function __construct(GrnMapper $_gm) {
        $this->grnMapper = $_gm;
    }

    public function findAll() {
        $sql = "SELECT * FROM grn";
        $detailSql = "SELECT * FROM grn_detail WHERE grn_id = :grn_id";
        $bindings = [];
        $grns = $this->grnMapper->find($bindings, $sql, $detailSql);
        return $grns;
    }

    public function findAllSansDetails() {
        $sql = "SELECT * FROM grn";
        $bindings = [];
        $grns = $this->grnMapper->find($bindings, $sql);
        return $grns;
    }

    public function save(Grn $grn) {
        if ($grn->getId() === null) {
            return $this->grnMapper->insert($grn);
        }
        return $this->grnMapper->update($grn);
    }
}