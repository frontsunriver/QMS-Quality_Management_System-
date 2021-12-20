<link rel="stylesheet" href="<?= base_url(PORTO_URL . 'vendor/select2/css/select2.css') ?>" />
<link rel="stylesheet" href="<?= base_url(PORTO_URL . 'vendor/select2-bootstrap-theme/select2-bootstrap.min.css') ?>" />
<link rel="stylesheet" href="<?= base_url(PORTO_URL . 'vendor/bootstrap-multiselect/bootstrap-multiselect.css') ?>" />

<style>
	.mb-3, .my-3 {
		margin-bottom: 0px !important;
	}
	#material_consume td > i {
		/*cursor: pointer;*/
		color: #2fa7ff;
	}
	#modal_transfer div.row {
		margin-bottom: 10px;
	}
	#modal_waste div.row {
		margin-bottom: 10px;
	}
	.src_doc_input {
		width: 140px;
	}
	.select2-search--dropdown:after {
		display: none;
	}
</style>

<div class="content col-md-12" style="margin-left: auto; margin-right: auto;">
	<div class="panel panel-flat">
		<div class="panel-heading" style="padding-bottom: 0px;">
			<h5 class="panel-title" style="display: inline-block;">
				Create Manufacturing Orders&nbsp;:&nbsp;
				<?php if ($manuorder) { ?>
					<?php if ($manuorder->state == 0) { ?>
						<label class="label label-danger">New</label>
					<?php } else if ($manuorder->state == 1) { ?>
						<label class="label label-warning">Awaiting Raw Materials</label>
					<?php } else if ($manuorder->state == 2) { ?>
						<label class="label label-info">Ready to Produce</label>
					<?php } else if ($manuorder->state == 3) { ?>
						<label class="label label-primary">Production Started</label>
					<?php } else if ($manuorder->state == 4) { ?>
						<label class="label label-success">Done</label>
					<?php } else if ($manuorder->state == 5) { ?>
						<label class="label label-success">Transfer</label>
					<?php } ?>
				<?php } else { ?>
					<label class="label label-danger">New</label>
				<?php } ?>

			</h5>
			<div class="pull-right">
					<?php if (!$manuorder || ($manuorder && $manuorder->state == 0)) : ?>
						<button type="button" class="btn bg-blue" onclick="javascript:onSave();">Save</button>
					<?php endif; ?>
					<a class="btn btn-default" href="<?= base_url('manufacture/manuorder') ?>">Back</a>
			</div>
		</div>
		<div class="container-fluid">
			<form id="create_form" class="form-control" action="<?= base_url('manufacture/manuorder/create') ?><?= $manuorder ? "/{$manuorder->id}" : '' ?>" method="post" enctype="multipart/form-data">
				<?php if (isset($plan_id)) : ?>
					<input type="hidden" name="plan_id" value="<?= $plan_id ?>">
				<?php endif; ?>
				<div class="row" style="padding-right: 0px;">
					<input type="hidden" name="manuorder[manuorder_num]">
					<div class="row col-lg-12 form-group">
						<div class="col-lg-6 form-group">
							<div class="form-group row">
								<div class="col-lg-1"></div>
								<label class="col-lg-4 control-label pt-2"><b>Manufacturing Order</b></label>
								<div class="col-lg-6">
									<input type="text" class="form-control mb-3 col-lg-6" name="manuorder[manuorder_num]" value="<?= !$manuorder ? $manuorder_num : $manuorder->manuorder_num ?>" <?= $manuorder && $manuorder->state != 0 ? 'disabled' : '' ?> readonly>
								</div>
							</div>
							<div class="form-group row">
								<div class="col-lg-1"></div>
								<label class="col-lg-4 control-label pt-2">Product</label>
								<div class="col-lg-6">
									<select id="product" data-plugin-selectTwo class="form-control populate placeholder" name="manuorder[product_id]" data-plugin-options='{ "placeholder": "Select a State", "allowClear": true }' <?= $manuorder && $manuorder->state != 0 ? 'disabled' : '' ?> required>
										<?php foreach ($products as $product) : ?>
											<?php if (isset($product->variants)) { ?>
												<optgroup label="<?= $product->name ?>">
													<?php foreach ($product->variants as $item) : ?>
														<option value="<?= $product->id ?>@<?= $item ?>" <?= $manuorder && $manuorder->product_id == $product->id && $manuorder->variant == $item ? 'selected' : '' ?>><?= $item ?></option>
													<?php endforeach; ?>
												</optgroup>
											<?php } else { ?>
												<option value="<?= $product->id ?>" <?= $manuorder && $manuorder->product_id == $product->id ? 'selected' : '' ?>><?= $product->name ?></option>
											<?php } ?>
										<?php endforeach; ?>
									</select>
									<input id="product_hidden" type="hidden" name="manuorder[product_id]" />
								</div>
							</div>
							<div class="form-group row">
								<div class="col-lg-1"></div>
								<label class="col-lg-4 control-label pt-2">Product Quantity</label>
								<div class="col-lg-6">
									<input id="quantity" type="number" class="form-control mb-3 col-lg-7" name="manuorder[quantity]" value="<?= !$manuorder ? '1' : $manuorder->quantity ?>" <?= $manuorder && $manuorder->state != 0 ? 'disabled' : '' ?>>
								</div>
							</div>
							<div class="form-group row">
								<div class="col-lg-1"></div>
								<label class="col-lg-4 control-label pt-2">Scheduled Date</label>
								<div class="col-lg-6">
									<input type="text" id="scheduled_date" class="form-control mb-3" name="manuorder[scheduled_date]" style="background-color: white;" value="<?= !$manuorder ? '' : $manuorder->scheduled_date ?>" <?= $manuorder && $manuorder->state != 0 ? 'disabled' : '' ?>>
								</div>
							</div>
							<div class="form-group row">
								<div class="col-lg-1"></div>
								<label class="col-lg-4 control-label pt-2">Lot Code</label>
								<div class="col-lg-6">
									<input type="text" class="form-control mb-3 col-lg-6" name="manuorder[lot_code]" value="<?= !$manuorder ? $lot_code : $manuorder->lot_code ?>" <?= $manuorder && $manuorder->state != 0 ? 'disabled' : '' ?>>
								</div>
							</div>
						</div>
						<div class="col-lg-6 form-group">
							<div class="form-group row">
								<div class="col-lg-1"></div>
								<label class="col-lg-4 control-label pt-2">Bill of Status</label>
								<div class="col-lg-6">
									<input type="checkbox" id="active" data-on-color="danger" data-off-color="primary" data-on-text="Active" data-off-text="Deactive" class="switch" <?= !$manuorder || ($manuorder && !$manuorder->bill_id) ? '' : 'checked="checked"' ?> <?= $manuorder && $manuorder->state != 0 ? 'disabled' : '' ?> onchange="javascript:onChangeActive();">
								</div>
							</div>
							<div class="form-group row">
								<div class="col-lg-1"></div>
								<label class="col-lg-4 control-label pt-2">Bill of Material</label>
								<div class="col-lg-6">
									<select id="bill" data-plugin-selectTwo class="form-control populate placeholder mb-3" name="manuorder[bill_id]" data-plugin-options='{ "placeholder": "Select a Bill", "allowClear": true }' onchange="javascript:onChangeBillMaterial(this.value);" <?= $manuorder && $manuorder->state != 0 ? 'disabled' : '' ?> required>
										<?php foreach ($bills as $bill) : ?>
											<?php if (isset($bill->variants)) { ?>
												<optgroup label="<?= $bill->name ?>">
													<?php foreach ($bill->variants as $item) : ?>
														<option value="<?= "$item->id@$bill->product_id@$item->variant" ?>" <?= $manuorder && $manuorder->bill_id == $item->id ? 'selected' : '' ?>><?= $item->variant ?></option>
													<?php endforeach; ?>
												</optgroup>
											<?php } else { ?>
												<option value="<?= $bill->id ?>" <?= $manuorder && $manuorder->bill_id == $bill->id ? 'selected' : '' ?>><?= $bill->name ?></option>
											<?php } ?>
										<?php endforeach; ?>
									</select>
								</div>
							</div>
							<div class="form-group row">
								<div class="col-lg-1"></div>
								<label class="col-lg-4 control-label pt-2">Routing</label>
								<div class="col-lg-6">
									<select class="form-control mb-3 col-lg-8" name="manuorder[routing_id]" <?= $manuorder && $manuorder->state != 0 ? 'disabled' : '' ?>>
										<?php foreach ($routings as $routing) : ?>
											<option value="<?= $routing->id ?>" <?= $manuorder && $manuorder->routing_id == $routing->id ? 'selected' : '' ?>><?= $routing->name ?></option>
										<?php endforeach; ?>
									</select>
								</div>
							</div>
							<div class="form-group row">
								<div class="col-lg-1"></div>
								<label class="col-lg-4 control-label pt-2">Responsible</label>
								<div class="col-lg-6">
									<select class="form-control mb-3" name="manuorder[responsible_id]" <?= $manuorder && $manuorder->state != 0 ? 'disabled' : '' ?>>
										<?php foreach ($employees as $employee) : ?>
											<option value="<?= $employee->employee_id ?>" <?= $manuorder && $manuorder->responsible_id == $employee->employee_id ? 'selected' : '' ?>><?= $employee->employee_name ?></option>
										<?php endforeach; ?>
									</select>
								</div>
							</div>
							<div class="form-group row">
								<div class="col-lg-1"></div>
								<label class="col-lg-4 control-label pt-2">Source Document</label>
								<div class="col-lg-6">
									<input type="file" class="form-control mb-3" name="userfile" value="<?= !$manuorder ? '' : $manuorder->src_doc ?>" <?= $manuorder && $manuorder->state != 0 ? 'disabled' : '' ?>>
								</div>
								<?php if ($manuorder && $manuorder->src_doc) : ?>
									<span style="line-height: 45px; vertical-align: middle;">
										<a href="<?= base_url("uploads/src_doc/{$manuorder->src_doc}") ?>" target="_blank">
											<i class="icon-file-pdf" style="font-size: 20px; cursor: pointer; color: cornflowerblue;"></i>
										</a>
									</span>
								<?php endif; ?>
							</div>
						</div>
					</div>
				</div>
				<br />
				<?php if ($manuorder) : ?>
					<div class="row form-group col-sm-12">
						<?php if ($manuorder->state == 0 && $manuorder->id != -1) { ?>
							<button type="button" class="btn btn-danger" onclick="javascript:onConfirmProduction(<?= $manuorder->id ?>);">Confirm Production</button>
						<?php } else if ($manuorder->state == 1) { ?>
							<button type="button" class="btn btn-danger" onclick="javascript:onCheckAvailability(<?= $manuorder->id ?>);">Check Availability</button>&nbsp;&nbsp;&nbsp;
							<!-- <button type="button" class="btn btn-default" onclick="">Force Reservation</button> -->
						<?php } else if ($manuorder->state == 2) { ?>
							<button type="button" class="btn btn-danger" onclick="javascript:onProduce(<?= $manuorder->id ?>);">Produce</button>&nbsp;&nbsp;&nbsp;
							<button type="button" class="btn btn-primary" onclick="javascript:onWaste(<?= $manuorder->id ?>);">Waste</button>
						<?php } ?>
					</div>
				<?php endif; ?>
				<div class="row form-group">
					<div class="col-sm-12" style="padding-right: 30px;">
						<div class="tabbable">
							<ul class="nav nav-tabs nav-tabs-top top-divided">
								<li class="<?= !$manuorder || ($manuorder && $manuorder->state < 3) ? 'active' : '' ?>">
									<a href="#tab1" data-toggle="tab">Consumed Materials</a>
								</li>
								<li class="<?= $manuorder && $manuorder->state >= 4 ? 'active' : '' ?>">
									<a href="#tab2" data-toggle="tab">Finished Products</a>
								</li>
								<li class="<?= $manuorder && $manuorder->state > 2 && $manuorder->state < 4 ? 'active' : '' ?>">
									<a href="#tab3" data-toggle="tab">Work Orders</a>
								</li>
