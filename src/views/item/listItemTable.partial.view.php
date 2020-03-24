<div class="table-responsive">
    <table id="item-list-table" class="table table-hover">
        <thead>
            <tr>
                <?php if(empty($items)): echo 'No items created in the inventory. Click \'Create Item\' to create a new item'; ?>
                <?php else: ?>
                <th>Item Id</th>
                <th>Name</th>
                <th>Selling Price</th>
                <th>Subategory</th>
                <th>Make</th>
                <th>Model</th>
                <th>Brand</th>
                <th>Quantity</th>
                <th>&nbsp;</th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($items as $i): ?>
            <tr id="<?= $i->getItemId(); ?>">
                <td><?= $i->getItemId(); ?></td>
                <td><?= $i->getName(); ?></td>
                <td><?= $i->getSellingPrice(); ?></td>
                <td><?= $i->getSubcategory()->getSubcategoryName(); ?></td>
                <td><?= $i->getMake(); ?></td>
                <td><?= $i->getModel(); ?></td>
                <td><?= $i->getBrand(); ?></td>
                <td><?= $i->getQuantity(); ?></td>
                <td><a data-entity-id="<?= $i->getItemId(); ?>" class="select-item btn btn-sm btn-outline-primary" href="#"><i class="far fa-plus-square" data-toggle="tooltip" data-placement="top" title="Select Item to Add Purchase Order"></i>Select</a></td>
                <!-- <td></td> -->
            </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>