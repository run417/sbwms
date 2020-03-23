<?php
    $st = $serviceType;
?>
<tr id="<?= $st->getId(); ?>">
    <td><?= $st->getId(); ?></td>
    <td><?= $st->getName(); ?></td>
    <td><?= $st->getStatus(); ?></td>
    <td><?= $st->getDuration()->format('%H hours and %I mins.'); ?></td>
    <td><a data-entity-id="<?= $st->getId(); ?>" class="edit-service-type" href="#"><i class="fas fa-pencil-alt" data-toggle="tooltip" data-placement="top" title="Edit Service Type"></i></a></td>
</tr>