<!--								<li>-->
<!--									<a href="#tab4" data-toggle="tab">Scheduled Products</a>-->
<!--								</li>-->
								<li>
									<a href="#tab5" data-toggle="tab">Extra Information</a>
								</li>
							</ul>
							<div class="tab-content">
								<div id="tab1" class="tab-pane <?= !$manuorder || ($manuorder && $manuorder->state < 3) ? 'active' : '' ?>">
									<div class="row">
										<div class="col-lg-6 form-group">
											<label class="text-bold">
												Material to Consume
											</label>
											<hr style="margin: 0 0 10px 0;" />
											<div class="form-group row col-lg-12">
												<div class="table-responsive">
													<table id="material_consume" class="table">
														<thead>
															<tr style="background-color: #e8f5e9;">
																<th width="44%">Material</th>
																<th width="44%">Quantity</th>
																<th width="10px"></th>
																<?php if ($manuorder && $manuorder->state > 0) : ?>
																	<th width="40px"></th>
																<?php endif; ?>
															</tr>
														</thead>
														<tbody>
															<?php $i = 0; ?>
															<?php foreach ($material_to_consumes as $item) : ?>
																<tr>
																	<td>
																		<select class="form-control form-control-sm col-lg-12" name="material[<?= $i ?>][material_id]" <?= $manuorder && $manuorder->state != 0 ? 'disabled' : '' ?>>
																			<?php foreach ($materials as $material) : ?>
																				<option value="<?= $material->id ?>" <?= $item->material_id == $material->id ? 'selected' : '' ?>><?= $material->name ?></option>
																			<?php endforeach; ?>
																		</select>
																	</td>
																	<td>
																		<input type="number" class="form-control form-control-sm col-lg-12" name="material[<?= $i ++ ?>][quantity]" value="<?= $item->quantity ?>" <?= $manuorder && $manuorder->state != 0 ? 'disabled' : '' ?>>
																	</td>
																	<td>
																		<ul class="icons-list">
																			<li><a class="text-danger-600" href="#" onclick="javascript:onDeleteItem(this)" title="Delete"><i class="icon-trash"></i></a></li>
																		</ul>
																	</td>
																	<?php if ($manuorder) : ?>
																		<?php if ($manuorder->state > 0) : ?>
																			<?php if ($manuorder->state == 1) { ?>
																				<td><i class="icon-database-insert"></i></td>
																			<?php } else { ?>
																				<td><i class="icon-coins"></i></td>
																			<?php } ?>
																		<?php endif; ?>
																	<?php endif; ?>
																</tr>
															<?php endforeach; ?>
														</tbody>
													</table>
													<?php if (!$manuorder || ($manuorder && $manuorder->state == 0)) : ?>
														&nbsp;&nbsp;<button id="addBtn" type="button" class="btn btn-xs bg-blue" onclick="javascript:onAddItem();">Add an item</button>
													<?php endif; ?>
												</div>
											</div>
										</div>
										<div class="col-lg-6 form-group">
											<label class="text-bold">
												Consumed Material
											</label>
											<hr style="margin: 0 0 10px 0;" />
											<div class="form-group row col-lg-12">
												<div class="table-responsive">
													<table id="consumed_material" class="table">
														<thead>
															<tr style="background-color: #e8f5e9;">
																<th width="33%">Material</th>
																<th width="33%">Lot</th>
																<th width="33%">Quantity</th>
															</tr>
														</thead>
														<tbody>
															<?php foreach ($consumed_materials as $item) : ?>
																<tr>
																	<td><?= $item->name ?></td>
																	<td><?= $item->upc ?></td>
																	<td><?= $item->quantity ?></td>
																</tr>
															<?php endforeach; ?>
														</tbody>
													</table>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div id="tab2" class="tab-pane <?= $manuorder && $manuorder->state >= 4 ? 'active' : '' ?>">
									<div class="col-lg-12 form-group">
										<div class="table-responsive">
											<table class="table">
												<thead>
													<tr style="background-color: #e8f5e9;">
														<th>Product</th>
														<th>Quantity</th>
														<th>Manufactured Date</th>
														<th>Count of Work Order</th>
														<th>Resposible</th>
													</tr>
												</thead>
												<tbody>
													<?php if ($manuorder && $manuorder->state >= 4 && isset($finished_product)) : ?>
														<tr>
															<td><?= $finished_product->product_name ?></td>
															<td><?= $finished_product->quantity ?></td>
															<td><?= $finished_product->manufactured_date ?></td>
															<td><?= $finished_product->workorder_count ?></td>
															<td><?= $finished_product->responsible_name ?></td>
														</tr>
													<?php endif; ?>
												</tbody>
											</table>
										</div>
									</div>
								</div>
								<div id="tab3" class="tab-pane <?= $manuorder && $manuorder->state > 2 && $manuorder->state < 4 ? 'active' : '' ?>">
									<div class="col-lg-12 form-group">
										<button type="button" class="btn btn-sm bg-blue"><i class="icon-calculator2"></i>&nbsp;Compute Data</button>&nbsp;&nbsp;&nbsp;
										<?php if ($manuorder && $manuorder->state == 4) : ?>
											<button type="button" class="btn btn-sm btn-warning" onclick="javascript:onTransfer(<?= $manuorder->product_id ?>, '<?= $manuorder->variant ?>', <?= $manuorder->quantity ?>, '<?= $manuorder->lot_code ?>');">Transfer</button>
										<?php endif; ?>
										<hr style="margin: 5px 0 10px 0;" />
										<div class="form-group row col-lg-12">
											<div class="table-responsive">
												<table class="table">
													<thead>
														<tr style="background-color: #e8f5e9;">
															<th>Sequence</th>
															<th>Work Order</th>
															<th>Work Center</th>
															<th>Number of Cycles</th>
															<th>Number of Hours</th>
															<th>Source Document</th>
															<th>Status</th>
															<th></th>
														</tr>
													</thead>
													<tbody>
														<?php foreach ($work_orders as $item) : ?>
															<tr>
																<td align="right"><?= $item->sequence ?></td>
																<td><?= $item->name ?></td>
																<td><?= $item->workcenter_name ?></td>
																<td><?= $item->number_of_cycles ?></td>
																<td><?= $item->number_of_hours ?></td>
																<td style="text-align: center;">
																	<?php if ($item && $item->src_doc) : ?>
																		<a id="src_doc_<?= $item->work_order_id ?>" href="<?= base_url("uploads/src_doc/$item->src_doc") ?>" target="_blank"><i class="icon-file-pdf" style="cursor: pointer; color: cornflowerblue;"></i></a>
																	<?php endif; ?>
																	<?php if ($manuorder->state < 4) : ?>
																		<input type="file" id="src_doc_input_<?= $item->work_order_id ?>" class="src_doc_input" workorder="<?= $item->work_order_id ?>" />
																	<?php endif; ?>
																</td>
																<td>
																	<?php if ($item->work_order_state == 0) { ?>
																		<i class="icon-play3" style="cursor: pointer;" onclick="location.href = base_url + 'manufacture/workorder/view/<?= $item->work_order_id ?>';"></i>
																	<?php } else if ($item->work_order_state == 1) { ?>
																		<label class="label label-primary" style="cursor: pointer;" onclick="location.href = base_url + 'manufacture/workorder/view/<?= $item->work_order_id ?>';">Started</label>
																	<?php } else if ($item->work_order_state == 2) { ?>
																		<label class="label label-info" style="cursor: pointer;" onclick="location.href = base_url + 'manufacture/workorder/view/<?= $item->work_order_id ?>';">PASS</label>
																	<?php } else if ($item->work_order_state == -2) { ?>
																		<label class="label label-danger" style="cursor: pointer;" onclick="location.href = base_url + 'manufacture/workorder/view/<?= $item->work_order_id ?>';">FAIL</label>
																	<?php } else if ($item->work_order_state == 3) { ?>
																		<label class="label label-success" style="cursor: pointer;" onclick="location.href = base_url + 'manufacture/workorder/view/<?= $item->work_order_id ?>';">Done</label>
																	<?php } ?>
																</td>
																<td>
																	<?php if ($user->type == 'monitor' && $item->work_order_state == -2) : ?>
																		<a href="<?= base_url("manufacture/workorder/conduct/$item->work_order_id") ?>" class="btn btn-primary btn-xs">Manage</a>
																	<?php endif; ?>
																</td>
															</tr>
														<?php endforeach; ?>
													</tbody>
												</table>
											</div>
										</div>
									</div>
									<div id="tab4" class="tab-pane"></div>
									<div id="tab5" class="tab-pane">
										<div class="row col-lg-9" style="margin-left: auto; margin-right: auto;">
											<label class="col-lg-4 control-label pt-2"><h3 style="margin-top: 0px; margin-bottom: 0px;">Notes</h3></label>
											<div class="col-lg-12">
												<textarea class="form-control col-lg-12" name="manuorder[note]" style="height: 120px;"><?= !$manuorder ? '' : $manuorder->note ?></textarea>
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
</div>

