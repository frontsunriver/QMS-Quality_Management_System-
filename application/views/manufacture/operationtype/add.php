<input type="hidden" name="id" value="<?= !$operationtype ? -1 : $operationtype->id ?>">

<div class="form-group">
    <div class="row">
        <div class="col-sm-12">
            <label>Name</label>
            <input type="text" class="form-control" name="add[name]" value="<?= !$operationtype ? '' : $operationtype->name ?>">
        </div>
    </div>
    <br/>
    <div class="row">
        <div class="col-sm-12">
            <label>Description</label>
            <textarea class="form-control" name="add[description]"><?= !$operationtype ? '' : $operationtype->description ?></textarea>
        </div>
    </div>
</div>