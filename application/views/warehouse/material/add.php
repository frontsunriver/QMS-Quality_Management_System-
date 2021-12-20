<input type="hidden" name="id" value="<?= !$material ? -1 : $material->id ?>">
<div class="form-group">
    <div class="row">
        <div class="col-sm-6">
            <label>Name</label>
            <input type="text" class="form-control" name="add[name]" placeholder="" value="<?= !$material ? '' : $material->name ?>" disabled>
        </div>
        <div class="col-sm-6">
            <label>Lot/Trace Number</label>
            <input type="text" class="form-control" name="add[upc]" value="<?= !$material ? '' : $material->upc ?>" disabled>
        </div>
    </div>
</div>
<div class="form-group">
    <div class="row">
        <div class="col-sm-6">
            <label>Quantity</label>
            <input type="number" class="form-control" name="add[quantity]" placeholder="" value="<?= !$material ? '' : $material->quantity ?>">
        </div>
        <div class="col-sm-6">
            <label>Barcode</label>
            <input type="text" class="form-control" name="add[barcode]" value="<?= !$material ? '' : $material->barcode ?>" disabled>
        </div>
    </div>
</div>
<div class="form-group">
    <div class="row">
        <div class="col-sm-6">
            <label>Supplier</label>
            <select class="form-control" name="add[supplier_id]" disabled>
            	<?php foreach ($suppliers as $supplier) : ?>
            		<option value="<?= $supplier->id ?>" <?= $material && $material->supplier_id == $supplier->id ? 'selected' : '' ?>><?= $supplier->name ?></option>
            	<?php endforeach; ?>
            </select>
        </div>
        <div class="col-sm-6">
            <label>Warehouse</label>
            <select class="form-control" name="add[warehouse_id]" disabled>
                <?php foreach ($warehouses as $warehouse) : ?>
                    <option value="<?= $warehouse->id ?>" <?= $material && $material->warehouse_id == $warehouse->id ? 'selected' : '' ?>><?= $warehouse->name ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
</div>