<div id="modal_transfer" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Transfer Product</h5>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<form id="transfer_form" action="<?= base_url("manufacture/manuorder/transfer/{$manuorder->id}") ?>" method="post">
				<div class="modal-body">
					<div class="form-group">
						<div class="row">
							<label class="col-sm-4 control-label text-lg-right pt-2">Product:</label>
							<div class="col-sm-6">
								<select id="product_select" class="form-control mb-3" disabled="disabled">
									<?php foreach ($products as $product) : ?>
										<option value="<?= $product->id ?>" <?= $manuorder && $manuorder->product_id == $product->id ? 'selected' : '' ?>><?= $product->name ?></option>
									<?php endforeach; ?>
								</select>
								<input id="product_hidden" type="hidden" name="transfer[product_id]">
							</div>
						</div>
						<div class="row">
							<label class="col-sm-4 control-label text-lg-right pt-2">Variant:</label>
							<div class="col-sm-6">
								<input id="variant" type="text" class="form-control" name="transfer[variant]" readonly="readonly">
							</div>
						</div>
						<div class="row">
							<label class="col-sm-4 control-label text-lg-right pt-2">Quantity:</label>
							<div class="col-sm-6">
								<input id="product_quantity" type="number" class="form-control" name="transfer[quantity]" readonly="readonly">
							</div>
						</div>
						<div class="row">
							<label class="col-sm-4 control-label text-lg-right pt-2">Warehouse:</label>
							<div class="col-sm-6">
								<select class="form-control" name="transfer[warehouse_id]">
									<?php foreach ($warehouses as $item) : ?>
										<option value="<?= $item->id ?>"><?= $item->name ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
						<div class="row">
							<label class="col-sm-4 control-label text-lg-right pt-2">Expired Date:</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="expired_date" name="transfer[expired_date]" style="background-color: white;" readonly>
							</div>
						</div>
						<input type="hidden" id="lot_code" name="transfer[lot_code]" />
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn bg-blue">Transfer</button>
					<button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
				</div>
			</form>
		</div>
	</div>
