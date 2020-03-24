<?php
    $c = $category;
?>

<div class="form-group">
    <label for="edit-name">Name</label>
    <input value="<?= $c->getCategoryName(); ?>" id="edit-name" name="name" type="text" class="form-control">
</div>