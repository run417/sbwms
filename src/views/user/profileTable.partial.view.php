<div class="table-responsive">
    <table id="profile-list-table" class="table table-hover">
        <thead>
            <tr>
                <th>Id</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Telephone</th>
                <th>Email</th>
                <th>Role</th>
                <th></th>
                <!-- <th>&nbsp;</th> -->
            </tr>
        </thead>
        <tbody>
            <?php foreach ($profiles as $p): ?>
            <tr id="<?= $p->getId(); ?>">
                <td class="_pdata"><?= $p->getId(); ?></td>
                <td class="_pdata"><?= $p->getFirstName(); ?></td>
                <td class="_pdata"><?= $p->getLastName(); ?></td>
                <td><?= $p->getTelephone(); ?></td>
                <td><?= $p->getEmail(); ?></td>
                <td class="_pdata _dash"><?= $p->getRole(); ?></td>
                <td><a class="select-profile btn btn-sm btn-outline-primary" href="#" data-toggle="tooltip" data-placement="top" title="Select Profile">Select</a></td>
                <!-- <td></td> -->
            </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>