</div>

<div id="modal_waste" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Waste Material</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
            <form id="waste_form">
                <div class="modal-body">
					<div class="form-group">
					    <div class="row">
					        <div class="col-sm-4">
					            <label>&nbsp;&nbsp;Material Name:</label>
					        </div>
					        <div class="col-sm-7">
					        	<select class="form-control" name="waste[good_id]" onchange="javascript:onChangeMaterial(this.value);">
					        		<?php foreach ($consumed_materials as $item) : ?>
					        			<option value="<?= $item->id ?>"><?= $item->name ?></option>
					        		<?php endforeach; ?>
					        	</select>
					        </div>
					    </div>
					    <div class="row">
					        <div class="col-sm-4">
					            <label>&nbsp;&nbsp;Waste Category:</label>
					        </div>
					        <div class="col-sm-6">
					        	<select class="form-control" name="waste[waste_category_id]">
					        		<?php foreach ($waste_categories as $item) : ?>
					        			<option value="<?= $item->id ?>"><?= $item->name ?></option>
					        		<?php endforeach; ?>
					        	</select>
					        </div>
					    </div>
					    <div class="row">
					        <div class="col-sm-4">
					            <label>&nbsp;&nbsp;Quantity:</label>
					        </div>
					        <div class="col-sm-5">
					        	<input type="number" class="form-control" name="waste[quantity]" min="1">
					        </div>
					    </div>
					    <div class="row">
					        <div class="col-sm-4">
					            <label>&nbsp;&nbsp;Reason:</label>
					        </div>
					        <div class="col-sm-8">
					        	<textarea class="form-control" name="waste[reason]"></textarea>
					        </div>
					    </div>
					</div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn bg-blue">Waste</button>
                    <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript" src="<?= base_url(PLUGINS_URL . 'pickers/anytime.min.js') ?>"></script>
