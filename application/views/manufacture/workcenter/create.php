<style>
	.mb-3, .my-3 {
		margin-bottom: 0px !important;
	}
	sup {
		font-size: 12px;
    	color: green;
	}
</style>

<div class="content col-md-12" style="margin-left: auto; margin-right: auto;">
	<div class="panel panel-flat">
		<div class="panel-heading">
			<h5 class="panel-title" style="display: inline-block;">Work Center</h5>
			<a class="btn btn-default pull-right" href="<?= base_url('manufacture/workcenter') ?>" style="margin-left: 5px;">Back</a>
			<button type="submit" class="btn btn-primary pull-right" onclick="javascript:onSave();">Save</button>
		</div>
		<div class="container-fluid">
			<form id="create_form" action="<?= base_url('manufacture/workcenter/create') ?>/<?= !$workcenter ? -1 : $workcenter->id ?>" method="post">
				<div class="form-group">
					<div class="row">
						<div class="col-lg-6 form-group">
							<div class="form-group row">
								<label class="col-lg-4 control-label text-lg-right pt-2">Name</label>
								<div class="col-lg-6">
									<input type="text" class="form-control" name="create[name]" value="<?= !$workcenter ? '' : $workcenter->name ?>">
								</div>
							</div>
							<div class="form-group row">
								<label class="col-lg-4 control-label text-lg-right pt-2">Resource Type</label>
								<div class="col-lg-6">
									<select class="form-control mb-3" name="create[resource_type]">
										<option value="material" <?= $workcenter && $workcenter->resource_type == 'material' ? 'selected' : '' ?>>Material</option>
										<option value="product" <?= $workcenter && $workcenter->resource_type == 'product' ? 'selected' : '' ?>>Product</option>
									</select>
								</div>
							</div>
						</div>
						<div class="col-lg-6 form-group">
							<div class="form-group row">
								<label class="col-lg-4 control-label text-lg-right pt-2">Code</label>
								<div class="col-lg-6">
									<input type="number" class="form-control" name="create[code]" value="<?= !$workcenter ? '' : $workcenter->code ?>">
								</div>
							</div>
							<div class="form-group row">
								<label class="col-lg-4 control-label text-lg-right pt-2">Active</label>
								<div class="col-lg-6">
									<input type="checkbox" name="create[bom_type]" data-on-color="danger" data-off-color="primary" data-on-text="Active" data-off-text="Deactive" class="switch" checked="checked">
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<div class="tabbable">
								<ul class="nav nav-tabs nav-tabs-top top-divided">
									<li class="active">
										<a href="#tab1" data-toggle="tab">General Information</a>
									</li>
								</ul>
								<div class="tab-content">
									<div id="tab1" class="tab-pane active">
										<div class="row">
											<div class="col-lg-6 form-group">
												<label class="text-bold">
													Capacity Information
												</label>
												<hr style="margin: 0 0 10px 0;" />
												<div class="form-group row">
													<label class="col-lg-5 control-label text-lg-right pt-2">Efficiency factor&nbsp;<sup>?</sup>&nbsp;:</label>
													<div class="col-lg-6">
														<input type="number" class="form-control" name="create[efficiency_factor]" value="<?= !$workcenter ? '1' : $workcenter->efficiency_factor ?>">
													</div>
												</div>
												<div class="form-group row">
													<label class="col-lg-5 control-label text-lg-right pt-2">Capacity per Cycle&nbsp;<sup>?</sup>&nbsp;:</label>
													<div class="col-lg-6">
														<input type="number" class="form-control" name="create[capacity_per_cycle]" value="<?= !$workcenter ? '5' : $workcenter->capacity_per_cycle ?>">
													</div>
												</div>
												<div class="form-group row">
													<label class="col-lg-5 control-label text-lg-right pt-2">Time for 1 cycle (hour)&nbsp;<sup>?</sup>&nbsp;:</label>
													<div class="col-lg-6">
														<input type="text" id="time_for_cycle" class="form-control" name="create[time_for_cycle]" style="background: white;" value="<?= !$workcenter ? '01:00' : $workcenter->time_for_cycle ?>">
													</div>
												</div>
												<div class="form-group row">
													<label class="col-lg-5 control-label text-lg-right pt-2">Time before prod.&nbsp;<sup>?</sup>&nbsp;:</label>
													<div class="col-lg-6">
														<input type="text" id="time_before_prod" class="form-control" name="create[time_before_prod]" style="background: white;" value="<?= !$workcenter ? '00:10' : $workcenter->time_before_prod ?>">
													</div>
												</div>
												<div class="form-group row">
													<label class="col-lg-5 control-label text-lg-right pt-2">Time after prod.&nbsp;<sup>?</sup>&nbsp;:</label>
													<div class="col-lg-6">
														<input type="text" id="time_after_prod" class="form-control" name="create[time_after_prod]" style="background: white;" value="<?= !$workcenter ? '00:10' : $workcenter->time_after_prod ?>">
													</div>
												</div>
											</div>
											<div class="col-lg-6 form-group">
												<label class="text-bold">
													Costing Information
												</label>
												<hr style="margin: 0 0 10px 0;" />
												<div class="form-group row">
													<label class="col-lg-5 control-label text-lg-right pt-2">Cost per hour&nbsp;<sup>?</sup>&nbsp;:</label>
													<div class="col-lg-6">
														<input type="number" class="form-control" name="create[cost_per_hour]" value="<?= !$workcenter ? '0' : $workcenter->cost_per_hour ?>">
													</div>
												</div>
												<div class="form-group row">
													<label class="col-lg-5 control-label text-lg-right pt-2">Cost per cycle&nbsp;<sup>?</sup>&nbsp;:</label>
													<div class="col-lg-6">
														<input type="number" class="form-control" name="create[cost_per_cycle]" value="<?= !$workcenter ? '0' : $workcenter->cost_per_cycle ?>">
													</div>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-lg-12 form-group">
												<label class="text-bold">
													Description
												</label>
												<hr style="margin: 0 0 10px 0;" />
												<div class="form-group row">
													<div class="col-lg-12">
														<textarea class="form-control" name="create[description]"><?= !$workcenter ? '' : $workcenter->description ?></textarea>
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

<script type="text/javascript" src="<?= base_url(PLUGINS_URL . 'pickers/anytime.min.js') ?>"></script>
<script type="text/javascript" src="<?= base_url(PLUGINS_URL . 'forms/validation/validate.min.js') ?>"></script>
<script type="text/javascript" src="<?= base_url(PLUGINS_URL . 'forms/styling/uniform.min.js') ?>"></script>
<script type="text/javascript" src="<?= base_url(PLUGINS_URL . 'forms/styling/switch.min.js') ?>"></script>

<script type="text/javascript" src="<?= base_url(JS_URL . 'user/manufacture/workcenter/create.js') ?>"></script>