<link rel="stylesheet" href="<?= base_url(PORTO_URL . 'vendor/select2/css/select2.css') ?>" />
<link rel="stylesheet" href="<?= base_url(PORTO_URL . 'vendor/select2-bootstrap-theme/select2-bootstrap.min.css') ?>" />
<link rel="stylesheet" href="<?= base_url(PORTO_URL . 'vendor/bootstrap-multiselect/bootstrap-multiselect.css') ?>" />

<style>
	.select2-search--dropdown:after {
		display: none;
	}
	#frequency_list i {
		cursor: pointer;
	}
</style>

<div class="content col-md-12" style="margin-left: auto; margin-right: auto;">
	<div class="panel panel-flat">
		<div class="panel-heading" style="border-bottom: 1px solid #eee;">
			<h5 class="panel-title" style="display: inline-block;">New</h5>
			<div class="pull-right">
				<button type="button" class="btn bg-blue" onclick="javascript:onCreate();"><?= $qualitycheck ? 'Update' : 'Create' ?></button>
				<a class="btn btn-default" href="<?= base_url('manufacture/qualitycheck') ?>">Discard</a>
			</div>
		</div>
		<div class="container-fluid" style="padding-right: 6px;">
			<form id="create_form" class="form-group" action="<?= base_url('manufacture/qualitycheck/create') ?><?= $qualitycheck ? "/{$qualitycheck->id}" : '' ?>" method="post">
				<div class="row" style="padding-right: 0px;">
					<div class="row col-lg-12 form-group">
						<div class="col-lg-6 form-group">
							<div class="form-group row">
								<div class="col-lg-1"></div>
								<label class="col-lg-3 control-label pt-2">Title</label>
								<div class="col-lg-6">
									<input type="text" class="form-control col-lg-12" name="create[title]" value="<?= !$qualitycheck ? '' : $qualitycheck->title ?>" required>
								</div>
							</div>
							<div class="form-group row">
								<div class="col-lg-1"></div>
								<label class="col-lg-3 control-label pt-2">Product</label>
								<div class="col-lg-6">
									<select data-plugin-selectTwo class="form-control col-lg-12" name="create[product_id]" onchange="javascript:onChangeProduct(this.value);">
										<?php foreach ($products as $item) : ?>
											<option value="<?= $item->id ?>" <?= $qualitycheck && $qualitycheck->product_id == $item->id ? 'selected' : '' ?>><?= $item->name ?></option>
										<?php endforeach; ?>
									</select>
								</div>
							</div>
							<div class="form-group row">
								<div class="col-lg-1"></div>
								<label class="col-lg-3 control-label pt-2">Product Variant</label>
								<div class="col-lg-6">
									<select id="variant" data-plugin-selectTwo class="form-control col-lg-12" name="create[variant]">
										<?php foreach ($variants as $item) : ?>
											<option value="<?= $item ?>" <?= $qualitycheck && $qualitycheck->variant == $item ? 'selected' : '' ?>><?= $item ?></option>
										<?php endforeach; ?>
									</select>
								</div>
							</div>
							<!-- <div class="form-group row">
								<div class="col-lg-1"></div>
								<label class="col-lg-3 control-label pt-2">Operation</label>
								<div class="col-lg-6">
									<select data-plugin-selectTwo class="form-control col-lg-12" name="create[operation_id]">
										<?php foreach ($operations as $item) : ?>
											<option value="<?= $item->id ?>" <?= $qualitycheck && $qualitycheck->operation_id == $item->id ? 'selected' : '' ?>><?= $item->name ?></option>
										<?php endforeach; ?>
									</select>
								</div>
							</div> -->
							<div class="form-group row">
								<div class="col-lg-1"></div>
								<label class="col-lg-3 control-label pt-2">Workcenter</label>
								<div class="col-lg-6">
									<select data-plugin-selectTwo class="form-control col-lg-12" name="create[workcenter_id]">
										<?php foreach ($workcenters as $item) : ?>
											<option value="<?= $item->id ?>" <?= $qualitycheck && $qualitycheck->workcenter_id == $item->id ? 'selected' : '' ?>><?= $item->name ?></option>
										<?php endforeach; ?>
									</select>
								</div>
							</div>
							<div class="form-group row">
								<div class="col-lg-1"></div>
								<label class="col-lg-3 control-label pt-2">Frequency</label>
								<div class="col-lg-6">
									<select data-plugin-selectTwo class="form-control col-lg-12" id="frequency_select" name="create[frequency_id]">
										<?php foreach ($frequencies as $item) : ?>
											<option value="<?= $item->frequency_id ?>" <?= $qualitycheck && $qualitycheck->frequency_id == $item->frequency_id ? 'selected' : '' ?>><?= $item->frequency_name ?></option>
										<?php endforeach; ?>
									</select>
								</div>
								<div class="col-lg-2">
									<a data-toggle="modal" data-target="#frequencys" class="btn btn-primary btn-sm" style="color: white">Manage</a>
								</div>
							</div>
						</div>
						<div class="col-lg-6 form-group">
							<div class="form-group row">
								<div class="col-lg-1"></div>
								<label class="col-lg-3 control-label pt-2">Content Type</label>
								<div class="col-lg-6">
									<select data-plugin-selectTwo class="form-control col-lg-12" name="create[content_type]">
										<option value="1">All Operations</option>
									</select>
								</div>
							</div>
							<div class="form-group row">
								<div class="col-lg-1"></div>
								<label class="col-lg-3 control-label pt-2">Test Type</label>
								<div class="col-lg-6">
									<select id="test_type" data-plugin-selectTwo class="form-control col-lg-12" name="create[test_type]" onchange="javascript:onChangeTestType();">
										<option value="1" <?= $qualitycheck && $qualitycheck->test_type == '1' ? 'selected' : '' ?>>Pass - Fail</option>
										<option value="2" <?= $qualitycheck && $qualitycheck->test_type == '2' ? 'selected' : '' ?>>Measure</option>
									</select>
								</div>
							</div>
							<div id="measure_norm" class="form-group row">
								<div class="col-lg-1"></div>
								<label class="col-lg-3 control-label pt-2">Norm</label>
								<div class="col-lg-3">
									<input type="number" class="form-control col-lg-12" name="create[norm]" value="<?= !$qualitycheck ? '' : $qualitycheck->norm ?>" required>
								</div>
								<div class="col-lg-3">
									<select data-plugin-selectTwo class="form-control col-lg-12 mb-3" name="create[norm_unit]">
										<option value="mm" <?= $qualitycheck && $qualitycheck->norm_unit == 'mm' ? 'selected' : '' ?>>mm</option>
									</select>
								</div>
							</div>
							<div id="measure_tolerance" class="form-group row">
								<div class="col-lg-1"></div>
								<label class="col-lg-3 control-label pt-2">Tolerance</label>
								<div class="col-lg-3">
									from:
									<input type="number" class="form-control col-lg-12" name="create[tolerance_from]" value="<?= !$qualitycheck ? '' : $qualitycheck->tolerance_from ?>" required>
								</div>
								<div class="col-lg-3">
									to:
									<input type="number" class="form-control col-lg-12" name="create[tolerance_to]" value="<?= !$qualitycheck ? '' : $qualitycheck->tolerance_to ?>" required>
								</div>
							</div>
							<div class="form-group row">
								<div class="col-lg-1"></div>
								<label class="col-lg-3 control-label pt-2">Responsible</label>
								<div class="col-lg-6">
									<select data-plugin-selectTwo class="form-control col-lg-12" name="create[responsible_id]">
										<?php foreach ($responsibles as $item) : ?>
											<option value="<?= $item->employee_id ?>" <?= $qualitycheck && $qualitycheck->responsible_id == $item->employee_id ? 'selected' : '' ?>><?= $item->employee_name ?></option>
										<?php endforeach; ?>
									</select>
								</div>
							</div>
						</div>
					</div>
					<div class="row col-lg-12 form-group">
						<div class="col-sm-12" style="padding: 5px 50px;">
							<div class="tabbable">
								<ul class="nav nav-tabs nav-tabs-top top-divided">
									<li class="active">
										<a href="#tab1" data-toggle="tab">Note</a>
									</li>
								</ul>
								<div class="tab-content">
									<div id="tab1" class="tab-pane active">
										<textarea id="note" type="text" class="form-control" name="create[note]" required><?= !$qualitycheck ? '' : $qualitycheck->note ?></textarea>
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

