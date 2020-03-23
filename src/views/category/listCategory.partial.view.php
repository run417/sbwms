<div class="table-responsive">
    <table id="category-list-table" class="table table-hover">
        <thead>
            <tr>
                <?php if(empty($categories)): echo 'No categories created in the inventory. Click \'Create Category\' to create a new category'; ?>
                <?php else: ?>
                <th>Category Id</th>
                <th>Name</th>
                <th>&nbsp;</th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($categories as $c): ?>
            <tr id="<?= $c->getCategoryId(); ?>">
                <td><?= $c->getCategoryId(); ?></td>
                <td><?= $c->getName(); ?></td>
                <td><a href="#"><i class="far fa-list-alt" data-toggle="tooltip" data-placement="top" title="Edit Category Details"></i></a></td>
                <!-- <td></td> -->
            </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>