<script type="text/javascript" src="<?= base_url(PLUGINS_URL . 'forms/styling/uniform.min.js') ?>"></script>
<script type="text/javascript" src="<?= base_url(PLUGINS_URL . 'forms/styling/switch.min.js') ?>"></script>
<script type="text/javascript" src="<?= base_url(PORTO_URL . 'vendor/select2/js/select2.js') ?>"></script>
<script type="text/javascript" src="<?= base_url(PORTO_URL . 'vendor/bootstrap-multiselect/bootstrap-multiselect.js') ?>"></script>

<script>
	var material_options = '';
	var manuorder_id = <?= !$manuorder ? -1 : $manuorder->id ?>;
	var confirmed = <?= $manuorder && $manuorder->state != 0 ? 1 : 0 ?>;
	<?php foreach ($materials as $material) : ?>
		material_options += '<option value="<?= $material->id ?>">' + '<?= $material->name ?>' + '</option>';
	<?php endforeach; ?>

	var limit_qty = [];
	<?php foreach ($consumed_materials as $item) : ?>
		limit_qty[<?= $item->id ?>] = <?= $item->quantity ?>;
	<?php endforeach; ?>
</script>
<script type="text/javascript" src="<?= base_url(JS_URL . 'user/manufacture/manuorder/create.js') ?>"></script>