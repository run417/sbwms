<?php
    $c = $category;
?>
<tr id="<?= $c->getCategoryId(); ?>">
    <td><?= $c->getCategoryId(); ?></td>
    <td><?= $c->getName(); ?></td>
    <td><a data-entity-id="<?= $c->getCategoryId(); ?>" class="edit-category" href="#"><i class="fas fa-pencil-alt" data-toggle="tooltip" data-placement="top" title="Edit Category Details"></i></a></td>
</tr>