<table id="schedule-table" class="table table-hover">
    <thead>
        <th>Service Order Id</th>
        <th>Booking Id</th>
        <th>Employee</th>
        <th>Date</th>
        <th>Start Time</th>
        <th>Resources</th>
    </thead>
    <tbody>
        <?php foreach ($serviceOrders as $s): ?>
            <tr id="<?= $s->getId(); ?>">
                <td><?= $s->getId(); ?></td>
                <td><?= $s->getBooking()->getId(); ?></td>
                <td><?= $s->getBooking()->getEmployee()->getFirstName(); ?></td>
                <td><?= $s->getBooking()->getStartDateTime()->format('Y-m-d'); ?></td>
                <td><?= $s->getBooking()->getStartDateTime()->format('H:i:s'); ?></td>
                <td><a class="manage-resources" href="#"><i class="far fa-list-alt" data-toggle="tooltip" data-placement="top" title="Manage Resources"></i></a></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>