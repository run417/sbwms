<?php
    $b = $bay;
?>
<tr id="<?= $b->getBayId(); ?>">
    <td><?= $b->getBayId(); ?></td>
    <td><?= $b->getBayType(); ?></td>
    <td><?= $b->getBayStatus(); ?></td>
    <td><a data-entity-id="<?= $b->getBayId(); ?>" class="edit-bay" href="#"><i class="fas fa-pencil-alt" data-toggle="tooltip" data-placement="top" title="Edit Bay Details"></i></a></td>
    <!-- <td></td> -->
</tr>
