<?php
    $c = $customer;
    if ($c === null) { echo 'Invalid Customer'; return; }
    if (empty($c->getVehicles())) {
        echo 'Customer has no vehicles';
        return;
    }


?>
<div class="table-responsive">
    <table id="customer_list_table" class="table table-hover">
    <?php if (!empty($c->getVehicles())): ?>
        <thead>
            <tr>
                <th>Vehicle Id</th>
                <th>Make</th>
                <th>Model</th>
                <th>Year</th>
                <th>Reg No</th>
                <th>Edit</th>
                <!-- <th>&nbsp;</th> -->
            </tr>
        </thead>
    <?php else: echo 'This customer has no vehicles'; ?>
    <?php endif; ?>
        <tbody>
            <?php foreach ($c->getVehicles() as $v): ?>
            <tr id="<?= $v->getVehicleId(); ?>">
                <td><?= $v->getVehicleId(); ?></td>
                <td><?= $v->getMake(); ?></td>
                <td><?= $v->getModel(); ?></td>
                <td><?= $v->getYear(); ?></td>
                <td><?= $v->getRegNo(); ?></td>
                <td><a class="edit_vehicle" href="#"><i class="fas fa-pencil-alt" data-toggle="tooltip" data-placement="top" title="Edit Vehicle Details"></i></a></td>
                <!-- <td></td> -->
            </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>