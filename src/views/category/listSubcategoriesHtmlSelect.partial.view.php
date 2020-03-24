<select id="subcategory" name="subcategory" class="custom-select">
    <option value="">Select a subcategory</option>
    <?php foreach($subcategories as $sub): ?>
    <option value="<?= $sub->getId(); ?>"><?= $sub->getSubcategoryName(); ?></option>
    <?php endforeach; ?>
</select>