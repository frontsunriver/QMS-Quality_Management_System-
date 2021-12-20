<link rel="stylesheet" href="<?= base_url(PORTO_URL . 'vendor/select2/css/select2.css') ?>" />
<link rel="stylesheet" href="<?= base_url(PORTO_URL . 'vendor/select2-bootstrap-theme/select2-bootstrap.min.css') ?>" />
<link rel="stylesheet" href="<?= base_url(PORTO_URL . 'vendor/bootstrap-multiselect/bootstrap-multiselect.css') ?>" />

<style>
	.mb-3, .my-3 {
		margin-bottom: 0px !important;
	}
	.select2-search--dropdown:after {
		display: none;
	}
</style>

<div class="content">
	<div class="panel panel-flat">
		<div class="panel-heading" style="border-bottom: 1px solid #eee;">
			<button type="submit" class="btn bg-blue" onclick="javascript:onCreate();"><?= !$bill ? 'Create' : 'Update' ?></button>
			<a class="btn btn-default" href="<?= base_url('manufacture/bill') ?>">Back</a>
			<div class="pull-right">
				<div class="checkbox checkbox-switch">
					<input type="checkbox" id="active" data-on-color="danger" data-off-color="primary" data-on-text="Active" data-off-text="Deactive" class="switch" <?= !$bill || ($bill && $bill->active == '1') ? 'checked="checked"' : '' ?>>
				</div>
			</div>
		</div>
		<div class="container-fluid">
			<form id="create_form" action="<?= base_url('manufacture/bill/create') ?><?= !$bill ? '' : "/{$bill->id}" ?>" method="post">
				<div class="form-group">
					<div class="row">
						<div class="col-lg-6 form-group">
							<div class="form-group row">
								<label class="col-lg-4 control-label text-lg-right pt-2">Product</label>
								<div class="col-lg-6">
									<select id="product" data-plugin-selectTwo class="form-control populate placeholder" name="bill[product_id]" data-plugin-options='{ "placeholder": "Select a State", "allowClear": true }' <?= $manuorder && $manuorder->state != 0 ? 'disabled' : '' ?> required>
										<?php foreach ($products as $product) : ?>
											<?php if (isset($product->variants)) { ?>
												<optgroup label="<?= $product->name ?>">
													<?php foreach ($product->variants as $item) : ?>
														<option value="<?= $product->id ?>@<?= $item ?>" <?= $bill && $bill->product_id == $product->id && $bill->variant == $item ? 'selected' : '' ?>><?= $item ?></option>
													<?php endforeach; ?>
												</optgroup>
											<?php } else { ?>
												<option value="<?= $product->id ?>" <?= $bill && $bill->product_id == $product->id && $bill->variant == null ? 'selected' : '' ?>><?= $product->name ?></option>
											<?php } ?>
										<?php endforeach; ?>
									</select>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-lg-4 control-label text-lg-right pt-2">Quantity</label>
								<div class="col-lg-6">
									<input type="number" class="form-control" name="bill[quantity]" value="<?= !$bill ? 1 : $bill->quantity ?>">
								</div>
							</div>
						</div>
						<div class="col-lg-6 form-group">
							<div class="form-group row">
								<label class="col-lg-4 control-label text-lg-right pt-2">Reference</label>
								<div class="col-lg-6">
									<input type="text" class="form-control" name="bill[reference]" value="<?= !$bill ? '' : $bill->reference ?>">
								</div>
							</div>
							<div class="form-group row">
								<label class="col-lg-4 control-label text-lg-right pt-2">BoM Type</label>
								<div class="col-lg-6" style="margin-top: 10px;">
									<div class="radio">
										<label>
											<input type="radio" class="control-success" name="manufacture" <?= !$bill || ($bill && $bill->bom_type == 1) ? 'checked="checked"' : '' ?>>
											Manufacture this product
										</label>
									</div>
									<div class="radio">
										<label>
											<input type="radio" class="control-success" name="kit" <?= $bill && $bill->bom_type == 0 ? 'checked="checked"' : '' ?>>
											Kit
										</label>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<div class="tabbable">
								<ul class="nav nav-tabs nav-tabs-top top-divided">
									<li class="active">
										<a href="#tab1" data-toggle="tab">Material</a>
									</li>
								</ul>
								<div class="tab-content">
									<div id="tab1" class="tab-pane active">
										<button type="button" class="btn bg-blue btn-xs" style="margin-bottom: 5px;" onclick="javascript:onAddLine();">Add a line</button>
										<div class="table-responsive">
											<table class="table datatable-basic">
												<thead>
													<tr style="background-color: #e8f5e9;">
														<th width="27%">Material</th>
														<th width="27%">Quantity</th>
														<th width="27%">Apply on Variants</th>
														<th width="15%">Action</th>
													</tr>
												</thead>
												<tbody>
													<?php $i = 0; ?>
                                                    <?php foreach ($bill_materials as $bill_material) : ?>
                                                        <tr>
                                                            <td>
                                                            	<select class="form-control form-control-sm col-lg-8" name="material[<?= $i ?>][material_id]" onchange="javascript:onChangeMaterial(this);">
                                                            		<?php foreach ($materials as $material) : ?>
                                                            			<option value="<?= $material->id ?>" <?= $bill_material->material_id == $material->id ? 'selected' : '' ?>><?= $material->name ?></option>
                                                            		<?php endforeach; ?>
                                                            	</select>
                                                            </td>
                                                            <td>
                                                            	<label><?= $bill_material->quantity ?></label>
                                                            </td>
                                                            <td>
                                                            	<input type="number" class="form-control form-control-sm col-lg-8" name="material[<?= $i ++ ?>][apply_on_variants]" value="<?= $bill_material->apply_on_variants ?>" onchange="javascript:onChangeQuantity(this)">
                                                            </td>
                                                            <td>
                                                                <ul class="icons-list">
                                                                    <li class="text-danger-600"><i class="icon-trash" onclick="javascript:onDeleteMaterial(this);"></i></li>
                                                                </ul>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<input type="hidden" name="bill[active]">
			</form>
		</div>
	</div>
</div>

<script type="text/javascript" src="<?= base_url(JS_URL . 'jquery.dataTables.min.js') ?>"></script>
<script type="text/javascript" src="<?= base_url(PLUGINS_URL . 'forms/validation/validate.min.js') ?>"></script>
<script type="text/javascript" src="<?= base_url(PLUGINS_URL . 'forms/styling/uniform.min.js') ?>"></script>
<script type="text/javascript" src="<?= base_url(PLUGINS_URL . 'forms/styling/switch.min.js') ?>"></script>
<script type="text/javascript" src="<?= base_url(PORTO_URL . 'vendor/select2/js/select2.js') ?>"></script>
<script type="text/javascript" src="<?= base_url(PORTO_URL . 'vendor/bootstrap-multiselect/bootstrap-multiselect.js') ?>"></script>

<script>
	var material_select = '';
	<?php foreach ($materials as $material) : ?>
		material_select += '<option value="<?= $material->id ?>"><?= $material->name ?></option>';
	<?php endforeach; ?>

	var quantity = <?= $quantity ?>;
</script>
<script type="text/javascript" src="<?= base_url(JS_URL . 'user/manufacture/bill/create.js') ?>"></script>