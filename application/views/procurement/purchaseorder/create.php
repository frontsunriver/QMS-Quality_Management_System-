<style>
	.table th, .table td {
		line-height: 10px;
	}
</style>

<?php
$edit = (!$order || ($order && $order->state == 0));
?>

<div class="content col-md-12" style="margin-left: auto; margin-right: auto;">
	<div class="panel panel-flat">
		<div class="panel-heading" style="border-bottom: 1px solid #eee;">
			<h5 class="panel-title" style="display: inline-block;">New</h5>
			<div class="pull-right">
				<?php if ($edit) { ?>
					<button type="button" class="btn bg-blue" onclick="javascript:onSave();">Save</button>
				<?php } ?>
				<a class="btn btn-default" href="<?= base_url('procurement/purchaseorder') ?>">Discard</a>
			</div>
		</div>
		<div class="container-fluid" style="padding-right: 6px;">
			<div class="row col-md-12" style="padding-right: 0px;">
				<div class="row col-md-12" style="margin-bottom: 10px;">
					<?php if ($order) { ?>
						<button type="button" class="btn btn-default" onclick="javascript:onDownloadPDF(<?= $order->id ?>);">Download PDF</button>&nbsp;&nbsp;
						<?php if ($order->state == 0) { ?>
							<button type="button" class="btn btn-default" onclick="javascript:onConfirmOrder(<?= $order->id ?>);">Confirm Order</button>&nbsp;&nbsp;
						<?php } ?>
						<a class="btn btn-default" href="<?= base_url('procurement/purchaseorder') ?>">Cancel</a>
					<?php } ?>
				</div>
				<form id="create_form" class="form-control" action="<?= base_url('procurement/purchaseorder/create') . ($order ? "/{$order->id}" : '') ?>" method="post" style="padding: 20px 0;">
					<div class="row">
						<div class="col-lg-6">
							<div class="form-group row">
								<label class="col-lg-4 control-label pt-2 text-right">Purchase Number</label>
								<div class="col-lg-8">
									<input type="text" class="form-control mb-3 col-lg-10" name="order[purchase_num]" value="<?= !$order ? $purchase_num : $order->purchase_num ?>" required <?= !$edit ? 'disabled' : '' ?> readonly>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-lg-4 control-label pt-2 text-right">Deliver To</label>
								<div class="col-lg-8">
									<select class="form-control mb-3 col-lg-10" name="order[warehouse_id]" <?= !$edit ? 'disabled' : '' ?>>
										<?php foreach ($warehouses as $warehouse) : ?>
											<option value="<?= $warehouse->id ?>" <?= $order && $order->warehouse_id == $warehouse->id ? 'selected' : '' ?>><?= $warehouse->name ?></option>
										<?php endforeach; ?>
									</select>
								</div>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group row">
								<label class="col-lg-4 control-label pt-2 text-right">Order Date</label>
								<div class="col-lg-8">
									<input type="text" class="form-control col-lg-10" id="order_date" name="order[order_date]" value="<?= !$order ? '' : $order->order_date ?>" style="background-color: white;" <?= !$edit ? 'disabled' : '' ?>>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-lg-4 control-label pt-2 text-right">Purchase Representative</label>
								<div class="col-lg-8">
									<input type="text" class="form-control mb-3 col-lg-10" name="order[purchase_representative]" value="<?= !$order ? '' : $order->purchase_representative ?>" required <?= !$edit ? 'disabled' : '' ?>>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12" style="padding: 5px 40px;">
							<div class="tabbable">
								<ul class="nav nav-tabs nav-tabs-top top-divided">
									<li class="active">
										<a href="#tab1" data-toggle="tab">Materials</a>
									</li>
								</ul>
								<div class="tab-content">
									<div id="tab1" class="tab-pane active">
										<div class="col-lg-12">
											<div class="row">
												<div class="table-responsive">
													<?php if ($edit) { ?>
														<button type="button" class="btn bg-blue btn-xs" style="margin: 5px 0;" onclick="javascrit:onAddLine();">
															Add a line <i class="fa fa-plus"></i></button>
													<?php } ?>
													<table class="table datatable-basic">
														<thead>
															<tr style="background-color: #e8f5e9;">
																<th width="14%">Material</th>
																<th width="14%">Supplier</th>
																<th width="14%">Lot/Trace Number</th>
																<th width="14%">Scheduled Date</th>
																<th width="11%">Quantity</th>
																<th width="11%">Unit Price</th>
																<th width="11%">Taxes(%)</th>
																<th width="11%">Subtotal</th>
																<th width="5%">Action</th>
															</tr>
														</thead>
														<tbody>
															<?php if (isset($purchase_materials)) { ?>
																<?php for ($i = 0; $i < count($purchase_materials); $i ++) { ?>
																	<tr>
																		<td>
																			<select class="form-control form-control-sm" name="material[<?= $i ?>][material_id]" onchange="javascript:onChangeMaterial(this);" <?= !$edit ? 'disabled' : '' ?>>
																				<?php foreach ($materials as $material) : ?>
																					<option value="<?= $material->id ?>" <?= $purchase_materials[$i]->material_id == $material->id ? 'selected' : '' ?>><?= $material->name ?></option>
																				<?php endforeach; ?>
																			</select>
																		</td>
																		<td>
																			<select class="form-control form-control-sm" name="material[<?= $i ?>][supplier_id]" <?= !$edit ? 'disabled' : '' ?>>
																				<?php foreach ($suppliers as $supplier) : ?>
																					<option value="<?= $supplier->id ?>" <?= $purchase_materials[$i]->supplier_id == $supplier->id ? 'selected' : '' ?>><?= $supplier->name ?></option>
																				<?php endforeach; ?>
																			</select>
																		</td>
																		<td>
																			<input type="text" class="form-control form-control-sm col-lg-12" name="material[<?= $i ?>][trace_code]" value="<?= $purchase_materials[$i]->trace_code ?>" <?= !$edit ? 'disabled' : '' ?>>
																		</td>
																		<td>
																			<input type="text" class="form-control form-control-sm col-lg-12 anytime" id="anytime<?= $i ?>" name="material[<?= $i ?>][scheduled_date]" value="<?= $purchase_materials[$i]->scheduled_date ?>" style="background-color: white;" <?= !$edit ? 'disabled' : '' ?>>
																		</td>
																		<td>
																			<input type="number" class="form-control form-control-sm format-unit-price" name="material[<?= $i ?>][quantity]" value="<?= $purchase_materials[$i]->quantity ?>" onchange="javascript:onCalcTotal();" <?= !$edit ? 'disabled' : '' ?>>
																		</td>
																		<td>
																			<input type="number" class="form-control form-control-sm format-unit-price" name="material[<?= $i ?>][unit_price]" value="<?= $purchase_materials[$i]->unit_price ?>" onchange="javascript:onCalcTotal();" <?= !$edit ? 'disabled' : '' ?>>
																		</td>
																		<td>
																			<input type="number" class="form-control form-control-sm format-tax" name="material[<?= $i ?>][tax]" value="<?= $purchase_materials[$i]->tax ?>" onchange="javascript:onCalcTotal();" <?= !$edit ? 'disabled' : '' ?>>
																		</td>
																		<td></td>
																		<td>
																			<!-- <?php if ($edit) { ?> -->
																				<ul class="icons-list text-center"><li class="text-danger-400" style="margin-left: 0px;"><i class="icon-trash" onclick="javascript:onDeleteMaterial(this);" <?= !$edit ? 'disabled' : '' ?>></i></li></ul>
																			<!-- <?php } ?> -->
																		</td>
																	</tr>
																<?php } ?>
															<?php } ?>
														</tbody>
													</table>
												</div>
											</div>
											<div class="row">
												<div class="col-sm-6">
													<div class="content-group">
														<h5>Define your terms and conditions</h5>
														<textarea class="form-control" name="order[description]" rows="10" cols="5" style="height: 120px;" <?= !$edit ? 'disabled' : '' ?>><?= !$order ? '' : $order->description ?></textarea>
													</div>
												</div>
												<div class="col-sm-3"></div>
												<div class="col-sm-3" style="padding-right: 0px;">
													<div class="content-group">
														<div class="table-responsive no-border">
															<table class="table">
																<tbody>
																	<tr>
																		<th class="text-right">Untaxed Amount:&nbsp;</th>
																		<td class="text-right">$&nbsp;<span class="subtotal_span"></span></td>
																		<input type="hidden" value="0" name="order[untaxes]" value="<?= !$order ? '' : $order->untaxes ?>">
																	</tr>
																	<tr>
																		<th class="text-right">Taxes:&nbsp;<span class="text-regular"></span></th>
																		<td class="text-right">$&nbsp;<span class="taxable_span"></span></td>
																		<input type="hidden" value="0" name="order[taxes]" value="<?= !$order ? '' : $order->taxes ?>">
																	</tr>
																	<tr>
																		<th class="text-bold text-right">Total:&nbsp;</th>
																		<td class="text-right text-primary">
																			<h5 class="text-semibold">
																				$&nbsp;<span class="total_span"></span>
																			</h5>
																			<input type="hidden" value="0" name="order[total]" value="<?= !$order ? '' : $order->total ?>">
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
</div>

<script type="text/javascript" src="<?= base_url(PLUGINS_URL . 'pickers/anytime.min.js') ?>"></script>

<script>
	var material_id = <?= empty($materials[0]) ? '-1' : $materials[0]->id ?>;
	var materials = '';
	var supplier = "";
	$(function(){
		<?php foreach ($materials as $material) : ?>
			materials += '<option value="<?= $material->id ?>"><?= $material->name ?></option>';
		<?php endforeach; ?>
		<?php foreach ($suppliers as $supplier) : ?>
			supplier += '<option value="<?= $supplier->id ?>"><?= $supplier->name ?></option>';
		<?php endforeach; ?>
	});
</script>
<script type="text/javascript" src="<?= base_url(JS_URL . 'user/procurement/purchaseorder/create.js') ?>"></script>