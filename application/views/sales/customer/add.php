<input type="hidden" name="id" value="<?= !$customer ? -1 : $customer->id ?>" />

<div class="form-group">
    <div class="row">
        <div class="col-sm-6">
            <label>Name</label>
            <input type="text" class="form-control" placeholder="" name="add[name]" value="<?= !$customer ? '' : $customer->name ?>">
        </div>
        <div class="col-sm-6">
            <label>Phone</label>
            <input type="text" class="form-control" placeholder="9-999-999-9999" name="add[phone]" value="<?= !$customer ? '' : $customer->phone ?>" data-mask="9-999-999-9999">
            <span class="help-block">9-999-999-9999</span>
        </div>
    </div>
</div>
<div class="form-group">
    <div class="row">
        <div class="col-sm-6">
            <label>Email Address</label>
            <input type="text" class="form-control" placeholder="eugene@kopyov.com" name="add[email]" value="<?= !$customer ? '' : $customer->email ?>">
            <span class="help-block">name@domain.com</span>
        </div>
        <div class="col-sm-6">
            <label>Street Address</label>
            <input type="text" class="form-control" name="add[address]" placeholder="" value="<?= !$customer ? '' : $customer->address ?>">
        </div>
    </div>
</div>