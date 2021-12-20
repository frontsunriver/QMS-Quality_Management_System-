<input type="hidden" name="id" value="<?= !$material ? -1 : $material->id ?>">
<div class="form-group">
    <div class="row">
        <div class="col-sm-6">
            <label>Name</label>
            <input type="text" class="form-control" name="add[name]" placeholder="" value="<?= !$material ? '' : $material->name ?>">
        </div>
        <div class="col-sm-6">
            <label>Material Type</label>
            <input type="text" class="form-control" name="add[type]" placeholder="" value="<?= !$material ? '' : $material->type ?>">
        </div>
    </div>
</div>
<div class="form-group">
    <div class="row">
        <div class="col-sm-6">
            <label>Type</label>
            <select class="form-control" name="add[lot_type]" value="">
                <option value="lot" <?= $material && $material->lot_type == 'lot' ? 'selected' : '' ?>>Lot Number</option>
                <option value="trace" <?= $material && $material->lot_type == 'trace' ? 'selected' : '' ?>>Trace Code</option>
            </select>
        </div>
        <div class="col-sm-6">
            <label>Lot/Trace Number</label>
            <input type="text" class="form-control" name="add[upc]" value="<?= !$material ? '' : $material->upc ?>">
        </div>
    </div>
</div>
<div class="form-group">
    <div class="row">
        <div class="col-sm-6">
            <label>Supplier</label>
            <select class="form-control" name="add[supplier_id]">
                <?php foreach ($suppliers as $supplier) : ?>
                    <option value="<?= $supplier->id ?>" <?= $material && $material->supplier_id == $supplier->id ? 'selected' : '' ?>><?= $supplier->name ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-sm-6">
            <label>Barcode</label>
            <input type="text" class="form-control" name="add[barcode]" value="<?= !$material ? '' : $material->barcode ?>">
        </div>
    </div>
</div>