<!-- Primary modal -->
<div id="frequencys" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header bg-primary">
				<h4 class="modal-title" style="margin-top: 0px;"><i class="icon-plus2"></i>&nbsp;FREQUENCY: </h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body">
				<form method="post">
					<div class="form-group">
						<div class="row">
							<div class="col-md-5">
								<div class="input-group">
									<input type="text" class="form-control" placeholder="Name" name="name" id="new_frequency">
									<div class="input-group-append">
										<button type="button" class="btn btn-default">
											<i class="icon-list text-muted"></i>
										</button>
									</div>
								</div>
								<span class="text-danger-600" id="frequency_err"></span>
							</div>
							<div class="col-md-3">
								<div class="form-group has-feedback">
									<select class="form-control" name="type" id="frequency_type" required>
										<option value="0">Days</option>
										<option value="1">Hours</option>
										<option value="2">Minutes</option>
									</select>
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group has-feedback">
									<input type="number" min="1" value="1" placeholder="Days" class="form-control" name="day" id="new_day" style="padding-right: 8px;">
								</div>
								<span class="text-danger-600" id="day_err"></span>
							</div>
							<div class="col-md-2">
								<button type="button" class="btn btn-primary" onclick="javascript:onAddFrequency();">ADD</button>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="row" style="max-height: 450px; overflow-y: auto;">
							<div class="col-md-12">
								<table class="table">
									<thead>
										<tr>
											<th>NO</th>
											<th>Name</th>
											<th>Count</th>
											<th>Type</th>
											<th class="center">ACTION</th>
										</tr>
									</thead>
									<tbody id="frequency_list"></tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- /primary modal -->

<script type="text/javascript" src="<?= base_url(PLUGINS_URL . 'forms/validation/validate.min.js') ?>"></script>
<script type="text/javascript" src="<?= base_url(PORTO_URL . 'vendor/select2/js/select2.js') ?>"></script>
<script type="text/javascript" src="<?= base_url(PORTO_URL . 'vendor/bootstrap-multiselect/bootstrap-multiselect.js') ?>"></script>
<script type="text/javascript" src="<?= base_url(PORTO_URL . 'vendor/ckeditor/ckeditor.js') ?>"></script>
<script type="text/javascript" src="<?= base_url(PORTO_URL . 'vendor/ckeditor/dosamigos-ckeditor.widget.js') ?>"></script>

<script type="text/javascript" src="<?= base_url(JS_URL . 'user/manufacture/qualitycheck/create.js') ?>"></script>