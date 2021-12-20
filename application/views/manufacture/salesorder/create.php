<link rel="stylesheet" href="<?= base_url(PORTO_URL . 'vendor/select2/css/select2.css') ?>" />
<link rel="stylesheet" href="<?= base_url(PORTO_URL . 'vendor/select2-bootstrap-theme/select2-bootstrap.min.css') ?>" />
<link rel="stylesheet" href="<?= base_url(PORTO_URL . 'vendor/bootstrap-multiselect/bootstrap-multiselect.css') ?>" />

<style>
	.mb-3, .my-3 {
		margin-bottom: 0px !important;
	}
	.table th, .table td {
		line-height: 10px;
	}
	.select2-search--dropdown:after {
		display: none;
	}
</style>

<div class="content col-md-12" style="margin-left: auto; margin-right: auto;">
	<div class="panel panel-flat">
		<div class="panel-heading" style="padding-bottom: 0px;">
			<h3 class="panel-title" style="display: inline-block;">
				New&nbsp;&nbsp;
			</h3>
			<div class="pull-right">
				<a class="btn btn-default" href="<?= base_url('manufacture/salesorder') ?>">Back</a>
			</div>
		</div>
		<div class="container-fluid">
			<form id="create_form" class="form-control" action="<?= base_url('sales/salesorder/create') ?><?= $salesorder ? "/{$salesorder->id}" : '' ?>" method="post">
				<div class="row" style="padding-right: 0px;">
					<div class="row col-lg-12 form-group">
						<div class="col-lg-6 form-group">
							<div class="form-group row">
								<div class="col-lg-1"></div>
								<label class="col-lg-4 control-label pt-2 text-right"><b>Sales Order</b></label>
								<div class="col-lg-6">
									<input type="text" class="form-control mb-3" name="salesorder[salesorder_num]" value="<?= !$salesorder ? $salesorder_num : $salesorder->salesorder_num ?>" />
								</div>
							</div>
							<div class="form-group row">
								<div class="col-lg-1"></div>
								<label class="col-lg-4 control-label pt-2 text-right">Customer</label>
								<div class="col-lg-6">
									<select class="form-control mb-3" name="salesorder[customer_id]">
										<?php foreach ($customers as $customer) : ?>
											<option value="<?= $customer->id ?>" <?= $salesorder && $salesorder->customer_id == $customer->id ? 'selected' : '' ?>><?= $customer->name ?></option>
										<?php endforeach; ?>
									</select>
								</div>
							</div>
						</div>
						<div class="col-lg-6 form-group">
							<!-- <div class="form-group row">
								<div class="col-lg-1"></div>
								<label class="col-lg-3 control-label pt-2">Validity</label>
								<div class="col-lg-7">
									<select class="form-control mb-3">
									</select>
								</div>
							</div> -->
							<div class="form-group row">
								<div class="col-lg-1"></div>
								<label class="col-lg-3 control-label pt-2">Payment Terms</label>
								<div class="col-lg-7">
									<textarea class="form-control mb-3" name="salesorder[payment_terms]"><?= !$salesorder ? '' : $salesorder->payment_terms ?></textarea>
								</div>
							</div>
						</div>
					</div>
					<div class="row col-lg-12 form-group">
						<div class="col-lg-6 form-group">
							<div class="form-group row">
								<div class="col-lg-2"></div>
								<h4 style="margin-top: 0px; margin-bottom: 0px;">Shipping Information</h4>
							</div>
							<div class="form-group row">
								<div class="col-lg-2"></div>
								<label class="col-lg-3 control-label pt-2">Warehouse</label>
								<div class="col-lg-7">
									<select id="warehouse_select" class="form-control mb-3" name="salesorder[warehouse_id]" onchange="javascript:onChangeWarehouse(this.value);">
										<?php foreach ($warehouses as $warehouse) : ?>
											<option value="<?= $warehouse->id ?>" <?= $salesorder && $salesorder->warehouse_id == $warehouse->id ? 'selected' : '' ?>><?= $warehouse->name ?></option>
										<?php endforeach; ?>
									</select>
								</div>
							</div>
							<div class="form-group row">
								<div class="col-lg-2"></div>
								<label class="col-lg-3 control-label pt-2">Shipping Policy</label>
								<div class="col-lg-7">
									<textarea class="form-control mb-3" name="salesorder[shipping_policy]"><?= !$salesorder ? '' : $salesorder->shipping_policy ?></textarea>
								</div>
							</div>
						</div>
						<div class="col-lg-6 form-group">
							<div class="form-group row">
								<div class="col-lg-1"></div>
								<h4 style="margin-top: 0px; margin-bottom: 0px;">Sales Information</h4>
							</div>
							<div class="form-group row">
								<div class="col-lg-1"></div>
								<label class="col-lg-3 control-label pt-2">Salesperson</label>
								<div class="col-lg-7">
									<select class="form-control mb-3" name="salesorder[salesperson_id]">
										<?php foreach ($employees as $employee) : ?>
											<option value="<?= $employee->employee_id ?>" <?= $salesorder && $salesorder->salesperson_id == $employee->employee_id ? 'selected' : '' ?>><?= $employee->employee_name ?></option>
										<?php endforeach; ?>
									</select>
								</div>
							</div>
							<div class="form-group row">
								<div class="col-lg-1"></div>
								<label class="col-lg-3 control-label pt-2">Sales Team</label>
								<div class="col-lg-7">
									<input type="text" class="form-control mb-3" name="salesorder[sales_team]" value="<?= !$salesorder ? '' : $salesorder->sales_team ?>" />
								</div>
							</div>
							<div class="form-group row">
								<label class="col-lg-4 control-label pt-2">Customer Reference</label>
								<div class="col-lg-7">
									<input class="form-control mb-3" name="salesorder[customer_reference]" value="<?= !$salesorder ? '' : $salesorder->customer_reference ?>">
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row col-lg-12 form-group">
					<div class="col-sm-12" style="padding-right: 30px;">
						<div class="tabbable">
							<ul class="nav nav-tabs nav-tabs-top top-divided">
								<li class="active"><a href="#tab1" data-toggle="tab">Order Lines</a></li>
							</ul>
							<div class="tab-content">
								<div id="tab1" class="tab-pane active">
									<div class="col-lg-12">
										<div class="row">
											<div class="table-responsive">
												<table class="table datatable-basic">
													<thead>
														<tr style="background-color: #e8f5e9;">
															<th width="13%">Product</th>
															<th width="16%">Description</th>
															<th width="12%">Available Qty</th>
															<th width="12%">Ordered Qty</th>
															<th width="11%">Unit Price</th>
															<th width="8%">Taxes</th>
															<th width="8%">Discount(%)</th>
															<th width="8%">Subtotal</th>
															<th width="5%">Action</th>
														</tr>
													</thead>
													<tbody>
														<?php 
															if ($salesorder) :
																$iPos = 0; 
																foreach ($salesorder->products as $item) :
														?>
																	<tr>
																		<td>
																			<select data-plugin-selectTwo id="product<?= $iPos ?>" class="form-control form-control-sm populate placeholder" data-plugin-options='{ "placeholder": "Select a item", "allowClear": true }' required>
																				<?php foreach ($products as $product) : ?>
																					<optgroup label="<?= $product->name ?>">
																						<?php foreach ($product->variants as $variant) : ?>
																							<option value="<?= $product->id ?>@<?= $variant ?>" <?= $item->product_id == $product->id && $item->variant == $variant ? 'selected' : '' ?>><?= $variant ?></option>
																						<?php endforeach; ?>
																					</optgroup>
																				<?php endforeach; ?>
																			</select>
																		</td>
																		<td>
																			<input type="text" class="form-control form-control-sm col-lg-12" name="product[<?= $iPos ?>][description]" value="<?= $item->description ?>">
																		</td>
																		<td>
																			<label id="available_qty<?= $iPos ?>"></label>
																		</td>
																		<td>
																			<input type="number" id="product_qty<?= $iPos ?>" class="form-control form-control-sm" name="product[<?= $iPos ?>][ordered_qty]" value="<?= $item->ordered_qty ?>" onchange="javascript:onCalcTotal();">
																		</td>
																		<td>
																			<input type="number" class="form-control form-control-sm" name="product[<?= $iPos ?>][unit_price]" value="<?= $item->unit_price ?>" onchange="javascript:onCalcTotal();">
																		</td>
																		<td>
																			<input type="number" class="form-control form-control-sm format-tax" name="product[<?= $iPos ?>][tax]" value="<?= $item->tax ?>" onchange="javascript:onCalcTotal();">
																		</td>
																		<td>
																			<input type="number" class="form-control form-control-sm" name="product[<?= $iPos ++ ?>][discount]" value="<?= $item->discount ?>">
																		</td>
																		<td>
																		</td>
																		<td>
																			<ul class="icons-list text-center"><li class="text-danger-400" style="margin-left: 0px;"><i class="icon-trash" onclick="javascript:onDeleteProduct(this);"></i></li></ul>
																		</td>
																	</tr>
														<?php
																endforeach;
															endif;
														?>
													</tbody>
												</table>
												<hr style="margin-top: 0px; margin-bottom: 0px;"/>
											</div>
										</div>
										<div class="row">
											<div class="col-sm-6">
												<div class="content-group">
													<h5>Define your terms and conditions</h5>
													<textarea class="form-control" name="salesorder[description]" rows="10" cols="5" style="height: 120px;"><?= !$salesorder ? '' : $salesorder->description ?></textarea>
												</div>
											</div>
											<div class="col-sm-3"></div>
											<div class="col-sm-3" style="margin-top: 35px;padding-right: 0px;">
												<div class="content-group" style="margin-bottom: 0px !important;">
													<div class="table-responsive no-border">
														<table class="table">
															<tbody>
																<tr>
																	<th class="text-right">Untaxed Amount:&nbsp;</th>
																	<td class="text-right">$&nbsp;<span class="subtotal_span"></span></td>
																	<input type="hidden" value="0" name="salesorder[untaxes]" value="<?= !$salesorder ? 0 : $salesorder->untaxes ?>">
																</tr>
																<tr>
																	<th class="text-right">Taxes:&nbsp;<span class="text-regular"></span></th>
																	<td class="text-right">$&nbsp;<span class="taxable_span"></span></td>
																	<input type="hidden" name="salesorder[taxes]" value="<?= !$salesorder ? 0 : $salesorder->taxes ?>">
																</tr>
																<tr>
																	<th class="text-bold text-right">Total:&nbsp;</th>
																	<td class="text-right text-primary">
																		<h5 class="text-semibold">
																			$&nbsp;<span class="total_span"></span>
																		</h5>
																		<input type="hidden" name="salesorder[total]" value="<?= !$salesorder ? 0 : $salesorder->total ?>">
																	</td>
																</tr>
															</tbody>
														</table>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

<script type="text/javascript" src="<?= base_url(PLUGINS_URL . 'forms/validation/validate.min.js') ?>"></script>
<script type="text/javascript" src="<?= base_url(JS_URL . 'jquery.dataTables.min.js') ?>"></script>
<script type="text/javascript" src="<?= base_url(PORTO_URL . 'vendor/select2/js/select2.js') ?>"></script>
<script type="text/javascript" src="<?= base_url(PORTO_URL . 'vendor/bootstrap-multiselect/bootstrap-multiselect.js') ?>"></script>

<script>
	var products = '';
	<?php foreach ($products as $item) : ?>
		<?php if (empty($item->variants)) { ?>
			products += '<option value="<?= $item->id ?>"><?= $item->name ?></option>';
		<?php } else { ?>
			products += '<optgroup label="<?= $item->name ?>">';
			<?php foreach ($item->variants as $variant) : ?>
				products += '<option value="<?= $item->id ?>@<?= $variant ?>"><?= $variant ?></option>';;
			<?php endforeach; ?>
			products += '</optgroup>';
		<?php } ?>
	<?php endforeach; ?>
</script>

<script type="text/javascript" src="<?= base_url(JS_URL . 'user/sales/salesorder/create.js') ?>"></script>