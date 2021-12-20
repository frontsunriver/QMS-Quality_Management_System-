<input type="hidden" name="id" value="<?= !$supplier ? -1 : $supplier->id ?>">
<div class="form-group">
    <div class="row">
        <div class="col-sm-6">
            <label>Name</label>
            <input type="text" class="form-control" name="add[name]" placeholder="" value="<?= !$supplier ? '' : $supplier->name ?>">
        </div>
        <div class="col-sm-6">
            <label>Phone</label>
            <input type="text" class="form-control" name="add[phone]" placeholder="9-999-999-9999" value="<?= !$supplier ? '' : $supplier->phone ?>" data-mask="9-999-999-9999">
            <span class="help-block">9-999-999-9999</span>
        </div>
    </div>
</div>
<div class="form-group">
    <div class="row">
        <div class="col-sm-6">
            <label>Email Address</label>
            <input type="text" class="form-control" name="add[email]" placeholder="eugene@kopyov.com" value="<?= !$supplier ? '' : $supplier->email ?>">
            <span class="help-block">name@domain.com</span>
        </div>
        <div class="col-sm-6">
            <label>Street Address</label>
            <input type="text" class="form-control" name="add[address]" placeholder="" value="<?= !$supplier ? '' : $supplier->address ?>">
        </div>
    </div>
</div>