<input type="hidden" name="id" value="<?= !$wastecategory ? -1 : $wastecategory->id ?>">

<div class="form-group">
    <div class="row">
        <div class="col-sm-12">
            <label>Name</label>
            <input type="text" class="form-control" name="add[name]" value="<?= !$wastecategory ? '' : $wastecategory->name ?>">
        </div>
    </div>
    <br/>
    <div class="row">
        <div class="col-sm-12">
            <label>Description</label>
            <textarea class="form-control" name="add[description]"><?= !$wastecategory ? '' : $wastecategory->description ?></textarea>
        </div>
    </div>
</div>