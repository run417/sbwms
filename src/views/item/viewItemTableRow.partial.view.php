<?php
    $i = $item;
?>
<tr id="<?= $i->getItemId(); ?>">
    <td><?= $i->getItemId(); ?></td>
    <td><?= $i->getName(); ?></td>
    <td><?= $i->getCategory()->getName(); ?></td>
    <td><?= $i->getSubcategory()->getSubcategoryName(); ?></td>
    <td><?= $i->getMake(); ?></td>
    <td><?= $i->getModel(); ?></td>
    <td><?= $i->getBrand(); ?></td>
    <td><?= $i->getQuantity(); ?></td>
    <td><?= $i->getReorderLevel(); ?></td>
    <td><?= $i->getSupplier()->getCompanyName(); ?></td>
    <td><a data-entity-id="<?= $i->getItemId(); ?>" class="edit-item" href="#"><i class="fas fa-pencil-alt" data-toggle="tooltip" data-placement="top" title="Edit Item Details"></i></a></td>
    <!-- <td></td> -->
</tr>