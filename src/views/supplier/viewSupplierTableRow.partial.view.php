<?php
    $s = $supplier;
?>
<tr id="<?= $s->getSupplierId(); ?>">
    <td><?= $s->getSupplierId(); ?></td>
    <td><?= $s->getSupplierName(); ?></td>
    <td><?= $s->getCompanyName(); ?></td>
    <td><?= $s->getTelephone(); ?></td>
    <td><?= $s->getEmail(); ?></td>
    <td><a data-entity-id="<?= $s->getSupplierId(); ?>" class="edit-supplier" href="#"><i class="fas fa-pencil-alt" data-toggle="tooltip" data-placement="top" title="Edit Supplier Details"></i></a></td>
    <!-- <td></td> -->
</tr>
