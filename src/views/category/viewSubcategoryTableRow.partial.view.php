<?php
    $s = $subcategory;
?>
<tr id="<?= $s->getSubcategoryId(); ?>">
    <td><?= $s->getSubcategoryId(); ?></td>
    <td><?= $s->getSubcategoryName(); ?></td>
    <td><?= $s->getCategory()->getName(); ?></td>
    <td><a data-entity-id="<?= $s->getSubcategoryId(); ?>" class="edit-subcategory" href="#"><i class="fas fa-pencil-alt" data-toggle="tooltip" data-placement="top" title="Edit Subcategory Details"></i></a></td>
    <!-- <td></td> -->
</tr>