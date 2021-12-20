<style>
	.mb-3, .my-3 {
		margin-bottom: 0px !important;
	}
	.table th, .table td {
		line-height: 10px;
	}
</style>

<div class="content col-md-12" style="margin-left: auto; margin-right: auto;">
	<div class="panel panel-flat">
		<div class="panel-heading" style="border-bottom: 1px solid #eee;">
			<h5 class="panel-title" style="display: inline-block;">Create Ship Order</h5>
			<div class="pull-right">
				<button type="button" class="btn bg-blue" onclick="javascript:onConfirmOrder(<?= $shiporder->id ?>);">Confirm Order</button>
				<a href="<?= base_url('warehouse/shiporder') ?>" class="btn btn-default">Cancel</a>
			</div>
		</div>
		<div class="container-fluid">
			<form id="create_form" action="<?= base_url('sales/shiporder/create') ?>/<?= !$shiporder ? -1 : $shiporder->id ?>" method="post">
				<input type="hidden" name="shiporder[salesorder_id]" value="<?= !$shiporder ? -1 : $shiporder->salesorder_id ?>" />
				<div class="row" style="padding-right: 0px;">
					<div class="row col-lg-12 form-group">
						<div class="col-lg-6 form-group">
							<div class="form-group row">
								<label class="col-lg-4 control-label pt-2 text-right"><b>Ship Order</b></label>
								<div class="col-lg-6">
									<input type="text" class="form-control mb-3" name="shiporder[reference]" value="<?= !$shiporder ? $reference : $shiporder->reference ?>" readonly />
								</div>
							</div>
							<div class="form-group row">
								<label class="col-lg-4 control-label pt-2 text-right">Customer</label>
								<div class="col-lg-6">
									<select class="form-control mb-3" name="shiporder[customer_id]">
										<?php foreach ($customers as $customer) : ?>
											<option value="<?= $customer->id ?>" <?= $shiporder && $shiporder->customer_id == $customer->id ? 'selected' : '' ?>><?= $customer->name ?></option>
										<?php endforeach; ?>
									</select>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-lg-4 control-label pt-2 text-right">Operation Type</label>
								<div class="col-lg-6">
									<select class="form-control mb-3" name="shiporder[opt_id]">
										<?php foreach ($opts as $opt) : ?>
											<option value="<?= $opt->id ?>"><?= $opt->name ?></option>
										<?php endforeach; ?>
									</select>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-lg-4 control-label pt-2 text-right">Source Location</label>
								<div class="col-lg-7">
									<select class="form-control mb-3" name="shiporder[src_location]">
										<?php foreach ($warehouses as $warehouse) : ?>
											<option value="<?= $warehouse->id ?>" <?= $shiporder && $shiporder->src_location == $warehouse->id ? 'selected' : '' ?>><?= $warehouse->name ?></option>
										<?php endforeach; ?>
									</select>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-lg-4 control-label pt-2 text-right">Destination Location</label>
								<div class="col-lg-7">
									<select class="form-control mb-3" name="shiporder[des_location]">
										<?php foreach ($warehouses as $warehouse) : ?>
											<option value="<?= $warehouse->id ?>" <?= $shiporder && $shiporder->des_location == $warehouse->id ? 'selected' : '' ?>><?= $warehouse->name ?></option>
										<?php endforeach; ?>
									</select>
								</div>
							</div>
						</div>
					</div>
					<div class="row col-lg-12 form-group">
						<div class="col-sm-12" style="padding-right: 30px;">
							<div class="tabbable">
								<ul class="nav nav-tabs nav-tabs-top top-divided">
									<li class="active"><a href="#tab1" data-toggle="tab">Operations</a></li>
								</ul>
								<div class="tab-content">
									<div id="tab1" class="tab-pane active">
										<div class="col-lg-12">
											<div class="row">
												<div class="table-responsive">
													<table class="table datatable-basic">
														<thead>
															<tr style="background-color: #e8f5e9;">
																<th width="40%">Product</th>
																<th width="15%">Initial</th>
																<th width="15%">Reserved</th>
																<th width="15%">Done</th>
															</tr>
														</thead>
														<tbody>
															<?php if ($shiporder) : ?>
																<?php foreach ($shiporder->product as $item) : ?>
																	<tr>
																		<td><?= $item->product_name ?>&nbsp;(<?= $item->variant ?>)</td>
																		<td><?= $item->ordered_qty ?></td>
																		<td>0.000</td>
																		<td>&nbsp;</td>
																	</tr>
																<?php endforeach; ?>
															<?php endif; ?>
														</tbody>
													</table>
													<hr style="margin-top: 0px; margin-bottom: 0px;"/>
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

<script type="text/javascript" src="<?= base_url(JS_URL . 'user/warehouse/shiporder/create.js') ?>"></script>