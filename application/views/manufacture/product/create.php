<link rel="stylesheet" href="<?= base_url(PORTO_URL . 'vendor/bootstrap-tagsinput/bootstrap-tagsinput.css') ?>" />

<style>
	.dropzone {
		width: 200px;
		min-height: 200px;
	}
	.dropzone .dz-default.dz-message {
	    height: 175px;
	}
	.mb-3, .my-3 {
		margin-bottom: 0px !important;
	}
	.file-upload {
		display: none;
	}
	.upload-file {
		height: 20vh;
		background-size: cover;
		vertical-align: middle;
		line-height: 10vh;
	}
	button#add_btn {
		margin-bottom: 10px;
	}
	table#attr_tbl {
		border: 2px solid darkgray;
	}
	.badge-info {
		background-color: #4caf50 !important;
		border-color: #4caf50 !important;
	}
</style>

<div class="content">
	<div class="panel panel-flat">
		<div class="panel-heading" style="border-bottom: 1px solid #eee;">
			<h5 class="panel-title" style="display: inline-block;">&nbsp;</h5>
			<button class="btn btn-default pull-right" onclick="javascript:onBack();">Back</button>
			<button class="btn bg-blue pull-right" style="margin-right: 5px;" onclick="javascript:onCreate();"><?= !$product ? 'Create' : 'Update' ?></button>
		</div>
		<div class="container-fluid">
			<form id="create_form" action="<?= base_url("manufacture/product/create") ?>/<?= !$product ? -1 : $product->id ?>" method="post" enctype="multipart/form-data">
				<div class="form-group">
					<div class="row">
						<div class="col-sm-9">
							<h3 style="margin-top: 0px;">Product Name</h3>
							<input type="text" class="form-control col-md-6" style="margin-bottom: 5px;" name="create[name]" value="<?= !$product ? '' : $product->name ?>">
							<div class="checkbox">
								<label>
									<input type="checkbox" class="control-success" <?= $product && $product->is_sold == 1 ? 'checked="checked"' : '' ?> name="create[is_sold]">
									Can be Sold
								</label>
							</div>
							<div class="checkbox">
								<label>
									<input type="checkbox" class="control-success" <?= $product && $product->is_purchased == 1 ? 'checked="checked"' : '' ?> name="create[is_purchased]">
									Can be Purchased
								</label>
							</div>
						</div>
						<div class="col-sm-3">
							<!-- <div id="product_img" action="<?= base_url('manufacture/product/upload') ?>"></div> -->
							<div class="p-4 border rounded text-center upload-file d-block" >
								<i class="icon-file-plus" style="font-size: 40px;"></i>
								<p class="">Upload Image</p>
							</div>
							<input type="file" class="file-upload" name="userfile" accept="image/*"/>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<div class="tabbable">
								<ul class="nav nav-tabs nav-tabs-top top-divided">
									<li class="active">
										<a href="#tab1" data-toggle="tab">General Information</a>
									</li>
									<li>
										<a href="#tab2" data-toggle="tab">Variants</a>
									</li>
