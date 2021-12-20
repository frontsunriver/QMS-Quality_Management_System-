<style>
	.table th, .table td {
		line-height: 10px;
	}
	.form-group {
		margin-bottom: 0px;
	}
	.nav-tabs.nav-tabs-top>li.active {
		border-top: 2px solid darkorange;
	}
	.anytime {
		background-color: white !important;
	    min-height: initial !important;
		height: 30px !important;
	}
</style>

<div class="content col-md-9" style="margin-left: auto; margin-right: auto;">
	<div class="panel panel-flat">
		<div class="panel-heading" style="border-bottom: 1px solid #eee;">
			<h5 class="panel-title" style="display: inline-block;">View Transfer:&nbsp;</h5>
			<h3 style="display: inline-block; margin-top: 0px;"><?= $transfer->reference ?></h3>
			<div class="pull-right">
				<a class="btn btn-default" href="<?= base_url('warehouse/transfer') ?>">Back</a>
			</div>
		</div>
		<div class="container-fluid" style="padding-right: 6px;">
			<div class="row col-md-12" style="padding-right: 0px;">
				<div class="row col-md-12" style="margin-bottom: 10px;">
					<a class="btn btn-default" href="<?= base_url("warehouse/transfer/pdf/$transfer->id") ?>">Download PDF</a>&nbsp;&nbsp;
					<?php if ($transfer->state == 1) { ?>
						<button type="button" class="btn btn-default" onclick="javascript:onDone(<?= $transfer->id ?>);">Done</button>&nbsp;&nbsp;
					<?php } ?>
				</div>
				<div class="form-control">
					<div class="row">
						<div class="col-lg-6">
							<div class="form-group row">
								<label class="col-lg-4 control-label pt-2 text-right">Purchase Number:&nbsp;</label>
								<label class="col-lg-8 control-label pt-2" style="color: green;"><?= $transfer->purchase_num ?></label>
							</div>
							<div class="form-group row">
								<label class="col-lg-4 control-label pt-2 text-right">Destination Location:&nbsp;</label>
								<label class="col-lg-8 control-label pt-2" style="color: green;"><?= $transfer->warehouse_name ?></label>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group row">
								<label class="col-lg-5 control-label pt-2 text-right">Order Date:&nbsp;</label>
								<label class="col-lg-7 control-label pt-2" style="color: green;"><?= $transfer->order_date ?></label>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12" style="padding: 5px 60px;">
							<div class="tabbable">
								<ul class="nav nav-tabs nav-tabs-top top-divided">
									<li class="active">
										<a href="#tab1" data-toggle="tab">Operations</a>
									</li>
								</ul>
								<div class="tab-content">
									<div id="tab1" class="tab-pane active">
										<div class="col-lg-12">
											<div class="row">
												<div class="table-responsive">
													<table class="table datatable-basic">
														<thead>
															<tr style="background-color: #e8f5e9;">
																<th width="60%">Materials</th>
																<th width="12%">Initial Demand</th>
																<th width="10%">Done</th>
																<th width="15%">Expired Date</th>
															</tr>
														</thead>
														<tbody>
															<?php if (isset($transfer_materials)) { ?>
																<?php foreach ($transfer_materials as $item) : ?>
																	<tr>
																		<td><?= $item->material_name ?></td>
																		<td><?= $item->quantity ?></td>
																		<td><?= $item->quantity ?></td>
																		<td>
																			<input type="text" class="form-control anytime" id="datepicker<?= $item->material_id ?>" <?= $transfer->state == 2 ? 'disabled' : '' ?>>
																		</td>
																	</tr>
																<?php endforeach; ?>
															<?php } ?>
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
		</div>
	</div>
</div>

<script type="text/javascript" src="<?= base_url(JS_URL . 'jquery.dataTables.min.js') ?>"></script>
<script type="text/javascript" src="<?= base_url(PLUGINS_URL . 'ui/moment/moment.min.js') ?>"></script>
<script type="text/javascript" src="<?= base_url(PLUGINS_URL . 'pickers/daterangepicker.js') ?>"></script>

<script type="text/javascript" src="<?= base_url(JS_URL . 'user/warehouse/transfer/view.js') ?>"></script>