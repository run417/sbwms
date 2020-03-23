<div class="table-responsive">
<table id="service-items-table" class="table table-hover">
    <thead>
        <tr>
            <th>Item Id</th>
            <th>Item Name</th>
            <th>Selling Price</th>
            <th>Quantity</th>
            <th>Sub. Total</th>
            <!-- <th>&nbsp;</th> -->
            <th>&nbsp;</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($jobCardItems as $i): ?>
        <tr id="<?= $i['item_id']; ?>">
            <td><?= $i['item_id']; ?></td>
            <td><?= $i['item_name']; ?></td>
            <td><?= $i['selling_price']; ?></td>
            <td><?= $i['quantity']; ?></td>
            <td><?php echo sprintf('%0.2f', ($i['selling_price'] * $i['quantity'])); ?></td>
            <td><a data-entity-id="<?= $i['item_id']; ?>" class="text-danger remove-item" href="#"><i class="fas fa-minus-square" data-toggle="tooltip" data-placement="top" title="Remove Item"></i></a></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
</div>