<!--									<li>-->
<!--										<a href="#tab3" data-toggle="tab">Sales</a>-->
<!--									</li>-->
<!--									<li>-->
<!--										<a href="#tab4" data-toggle="tab">Purchase</a>-->
<!--									</li>-->
<!--									<li>-->
<!--										<a href="#tab5" data-toggle="tab">Inventory</a>-->
<!--									</li>-->
								</ul>
								<div class="tab-content">
									<div id="tab1" class="tab-pane active">
										<div class="row">
											<div class="col-lg-6 form-group">
												<div class="form-group row">
													<label class="col-lg-4 control-label text-lg-right pt-2">Product Category</label>
													<div class="col-lg-6">
														<select class="form-control mb-3" name="create[category_id]" required>
															<?php foreach ($categories as $category) : ?>
																<option value="<?= $category->id ?>" <?= $product && $product->category_id == $category->id ? 'selected' : '' ?>><?= $category->name ?></option>
															<?php endforeach; ?>
														</select>
													</div>
												</div>
												<div class="form-group row">
													<label class="col-lg-4 control-label text-lg-right pt-2">Internal Reference</label>
													<div class="col-lg-6">
														<input type="text" class="form-control" name="create[reference]" value="<?= !$product ? '' : $product->reference ?>">
													</div>
												</div>
												<div class="form-group row">
													<label class="col-lg-4 control-label text-lg-right pt-2">Barcode</label>
													<div class="col-lg-6">
														<input type="text" class="form-control" name="create[barcode]" value="<?= !$product ? '' : $product->barcode ?>">
													</div>
												</div>
												<div class="form-group row">
													<label class="col-lg-4 control-label text-lg-right pt-2">Version</label>
													<div class="col-lg-6">
														<input type="number" min="0" class="form-control" name="create[version]" value="<?= !$product ? '1' : $product->version ?>">
													</div>
												</div>
											</div>
											<div class="col-lg-6 form-group">
												<div class="form-group row">
													<label class="col-lg-4 control-label text-lg-right pt-2">Sales Price</label>
													<div class="col-lg-6">
														<input type="text" class="form-control cost-input" name="create[sales_price]" data-mask="999.99"  value="<?= !$product ? '1' : $product->sales_price ?>">
													</div>
												</div>
												<div class="form-group row">
													<label class="col-lg-4 control-label text-lg-right pt-2">Customer Taxes(%)</label>
													<div class="col-lg-6">
														<input type="number" class="form-control" name="create[customer_tax]"  value="<?= !$product ? '15' : $product->customer_tax ?>">
													</div>
												</div>
												<div class="form-group row">
													<label class="col-lg-4 control-label text-lg-right pt-2">Cost</label>
													<div class="col-lg-6">
														<input type="text" class="form-control cost-input" name="create[cost]" data-mask="999.99" value="<?= !$product ? '' : $product->cost ?>">
													</div>
												</div>
											</div>
										</div>
										<div class="row col-lg-9" style="margin-left: auto; margin-right: auto;">
											<label class="col-lg-4 control-label pt-2"><h3 style="margin-top: 0px; margin-bottom: 0px;">Internal Notes</h3></label>
											<div class="col-lg-12">
												<textarea class="col-lg-12" name="create[note]" style="height: 120px;"><?= !$product ? '' : $product->note ?></textarea>
											</div>
										</div>
									</div>
									<div id="tab2" class="tab-pane">
										<div class="row">
											<div class="col-lg-12 form-group">
												<button id="add_btn" type="button" class="btn btn-xs bg-blue">Add an item</button>
												<div class="table-responsive">
													<table id="attr_tbl" class="table">
														<thead>
															<tr style="background-color: #e8f5e9;">
																<th width="20%">Attribute</th>
																<th width="70%">Product Attribute Value</th>
																<th></th>
															</tr>
														</thead>
														<tbody>
															<?php if ($product) : ?>
																<?php foreach ($product->attrs as $key => $attr) : ?>
																	<tr>
																		<td>
																			<input type="text" class="form-control form-control-sm" name="attr[<?= $key ?>][name]" value="<?= $attr->name ?>" />
																		</td>
																		<td>
																			<input data-role="tagsinput" data-tag-class="badge badge-primary" class="form-control form-control-sm" name="attr[<?= $key ?>][value]" value="<?= $attr->value ?>" />
																		</td>
																		<td>
																			<ul class="icons-list text-center">
																				<li class="text-danger-400" style="margin-left: 0px;">
																					<i class="icon-trash" onclick="javascript:onDeleteItem(this);"></i>
																				</li>
																			</ul>
																		</td>
																	</tr>
																<?php endforeach; ?>
															<?php endif; ?>
														</tbody>
													</table>
												</div>
											</div>
										</div>
									</div>
									<!-- <div id="tab3" class="tab-pane">
										<p>Sales</p>
									</div>
									<div id="tab4" class="tab-pane">
										<p>Purchase</p>
									</div>
									<div id="tab5" class="tab-pane">
										<p>Inventory</p>
									</div> -->
								</div>
								<br/>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

<script type="text/javascript" src="<?= base_url(JS_URL . 'jquery.dataTables.min.js') ?>"></script>
<script type="text/javascript" src="<?= base_url(PLUGINS_URL . 'forms/inputs/formatter.min.js') ?>"></script>
<script type="text/javascript" src="<?= base_url(PLUGINS_URL . 'forms/validation/validate.min.js') ?>"></script>
<script type="text/javascript" src="<?= base_url(PLUGINS_URL . 'forms/styling/uniform.min.js') ?>"></script>
<script type="text/javascript" src="<?= base_url(PLUGINS_URL . 'uploaders/dropzone.min.js') ?>"></script>
<script type="text/javascript" src="<?= base_url(PORTO_URL . 'vendor/bootstrap-tagsinput/bootstrap-tagsinput.js') ?>"></script>


<script>
	var image = '<?= $product && $product->image ? $product->image : '' ?>';
</script>
<script type="text/javascript" src="<?= base_url(JS_URL . 'user/manufacture/product/create.js') ?>"></script>