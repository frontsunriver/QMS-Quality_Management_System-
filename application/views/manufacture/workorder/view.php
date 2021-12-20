<style>
	.no-margin-bottom {
		margin-bottom: 0px !important;
	}
	h3 {
		margin-top: 0px;
		color: lightseagreen;
	}
</style>

<div class="content col-md-8" style="margin-left: auto; margin-right: auto;">
	<div class="panel panel-flat">
		<div class="panel-heading">
			<h5 class="panel-title" style="display: inline-block;">
				View Work Orders:&nbsp;
				<?php if ($view_order->state == 1) { ?>
					<label class="label label-warning" style="margin-bottom: 0px;">Quality Not Determine</label>
				<?php } else if ($view_order->state == 2) { ?>
					<label class="label label-info" style="margin-bottom: 0px;">Quality Pass</label>
				<?php } else if ($view_order->state == -2) { ?>
					<label class="label label-danger" style="margin-bottom: 0px;">Fail</label>
				<?php } else if ($view_order->state == 3) { ?>
					<label class="label label-success" style="margin-bottom: 0px;">Done</label>
				<?php } ?>
			</h5>
			<div class="pull-right">
				<?php if ($view_order->state == 1 && $user->type == 'monitor') : ?>
					<button type="button" class="btn btn-danger" onclick="javascript:onQualityCheck(<?= $view_order->id ?>);">Quality Check</button>
					<a id="qualitycheck_btn" class="mb-1 mt-1 mr-1 modal-basic btn btn-primary hidden" href="#qualitycheck_modal"></a>
				<?php endif; ?>

				<?php if ($view_order->employee_id == $user->employee_id) : ?>
					<?php if ($view_order->state == 0) { ?>
						<button type="button" class="btn bg-blue" onclick="javascript:onStart(<?= $view_order->id ?>);">Start</button>
					<?php } else if ($view_order->state == 1) { ?>
						<button type="button" class="btn bg-blue" onclick="javascript:onPending();">Pending</button>
					<?php } else if ($view_order->state == 2) { ?>
						<button type="button" class="btn btn-danger" onclick="javascript:onFinish(<?= $view_order->id ?>);">Finished</button>
						<button type="button" class="btn bg-blue" onclick="javascript:onPending();">Pending</button>
					<?php } ?>
				<?php endif; ?>

				<a class="btn btn-default" href="<?= base_url('manufacture/workorder') ?>">Back</a>
			</div>
		</div>
		<div class="container-fluid">
			<div class="row col-lg-12">
				<div class="col-lg-6 form-group">
					<div class="form-group row no-margin-bottom">
						<label class="col-lg-5 control-label pt-2 text-bold">Work Order</label>
						<label class="col-lg-5 control-label pt-2"><?= $view_order->routing_name ?> - <?= $view_order->product_name ?>&nbsp;(<?= $view_order->variant ?>)</label>
					</div>
					<div class="form-group row no-margin-bottom">
						<label class="col-lg-5 control-label pt-2 text-bold">Manufacturing Order</label>
						<label class="col-lg-5 control-label pt-2 text-mute"><?= $view_order->manuorder_num ?></label>
					</div>
					<div class="form-group row no-margin-bottom">
						<label class="col-lg-5 control-label pt-2 text-bold">Sequence</label>
						<label class="col-lg-5 control-label pt-2"><?= $view_order->sequence ?></label>
					</div>
				</div>
				<div class="col-lg-6 form-group">
					<div class="form-group row no-margin-bottom">
						<label class="col-lg-5 control-label pt-2 text-bold">Work Center</label>
						<label class="col-lg-5 control-label pt-2 text-mute"><?= $view_order->workcenter_name ?></label>
					</div>
					<div class="form-group row no-margin-bottom">
						<label class="col-lg-5 control-label pt-2 text-bold">Production Status</label>
						<label id="status" class="col-lg-5 control-label pt-2">
							<?php if ($view_order->state == 0) { ?>
								<label class="label label-info">Ready to Produce</label>
							<?php } else if ($view_order->state == 1) { ?>
								<label class="label label-primary">Producing</label>
							<?php } ?>
						</label>
					</div>
				</div>
			</div>
			<div class="row form-group">
				<div class="col-sm-12">
					<div class="tabbable">
						<ul class="nav nav-tabs nav-tabs-top top-divided">
							<li class="active">
								<a href="#tab1" data-toggle="tab">Work Instruction</a>
							</li>
							<li>
								<a href="#tab2" data-toggle="tab">Information</a>
							</li>
						</ul>
						<div class="tab-content">
							<div id="tab1" class="tab-pane active">
								<div class="row" style="margin: 5px 5px;">
									<?php if ($view_order->src_doc && $view_order->src_doc != '') : ?>
										<iframe src="<?= $view_order->src_doc && $view_order->src_doc != '' ? base_url("uploads/src_doc/{$view_order->src_doc}") : '' ?>" style="width: 100%; height: 300px;"></iframe>
									<?php else : ?>
										<span class="form-control" style="text-align: center; border: none;">No source document !!!</span>
									<?php endif; ?>
									
								</div>
							</div>
							<div id="tab2" class="tab-pane">
								<div class="row col-lg-12">
									<div class="col-lg-6 form-group">
										<h3>Planned Date</h3>
										<div class="form-group row no-margin-bottom">
											<label class="col-lg-5 control-label pt-2 text-bold">Scheduled Date</label>
											<label class="col-lg-5 control-label pt-2"><?= date('d/m/Y H:i:s', strtotime($view_order->scheduled_date)) ?></label>
										</div>
										<div class="form-group row no-margin-bottom">
											<label class="col-lg-5 control-label pt-2 text-bold">End Date</label>
											<label class="col-lg-5 control-label pt-2 text-mute"><?= $view_order->endp_date->format('d/m/Y H:i:s') ?></label>
										</div>
									</div>
									<div class="col-lg-6 form-group">
										<h3>Duration</h3>
										<div class="form-group row no-margin-bottom">
											<label class="col-lg-5 control-label pt-2 text-bold">Number of Cycles</label>
											<label class="col-lg-5 control-label pt-2 text-mute"><?= $view_order->number_of_cycles ?></label>
										</div>
										<div class="form-group row no-margin-bottom">
											<label class="col-lg-5 control-label pt-2 text-bold">Number of Hours</label>
											<label class="col-lg-5 control-label pt-2"><?= $view_order->number_of_hours ?></label>
										</div>
									</div>
								</div>
								<div class="row col-lg-12">
									<div class="col-lg-6 form-group">
										<h3>Actual Production Date</h3>
										<div class="form-group row no-margin-bottom">
											<label class="col-lg-5 control-label pt-2 text-bold">Start Date</label>
											<label class="col-lg-5 control-label pt-2">
												<?= $view_order->state > 0 ? date('d/m/Y H:i:s', strtotime($view_order->started_at)) : '' ?></label>
										</div>
										<div class="form-group row no-margin-bottom">
											<label class="col-lg-5 control-label pt-2 text-bold">End Date</label>
											<label class="col-lg-5 control-label pt-2 text-mute">
												<?= $view_order->state == 2 ? date('d/m/Y H:i:s', strtotime($view_order->finished_at)) : '' ?></label>
										</div>
										<div class="form-group row no-margin-bottom">
											<label class="col-lg-5 control-label pt-2 text-bold">Working Hours</label>
											<label class="col-lg-5 control-label pt-2 text-mute"><?= $view_order->state > 0 ? $view_order->working_hours->format('%H:%I') : '00:00' ?></label>
										</div>
									</div>
									<div class="col-lg-6 form-group">
										<h3>Product to Produce</h3>
										<div class="form-group row no-margin-bottom">
											<label class="col-lg-5 control-label pt-2 text-bold">Product</label>
											<label class="col-lg-5 control-label pt-2 text-mute"><?= $view_order->product_name ?></label>
										</div>
										<div class="form-group row no-margin-bottom">
											<label class="col-lg-5 control-label pt-2 text-bold">Qty</label>
											<label class="col-lg-5 control-label pt-2"><?= $view_order->quantity ?></label>
										</div>
										<div class="form-group row no-margin-bottom">
											<label class="col-lg-5 control-label pt-2 text-bold">Unit of Measure</label>
											<label class="col-lg-5 control-label pt-2">Unit($)</label>
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

