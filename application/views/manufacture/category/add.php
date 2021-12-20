<input type="hidden" name="id" value="<?= !$category ? -1 : $category->id ?>" />

<div class="form-group">
    <div class="row">
        <div class="col-sm-12">
            <label>Name</label>
            <input type="text" class="form-control" placeholder="" name="add[name]" value="<?= !$category ? '' : $category->name ?>">
        </div>
    </div>
</div>
<div class="form-group">
    <div class="row">
        <div class="col-sm-12">
            <label>Description</label>
            <textarea type="text" class="form-control" placeholder="" name="add[description]"><?= !$category ? '' : $category->description ?></textarea>
        </div>
    </div>
</div>