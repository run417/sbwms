<div class="table-responsive">
    <table id="customer-list-table" class="table table-hover">
        <thead>
            <tr>
                <th>Customer Id</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Telephone</th>
                <th>Email</th>
                <th>Select</th>
                <!-- <th>&nbsp;</th> -->
            </tr>
        </thead>
        <tbody>
            <?php foreach ($customers as $c): ?>
            <tr id="<?= $c->getCustomerId(); ?>">
                <td><?= $c->getCustomerId(); ?></td>
                <td><?= $c->getFirstName(); ?></td>
                <td><?= $c->getLastName(); ?></td>
                <td><?= $c->getTelephone(); ?></td>
                <td><?= $c->getEmail(); ?></td>
                <td><a data-entity-id="<?= $c->getCustomerId(); ?>" class="select-customer btn btn-sm btn-outline-primary" href="#"><i class="far fa-plus-square" data-toggle="tooltip" data-placement="top" title="Select Customer"></i>Select</a></td>
            </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>