<div id="qualitycheck_passfail_modal" class="modal-block modal-block-primary mfp-hide">
	<form action="<?= base_url("manufacture/workorder/qualitycheck/{$view_order->id}") ?>" method="post">
		<input type="hidden" id="qualitycheck_id" name="qualitycheck_id">
		<input type="hidden" id="test_type" name="test_type">
		<section class="card">
			<header class="card-header">
				<h2 class="card-title">Quality Check</h2>
			</header>
			<div class="card-body">
				<div class="modal-wrapper">
					<div class="modal-icon">
						<i class="fas fa-question-circle"></i>
					</div>
					<div class="modal-text">
						<h4>Notice</h4>
						<input type="hidden" id="check_value" name="check_value">
					</div>
				</div>
			</div>
			<footer class="card-footer">
				<div class="row">
					<div class="col-md-12 text-right">
						<button class="btn btn-primary modal-confirm" onclick="javascript:onPassFail(2);">PASS</button>
						<button class="btn btn-primary modal-confirm" onclick="javascript:onPassFail(-2);">FAIL</button>
						<button class="btn btn-default modal-dismiss">CANCEL</button>
					</div>
				</div>
			</footer>
		</section>
	</form>
</div>

<div id="qualitycheck_measure_modal" class="modal-block modal-block-primary mfp-hide">
	<form action="<?= base_url("manufacture/workorder/qualitycheck/{$view_order->id}") ?>" method="post">
		<input type="hidden" id="qualitycheck_id" name="qualitycheck_id">
		<input type="hidden" id="test_type" name="test_type">
		<section class="card">
			<header class="card-header">
				<h2 class="card-title">Quality Check</h2>
			</header>
			<div class="card-body">
				<div class="modal-wrapper">
					<div class="modal-icon">
						<i class="fas fa-question-circle"></i>
					</div>
					<div class="modal-text">
						<h4>Notice</h4>
						<div class="row">
							<div class="col-lg-6">UL:&nbsp;<input id="tolerance_from" type="number" class="form-control" name="tolerance_from" readonly></div>
							<div class="col-lg-6">LL:&nbsp;<input id="tolerance_to" type="number" class="form-control" name="tolerance_to" readonly></div>
						</div>
						<div class="row" style="margin-top: 10px;">
							<div class="col-lg-6">
								Check Value:&nbsp;<input type="number" class="form-control" name="check_value" required>
							</div>
						</div>
					</div>
				</div>
			</div>
			<footer class="card-footer">
				<div class="row">
					<div class="col-md-12 text-right">
						<button class="btn btn-primary modal-confirm">MEASURE</button>
						<button class="btn btn-default modal-dismiss">CANCEL</button>
					</div>
				</div>
			</footer>
		</section>
	</form>
</div>

<script>
	var number_of_cycles = <?= $view_order->number_of_cycles ?>;
	var number_of_hours = '<?= $view_order->number_of_hours ?>';
</script>
<script type="text/javascript" src="<?= base_url(JS_URL . 'user/manufacture/workorder/view.js') ?>"></script>