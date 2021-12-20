<input type="hidden" name="id" value="<?= !$warehouse ? -1 : $warehouse->id ?>" />

<div class="form-group">
    <div class="row">
        <div class="col-sm-6">
            <label>Warehouse Name</label>
            <input type="text" class="form-control" placeholder="" name="add[name]" value="<?= !$warehouse ? '' : $warehouse->name ?>">
        </div>
        <div class="col-sm-6">
            <label>Short Name</label>
            <input type="text" class="form-control" placeholder="" name="add[short_name]" value="<?= !$warehouse ? '' : $warehouse->short_name ?>">
        </div>
    </div>
</div>
<div class="form-group">
    <div class="row">
        <div class="col-sm-6">
            <label>Address</label>
            <input type="text" class="form-control" placeholder="" name="add[address]" value="<?= !$warehouse ? '' : $warehouse->address ?>">
        </div>
    </div>
</div>